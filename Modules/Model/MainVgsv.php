<?php

namespace Modules\Model;
class MainVgsv extends BaseModel 
{
    protected const TABLE_NAME = 'main_vgsv';
    protected const DEFAULT_ORDER = 'timestamp DESC';
    protected const RELATIONS = ['vgsos' => ['external' => 'vgso', 'primary' => 'id']];
}

?>