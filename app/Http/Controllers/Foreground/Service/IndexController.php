<?php
namespace App\Http\Controllers\Foreground\Service;

/*
 * 商品相关控制器
 * */

use App\Facades\IndexRepositoryFacade;
use App\Facades\UserRepositoryFacade;
use App\Http\Controllers\ForeController;
use App\Mspecs\M3Result;
use App\Models\Member;
use App\Models\Object;
use App\Models\Bid_record;

class IndexController extends ForeController
{

    public function __construct()
    {
        $this->jsonMspecs = new M3Result();
    }

    //获取最新揭晓商品
    public function getLatest()
    {
	    $latest = IndexRepositoryFacade::findLatest(5);
	    $open = IndexRepositoryFacade::findLatestOpen(5);

	    //构造数组
	    $arr1=$arr2=array();
	    foreach ($latest as $k=>$v){
		    $arr1[$k]['title']=$v['belongs_to_goods']['title'];
		    $arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
		    $arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
		    $arr1[$k]['money']=$v['belongs_to_goods']['money'];
		    $arr1[$k]['path']='/product/'.$v['id'];
		    $arr1[$k]['id']=$v['id'];
		    $arr1[$k]['is_lottery']=$v['is_lottery'];
	    }
	    foreach($open as $k => $v){
		    $arr2[$k]['title']=$v['belongs_to_goods']['title'];
		    $arr2[$k]['thumb']=$v['belongs_to_goods']['thumb'];
		    $arr2[$k]['money']=$v['belongs_to_goods']['money'];
		    $arr2[$k]['path']='/product/'.$v['id'];
		    $arr2[$k]['id']=$v['id'];
		    $arr2[$k]['is_lottery']=$v['is_lottery'];
		    $arr2[$k]['nickname']=$v['nickname'];
		    $arr2[$k]['usr_id']=$v['usr_id'];
	    }

	    krsort($arr1);

	    $data['data'] = array_slice(array_merge($arr1, $arr2), 0, 5);

        $data['latest_count']= IndexRepositoryFacade::findLatestCount();
        return $this->packageData($data);
    }

	public function getLotteryResult(){
		$o_id = $this->getParam('o_id');
		$object = Object::find($o_id);
		if($object->is_lottery == 2){  //已开奖，查询中奖用户
			$open = Object::with('belongsToGoods')->where('id', $o_id)->first()->toArray();
			$bid_record = Bid_record::where('o_id', $o_id)->where('fetchno', $open['lottery_code'])->first();
			$winner = Member::where('usr_id', $bid_record->usr_id)->first();
			$open['nickname'] = $winner->nickname;
			$open['usr_id']   = $bid_record->usr_id;

			$arr2 = array();
			$arr2['title']=$open['belongs_to_goods']['title'];
			$arr2['thumb']=$open['belongs_to_goods']['thumb'];
			$arr2['money']=$open['belongs_to_goods']['money'];
			$arr2['path']='/product/'.$open['id'];
			$arr2['id']=$open['id'];
			$arr2['is_lottery']=$open['is_lottery'];
			$arr2['nickname']=$open['nickname'];
			$arr2['usr_id']  =$open['usr_id'];

			$data['data'] = $arr2;
			$data['latest_count']= IndexRepositoryFacade::findLatestCount();
		}else{
			$data = array();
		}

		return $this->packageData($data);
	}

	public function getLatest_m(){
		$o_id = $this->getParam('o_id');
		$object = Object::find($o_id);
		if($object->is_lottery == 2){  //已开奖，查询中奖用户
			$open = Object::with('belongsToGoods')->where('id', $o_id)->first()->toArray();
			$bid_record = Bid_record::where('o_id', $o_id)->where('fetchno', $open['lottery_code'])->first();
			$winner = Member::where('usr_id', $bid_record->usr_id)->first();
			$open['nickname'] = mb_substr($winner->nickname, 0, 5); //截取5个长度
			$open['usr_id']   = $bid_record->usr_id; 

			$arr2 = array();
			$arr2['title']=$open['belongs_to_goods']['title'];
			$arr2['thumb']=$open['belongs_to_goods']['thumb'];
			$arr2['money']=$open['belongs_to_goods']['money'];
			$arr2['path']='/product_m/'.$open['id'];
			$arr2['id']=$open['id'];
			$arr2['is_lottery']=$open['is_lottery'];
			$arr2['nickname']=$open['nickname'];
			$arr2['usr_id']=$open['usr_id'];
		}else{
			$arr2 = array();
		}

		return $this->packageData($arr2);
	}

