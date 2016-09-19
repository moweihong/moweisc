<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlbeanCharge extends Model {
    public   $table  =  'tab_klbean_charge';  //天天免费抽奖记录表
    public   $timestamps = false;
	
	 //用户表
    public function user() {
        return $this->hasOne('App\Models\Member','usr_id','recommend_id');
    } 
	
	//用户表2
	public function usersec() {
        return $this->hasOne('App\Models\Member','usr_id','usr_id');
    }  
    
}