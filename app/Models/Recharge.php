<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    protected $table = 'tab_recharge';
    Public $timestamps = false;
    //关联订单表
    public function order() {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }   
    //用户表
    public function user() {
        return $this->hasOne('App\Models\Member','usr_id','usr_id');
    }
}
