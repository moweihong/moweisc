<?php

namespace App\Repositories\Interfaces;


interface UserRepositoryInterface
{

    public function findBuyRecordUser($uid);//根据uid找出用户所有购买记录

    public function findBuyRecordUserLimit($uid, $limit);//根据uid找出用户限定条数的购买记录

    public function findBuyRecordAllLimit($oid,$gid,$limit);//查询最新的全站购买记录$limit条

    public function findBuyRecordOrderByTime($time, $orderby, $limit);//查询按照时间排序的$limit条记录

    public function findShoppingCart($uid);//查询用户购物车信息

    public function findUserInfo($uid);//查出用户信息

    public function findUserInfoWithArray($arruid);//查出一组

    public function findBuyRecordWithId($id, $limit);//根据标的id查询出对应的所有用户购买记录,限定$limit条

    public function findBuyRecordUserWithId($id, $uid, $limit);//根据标的id查询出对应的所有用户购买记录,限定$limit条
    
    public function findLoginTime($uid);//查询用户最近的登陆时间，返回时间戳

    public function reduceMoney($uid,$money);//减少用户的余额

    public function moneyChangeLog($uid,$money,$type,$message='');//余额变更日志表

}
