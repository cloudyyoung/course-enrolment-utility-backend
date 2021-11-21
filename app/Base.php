<?php


namespace App;

class Base
{

    public function __toArray()
    {
        return json_decode(json_encode($this));
    }

    public function info($a = null)
    {
        return $this->__toArray();
    }

    public function dump()
    {
        return get_object_vars($this);
    }
}
