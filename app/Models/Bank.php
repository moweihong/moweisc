<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //银行卡
    public   $table  =  'tab_bank';
    protected $dateFormat = 'U';
    
    //关联提现表，1对多
    public function withdrawcash() {
        return $this->hasMany('App\Models\WithdrawCash','bankid','id');
    }
}
