<?php
/*
 M1 add by tangzhe 2016-06-14 分销系统入口处理
 M2 modify by tangzhe 2016-06-30 人气商品改为最快揭晓
 m3 add by tangzhe 2016-08-10 增加code拉邀请的首页入口
*/
namespace App\Http\Controllers\h5\View;
use App\Facades\ProductRepositoryFacade;
use App\Facades\OrderRepositoryFacade;
use App\Facades\UserRepositoryFacade;
use App\Models\Article;
use App\Models\Article_cat;
use App\Models\Link;
use App\Models\Goods;
use App\Models\Order;
use App\Models\Bid_record;
use App\Models\Member;
use App\Models\ShowOrder;
use App\Http\Controllers\ForeController;
use App\Facades\IndexRepositoryFacade;
use Request;
use DB;
use App\Models\Object;
use Cookie;

class IndexController extends ForeController
{
    //首页
    public function index()
    { 
		//M1 START
		// if(isset($_GET['salesman_usrid'])){
			// Cookie::queue('recommend_id',(int)$_GET['salesman_usrid']);
		// }else{
			// Cookie::queue('recommend_id','');
		// }
		// if(isset($_GET['salesman_usrid']) && isset($_GET['way']) ){ 
			// DB::table('ykg_cps')->insert(['time'=>time(),'salesman_usrid'=>(int)$_GET['salesman_usrid'],'way'=>(int)$_GET['way']]);
		// }
		//M1 END
		invite_code();//m3
		
        $data = array();
        //轮播
        $data['slide'] = IndexRepositoryFacade::findSlide(2)->toArray();//0.08S
        $data['count'] = count($data['slide']);
        
        //最新揭晓
        $data['latest'] = $this->getLatest();

        //M2 最快揭晓
        $data['fast'] = ProductRepositoryFacade::findAllProductNoPaginate(8,'fast');
        foreach ($data['fast'] as &$fast){
            $fast->rate = floor(round($fast->participate_person/$fast->total_person,8) * 100);
        }
    
        //晒单分享
        $share = IndexRepositoryFacade::findShow(3);
		if(!empty($share))
		{
			$data['share']['first'] = $share[0];
        	$data['share']['last'] = array_slice($share, 1);

		}
		else
		{
			$data['share'] = '';
		}
        
        //公告
        $data['articles']=OrderRepositoryFacade::getPrizeList();
        
        return view('h5.index', array('data' => $data));
    }

	//获取最新揭晓商品
	public function getLatest()
	{
		$latest = IndexRepositoryFacade::findLatest(2);
		$open = IndexRepositoryFacade::findLatestOpen(2);

		//构造数组
		$arr1=$arr2=array();
		foreach ($latest as $k=>$v){
			$arr1[$k]['title']=$v['belongs_to_goods']['title'];
			$arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
			$arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
			$arr1[$k]['money']=$v['belongs_to_goods']['money'];
			$arr1[$k]['path']='/product_m/'.$v['id'];
			$arr1[$k]['id']=$v['id'];
			$arr1[$k]['is_lottery']=$v['is_lottery'];
		}
		foreach($open as $k => $v){
			$arr2[$k]['title']=$v['belongs_to_goods']['title'];
			$arr2[$k]['thumb']=$v['belongs_to_goods']['thumb'];
			$arr2[$k]['money']=$v['belongs_to_goods']['money'];
			$arr2[$k]['path']='/product_m/'.$v['id'];
			$arr2[$k]['id']=$v['id'];
			$arr2[$k]['is_lottery']=$v['is_lottery'];
			$arr2[$k]['nickname']=mb_substr($v['nickname'], 0, 5); //截取5个长度
			$arr2[$k]['usr_id']=$v['usr_id'];
		}

		krsort($arr1);

		$data = array_slice(array_merge($arr1, $arr2), 0, 2);

		return $data;
	}
    
    //获取最新揭晓商品
//    public function getLatest()
//    {
//        $data['latest'] = IndexRepositoryFacade::findLatest(2);
//        $arr=config('goods');
//        $data['data']=array_values(array_except($arr,array_rand($arr,8)));
//        foreach ($data['data'] as $key=>$val){
//            $data['data'][$key]['ltime']=date('Y/m/d H:i:s',time()+rand(1,550));
//            $data['data'][$key]['path']='/jjjx_m';
//        }
//        //构造数组
//        $arr1=array();
//        foreach ($data['latest'] as $k=>$v){
//            $arr1[$k]['title']=$v['belongs_to_goods']['title'];
//            $arr1[$k]['thumb']=$v['belongs_to_goods']['thumb'];
//            $arr1[$k]['ltime']=date('Y/m/d H:i:s',floor($v['lottery_time']/1000));
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
//
//        return $data;
//    }
	
