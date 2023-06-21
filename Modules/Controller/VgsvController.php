<?php

namespace Modules\Controller;
class VgsvController extends BaseController
{
    public function newChange($params) 
    {
        $this->checkVgsv();

        $mainVgsvs = new \Modules\Model\MainVgsv;

        $vgsv = $mainVgsvs->getOr404($params['vgsvId'], 'id', 'id, apo_vehicle');

        if($this->currentUser['id'] != $vgsv['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        if($this->currentUser['online'] === 1) {
            \Modules\Helpers\redirect("/CALL_VGSO/vgsv/".$vgsv['id']."/change_already_on");
        }

        $formData = [];
        $vgsoSelectOptions = \Modules\Helpers\getOptionsForSelect('Vgso', 'id, name');

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);
            $formData = \Modules\Form\NewChangeForm::getNormalizedData($_POST);
            if(!isset($formData['__errors'])) {
                $formData = \Modules\Form\NewChangeForm::getPreparedData($formData);
                
                $vgsvs = new \Modules\Model\Vgsv;

                if(!empty($formData['oto_duty_name'])) {
                    $formData['oto_status'] = 1;
                }

                if(!empty($formData['sds_duty_name'])) {
                    $formData['sds_status'] = 1;
                }

                if(!empty($formData['mber_duty_name'])) {
                    $formData['mber_status'] = 1;
                }

                if($vgsv['apo_vehicle'] != '') {
                    $formData['apo_status'] = 1;
                }

                $vgsvs->insert($formData);

                $mainVgsvs->update(['online' => TRUE], $this->currentUser['id']);
                \Modules\Helpers\redirect('/CALL_VGSO');
            }
        } else {
            $formData = \Modules\Form\NewChangeForm::getInitialData(['vgsv' => $this->currentUser['id']]);
        }
        $formData['__token'] = \Modules\Helpers\generateToken();
        