	public function checkLatest(){
		$latest = IndexRepositoryFacade::findLatest(5);

		//构造数组
		$arr1=array();
		foreach ($latest as $k=>$v){
			$arr1[$k]['title']=$v['belongs_to_goods']['title'];
			$arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
			$arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
			$arr1[$k]['curtime']=date('Y/m/d H:i:s');
			$arr1[$k]['money']=$v['belongs_to_goods']['money'];
			$arr1[$k]['path']='/product/'.$v['id'];
			$arr1[$k]['id']=$v['id'];
		}

		if(count($arr1) <= 0){
			$data = array();
		}else{
			$data['data'] = $arr1;
			$data['latest_count']= IndexRepositoryFacade::findLatestCount();
		}

		return $this->packageData($data);
	}

	public function checkLatest_m(){
		$latest = IndexRepositoryFacade::findLatest(2);

		//构造数组
		$arr1=array();
		foreach ($latest as $k=>$v){
			$arr1[$k]['title']=$v['belongs_to_goods']['title'];
			$arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
			$arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
			$arr1[$k]['curtime']=date('Y/m/d H:i:s');
			$arr1[$k]['money']=$v['belongs_to_goods']['money'];
			$arr1[$k]['path']='/product_m/'.$v['id'];
			$arr1[$k]['id']=$v['id'];
		}

		if(count($arr1) <= 0){
			$arr1 = array();
		}

		return $this->packageData($arr1);
	}

	
	 //获取最新揭晓商品h5
//    public function getLatest_m()
//    {
//        $data['latest'] = IndexRepositoryFacade::findLatest(1);
//
//        $arr=config('goods');
//        $data['data']=array_values(array_except($arr,array_rand($arr,9)));
//
//        foreach ($data['data'] as $key=>$val){
//            $data['data'][$key]['ltime']=date('Y/m/d H:i:s',time()+rand(1,550));
//            $data['data'][$key]['curtime']=date('Y/m/d H:i:s');
//            $data['data'][$key]['path']='/announcement';
//        }
//        //构造数组
//        $arr1=array();
//        foreach ($data['latest'] as $k=>$v){
//            $arr1[$k]['title']=$v['belongs_to_goods']['title'];
//            $arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
//            $arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
//            $arr1[$k]['curtime']=date('Y/m/d H:i:s');
//            $arr1[$k]['money']=$v['belongs_to_goods']['money'];
//            $arr1[$k]['path']='/product_m/'.$v['id'];
//            $arr1[$k]['id']=$v['id'];
//        }
//        unset($data['latest']);
//        $count=count($arr1);
//        for ($i=0;$i<$count;$i++){
//            array_shift($data['data']);
//            array_push($data['data'],$arr1[$i]);
//        }
//        shuffle($data['data']);
//        $data['latest_count']= IndexRepositoryFacade::findLatestCount();
//        return $this->packageData($data);
//    }

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
        $data['news']=IndexRepositoryFacade::findNew(8);
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
		$i=0;
		foreach($data['show'] as &$d){
			$data['show'][$i]['sd_time'] = date('Y-m-d',$d['sd_time']);
			$user = Member::find($data['show'][$i]['sd_uid']);
			$data['show'][$i]['user_photo'] = $user->user_photo; 
			$data['show'][$i]['nickname']   = $user->nickname; 
			$data['show'][$i]['usr_id']   = $user->usr_id; 
			$i++;
		}
       
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