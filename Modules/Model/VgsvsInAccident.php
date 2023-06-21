<?php

namespace Modules\Model;
class VgsvsInAccident extends BaseModel 
{
    protected const TABLE_NAME = 'vgsvs_in_accidents';
    protected const DEFAULT_ORDER = 'id';
    protected const RELATIONS = ['accidents_list' => ['external' => 'accident', 'primary' => 'id'], 'vgsvs' => ['external' => 'current_change', 'primary' => 'id'], 'main_vgsv' => ['external' => 'vgsv', 'primary' => 'id']];
}

?>