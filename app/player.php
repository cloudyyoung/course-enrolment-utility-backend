<?php

namespace App;

use App\Base;

class Player extends Base
{
    public $account_id;
    public $character_id;
    private $clue;

    public function __construct($object)
    {
        if (is_array($object)) $object = (object) $object;
        $this->account_id = $object->account_id;
        $this->character_id = $object->character_id;
        $this->clue = $object->clue;
    }

    public function info($a = null)
    {
        $array = $this->__toArray();
        return $array;
    }

    public function dump()
    {
        return get_object_vars($this);
    }
}
