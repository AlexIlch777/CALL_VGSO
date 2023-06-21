<?php

namespace Modules\Form;
class NewChangeForm extends BaseForm
{
    protected const FIELDS = 
    [
        'vgsv' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden'],
        
        /* duty department info */
        'duty_department_senior_commander_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО старшего командира дежурной смены', 'blockName' => 'duty-department-info'],

        'duty_department_senior_commander_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона старшего командира дежурной смены', 'blockName' => 'duty-department-info'],
        
        'duty_department_number' => ['fieldType' => 'select', 'labelName' => 'Выберите номер дежурного отделения', 'blockName' => 'duty-department-info'],

        'duty_department_commander_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО командира дежурного отделения', 'blockName' => 'duty-department-info'],

        'duty_department_commander_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона командира дежурного отделения', 'blockName' => 'duty-department-info'],

        'duty_department_vehicle' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите марку и госномер автомобиля дежурного отделения', 'blockName' => 'duty-department-info'],

        /* reserve department name */
        'reserve_department_senior_commander_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО старшего командира резервной смены', 'blockName' => 'reserve-department-info'],

        'reserve_department_senior_commander_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона старшего командира резервной смены', 'blockName' => 'reserve-department-info'],
        
        'reserve_department_number' => ['fieldType' => 'select', 'labelName' => 'Выберите номер резервного отделения', 'blockName' => 'reserve-department-info'],

        'reserve_department_commander_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО командира резервного отделения', 'blockName' => 'reserve-department-info'],

        'reserve_department_commander_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона командира резервного отделения', 'blockName' => 'reserve-department-info'],

        'reserve_department_vehicle' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите марку и госномер автомобиля резервного отделения', 'blockName' => 'reserve-department-info'],

        /* oto info */
        'oto_duty_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО дежурного ОТО', 'buttonId' => 'add-oto', 'optional' => TRUE],

        'oto_duty_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона дежурного ОТО', 'buttonId' => 'add-oto', 'optional' => TRUE],

        /* sds info */
        'sds_duty_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО дежурного СДС', 'buttonId' => 'add-sds', 'optional' => TRUE],

        'sds_duty_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона дежурного СДС', 'buttonId' => 'add-sds', 'optional' => TRUE],

        /* mber info */
        'mber_duty_name' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите ФИО дежурного МБЭР', 'buttonId' => 'add-mber', 'optional' => TRUE],

        'mber_duty_telephone_number' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите номер телефона дежурного МБЭР', 'buttonId' => 'add-mber', 'optional' => TRUE],

        'mber_vehicle' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'text', 'labelName' => 'Укажите марку и госномер автомобиля скорой медицинской помощи для доставки МБЭР', 'buttonId' => 'add-mber', 'optional' => TRUE],

        /* kil info */
        'kil_status' => ['type' => 'boolean', 'fieldType' => 'checkbox', 'labelName' => 'Отметьте наличие КИЛ', 'blockName' => 'additional_department'],

        /* asi info */
        'asi_status' => ['type' => 'boolean', 'fieldType' => 'checkbox', 'labelName' => 'Отметьте наличие АСИ', 'blockName' => 'additional_department'],

        /* forces info */
        'people_forces' => ['type' => 'integer', 'fieldType' => 'input', 'inputType' => 'number', 'labelName' => 'Укажите группировку сил на смене (человек)', 'blockName' => 'forces-info'],
        
        'auto_forces' => ['type' => 'integer', 'fieldType' => 'input', 'inputType' => 'number', 'labelName' => 'Укажите группировку средств на смене (автомобилей)', 'blockName' => 'forces-info'],

        '__token' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden', 'noSave' => TRUE]
    ];
}

?>