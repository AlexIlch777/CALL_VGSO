<?php

namespace Modules\Form;
class UpdateVgsvInfoForm extends BaseForm
{
    protected const FIELDS = 
    [
        'name' => ['type' => 'string', 'optional' => TRUE],

        'vgso' => ['type' => 'integer', 'optional' => TRUE],

        'radio_call' => ['type' => 'string', 'optional' => TRUE],

        'telephone_number' => ['type' => 'string', 'optional' => TRUE],

        'senior_commander_name' => ['type' => 'string', 'optional' => TRUE],

        'senior_commander_telephone_number' => ['type' => 'string', 'optional' => TRUE],

        'apo_vehicle' => ['type' => 'string', 'optional' => TRUE],

        'login' => ['type' => 'string', 'optional' => TRUE],

        '__token' => ['type' => 'string', 'noSave' => TRUE]
    ];
}

?>