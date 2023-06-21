<?php

namespace Modules\Controller;
class LoginController extends BaseController
{
    public function vgsvLogin()
    {
        $checkNoUser = $this->checkNoUser();
        
        $loginForm;
        
        if($checkNoUser === TRUE) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                \Modules\Helpers\checkToken($_POST);
                $loginForm = \Modules\Form\VgsvLoginForm::getNormalizedData($_POST);
                if(!isset($loginForm['__errors'])) {
                    $loginForm = \Modules\Form\VgsvLoginForm::getPreparedData($loginForm);
                    $vgsvId = \Modules\Form\VgsvLoginForm::verifyVgsv($loginForm);
                    if($vgsvId) {
                        session_start();
                        $_SESSION['currentUser'] = $vgsvId;
                        $_SESSION['userStatus'] = 'vgsv';
                        \Modules\Helpers\redirect('/CALL_VGSO');
                    }
                }
            } else {
                $loginForm = \Modules\Form\VgsvLoginForm::getInitialData();
            }

            $loginForm['__token'] = \Modules\Helpers\generateToken();

            $context = 
            [
                'formData' => $loginForm,
                'siteTitle' => 'Вход',
                'style' => 'login_page',
            ];

            $this->render('vgsv_login', $context);
        } else {
            \Modules\Helpers\redirect('/CALL_VGSO/login/hub');
        }
    }

    public function adminLogin()
    {
        $checkNoUser = $this->checkNoUser();
        
        $loginFrom;

        if($checkNoUser === TRUE) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                \Modules\Helpers\checkToken($_POST);
                $loginForm = \Modules\Form\AdminLoginForm::getNormalizedData($_POST);
                if(!isset($loginForm['__errors'])) {
                    $loginForm = \Modules\Form\AdminLoginForm::getPreparedData($loginForm);
                    $adminId = \Modules\Form\AdminLoginForm::verifyAdmin($loginForm);
                    if($adminId) {
                        session_start();
                        $_SESSION['currentUser'] = $adminId;
                        $_SESSION['userStatus'] = 'admin';
                        \Modules\Helpers\redirect('/CALL_VGSO');
                    }
                }
            } else {
                $loginForm = \Modules\Form\AdminLoginForm::getInitialData();
            }
            
            $loginForm['__token'] = \Modules\Helpers\generateToken();
            
            $context = 
            [
                'formData' => $loginForm,
                'siteTitle' => 'Вход',
                'style' => 'login_page',
            ];
            $this->render('admin_login', $context);
        } else {
            \Modules\Helpers\redirect('/CALL_VGSO/login/hub');
        }
    }

    public function logout() 
    {
        $this->checkUser();
        $formData;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Modules\Helpers\checkToken($_POST);
            unset($_SESSION['currentUser']);
            unset($_SESSION['userStatus']);
            session_destroy();
            \Modules\Helpers\redirect('/CALL_VGSO/login/hub');
        } else {
            $formData = \Modules\Form\LogoutForm::getInitialData();
            $formData['__token'] = \Modules\Helpers\generateToken();
            
            $context = 
            [
                'formData' => $formData,
                'siteTitle' => 'Выход из аккаунта',
            ];
            $this->render('logout', $context);
        }
    }

    public function hub() 
    {
        $checkNoUser = $this->checkNoUser();
        
        $context = 
        [
            'style' => 'login_hub',
        ];

        if($checkNoUser === TRUE) {
            $context['siteTitle'] = 'Точка входа в приложение';
            $this->render('login_hub', $context);
        } else {
            $context['siteTitle'] = 'Вход в аккаунт уже выполнен';
            $this->render('login_hub_unavailable', $context);
        }
    }
}

?>