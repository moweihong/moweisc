<?php

namespace App\Models\Relations;

trait HasOneObjectsTrait
{

    //映射Object表
    public function hasOneObject()
    {
        return $this->hasOne('App\Models\Object','g_id');
    }

}
