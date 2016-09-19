<?php

namespace App\Models\Relations;

trait HasManyShowTrait
{

    public function objectHasManyShow()
    {
        return $this->hasMany('App\Models\Show','sd_gid');
    }

}
