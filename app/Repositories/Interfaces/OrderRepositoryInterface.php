<?php

namespace App\Repositories\Interfaces;


interface OrderRepositoryInterface
{

    //获取100条购买记录的用户id和购买数量,时间
    public function findLotteryRecord($o_id,$limit);

    //通过商品o_id获取该商品成交时间
    public function findDealTime($o_id);

    //通过o_id获取中奖用户信息
    public function findFetchUser($o_id);

}
