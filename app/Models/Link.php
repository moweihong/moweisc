<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'tab_link';
    Public $timestamps = false;
    public function getAll(){
        $links = $this->paginate(10);        
        return $links;
    }
}
