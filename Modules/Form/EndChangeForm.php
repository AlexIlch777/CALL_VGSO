<?php

namespace Modules\Form;
class EndChangeForm extends BaseForm
{
    protected const FIELDS = 
    [
        '__token' => ['type' => 'string', 'fieldType' => 'input', 'inputType' => 'hidden', 'noSave' => TRUE]
    ];
}

?>