	//他人主页
	public function home()
    { 
        $data = array();
        //轮播
        $data['slide'] = IndexRepositoryFacade::findSlide();//0.08S
        return view('h5.other', array('data' => $data));
    }
	//往期揭晓
	public function wqjx(Request $request){
	    $gid = $this->getParam('gid');
        $page = $this->getParam('page', 0);
        $limit = $this->getParam('limit', 10);
        $data['goods']=ProductRepositoryFacade::findReward($page, $limit, $gid);
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['total'] = count($data['goods']);

        foreach ($data['goods'] as $k=>$v){
            $data['goods'][$k]['fetchuser']=OrderRepositoryFacade::findFetchUser($v['id']);
            if(!empty($data['goods'][$k]['fetchuser'])){
                $userinfo=UserRepositoryFacade::findUserInfo($data['goods'][$k]['fetchuser'][0]['usr_id']);
               //多次购买的总数
                $data['goods'][$k]['fetchuser'][0]['buycount'] = Order::where(['o_id'=>$data['goods'][$k]['id'],'usr_id'=>$data['goods'][$k]['fetchuser'][0]['usr_id']])->sum('buycount');
                $data['goods'][$k]['fetchuser'][0]['nickname']=!empty($userinfo['nickname'])?$userinfo['nickname']:config('global.default_nickname');
                $data['goods'][$k]['fetchuser'][0]['user_photo']=!empty($userinfo['user_photo'])?$userinfo['user_photo']:config('global.default_photo');
                $data['goods'][$k]['fetchuser'][0]['bid_time']=date('Y年m月d日 H:i',floor($data['goods'][$k]['fetchuser'][0]['bid_time']/1000));
                //计算回报率
                $data['goods'][$k]['fetchuser'][0]['rate']=sprintf("%.2f", round($data['goods'][$k]['total_person']/$data['goods'][$k]['fetchuser'][0]['buycount'],2));
            }
        }
        
        if($request::ajax()){
            return response()->json($data);
        }else{
            return view('h5.wqjx',array('data'=>$data, 'gid'=>$gid));
        }
	}
	//建议反馈
	public function advise(){
		 return view('h5.advise');
	}
	
	//引导页
	public function guide(){

			 return view('h5.guide');

	}
	
	//找回密码
	public function forgetpwd(){
		 return view('h5.forgetpwd');
	}


 
	
	//产品图文详情
    public function product_content()
    {
    	$model=new Goods();
    	$data['shopCheap']=$model->getCheapShop();
        return view('h5.product_content',$data);
    }

    //最新揭晓页面   16.7.1 by byl  添加已揭晓的商品

    public function announcement(Request $request)
    {
        if($request::ajax()){
            $objects = Object::where('is_lottery', '1')->orWhere('is_lottery', '2')->orderBy('lottery_time', 'desc')->paginate(10);
            if($objects->count()>0){
                foreach ($objects as $key=>$val){
                    $data['data'][$key]['is_lottery'] = $val->is_lottery;
                    if($val->is_lottery == 2){
                        $order = Order::where('o_id',$val->id)->where('fetchno', '>', 0)->first();
                        $data['data'][$key]['o_id'] = $val->id;
                        $data['data'][$key]['periods'] = $val->periods;
                        $data['data'][$key]['thumb'] = $val->goods->thumb;
                        $data['data'][$key]['title'] = $val->goods->title;
                        //$data['data'][$key]['periods'] = $val->periods;
                        if(!empty($order)){
                            $data['data'][$key]['username'] = $order->user->nickname;
                            $data['data'][$key]['fetchno'] = $order->fetchno;
                            $data['data'][$key]['buynums'] = Order::where(['o_id'=>$val->id,'usr_id'=>$order->usr_id])->sum('buycount');
                            $data['data'][$key]['lottery_time'] = date('Y-m-d H:i:s',floor($order->kaijiang_time/1000));
                        }else{
                            $data['data'][$key]['username'] = '';
                            $data['data'][$key]['fetchno'] = $val->lottery_code;
                            $data['data'][$key]['buynums'] = '';
                            $data['data'][$key]['lottery_time'] = date('Y-m-d H:i:s',floor($val->lottery_time/1000));
                        }
                    }else{
                        $data['data'][$key]['o_id'] = $val->id;
                        $data['data'][$key]['periods'] = $val->periods;
                        $data['data'][$key]['thumb'] = $val->goods->thumb;
                        $data['data'][$key]['title'] = $val->goods->title;
                        $data['data'][$key]['periods'] = $val->periods;
                        $data['data'][$key]['time'] = date('Y/m/d H:i:s');
                        $data['data'][$key]['lottery_time'] = date('Y/m/d H:i:s',floor($val->lottery_time/1000));
                    }
                }
                $data['current_page'] = $objects->currentPage();
                $data['last_page'] = $objects->lastPage();
            }else{
                $data['data'] = [];
            }
            return json_encode($data);
        }
        return view('h5.jiexiao');
        
    }
    
