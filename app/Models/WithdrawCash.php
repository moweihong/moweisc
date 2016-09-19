<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawCash extends Model
{
    //银行卡转账表
    public $table = 'tab_withdraw_cash';
    Public $timestamps = false;
    
    public function getAll() {
        return $this->paginate(10);
    }	
    
    //关联银行卡
    public function bank() {
        return $this->hasOne('App\Models\Bank','id','bankid');
    }   
    //关联用户表
    public function user() {
        return $this->hasOne('App\Models\Member','usr_id','uid');
    }   
    
}
