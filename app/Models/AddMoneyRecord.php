<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddMoneyRecord extends Model {
    public   $table  =  'tab_member_addmoney_record';  //用户红包表
    public   $timestamps = false;
    
    /*
     * 关联member表
     */
    public function user()
    {
        return $this->hasOne('App\Models\Member','usr_id','usr_id');
    }
}