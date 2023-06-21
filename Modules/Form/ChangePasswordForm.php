<?php

namespace Modules\Form;
class ChangePasswordForm extends BaseForm
{
    protected const FIELDS = 
    [
        'login' => ['type' => 'string', 'fieldType' => 'input', 'noSave' => TRUE, 'inputType' => 'hidden'],

        'userStatus' => ['type' => 'string', 'fieldType' => 'input', 'noSave' => TRUE, 'inputType' => 'hidden'],

        'currentPassword' => ['type' => 'string', 'fieldType' => 'input', 'noSave' => TRUE, 'inputType' => 'hidden'],

        'password1' => ['type' => 'string', 'fieldType' => 'input', 'noSave' => TRUE, 'inputType' => 'password', 'labelName' => 'Укажите текущий пароль', 'blockName' => 'current-password'],

        'password2' => ['type' => 'string', 'fieldType' => 'input', 'noSave' => TRUE, 'inputType' => 'password', 'labelName' => 'Укажите новый пароль', 'blockName' => 'new-password'],

        'password3' => ['type' => 'string', 'fieldType' => 'input', 'noSave' => TRUE, 'inputType' => 'password', 'labelName' => 'Подтвердите новый пароль', 'blockName' => 'new-password'],

        '__token' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden', 'noSave' => TRUE]
    ];

    protected static function afterNormalizeData(&$data, &$errors)
    {
        if(!password_verify($data['password1'], $data['currentPassword'])) {
            $errors['password1'] = 'Текущий пароль неверный';
        }

        if($data['password1'] == $data['password2']) {
            $errors['password2'] = 'Вы указали такой же пароль как и был до этого';
        }

        if($data['password2'] != $data['password3']) {
            $errors['password3'] = 'Вы не подтвердили новый пароль. Попробуйте ещё раз';
        }
    }

    protected static function afterPrepareData(&$data, &$normData) 
    {
        $data['password'] = password_hash($normData['password2'], PASSWORD_BCRYPT);
    }
}

?>