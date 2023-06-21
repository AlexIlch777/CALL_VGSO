<?php

namespace Modules\Form;
class VgsvLoginForm extends BaseForm
{
    protected const FIELDS = 
    [
        'login' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Введите логин ВГСВ'],

        'password' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'password', 'labelName' => 'Введите пароль ВГСВ'],

        '__token' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden', 'noSave' => TRUE]
    ];

    static function verifyVgsv(&$data) 
    {
        $errors = [];
        $vgsvs = new \Modules\Model\MainVgsv;
        $vgsv = $vgsvs->get($data['login'], 'login', 'id, password');
        if(!$vgsv) {
            $errors['login'] = 'Неверное имя пользователя';
        } else {
            if (!password_verify($data['password'], $vgsv['password'])) {
                $errors['password'] = 'Неверный пароль';
            } else {
                return $vgsv['id'];
            }
        }
    $data['__errors'] = $errors;
    }
}

?>