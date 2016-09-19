<?php

namespace App\Repositories\Interfaces;


interface ProductRepositoryInterface
{

     //根据id查找Goods表
     public  function findInGoods($o_id);

     //查找全部可用商品的数量
     public  function findAllGoods();

     //根据id查询Object表
     public  function findInObject($o_id);

     //联合Goods和Object表根据id进行查询
     public  function findObjectBelongsGoods($o_id);

     //根据商品gid查询所有相关晒单
     public  function findShowWithGid($gid);

     //根据商品gid查询相关晒单，进行分页
     public  function findShowWithGidPaginate($gid,$limit);

     //根据gid查询所有期数和相关的o_id
     public  function findAllPeriodsByGid($gid,$limit);

     //根据标的id查询商品gid
     public  function findGidWithObjectId($o_id);

     //根据brandid查出所有相关商品，并分页
     public  function findAllProductByBrandid($brandid,$pagesize,$order);

     //根据catid查出所有相关商品，并分页
     public  function findAllProductByCatid($catid,$pagesize,$order);

     //查询全站的商品,不区分品牌和cateid
     public  function findAllProduct($pagesize,$order);

     //查询全站的商品,不区分品牌和cateid,无分页
     public  function findAllProductNopaginate($pagesize,$order);

     //根据catid查出相关商品信息，不分页，默认排序
     public  function findLimitProductByCatid($catid,$limit,$order='default');

     //根据标的id查询商品开奖状态，返回0,1,2三种状态
     public  function findStatusProductById($o_id);

     //根据o_id获取最新一期商品
     public  function findLatestGoods($o_id);

     //根据o_id获取指定o_id之前的$limit期
     public  function findOidAndPeriods($o_id,$limit);

     //获取最新揭晓和即将揭晓的商品
     public  function findAnnouncement($limit);

     //获取指定数量揭晓商品，按照剩余人数进行排序
     public  function findOverPlusGoods($limit,$order='participate_person');

     //模糊搜索，根据商品名称搜索商品
     public  function findGoodsWithLike($key,$limit);

     //查询商品是否已经开奖,返回0(可购买),1(正在开奖),2(已经开奖)
     public  function findProductStatus($oid);


}