    /*
     * 揭晓之后 页面信息更新  16.7.1 by byl
     */
    public function aferLottery()
    {
        $id = Request::input('id');
        $order = Order::where('o_id',$id)->where('fetchno', '>', 0)->first();
        if($order){
            $data['o_id'] = $id;
            $data['thumb'] = $order->goods->thumb;
            $data['title'] = $order->goods->title;
            //$data['data'][$key]['periods'] = $val->periods;
            $data['username'] = $order->user->nickname;
            $data['fetchno'] = $order->fetchno;
            $data['buynums'] = Order::where(['o_id'=>$id,'usr_id'=>$order->usr_id])->sum('buycount');
            $data['lottery_time'] = date('Y-m-d H:i:s',floor($order->kaijiang_time/1000));
            $data['status'] = 0;
            
        }else{
            $data['status'] = -1;
            $data['msg'] = '操作失败';
        }
        return json_encode($data);
    }   


    //最新揭晓页获取已揭晓列表
    public function getLotteryAfter(){
        $page = $this->getParam('page', 0);
        $limit = $this->getParam('limit', 10);
        $list = ProductRepositoryFacade::findRewardAll($page, $limit);
        
        return response()->json(array('status' => 0,'message'=>'ok' ,'data' => $list));
    }

    //客服页面
    public function customer()
    {
        return view('h5.customer');
    }
    /*
     * 帮助中心
     */
    public function help()
	{
        $article = Article::where(['article_type'=>2])->get();
        return view('h5.help',['article'=>$article]);
    }
    /*
     * 帮助中心内容
     */
    public function aricle($id)
	{
        $article = Article::where(['article_id'=>$id,'article_type'=>2])->first();
        return view('h5.help',['article'=>$article]);
    }
	
	//文章列表
	public function article_content($id){
		$article = Article::where(['article_id'=>$id])->first();
        return view('h5.article',['article'=>$article]);
	}

	//发现页面
	public function find()
	{
		return view('h5.find');
	}
	
	//关于我们
    public function aboutus()
    {  
        return view('h5.aboutus_m');
    }
	
	//即将揭晓
    public function jjjx(Request $request)
    {
        $page = $this->getParam('page', 0);
        $limit = $this->getParam('limit', 10);
        $data['goods']=ProductRepositoryFacade::findUnveiling($page, $limit);
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['total'] = count($data['goods']);

        if($data['goods']){
            foreach ($data['goods'] as &$value) {
                $value['progress'] = intval($value['participate_person']) / intval($value['total_person']);
                $value['progress'] = sprintf("%.2f", $value['progress']) * 100;
            }
        }

        if($request::ajax()){
            return response()->json($data);
        }else{
            return view('h5.jjjx_m',array('data'=>$data));
        }
    }
	
	//发现页面
    public function agreement()
    {
        return view('h5.agreement');
    }
	
    /*
     * 友情链接
     */
    public function friendLink(){
        $links = Link::all();
        return view('h5.link',['links'=>$links]);
    }
    /*
     * 公告栏
     */
    public function noticeBoard($id){
        $article = Article::find($id);
        $articles = Article::where('article_type',3)->orderBy('updated_at', 'desc')->paginate(10);
        return view('h5.noticeboard',['article'=>$article,'articles'=>$articles]);
    }

