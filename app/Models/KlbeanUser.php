<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlbeanUser extends Model {
    public   $table  =  'tab_klbean_user';  //天天免费抽奖记录表
    public   $timestamps = false;
	
	 //用户表
    public function user() {
        return $this->hasOne('App\Models\Member','usr_id','user_id');
    }   
    
}