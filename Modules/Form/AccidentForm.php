<?php

namespace Modules\Form;
class AccidentForm extends BaseForm
{
    protected const FIELDS = 
    [
        'accident' => ['fieldType' => 'select', 'labelName' => 'Выберите тип аварии'],

        'mine' => ['fieldType' => 'select', 'labelName' => 'Выберите шахту, на которой произошла авария'],

        'sender' => ['fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Кто вызвал', 'type' => 'string'],

        'accident_timestamp' => ['type' => 'timestamp', 'fieldType' => 'timestamp', 'labelName' => 'Укажите дату и время аварии'],

        '__token' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden', 'noSave' => TRUE],
    ];
}

?>