        $departmentsNumberArray = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
        $context = 
        [
            'siteTitle' => 'Новая смена',
            'formData' => $formData,
            'selectOptions' => ['duty_department_number' => $departmentsNumberArray, 'reserve_department_number' => $departmentsNumberArray],
        ];
        $this->render('vgsv_form', $context);
    }

    public function changeAlreadyOn($params)
    {
        $this->checkVgsv();

        if($this->currentUser['id'] != $params['vgsvId']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $context = 
        [
            'siteTitle' => 'Смена уже начата',
        ];
        $this->render('change_already_on_page', $context);
    }

    public function endChange($params)
    {
        $this->checkVgsv();

        if($this->currentUser['id'] != $params['vgsvId']) {
            throw new \Modules\Exception\Page403Exception;
        }

        if($this->currentUser['online'] != 1) {
            \Modules\Helpers\redirect('/CALL_VGSO');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);
            $vgsvs = new \Modules\Model\Vgsv;
            $mainVgsvs = new \Modules\Model\MainVgsv;
            $dateTime = new \DateTime('now');
            $dateTime->setTimezone(new \DateTimeZone('Europe/Moscow'));
            $timestamp = $dateTime->format('Y-m-d H:i:s');
            $vgsv = $vgsvs->getRecordWithLimit('id', NULL, 'vgsv = ?', [$this->currentUser['id']], 'start_timestamp DESC', NULL, 1);
            $vgsvs->update(['end_timestamp' => $timestamp], $vgsv['id']);
            $mainVgsvs->update(['online' => 0], $this->currentUser['id']);
            \Modules\Helpers\redirect('/CALL_VGSO');
        } else {
            $formData = \Modules\Form\EndChangeForm::getInitialData();
            $formData['__token'] = \Modules\Helpers\generateToken();
            $context = 
            [
                'formData' => $formData,
                'siteTitle' => 'Завершение смены',
            ];
            $this->render('end_change', $context);
        }
    }

    public function item($params)  
    {
        $this->checkUser();

        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'main_vgsv.id', 'main_vgsv.id, main_vgsv.name, vgsos.name AS vgsoName, telephone_number, radio_call, senior_commander_name, senior_commander_telephone_number, apo_vehicle, timestamp', ['vgsos']);

        $vgsvsChanges = new \Modules\Model\Vgsv;
        $vgsvsChanges->select('*', NULL, 'vgsv = ?', [$vgsv['id']], '', 0, 10);

        $changes = \Modules\Helpers\getArrayFromObject($vgsvsChanges);

        if(($this->userStatus == 'vgsv' && $this->currentUser['id'] != $vgsv['id'])) {
            throw new \Modules\Exception\Page403Exception;
        }

        $formData = ['__token'];

        $context = 
        [
            'siteTitle' => $vgsv['name'],
            'style' => 'vgsv_item',
            'vgsv' => $vgsv,
            'changes' => $changes,
        ];
        $this->render('vgsv_item', $context);
    }

    public function itemUpdate($params) 
    {
        $this->checkUser();

        $mainVgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $mainVgsvs->getOr404($params['vgsvId'], 'id', 'id');

        if($this->userStatus == 'vgsv' && $vgsv['id'] != $this->currentUser['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);
            $formData = \Modules\Form\UpdateVgsvInfoForm::getNormalizedData($_POST);
            
            if(!isset($formData['__errors'])) {
                $formData = \Modules\Form\UpdateVgsvInfoForm::getPreparedData($_POST);

                $mainVgsvs->update($formData, $vgsv['id'], 'id');

                \Modules\Helpers\redirect('/CALL_VGSO/vgsv/'.$vgsv['id']);
            }
        }

        
    }

    public function changePassword($params)
    {
        $this->checkVgsv();

        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'id');

        if($vgsv['id'] != $this->currentUser['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $formData = [];

        $initialData = ['login' => $this->currentUser['login'], 'currentPassword' => $this->currentUser['__user_passworD'], 'userStatus' => $this->userStatus];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);
            $formData = \Modules\Form\ChangePasswordForm::getNormalizedData($_POST);
            if(!isset($formData['__errors'])) {
                $formData = \Modules\Form\ChangePasswordForm::getPreparedData($formData);
                $vgsvs->update($formData, $vgsv['id']);
                unset($_SESSION['currentUser']);
                unset($_SESSION['userStatus']);
                session_destroy();
                \Modules\Helpers\redirect('/CALL_VGSO/login/hub');
            }
        } else {
            $formData = \Modules\Form\ChangePasswordForm::getInitialData($initialData);
        }

        $formData['__token'] = \Modules\Helpers\generateToken();

        $context = 
        [
            'formData' => $formData,
        ];

        $this->render('change_password', $context);
    }

    public function haveAlert($params)
    {
        $this->checkVgsv();

        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'id', 'id');

        $accidents = new \Modules\Model\AccidentsList;
        $accident = $accidents->getOr404($params['accidentId'], 'id', 'id, status');

        if($this->currentUser['id'] != $vgsv['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);

            if($accident['status'] == 1) {
                $vgsvInAccident = $vgsvsInAccidents->getRecord('id', NULL, 'accident = ? AND vgsv = ?', [$accident['id'], $vgsv['id']]);

                $vgsvsInAccidents->update(['alert' => 2], $vgsvInAccident['id'], 'id');
                
                $vgsvs->update(['alert' => 2], $vgsv['id'], 'id');
    
                \Modules\Helpers\redirect('/CALL_VGSO');
            } else {
                echo 'Отметить прочитанным уведолмление о данной аварии Вы не можете';
            }

        } else {
            echo 'Текущий тип запроса недоступен для данного адреса';
        }
    }

    public function departure($params)
    {
        $this->checkVgsv();

        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'id', 'id');

        $accidents = new \Modules\Model\AccidentsList;
        $accident = $accidents->getOr404($params['accidentId'], 'id', 'id, status');

        if($this->currentUser['id'] != $vgsv['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);

            if($accident['status'] == 1) {
                $vgsvInAccident = $vgsvsInAccidents->getRecord('id', NULL, 'accident = ? AND vgsv = ?', [$accident['id'], $vgsv['id']]);

                $dateTime = new \DateTime('now');
                
                $dateTime->setTimezone(new \DateTimeZone('Europe/Moscow'));
                
                $timestamp = $dateTime->format('Y-m-d H:i:s');

                $vgsvsInAccidents->update(['departure' => 1, 'departure_timestamp' => $timestamp], $vgsvInAccident['id'], 'id');
                
                $vgsvs->update(['departure' => 1], $vgsv['id'], 'id');
    
                \Modules\Helpers\redirect('/CALL_VGSO');
            } else {
                echo 'Отметить о выезде по данной аварии Вы не можете';
            }

        } else {
            echo 'Текущий тип запроса недоступен для данного адреса';
        }
    }

    public function addChangeToAccident($params) 
    {
        $this->checkVgsv();

        $vgsvs = new \Modules\Model\MainVgsv;

        $changes = new \Modules\Model\Vgsv;

        $accidents = new \Modules\Model\AccidentsList;

        $dispositions = new \Modules\Model\Disposition;

        $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'id', 'id');

        $change = $changes->getOr404($params['changeId'], 'id', 'id');

        $accident = $accidents->getOr404($params['accidentId'], 'id', 'id, mine, accident');

        if($this->currentUser['id'] != $vgsv['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);

            $change = $changes->getRecord('id, duty_department_status, reserve_department_status, sds_status, mber_status, oto_status, kil_status, asi_status, apo_status', NULL, 'vgsv = ? AND end_timestamp IS NULL', [$vgsv['id']]);

            $vgsvInAccident = $vgsvsInAccidents->getRecord('id', NULL, 'vgsv = ? AND accident = ? AND current_change IS NULL', [$vgsv['id'], $accident['id']]);

            if(!empty($change) && !empty($vgsvInAccident)) {
                $vgsvsInAccidents->update(['current_change' => $change['id']], $vgsvInAccident['id'], 'id');

                $dispositionInfo = $dispositions->getRecord('duty_department, reserve_department, mber, oto, kil, sds, apo, asi', NULL, 'vgsv = ? AND mine = ? AND accident = ?', [$vgsv['id'], $accident['mine'], $accident['accident']]);

                $changeStatuses = ['duty_department' => $change['duty_department_status'], 'reserve_department' => $change['reserve_department_status'], 'sds' => $change['sds_status'], 'mber' => $change['mber_status'], 'oto' => $change['oto_status'], 'kil' => $change['kil_status'], 'asi' => $change['asi_status'], 'apo' => $change['apo_status']];

                foreach ($changeStatuses as $department => $departmentStatus) {
                    if($dispositionInfo[$department] == 1 &&$departmentStatus == 1) {
                        $departmentName = $department.'_status';
                        $changes->update([$departmentName => 2], $change['id'], 'id');
                    }
                }

                \Modules\Helpers\redirect('/CALL_VGSO');

            }

        }
    }

    public function haveSuccessAlert($params) 
    {
        $this->checkVgsv();

        $mainVgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $mainVgsvs->getOr404($params['vgsvId'], 'id', 'id');

        if($this->userStatus == 'vgsv' && $vgsv['id'] != $this->currentUser['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);

            $mainVgsvs->update(['success_alert' => 0], $vgsv['id'], 'id');

            \Modules\Helpers\redirect('/CALL_VGSO');
        }
    }

}

?>