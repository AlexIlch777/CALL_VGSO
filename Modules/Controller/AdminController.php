<?php

namespace Modules\Controller;
class AdminController extends BaseController
{
    public function changePassword($params)
    {
        $this->checkAdmin();

        $admins = new \Modules\Model\Admin;
        $admin = $admins->getOr404($params['adminId'], 'id');

        if($admin['id'] != $this->currentUser['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $formData = [];

        $initialData = ['login' => $this->currentUser['login'], 'currentPassword' => $this->currentUser['password'], 'userStatus' => $this->userStatus];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);
            $formData = \Modules\Form\ChangePasswordForm::getNormalizedData($_POST);
            if(!isset($formData['__errors'])) {
                $formData = \Modules\Form\ChangePasswordForm::getPreparedData($formData);
                $admins->update($formData, $admin['id']);
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

    public function liquidateAccident($params) 
    {
        $this->checkAdmin();

        $admins = new \Modules\Model\Admin;
        $admin = $admins->getOr404($params['adminId'], 'id', 'id');

        if($this->currentUser['id'] != $admin['id']) 
        {
            throw new \Modules\Exception\Page403Exception;
        }

        $vgsvs = new \Modules\Model\MainVgsv;

        $accidents = new \Modules\Model\AccidentsList;
        $currentAccident = $accidents->getOr404($params['accidentId'], 'id', 'id, mine, accident, status');

        $disposition = new \Modules\Model\Disposition;
        $disposition->select('dispositions.id, vgsv, main_vgsv.online', ['main_vgsv'], 'mine = ? AND accident = ?', [$currentAccident['mine'], $currentAccident['accident']]);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);

            if($currentAccident['status'] == 1) {
                foreach ($disposition as $dispositionMember) {
                    $updateArray = ['alert' => 0, 'departure' => 0];
                    if($dispositionMember['online'] == 1) {
                        $updateArray['success_alert'] = 1;
                    }
                    $vgsvs->update($updateArray, $dispositionMember['vgsv'], 'id');
                }
            }

            $accidents->update(['is_liquidated' => 1], $currentAccident['id'], 'id');

            \Modules\Helpers\redirect("/CALL_VGSO");
        }
    }

    public function confirmAccident($params) 
    {
        $this->checkAdmin();

        $admins = new \Modules\Model\Admin;
        $admin = $admins->getOr404($params['adminId'], 'id', 'id');

        if($this->currentUser['id'] != $admin['id']) 
        {
            throw new \Modules\Exception\Page403Exception;
        }

        $vgsvs = new \Modules\Model\MainVgsv;

        $accidents = new \Modules\Model\AccidentsList;
        $currentAccident = $accidents->getOr404($params['accidentId'], 'id', 'id, mine, accident, status');

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);

            $accidents->update(['admin_checked' => true], $currentAccident['id'], 'id');

            \Modules\Helpers\redirect("/CALL_VGSO");
        }
    }

    public function getAccidentsList()
    {
        $this->checkAdmin();

        $accidentsList = new \Modules\Model\AccidentsList;
        $accidentsList->select('accidents_list.id, mines.name AS mine_name, accidents.name AS accident_name, accident_timestamp, is_liquidated', ['mines', 'accidents']);

        $context = 
        [
            'siteTitle' => 'Список аварий',
            'accidents' => $accidentsList,
        ];

        $this->render('accidents_list', $context);
    }
}

?>