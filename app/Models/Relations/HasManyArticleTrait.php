<?php

namespace App\Models\Relations;

trait HasManyArticleTrait
{

    public function hasManyAtricles()
    {
        return $this->hasMany('App\Models\Article','cat_id');
    }

}