    //获取最新一百条购买记录
    public function getLatestRecord()
	{
		   
		//$res=microtime_format('Y/m/d H:i:s:x', '1270626578.66');
		//echo  $res;
		$data['list'] =Bid_record::
        where('status','<>','0')
	   ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
       ->select('tab_bid_record.*','tab_member.nickname')
	   ->orderBy('tab_bid_record.id', 'desc')
	   ->take(100)
	   ->get();
		return view('h5.latestrecord',$data);
	}
    
	//获取历史购买记录
	public function getHistoryRecord()
	{
		$data['list'] =Bid_record::
        where('status','<>','0')
	   ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
       ->select('tab_bid_record.*','tab_member.nickname')
	   ->orderBy('tab_bid_record.id', 'desc')
       ->paginate(100);
		return view('h5.historyrecord',$data);				
	
	}
	
	public function searchRecord()
	{
		
		$stime=isset($_POST['stime'])?strtotime($_POST['stime'])*1000:0;
		$etime=isset($_POST['etime'])?strtotime($_POST['etime'])*1000:0;
		if($stime!=0 && $etime!=0)
		{
			session(['stime'=>$stime]);
		    session(['etime'=>$etime]);
		}
		
		if($stime==0 && $etime==0)
		{
			
			$stime=session('stime');
			$etime=session('etime');
		}
		$data['stime']=date('Y/m/d h:i:s',$stime/1000);
		$data['etime']=date('Y/m/d h:i:s',$etime/1000);
		$data['list'] =Bid_record::
        where('status','<>','0')
	   ->where('bid_time','<',$etime)
	   ->where('bid_time','>',$stime)
	   ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
       ->select('tab_bid_record.*','tab_member.nickname')
	   ->orderBy('tab_bid_record.id', 'desc')
       ->paginate(100);
	   //print_r($data['list']);
		return view('h5.historyrecord',$data);	
		
	}
    //为登陆的个人中心
    public function userCenter()
    {
	    if(session('user.id')){
		    return redirect('user_m/usercenter2');
	    }
        return  view('h5.usercenter');
    }
	
	//他人购买记录
	public function getHisBuy($usrid)
	{
		if(session('user.id'))
		{
			$data['userid']=session('user.id');
		}
		else
		{
			$data['userid']=-1;
		}
		$data['himid']=$usrid;
		$level=$this->mylevel($usrid);
		$data['level']=$level['name'];
		$userinfo=Member::where('usr_id',$usrid)->select('nickname','user_photo','usr_id')->first();
		$data['userinfo']=$userinfo;
		return view('h5.hisBuy',$data);
	}
	
	//中奖记录信息
	public function getFetchnoInfo()
	{
		$orders =Order::where('o_id',212)
						->where('fetchno','<>','')
                        ->join('tab_member','tab_member.usr_id', '=','tab_bid_record.usr_id')
                        ->orderBy('tab_bid_record.id','desc')
                        ->select('fetchno','buycount','nickname','kaijiang_time')->first();
		$data=$orders->tojson();
		return $data;
		//print_r($data);
	}
	
