<?php

namespace App\Models\Relations;

trait HasManyObjectsTrait
{

    //映射Object表
    public function hasManyObjects()
    {
        return $this->hasMany('App\Models\Object','g_id');
    }

}
