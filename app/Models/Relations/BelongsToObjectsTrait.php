<?php

namespace App\Models\Relations;

trait BelongsToObjectsTrait
{

    public function belongsToObjects()
    {
        return $this->belongsTo('App\Models\Object','o_id');
    }

}
