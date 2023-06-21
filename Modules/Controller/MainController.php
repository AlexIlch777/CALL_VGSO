<?php

namespace Modules\Controller;
class MainController extends BaseController
{
    public function list()
    {
        $this->checkUser();

        $formData;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkVgsv();
            \Modules\Helpers\checkToken($_POST);
            $formData = \Modules\Form\AccidentForm::getNormalizedData($_POST);
            if(!isset($formData['__errors'])) {
                $formData = \Modules\Form\AccidentForm::getPreparedData($formData);

                $vgsvs = new \Modules\Model\MainVgsv;
                $accidents = new \Modules\Model\AccidentsList;
                $changes = new \Modules\Model\Vgsv;

                $accidents->select('*', NULL, 'is_liquidated = 0');
                $notLiquidatedAccidents = \Modules\Helpers\getArrayFromObject($accidents);

                $accidentsCount = count($notLiquidatedAccidents);

                if($accidentsCount == 0) {
                    $formData['status'] = 1;
                } else {
                    $formData['status'] = $accidentsCount + 1;
                }

                $formData['vgsv'] = $this->currentUser['id'];

                $formData['vgso'] = $this->currentUser['vgso_id'];

                $currentAccident = $accidents->insert($formData);

                $currentAccidentInfo = $accidents->get($currentAccident, 'id', 'id, mine, accident, status');

                $dispositions = new \Modules\Model\Disposition;
                $dispositions->select('vgsv, duty_department, reserve_department, mber, oto, kil, sds, apo, asi', NULL, 'mine = ? AND accident = ?', [$currentAccidentInfo['mine'], $currentAccidentInfo['accident']]);

                $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

                if($currentAccidentInfo['status'] == 1) {
                    foreach($dispositions as $dispositionMember) {
                        $vgsv = $vgsvs->get($dispositionMember['vgsv'], 'id', 'id, online');

                        $vgsvs->update(['alert' => 1, 'success_alert' => 0], $vgsv['id'], 'id');
    
                        if($vgsv['online'] == 1) {
    
                            $change = $changes->getRecord('id, duty_department_status, reserve_department_status, sds_status, mber_status, oto_status, kil_status, asi_status, apo_status', NULL, 'vgsv = ? AND end_timestamp IS NULL', [$vgsv['id']]);
        
                            $vgsvsInAccidents->insert(['vgsv' => $vgsv['id'], 'current_change' => $change['id'], 'accident' => $currentAccidentInfo['id'], 'alert' => 1]);

                            $changeStatuses = ['duty_department' => $change['duty_department_status'], 'reserve_department' => $change['reserve_department_status'], 'sds' => $change['sds_status'], 'mber' => $change['mber_status'], 'oto' => $change['oto_status'], 'kil' => $change['kil_status'], 'asi' => $change['asi_status'], 'apo' => $change['apo_status']];

                            foreach ($changeStatuses as $department => $departmentStatus) {
                                if($dispositionMember[$department] == 1 && $departmentStatus == 1) {
                                    $departmentName = $department.'_status';
                                    $changes->update([$departmentName => 2], $change['id'], 'id');
                                }
                            }
                            
                        } else {
                            $vgsvsInAccidents->insert(['vgsv' => $vgsv['id'], 'current_change' => NULL, 'accident' => $currentAccidentInfo['id'], 'alert' => 1]);
                        }
                    }
                }

                \Modules\Helpers\redirect('/CALL_VGSO');
            }
        } else {
            $formData = \Modules\Form\AccidentForm::getInitialData();
        }

        $formData['__token'] = \Modules\Helpers\generateToken();

        $accidentsForSelect = \Modules\Helpers\getOptionsForSelect('Accident', 'id, name');
        $minesForSelect = \Modules\Helpers\getOptionsForSelect('VgsvsMine', 'mine, name', ['mines'], 'vgsv = ?', [$this->currentUser['id']]);

        $changes = new \Modules\Model\Vgsv;
        $lastChange = $changes->getRecordWithLimit('id, end_timestamp', NULL, 'vgsv = ?', [$this->currentUser['id']], 'start_timestamp DESC', NULL, 1);
        
