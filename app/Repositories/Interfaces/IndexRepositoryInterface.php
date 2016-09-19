<?php

namespace App\Repositories\Interfaces;


interface IndexRepositoryInterface
{

    //获取最新揭晓商品
    public function findLatest($limit);

    //获取已经揭晓商品数量
    public function findLatestCount();

    //轮播图片数据
    public function findSlide($type);
    //即将揭晓数据 按照剩余人次升序
    public function findSoon($limit);

    //正在购买数据
    public function findIsBuy($limit);

    //全部商品数据，按照期数最多的排序 desc
    public function findAll($order);

    //新品上架数据 按照goods表的time 降序
    public function findNew($limit);

    //晒单分享数据
    public function findShow($limit);

    //获取页面底部数据
    public function findFooter($order);

    //获取导航条数据
    public function findNavigata($order);

    //获取所有一级分类
    public function findCategory();

    //获取所有二级分类
    public function findCategoryChild($cateid);

    //获取10条公告
    public function findArticles($limit);


}
