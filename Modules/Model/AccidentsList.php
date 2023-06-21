<?php

namespace Modules\Model;
class AccidentsList extends BaseModel 
{
    protected const TABLE_NAME = 'accidents_list';
    protected const DEFAULT_ORDER = 'accident_timestamp DESC';
    protected const RELATIONS = ['mines' => ['external' => 'mine', 'primary' => 'id'], 'accidents' => ['external' => 'accident', 'primary' => 'id'], 'main_vgsv' => ['external' => 'vgsv', 'primary' => 'id'], 'vgsos' => ['external' => 'vgso', 'primary' => 'id']];
}

?>