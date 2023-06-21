<?php

namespace Modules\Model;
class Disposition extends BaseModel 
{
    protected const TABLE_NAME = 'dispositions';
    protected const DEFAULT_ORDER = 'vgsv';
    protected const RELATIONS = ['mines' => ['external' => 'mine', 'primary' => 'id'], 'accidents' => ['external' => 'accident', 'primary' => 'id'], 'main_vgsv' => ['external' => 'vgsv', 'primary' => 'id']];
}

?>