<?php

namespace Modules\Form;
class AdminLoginForm extends BaseForm
{
    protected const FIELDS = 
    [
        'login' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Введите логин администратора'],

        'password' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'password', 'labelName' => 'Введите пароль администратора'],

        '__token' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden', 'noSave' => TRUE]
    ];

    static function verifyAdmin(&$data) 
    {
        $errors = [];
        $admins = new \Modules\Model\Admin;
        $admin = $admins->get($data['login'], 'login', 'id, password');
        if(!$admin) {
            $errors['login'] = 'Неверное имя пользователя';
        } else {
            if (!password_verify($data['password'], $admin['password'])) {
                $errors['password'] = 'Неверный пароль';
            } else {
                return $admin['id'];
            }
        }
    $data['__errors'] = $errors;
    }
}

?>