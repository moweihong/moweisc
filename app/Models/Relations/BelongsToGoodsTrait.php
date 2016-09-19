<?php

namespace App\Models\Relations;

trait BelongsToGoodsTrait
{

    //属于Goods表
    public function belongsToGoods()
    {
        return $this->belongsTo('App\Models\Goods','g_id');
    }

}
