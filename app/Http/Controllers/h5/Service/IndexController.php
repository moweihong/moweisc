<?php
namespace App\Http\Controllers\h5\Service;

/*
 * 商品相关控制器
 * */

use App\Facades\IndexRepositoryFacade;
use App\Facades\UserRepositoryFacade;
use App\Http\Controllers\ForeController;
use App\Mspecs\M3Result;

class IndexController extends ForeController
{

    public function __construct()
    {
        $this->jsonMspecs = new M3Result();
    }

    //获取最新揭晓商品
    public function getLatest()
    {
        $data['latest'] = IndexRepositoryFacade::findLatest(2);
        $arr=config('goods');
        $data['data']=array_values(array_except($arr,array_rand($arr,6)));
        foreach ($data['data'] as $key=>$val){
            $data['data'][$key]['ltime']=date('Y/m/d H:i:s',time()+rand(1,550));
            $data['data'][$key]['path']='/announcement';
        }
        //构造数组
        $arr1=array();
        foreach ($data['latest'] as $k=>$v){
            $arr1[$k]['title']=$v['belongs_to_goods']['title'];
            $arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
            $arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
            $arr1[$k]['money']=$v['belongs_to_goods']['money'];
            $arr1[$k]['path']='/product/'.$v['id'];
            $arr1[$k]['id']=$v['id'];
        }
        unset($data['latest']);
        $count=count($arr1);
        for ($i=0;$i<$count;$i++){
            array_shift($data['data']);
            array_push($data['data'],$arr1[$i]);
        }
        shuffle($data['data']);
        $data['latest_count']= IndexRepositoryFacade::findLatestCount();
        return $this->packageData($data);
    }
    //获取热门推荐商品
    public function getSoon()
    {
        $data['soon'] = IndexRepositoryFacade::findSoon(8);
        foreach ($data['soon'] as $k=>$v){
            $data['soon'][$k]['rate']=round($v['participate_person']/$v['total_person'],4)*100;
        }
        return $this->packageData($data);
    }

    //获取最新揭晓商品
    public function getNew()
    {
        $data['new']=IndexRepositoryFacade::findNew(8);
        return $this->packageData($data);
    }
    //获取全部商品
    public function getAll()
    {
        //全部商品数据，按照期数最多的排序 desc
        $data['all']=IndexRepositoryFacade::findAll('periods');
        foreach ($data['all'] as $k=>$v){
            $data['all'][$k]['rate']=round($v['participate_person']/$v['total_person'],4)*100;
        }
        return $this->packageData($data);
    }
    //获取最新购买

    public function getIsbuy()
    {
        $data['isbuy']=IndexRepositoryFacade::findIsBuy(8);
        $userIds=[];
        foreach ($data['isbuy'] as $v){
            array_push($userIds,$v['usr_id']);
        }
        $userInfos=UserRepositoryFacade::findUserInfoWithArray($userIds);
        foreach ($data['isbuy']  as &$v){
            foreach ($userInfos as $v2){
                if($v2['usr_id']==$v['usr_id']){
                    $v2['nickname']=!empty($v2['nickname'])?$v2['nickname']:config('global.default_nickname');
                    $v2['user_photo']=!empty($v2['user_photo'])?$v2['user_photo']:config('global.default_photo');
                    $v['userinfo']=$v2;
                }
            }
        }

        return $this->packageData($data);
    }
    //获取晒单分享
    public function getShow()
    {
        $data['show']=IndexRepositoryFacade::findShow(7);
        return $this->packageData($data);
    }
    //获取底部数据
    public function getFooter()
    {
        $data['footer']=IndexRepositoryFacade::findFooter('sort_order');
        return $this->packageData($data);
    }
    //获取全部商品导航记录
    public function getNavigata()
    {
        $data['navigata'] = IndexRepositoryFacade::findNavigata('sort_order');//0.1s
        return $this->packageData($data);
    }
   
    //获取首页公告内容
    public function getArticles()
    {
        $data['articles']=IndexRepositoryFacade::findArticles(10);
        return $this->packageData($data);
    }

    public function packageData(Array $data){
        //封装数据
        if (is_array($data) && !empty($data)) {
            $this->jsonMspecs->status = '0';
            $this->jsonMspecs->message = 'success';
            $this->jsonMspecs->data = $data;
        } else {
            $this->jsonMspecs->status = '100001';
            $this->jsonMspecs->message = 'fail';
            $this->jsonMspecs->data = array();
        }
        return $this->jsonMspecs->toJson();
    }


}