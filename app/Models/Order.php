<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //订单表
    protected $table = 'tab_bid_record';
    Public $timestamps = false;
    protected $pagnum = 10;
    
    public function getAll() {
        $orders =  $this->paginate($this->pagnum);
        return $orders;
    }
    //关联member_address表
    public function relateAddress() {
        return $this->hasOne('App\Models\Address','id','addressid');
    }
    //关联标表
    public function object() {
        return $this->belongsTo('App\Models\Object','o_id','id');
    }   
    //关联商品表
    public function goods() {
        return $this->hasOne('App\Models\Goods','id','g_id');
    }   
    //用户表
    public function user() {
        return $this->hasOne('App\Models\Member','usr_id','usr_id');
    }   
    //关联邀请好友获取的商品表
    public function inviteGoods() {
        return $this->hasOne('App\Models\InviteGoods','id','g_id');
    }  
    
}
