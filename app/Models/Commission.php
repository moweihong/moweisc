<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    //佣金记录表
    public   $table  =  'tab_member_commission_record';
    public $timestamps = false;
    
    public function getAll() {
        return $this->paginate(10);
    }
    //用户member表
   public function member() {
        return $this->hasOne('App\Models\Member','usr_id','source_usr_id');
    } 
}
