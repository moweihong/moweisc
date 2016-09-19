<?php

namespace App\Models\Relations;

trait HasManyOrdersTrait
{

    //member has many orders relations
    public function memberHasManyOrders()
    {
        return $this->hasMany('App\Models\Bid_record','usr_id');
    }

    //objects has many orders relations
    public  function  objectHasManyOrders(){
        return $this->hasMany('App\Models\Bid_record','o_id');
    }
}
