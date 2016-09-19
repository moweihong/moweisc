<?php

namespace App\Models;

use App\Models\Relations\BelongsToObjectsTrait;
use Illuminate\Database\Eloquent\Model;

class Bid_record extends Model
{
    use BelongsToObjectsTrait;
    public   $table  =  'tab_bid_record';
	Public $timestamps = false;
	protected $tableShoplist='ykg_goods';//商品表
    public function getAll(){
        $article_cat = $this->paginate(10);
        return $article_cat;
    }
	
	//获取用户未晒单的记录
	public function getUserNoShow($uid)
	{
		
		$res =$this
	   //->where($this->tableShoplist.'.isdeleted','0')
	   ->where('fetchno','<>','0')
	   ->where('ykg_goods.is_virtual','0')
	   ->where('tab_bid_record.status',5)
	   ->where('tab_bid_record.usr_id',$uid)
	   ->join($this->tableShoplist,$this->tableShoplist.'.id','=',$this->table.'.g_id')
       ->select($this->table.'.*',$this->tableShoplist.'.thumb',$this->tableShoplist.'.money')
       ->paginate(20);
	   //print_r($res);exit;
	
	   return $res;
	}
	
	//获取用户未晒单的记录
	public function getUserNoShow_m($uid)
	{
	
	    $res =$this
	    //->where($this->tableShoplist.'.isdeleted','0')
	    ->where('fetchno','<>','0')
	    ->where('ykg_goods.is_virtual','0')
	    ->where('tab_bid_record.status','<>', 6)
	    ->where('tab_bid_record.usr_id',$uid)
	    ->join($this->tableShoplist,$this->tableShoplist.'.id','=',$this->table.'.g_id')
	    ->select($this->table.'.*',$this->tableShoplist.'.thumb',$this->tableShoplist.'.money')
	    ->paginate(20);
	    //print_r($res);exit;
	
	    return $res;
	}
	
	//用户表
    public function user() {
        return $this->hasOne('App\Models\Member','usr_id','usr_id');
    }   
}
