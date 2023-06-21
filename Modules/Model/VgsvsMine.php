<?php

namespace Modules\Model;
class VgsvsMine extends BaseModel 
{
    protected const TABLE_NAME = 'vgsvs_mines';
    protected const DEFAULT_ORDER = 'vgsv';
    protected const RELATIONS = ['mines' => ['external' => 'mine', 'primary' => 'id']];
}

?>