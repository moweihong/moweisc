<?php

namespace App\Models\Relations;

trait HasManyGoodsTrait
{

    //有许多商品
    public function hasManyGoods()
    {
        return $this->hasMany('App\Models\Cart','usr_id');
    }

}