        $context = 
        [
            'siteTitle' => 'Главная страница',
            'formData' => $formData,
            'accidentFormSelectOptions' => ['accident' => $accidentsForSelect, 'mine' => $minesForSelect],
            'script' => 'main_data',
            'style' => 'main_data',
            'lastChange' => $lastChange
        ];
        $this->render('main_page', $context);
    }
    


    public function getMainData()
    {
        $userCheck = $this->checkNoUser();

        if($userCheck == TRUE) {
            throw new \Modules\Exception\Page403Exception;
        }

        \Modules\Helpers\apiHeaders();

        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsvs->select();
        $vgsvsArray = \Modules\Helpers\getArrayFromObject($vgsvs);

        $vgsos = new \Modules\Model\Vgso;
        $vgsos->select();
        $vgsosArray = \Modules\Helpers\getArrayFromObject($vgsos);

        $changes = new \Modules\Model\Vgsv;
        $lastChange = $changes->getRecordWithLimit('vgsvs.id, main_vgsv.name as name, end_timestamp, duty_department_senior_commander_name, duty_department_senior_commander_telephone_number, duty_department_number, duty_department_commander_name, duty_department_commander_telephone_number, duty_department_vehicle, reserve_department_senior_commander_name, reserve_department_senior_commander_telephone_number, reserve_department_number, reserve_department_commander_name, reserve_department_commander_telephone_number, oto_duty_name, oto_duty_telephone_number, sds_duty_name, sds_duty_telephone_number, mber_duty_name, mber_duty_telephone_number, mber_vehicle, reserve_department_vehicle, asi_status, kil_status, people_forces, auto_forces', ['main_vgsv'], 'vgsv = ?', [$this->currentUser['id']], 'start_timestamp DESC', NULL, 1);

        $accidentsList = new \Modules\Model\AccidentsList;
        $accidentsList->select('accidents_list.id, mine, mines.name AS mine_name, accident, accidents.name AS accident_name, sender, accident_timestamp, send_timestamp, main_vgsv.name AS vgsv_name, status, admin_checked', ['mines', 'accidents', 'main_vgsv', 'vgsos'], 'is_liquidated = 0');
        $currentAccidents = \Modules\Helpers\getArrayFromObject($accidentsList);

        $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

        $dispositions = new \Modules\Model\Disposition;

        $preparedDispositions = [];

        foreach ($currentAccidents as $accident) {

            $dispositionMemberArray = [];

            if($accident['status'] == 1) {

                $vgsvsInAccidents->select('id, vgsv, current_change', NULL, 'accident = ?', [$accident['id']]);

                $vgsvsInAccidents2 = new \Modules\Model\VgsvsInAccident;

                foreach ($vgsvsInAccidents as $vgsvInAccident) {

                    $necessaryDepartmentsFromDisposition = $dispositions->getRecord('duty_department, reserve_department, mber, oto, kil, sds, apo, asi', NULL, 'vgsv = ? AND mine = ? AND accident = ?', [$vgsvInAccident['vgsv'], $accident['mine'], $accident['accident']]);

                    if(!is_null($vgsvInAccident['current_change'])) {
                        $dispositionMemberArray[$vgsvInAccident['vgsv']] = $vgsvsInAccidents2->getRecord('vgsvs_in_accidents.id, vgsvs_in_accidents.vgsv, main_vgsv.id AS vgsv_id, main_vgsv.name AS vgsv_name, current_change, vgsvs.duty_department_status, vgsvs.reserve_department_status, vgsvs.oto_status, vgsvs.sds_status, vgsvs.mber_status, vgsvs.kil_status, vgsvs.asi_status, vgsvs.apo_status, vgsvs.start_timestamp, vgsvs.duty_department_commander_name, vgsvs_in_accidents.alert, vgsvs_in_accidents.departure, departure_timestamp', ['vgsvs', 'main_vgsv'], 'vgsvs_in_accidents.id = ?', [$vgsvInAccident['id']]);
                    } else {
                        $dispositionMemberArray[$vgsvInAccident['vgsv']] = $vgsvsInAccidents2->getRecord('vgsvs_in_accidents.id, vgsvs_in_accidents.vgsv, main_vgsv.name AS vgsv_name, vgsvs_in_accidents.current_change, departure_timestamp', ['main_vgsv'], 'vgsvs_in_accidents.id = ?', [$vgsvInAccident['id']]);
                    }

                    $dispositionMemberArray[$vgsvInAccident['vgsv']]['necessaryDepartments'] = $necessaryDepartmentsFromDisposition;

                }
    
                $preparedDispositions[$accident['id']] = $dispositionMemberArray;
            } else {

                $dispositions->select('vgsv, main_vgsv.name AS vgsv_name', ['main_vgsv'], 'mine = ? AND accident = ?', [$accident['mine'], $accident['accident']]);

                $dispositionArray = \Modules\Helpers\getArrayFromObject($dispositions);

                foreach($dispositionArray as $dispositionMember) {
                    $statuses = $changes->getRecord('duty_department_status, reserve_department_status, sds_status, mber_status, oto_status, kil_status, asi_status, apo_status', NULL, 'vgsv = ? AND end_timestamp IS NULL', [$dispositionMember['vgsv']]);
                    
                    $dispositionMemberArray[$dispositionMember['vgsv']] = $dispositionMember;
                    $dispositionMemberArray[$dispositionMember['vgsv']]['statuses'] = $statuses;
                }

                $preparedDispositions[$accident['id']] = $dispositionMemberArray;
            }
        }

        http_response_code(200);

        $mainData = 
        [
            'userStatus' => $this->userStatus,
            'vgsvs' => $vgsvsArray,
            'vgsos' => $vgsosArray,
            'lastChange' => $lastChange,
            'currentAccidents' => $currentAccidents,
            'dispositions' => $preparedDispositions,
            'token' => \Modules\Helpers\generateToken(),
            'currentUserId' => $this->currentUser['id'],
            'currentUser' => $this->currentUser,
        ];

        echo json_encode($mainData, JSON_UNESCAPED_UNICODE);

    }
    
    
    
        public function getAccidentInfo()
    {
        $userCheck = $this->checkNoUser();

        if($userCheck == TRUE) {
            throw new \Modules\Exception\Page403Exception;
        }

        \Modules\Helpers\apiHeaders();

        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsvs->select();
        $vgsvsArray = \Modules\Helpers\getArrayFromObject($vgsvs);

        $vgsos = new \Modules\Model\Vgso;
        $vgsos->select();
        $vgsosArray = \Modules\Helpers\getArrayFromObject($vgsos);

        $changes = new \Modules\Model\Vgsv;
        $lastChange = $changes->getRecordWithLimit('id, end_timestamp', NULL, 'vgsv = ?', [$this->currentUser['id']], 'start_timestamp DESC', NULL, 1);

        $accidentsList = new \Modules\Model\AccidentsList;
        $accidentsList->select('id, admin_checked, status', NULL, 'is_liquidated = 0');
        
        $currentAccidents = \Modules\Helpers\getArrayFromObject($accidentsList);

        $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

        $preparedDispositions = [];

        foreach ($currentAccidents as $accident) {

            $dispositionMemberArray = [];

            if($accident['status'] == 1) {

                $vgsvsInAccidents2 = new \Modules\Model\VgsvsInAccident;

                $vgsvsInAccidents->select('id, vgsv, current_change', NULL, 'accident = ?', [$accident['id']]);

                foreach ($vgsvsInAccidents as $vgsvInAccident) {

                    $dispositionMemberArray[$vgsvInAccident['vgsv']] = $vgsvsInAccidents2->getRecord('id, vgsv, alert', NULL, 'id = ?', [$vgsvInAccident['id']]);

                }
    
                $preparedDispositions[$accident['id']] = $dispositionMemberArray;
            }
        }

        http_response_code(200);

        $mainData = 
        [
            'userStatus' => $this->userStatus,
            'lastChange' => $lastChange,
            'currentAccidents' => $currentAccidents,
            'dispositions' => $preparedDispositions,
            'currentUserId' => $this->currentUser['id'],
            'currentUser' => $this->currentUser,
        ];

        echo json_encode($mainData, JSON_UNESCAPED_UNICODE);

    }
}

?>