	//ajax请求
	public function getajxaHisBuy(Request $request)
	{
		
            $type = $request::input('type');
			$usrid =$request::input('himid');
            if ($type == '0'){
                //订单记录
                
                $orders =Order::where('usr_id',$usrid)
						->where('status','<>',0)
						->where('pay_type','<>','invite')
                        ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                        ->orderBy('id','desc')
                        ->select('tab_bid_record.*','tab_object.is_lottery')->paginate(5);
					
						
            }else if($type == 1){
                //中奖记录
                $orders = Order::where('usr_id',$usrid)
						  ->where('pay_type','<>','invite')
						  ->where('fetchno','<>','')
                          ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                          ->where('tab_object.is_lottery','=',2)->orderBy('id','desc')
                          ->select('tab_bid_record.*')->paginate(5);
				//print_r($orders);exit;
            }else if($type == 2){
                //晒单记录
                $res =ShowOrder::where(['sd_uid'=>$usrid,'is_show'=>1])->select('id','sd_title','sd_content','sd_admire','sd_photolist','sd_time','pic_num','sd_gid')
							   ->paginate(5);
							   //print_r($res);exit;
				if($res->count()>0)
				{
					foreach($res as $k=>$v)
					{
						$data['data'][$k]['title'] =$v->sd_title;
						$data['data'][$k]['content'] =$v->sd_content;
						$data['data'][$k]['admire'] =$v->sd_admire;
						$data['data'][$k]['img'] =unserialize($v->sd_photolist);
						$data['data'][$k]['imgnum'] =$v->pic_num;
						$data['data'][$k]['time'] =date('Y-m-d H:i:s',$v->sd_time);
						$data['data'][$k]['id'] =$v->id;						
						//商品最新的标id
						$oid=Object::where('g_id',$v->sd_gid)->orderby('periods','desc')->select('id')->first();
						$data['data'][$k]['oid'] =$oid['id'];
					}
					
					
				}else
				{
					$data['data']=[];
				}
				$userinfo=Member::where('usr_id',$usrid)->select('nickname','user_photo')->first();
				$data['nickname']=$userinfo['nickname'];
				$data['user_photo']=$userinfo['user_photo'];
				$data['current_page'] = $res->currentPage();
	            //数据为空lastpage 为0
	            $data['last_page'] = $res->lastPage();
	            $data['type'] = $type; //避免用户点击过快或网络慢，出现加载出错
	            return json_encode($data);
				
            }
            if($orders->count()>0){
                foreach ($orders as $key=>$val){
                    $data['data'][$key]['productname'] = '（第'.$val->g_periods.'期）'.$val->g_name;
                
                    $data['data'][$key]['buyno'] =$val->buyno;
					
                    $data['data'][$key]['img'] = $val->goods->thumb;
                    $data['data'][$key]['id'] = $val->id;
                    $data['data'][$key]['o_id'] = $val->object->id;
                    $data['data'][$key]['g_id'] = $val->g_id;
					$data['data'][$key]['buycount'] = $val->buycount;
					$data['data'][$key]['money'] = $val->goods->money;
					$data['data'][$key]['is_lottery'] = $val->is_lottery;
					
					//是否开奖
					if($val->is_lottery==2 && !$val->fetchno)
					{
						//查找此期的中奖用户
						$order =Order::where('o_id',$val->object->id)
						->where('fetchno','<>','')
                        ->join('tab_member','tab_member.usr_id', '=','tab_bid_record.usr_id')
                        ->orderBy('tab_bid_record.id','desc')
                        ->select('fetchno','buycount','nickname','kaijiang_time')->first();
						//组装数组
						$data['data'][$key]['nickname'] = $order['nickname'];
						$data['data'][$key]['fetchno'] = $order['fetchno'];
						$data['data'][$key]['buycountl'] = $order['buycount'];
						$data['data'][$key]['kaijiang_time'] = $this->microtime_format('Y-m-d H:i:s',$order['kaijiang_time']);
						
					}elseif($val->fetchno)
					{
						//中奖者是他自己
						$data['data'][$key]['nickname'] = $val->user->nickname;
						$data['data'][$key]['fetchno'] = $val->fetchno;
						$data['data'][$key]['kaijiang_time'] = $this->microtime_format('Y-m-d H:i:s',$val->kaijiang_time);
						$data['data'][$key]['buycountl']=$val->buycount;
					}
					else
					{
						//留空
					}
					
					
                }
            }else{
                $data['data'] = [];
            }
			
            $data['current_page'] = $orders->currentPage();
            //数据为空lastpage 为0
            $data['last_page'] = $orders->lastPage();
            $data['type'] = $type; //避免用户点击过快或网络慢，出现加载出错
            //print_r($data);exit;
            return json_encode($data);
        
	}

	public function microtime_format($tag,$time)
	{
	   $usec=substr($time,0,10);
	   $sec=substr($time,9,3);
	   $date = date($tag,$usec);
	   return str_replace('x', $sec, $date);
	}

	//等级
	public function mylevel($uid){
         $level_config = array(2000 => '土豪', 9999 => '铁豪', 29999 => '铜豪', 59999 => '银豪', 99999 => '金豪', 100000 => '砖豪');
         $total = DB::table('tab_member_addmoney_record')->where('usr_id', $uid)->where('type', 'buy')->where('amount', '>', 0)->where('bid', '<>', '')->sum('amount');
         $level = array();
         foreach ($level_config as $k => $v){
            if($total <= $k){
                $level['name'] = $v;
                $level['interval'] = $k;
                $level['rate'] = round($total/$k, 2)*100 . '%';
                break;
            }    
         }
         if(empty($level)){
             $level['name'] = $level_config[100000];
             $level['interval'] = 100000;
             $level['rate'] = 100;
         }
         
        return $level;
     }
	
}
