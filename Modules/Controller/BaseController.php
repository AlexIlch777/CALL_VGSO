<?php

namespace Modules\Controller;
global $basePath;
require_once $basePath.'Modules/helpers.php';
class BaseController
{
    /**
     * info about user with all statuses
     */
    public $currentUser = NULL;

    /**
     * admin | vgsv
     */
    public $userStatus;


    function __construct()     
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if(isset($_SESSION['currentUser']) && isset($_SESSION['userStatus'])) {
            if($_SESSION['userStatus'] == 'admin') {
                $admins = new \Modules\Model\Admin();
                $this->currentUser = $admins->getOr404($_SESSION['currentUser'], 'admins.id');

                $this->userStatus = 'admin';
            } else if ($_SESSION['userStatus'] == 'vgsv') {
                $vgsvs = new \Modules\Model\MainVgsv();
                $this->currentUser = $vgsvs->getOr404($_SESSION['currentUser'], 'main_vgsv.id', 'main_vgsv.id, main_vgsv.name, vgsos.id AS vgso_id, vgsos.name AS vgsoName, telephone_number, radio_call, senior_commander_name, senior_commander_telephone_number, apo_vehicle, login, password AS __user_passworD, online, alert, departure, success_alert', ['vgsos']);

                $this->userStatus = 'vgsv';
            }
        } else {
            session_destroy();
        }
    }

    protected function checkUser() 
    {
        if(!is_null($this->currentUser)) {
            if($this->userStatus == 'admin') {
                return $this->userStatus;
            } else if ($this->userStatus == 'vgsv') {
                return $this->userStatus;
            }
        } else {
            \Modules\Helpers\redirect('/CALL_VGSO/login/hub');
        }
    }

    protected function checkNoUser() 
    {
        if(is_null($this->currentUser)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function checkVgsv() 
    {
        $user = $this->checkUser();
        if(!($user == 'vgsv')) {
            throw new \Modules\Exception\Page403Exception;
        }
    }

    protected function checkAdmin() 
    {
        $user = $this->checkUser();
        if(!($user == 'admin')) {
            throw new \Modules\Exception\Page403Exception;
        }
    }

    /**
     * add some elements to main array $context
     */
    protected function contextAppend(array &$context) 
    {
        $context['__currentUser'] = $this->currentUser;
        $context['__userStatus'] = $this->userStatus;
    }

    /**
     * render template with function render from file modules/helpers.php
     * add some to array $context with function contentAppend()
     */
    public function render(string $template, array $context)
    {
        $this->contextAppend($context);
        \Modules\Helpers\render($template, $context);
    }
}

?>