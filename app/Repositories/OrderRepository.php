<?php

namespace App\Repositories;

/*
 *OrderRepository仓库
 */
use App\Models\Bid_record;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository extends Repository implements OrderRepositoryInterface
{
    //获取100条购买记录的用户id和购买数量,时间
    public function findLotteryRecord($o_id, $limit)
    {
        //获取商品最后成交时间
        $lasttime=$this->findDealTime($o_id);
        //通过最后成交时间查询100条购买记录
        $buyrecord=Bid_record::where('bid_time','<=',!empty($lasttime)?$lasttime:0)
            ->where('pay_type','!=','invite')
            ->orderBy('id','desc')->take($limit)->get();
        return $this->object2Array($buyrecord);
    }

    //获取商品成交时间
    public function findDealTime($o_id)
    {
        $time=Bid_record::where('o_id',$o_id)->orderBy('id','desc')->get(['bid_time']);
        foreach ($time as $k=>$v){
            return $v->bid_time;
        }

    }

    //获取中奖用户usr_id
    public function findFetchUser($o_id)
    {
        $usrid=Bid_record::where('o_id',$o_id)->where('fetchno','>',0)->get(['usr_id','bid_time','kaijiang_time','buycount','fetchno']);
        return $this->object2Array($usrid);
    }

    //获取10条最新的中奖记录
    public function getPrizeList(){
        return Bid_record::leftjoin('tab_member', 'tab_member.usr_id', '=', 'tab_bid_record.usr_id')->where('tab_bid_record.fetchno','>',0)->orderBy('tab_bid_record.kaijiang_time','desc')->take(10)->get(['tab_bid_record.*', 'tab_member.nickname']);
    }
}
