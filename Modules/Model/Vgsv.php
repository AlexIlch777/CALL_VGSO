<?php

namespace Modules\Model;
class Vgsv extends BaseModel 
{
    protected const TABLE_NAME = 'vgsvs';
    protected const DEFAULT_ORDER = 'start_timestamp DESC';
    protected const RELATIONS = ['main_vgsv' => ['external' => 'vgsv', 'primary' => 'id']];
}

?>