<?php
/**
*	M1 add by tangzhe 2016-07-20 根据商品ID跳转到当前正在购买期数
*/
namespace App\Http\Controllers\h5\View;

/*
 * 商品相关控制器
 * */
use App\Facades\IndexRepositoryFacade;
use App\Facades\ProductRepositoryFacade;//商品仓库facade代理
use App\Facades\UserRepositoryFacade;
use App\Http\Controllers\ForeController;
use App\Facades\OrderRepositoryFacade;
use App\Models\Object;
use App\Models\Order;
use App\Models\Member;
use App\Models\Bid_record;
use App\Models\Goods;
use Request;
use Cookie;
use DB;

class ProductsController extends ForeController
{

    public function __construct()
    {
        parent::__construct();
    }

	public function calculate($id){
		$id = (int)$id;
		$o_id = $this->getParam('o_id');
		$lasttime = OrderRepositoryFacade::findDealTime($o_id);
		
		if($id==1){
			$info=Bid_record::join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')->where('tab_bid_record.bid_time', '<=', $lasttime)->where('tab_bid_record.pay_type', '<>', 'invite')->orderby('tab_bid_record.id','desc')->take(100)->select('nickname','bid_time')->get();
			$data['info']=$info;
			return view('h5.calculate_jiexiaozhong',$data);
		}elseif($id==2){
			$info=Bid_record::join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')->where('tab_bid_record.bid_time', '<=', $lasttime)->where('tab_bid_record.pay_type', '<>', 'invite')->orderby('tab_bid_record.id','desc')->take(100)->select('nickname','bid_time')->get()->toArray();
			
			$data['info']=Bid_record::join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')->where('tab_bid_record.bid_time', '<=', $lasttime)->where('tab_bid_record.pay_type', '<>', 'invite')->orderby('tab_bid_record.id','desc')->take(100)->select('nickname','bid_time')->get();
			$object = Object::where('id', $o_id)->first();
			$data['total_person'] = $object->total_person;
			$data['winner'] = OrderRepositoryFacade::findFetchUser($o_id);

			$data['total_time'] = 0;
			foreach ($info as $v){
    			preg_match_all('/\d+/is', date('H:i:s', floor($v['bid_time']/1000)) . '.' . substr($v['bid_time'], -3), $string);
    			$data['total_time'] += implode($string[0]);
			}
			
			return view('h5.calculate_yijiexiao',$data);
		} 
	}
    /**
     * @param $id
     * @return  商品购买页面-开奖详情
     */
    public function product($id)
    {
        //获取商品id,如果商品id不存在跳转到存在商品的视图
        $id = (int)$id;
        if (empty((int)$id)) return view('foreground.product_notfound');
        $data['userbuywithid'] = array();//用户购买记录
        //查询商品的状态,根据商品查询状态，返回码0,1,2（0，未开奖，1开奖倒计时中，2已开奖）
        $status = ProductRepositoryFacade::findStatusProductById($id);
        $usr_ids = array();
        //所有期数和相关的o_id
        //$gid=ProductRepositoryFacade::findGidWithObjectId($id);
        //获取所有期数
        //$data['goods_periods']=ProductRepositoryFacade::findAllPeriodsByGid($gid,1000);
        switch ($status) {
            case '0':
                //商品处于未开奖状态，可以购买
                $data['goods'] = ProductRepositoryFacade::findObjectBelongsGoods($id);
                $data['goods']['belongs_to_goods']['picarr'] = unserialize($data['goods']['belongs_to_goods']['picarr']) ?: [];

                //自什么时候开始时间
                $buystart = Order::where(['o_id'=>$id,'g_id'=>$data['goods']['belongs_to_goods']['id']])->get(['bid_time'])->first();
                if($buystart){
                    $data['starttime'] = date('Y-m-d H:i:s',$buystart->bid_time/1000). '.' . substr($buystart->bid_time, -3);
                }                
                //上一期开奖结果  by baoyaoling
                if($data['goods']['periods'] > 1){
                    $periods = $data['goods']['periods']-1;
                    $lastPeriod = Object::where(['g_id'=>$data['goods']['g_id'],'periods'=>$periods])->first(['id','is_lottery','lottery_code','lottery_time']);
                    if($lastPeriod->is_lottery ==1){
                        $prizeUser = null;
                    }else{
                        $lastOrderPrize = Order::where(['o_id'=>$lastPeriod->id,'fetchno'=>$lastPeriod->lottery_code])->first();
                        $prizeUser['username'] =  $lastOrderPrize->user->nickname;
                        $prizeUser['user_photo'] =  $lastOrderPrize->user->user_photo;
                        $prizeUser['buycount'] =  Order::where(['o_id'=>$lastPeriod->id,'usr_id'=>$lastOrderPrize->user->usr_id])->sum('buycount');
                        $prizeUser['fetchno'] =  $lastPeriod->lottery_code;
                        $prizeUser['lottery_time'] = date('Y-m-d H:i:s',$lastPeriod->lottery_time/1000). '.' . substr($lastPeriod->lottery_time, -3);
                        $prizeUser['bug_time'] = date('Y-m-d H:i:s',$lastOrderPrize->bid_time/1000). '.' . substr($lastOrderPrize->bid_time, -3);
                        $prizeUser['o_id'] = $lastPeriod->id;
						$prizeUser['usr_id']=$lastOrderPrize->user->usr_id;
                    }
                }else{
                    $prizeUser = null;
                }
                //end 上一期开奖结果

                //查出最新一起商品id
                $latest_id = ProductRepositoryFacade::findLatestGoods($id);
                $data['goods_latest'] = ProductRepositoryFacade::findObjectBelongsGoods($latest_id);

                //检查用户是否处于登陆状态
                $usr_id = session('user.id') ? session('user.id') : 0;
                if (!empty($usr_id)) {
                    //查出用户的购买记录
                    $data['userbuy'] = UserRepositoryFacade::findBuyRecordUserLimit($usr_id, 10);
                    //用户信息
                    $data['userinfo'] = Member::find($usr_id)->toArray();
                    //用户购买记录
                    $data['buybid'] = Order::select('buycount')->where(['usr_id'=>$usr_id,'o_id'=>$id])->limit(10)->get()->toArray();
                    //通过标的id查找用户的购买记录
                    $data['userbuywithid'] = UserRepositoryFacade::findBuyRecordUserWithId($id, $usr_id);
                    $data['buyno']=[];
                    if(!empty($data['userbuywithid'] && is_array($data['userbuywithid']))){
                        foreach ($data['userbuywithid'] as $val){
                           $data['buyno']=array_merge($data['buyno'],json_decode($val['buyno'], true));
                           array_values($data['buyno']);
                        }
                    }else{
                        $data['buyno'] = [];
                    }
                } else {
                    //显示用户未登陆，提示去登陆界面。
                }

	            //seo配置
	            $seo_index = config('seo.index_m');
	            $seo['web_title'] = $data['goods']['belongs_to_goods']['seo_title'] ? $data['goods']['belongs_to_goods']['seo_title'] : $seo_index['web_title'];
	            $seo['web_keyword'] = $data['goods']['belongs_to_goods']['seo_keyword'] ? $data['goods']['belongs_to_goods']['seo_keyword'] : $seo_index['web_keyword'];
	            $seo['web_description'] = $data['goods']['belongs_to_goods']['seo_descript'] ? $data['goods']['belongs_to_goods']['seo_descript'] : $seo_index['web_description'];
				
                return view('h5.product_detail', array('data' => $data, 'userid' => $usr_id, 'id' => $id, 'status' => $status,'prizeUser'=>$prizeUser, 'seo' => $seo));
                break;
            case '1':
                //商品处于开奖中
                $latest_id = ProductRepositoryFacade::findLatestGoods($id);
                $data['goods_will'] = ProductRepositoryFacade::findObjectBelongsGoods($id);
                $data['goods_will']['belongs_to_goods']['picarr'] = unserialize($data['goods_will']['belongs_to_goods']['picarr']) ?: [];
	            $data['goods_will']['lottery_time'] = date('Y/m/d H:i:s',floor($data['goods_will']['lottery_time'] /1000));

                //查出商品最新一期状态
                $data['goods'] = ProductRepositoryFacade::findObjectBelongsGoods($latest_id);
                $newPeriod = $data['goods']['id'];
                //自什么时候开始时间
                $buystart = Order::where(['o_id'=>$id,'g_id'=>$data['goods']['belongs_to_goods']['id']])->get(['bid_time'])->first();
                if($buystart){
                    $data['starttime'] = date('Y-m-d H:i:s',$buystart->bid_time/1000). '.' . substr($buystart->bid_time, -3);
                }
                //上一期开奖结果  by baoyaoling
                if($data['goods_will']['periods'] > 1){
                    $periods = $data['goods_will']['periods']-1;
                    $lastPeriod = Object::where(['g_id'=>$data['goods_will']['g_id'],'periods'=>$periods])->first(['id','is_lottery','lottery_code','lottery_time']);
                    if($lastPeriod->is_lottery ==1){
                        $prizeUser = null;
                    }else{
                        $lastOrderPrize = Order::where(['o_id'=>$lastPeriod->id,'fetchno'=>$lastPeriod->lottery_code])->first();
                        $prizeUser['username'] =  $lastOrderPrize->user->nickname;
                        $prizeUser['user_photo'] =  $lastOrderPrize->user->user_photo;
                        $prizeUser['buycount'] =  Order::where(['o_id'=>$lastPeriod->id,'usr_id'=>$lastOrderPrize->user->usr_id])->sum('buycount');
                        $prizeUser['fetchno'] =  $lastPeriod->lottery_code;
                        $prizeUser['lottery_time'] = date('Y-m-d H:i:s',$lastPeriod->lottery_time/1000). '.' . substr($lastPeriod->lottery_time, -3);
                        $prizeUser['bug_time'] = date('Y-m-d H:i:s',$lastOrderPrize->bid_time/1000). '.' . substr($lastOrderPrize->bid_time, -3);
                        $prizeUser['o_id'] = $lastPeriod->id;
                    }
                }else{
                    $prizeUser = null;
                }
                //end 上一期开奖结果
                //检查用户是否处于登陆状态
                $usr_id = session('user.id') ? session('user.id') : 0;
                if (!empty($usr_id)) {
                    //查出用户的购买记录
                    $data['userbuy'] = UserRepositoryFacade::findBuyRecordUserLimit($usr_id, 10);
                    //通过标的id查找用户的购买记录
                    $data['userbuywithid'] = UserRepositoryFacade::findBuyRecordUserWithId($id, $usr_id);
                    $data['buyno']=[];
                    if(!empty($data['userbuywithid'] && is_array($data['userbuywithid']))){
                        foreach ($data['userbuywithid'] as $val){
                            $data['buyno']=array_merge($data['buyno'],json_decode($val['buyno'], true));
                            array_values($data['buyno']);
                        }
                    }else{
                        $data['buyno'] = [];
                    }
                } else {
                    //显示用户未登陆，提示去登陆界面。
                }

	            //seo配置
				$seo_index = config('seo.index_m');
	            $seo['web_title'] = $data['goods_will']['belongs_to_goods']['seo_title'] ? $data['goods_will']['belongs_to_goods']['seo_title'] : $seo_index['web_title'];
	            $seo['web_keyword'] = $data['goods_will']['belongs_to_goods']['seo_keyword'] ? $data['goods_will']['belongs_to_goods']['seo_keyword'] : $seo_index['web_keyword'];
	            $seo['web_description'] = $data['goods_will']['belongs_to_goods']['seo_descript'] ? $data['goods_will']['belongs_to_goods']['seo_descript'] : $seo_index['web_description'];

                return view('h5.product_lotterygo', array('data' => $data, 'usr_id' => $usr_id, 'id' => $id, 'status' => $status,'newPeriod'=>$newPeriod,'prizeUser'=>$prizeUser, 'seo' => $seo));
                break;
            case '2':
                //当前商品gid
                $latest_id = ProductRepositoryFacade::findLatestGoods($id);
                $data['goods_will'] = ProductRepositoryFacade::findObjectBelongsGoods($id);
                $data['goods_will']['belongs_to_goods']['picarr'] = unserialize($data['goods_will']['belongs_to_goods']['picarr']) ?: [];

                //查出商品最新一期状态
                $data['goods'] = ProductRepositoryFacade::findObjectBelongsGoods($latest_id);

                //自什么时候开始时间
                $buystart = Order::where(['o_id'=>$id,'g_id'=>$data['goods']['belongs_to_goods']['id']])->get(['bid_time'])->first();
                if($buystart){
                    $data['starttime'] = date('Y-m-d H:i:s',$buystart->bid_time/1000). '.' . substr($buystart->bid_time, -3);
                }

                //获取中奖者信息
                $fetchuser = OrderRepositoryFacade::findFetchUser($id);

                //获取中奖用户信息
                if (!empty($fetchuser) && is_array($fetchuser)) {
                    $userinfo = UserRepositoryFacade::findUserInfo($fetchuser[0]['usr_id']);
                    foreach ($fetchuser as $key => $val) {
                        $fetchuser[$key]['nickname'] = !empty($userinfo['nickname']) ? $userinfo['nickname'] : config('global.default_nickname');
                        $fetchuser[$key]['user_photo'] = !empty($userinfo['user_photo']) ? $userinfo['user_photo'] : config('global.default_photo');
                        $fetchuser[$key]['bid_time'] = date('Y-m-d H:i:s', floor($val['bid_time']/1000)). '.' . substr($val['bid_time'], -3);
                        $fetchuser[$key]['kaijiang_time'] = date('Y-m-d H:i:s', floor($data['goods_will']['lottery_time']/1000)). '.' . substr($data['goods_will']['lottery_time'], -3);
                    }
                    //通过标的id查找用户的购买记录
                    $data['userlucky'] = UserRepositoryFacade::findBuyRecordUserWithId($id, $fetchuser[0]['usr_id']);
                    $data['buynolucky']=[];
                    if(!empty($data['userlucky'] && is_array($data['userlucky']))){
                        foreach ($data['userlucky'] as $val){
                            $data['buynolucky']=array_merge($data['buynolucky'],json_decode($val['buyno'], true));
                            array_values($data['buynolucky']);
                        }
                    }else{
                        $data['buynolucky'] = [];
                    }
                }
                $usr_id = session('user.id') ? session('user.id') : 0;
                if (!empty($usr_id)) {
                    //查出用户的购买记录
                    $data['userbuy'] = UserRepositoryFacade::findBuyRecordUserLimit($usr_id, 10);
                    //通过标的id查找用户的购买记录
                    $data['userbuywithid'] = UserRepositoryFacade::findBuyRecordUserWithId($id, $usr_id);
                    $data['buyno']=[];
                    if(!empty($data['userbuywithid'] && is_array($data['userbuywithid']))){
                        foreach ($data['userbuywithid'] as $val){
                            $data['buyno']=array_merge($data['buyno'],json_decode($val['buyno'], true));
                            array_values($data['buyno']);
                        }
                    }else{
                        $data['buyno'] = [];
                    }
                } else {
                    //显示用户未登陆，提示去登陆界面。
                }

	            //seo配置
	            $seo_index = config('seo.index_m');
	            $seo['web_title'] = $data['goods_will']['belongs_to_goods']['seo_title'] ? $data['goods_will']['belongs_to_goods']['seo_title'] : $seo_index['web_title'];
	            $seo['web_keyword'] = $data['goods_will']['belongs_to_goods']['seo_keyword'] ? $data['goods_will']['belongs_to_goods']['seo_keyword'] : $seo_index['web_keyword'];
	            $seo['web_description'] = $data['goods_will']['belongs_to_goods']['seo_descript'] ? $data['goods_will']['belongs_to_goods']['seo_descript'] : $seo_index['web_description'];
				
                return view('h5.product_lotteryafter', array('data' => $data, 'usr_id' => $usr_id, 'id' => $id, 'fetchuser' => $fetchuser, 'status' => $status, 'seo' => $seo));
                break;
            default:
                return view('h5.product_notfound');
        }


    }
    
	//商品图文详情
	public function productdetail($id)
	{
		$content=Goods::where('tab_object.id',$id)->join('tab_object','tab_object.g_id','=','ykg_goods.id')->select('ykg_goods.content')->first();
		//var_dump($content);exit;
		$data['content']=$content;
		return view('h5.product_content',$data);
	}
    //所有商品分类
    public function productCatgory(Request $request)
    {
        //获取页数
        $page = $this->getParam('page', 0);
        //获取排序方式
        $order = $this->getParam('order', 'fast');//最热和最快调换位置 16.6.21 by byl

        $pagesize = 10;
        
        $data = array();
        
        //获取所有商品分类
        $catid = $this->getParam('catid', 0);
        
        if($request::ajax()){
            //如果获取不到brandid则获取catid进行显示
            if ((int)$catid) {
                $data = ProductRepositoryFacade::findAllProductByCatidMobile($catid, $page, $pagesize, $order); //根据catid获取所有商品,包含分页
            }else{
                //如果获取不到cateid,显示默认页面
                $data = ProductRepositoryFacade::findAllProductMobile($page, $pagesize, $order); 
            }
            
            foreach ($data as &$val) {                
                $val->rate = round($val->participate_person/$val->total_person*100,2);
                $val->surplus = $val->total_person - $val->participate_person;
            }
            
            return response()->json(array('data' => $data, 'page' => $page, 'order' => $order));
        }
        
        return view('h5.category_m', array('data' => $data, 'page' => $page, 'order' => $order, 'catid' => $catid));
    }
	
	public function search()
    {
        // 最近搜索
        $history = $this->get_history();


        // 热门搜索
        $hot = $this->get_hot();;

		return view('h5.search', ['history' => $history, 'hot' => $hot, 'searchval' => $this->getParam('key')]);
	}
	//选择期数
	public function selectperiods(Request $request)
    {
        $gid = $this->getParam('gid');
        if($gid){
            $max = Object::where('g_id', $gid)->max('periods');
            if($request::ajax()){
                $list= Object::where('g_id', $gid)->orderBy('periods', 'desc')->paginate(40);
                if($list->count()>0){
                    foreach ($list as $key=>$val){
                        $data['data'][$key]['period'] = $val->periods;
                        $data['data'][$key]['id'] = $val->id;
                        $data['data'][$key]['is_lottery'] = $val->is_lottery;      
                    }
                }else{
                    $data['data'] = [];
                }
                $data['current_page'] = $list->currentPage();
                //数据为空lastpage 为0
                $data['last_page'] = $list->lastPage();
                return json_encode($data);
            }
            
            return view('h5.selectperiods', array('max'=>$max));
        }
	}
	
	public function getUrlByPeriod(){
	    $gid = $this->getParam('gid');
	    $period = $this->getParam('period');
	    $object = Object::where('g_id', $gid)->where('periods', $period)->first();
	    if($object){
	       return response()->json(array('status'=>0, 'message'=>'ok', 'data'=>'/product_m/'.$object->id));
	    }else{
	        return response()->json(array('status'=>-1, 'message'=>'no data'));
	    }
	}
	
    /*
     * search 商品搜索 $type: 0:即将揭晓 1:剩余人次 2:热卖 3:最新商品 4:价格 升序 5：价格 降序
     * strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) 转义
     */
    public function search_result(Request $request)
    {
        $key = $this->getParam('key');
        if(!$key){
            return back()->withInput();
        }

        $this->get_history();
        $this->get_hot();

        $page = $this->getParam('page', 1);
        $limit = 10;
        $list = array();

        if($request::ajax()){
            if ($key) {
                $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->where('ykg_goods.title', 'like', '%' . strtr($key,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%')
                        ->select('ykg_goods.*', 'tab_object.*')
                        ->paginate($limit)->toArray();
            }
            return response()->json(array('list' => $list, 'page' => $page, 'searchval' => $key));
        }
        return view('h5.search_result', ['list' => $list, 'page' => $page, 'searchval' => $key]);
    }

    /**
     * 热门搜索
     */
    private function get_hot(){
        $key = $this->getParam('key');
        $key = strtr($key,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\'));
        $hotword = [];
        if ($key) {
            $expiretime = 60 * 60 * 24 * 30 *3; // 3个月
            $hotword = DB::select('select * from tab_hotword where keyword = :keyword', ['keyword' => $key]);
            if(empty($hotword)){
                DB::insert('insert into tab_hotword (keyword, num, expiretime, addtime) values (?, ?, ?, ?)', [$key, 1, $expiretime, time()]);
            }elseif(intval($this->getParam('page')) < 2){
                $num = $hotword['0']->num + 1;
                DB::update('update tab_hotword set num = '.$num.', expiretime = '.$expiretime.', addtime = '.time().' where keyword = ?', [$key]);
            }
        }else{
            $limit = 6;
            $hotword = DB::select('select * from tab_hotword order by num desc limit :limit', ['limit' => $limit]);
        }
        
        return $hotword;
    }

    /**
     * 记录搜索并返回搜索历史
     * 历史搜索最大值 6个
     * 有效期 1个月
     * 字符串长度小 100
     */
    public function get_history(){
        $key = $this->getParam('key');
        $cookieName = 'keyword_'.session('user.id');
        $keyword = Cookie::get("$cookieName");
        if($this->getParam('name')){
            Cookie::queue($cookieName,'',-1); 
            return ;
        }
        if(!$key OR strlen($key) > 100){
            return $keyword;
        }
        $max = 6;
        $expire = 60 * 60 * 24 * 30;
        if(!empty($keyword)){
            if(in_array($key, $keyword)){
                return $keyword;
            }else{
                $keyword[] = $key;
            }
            $length = count($keyword);
            foreach ($keyword as $k=>$v) {
                if($length - $k > $max){
                    unset($keyword[$k]);
                }
            }
            $keyword = array_values($keyword);
        }else{
            $keyword[] = $key;
        }
        Cookie::queue($cookieName,$keyword,$expire); 

        return $keyword;
    }

	//M1
	public function proCurObj($id){
		$res  = DB::table('tab_object')->where('g_id',$id)->where('is_lottery',0)->orderBy('periods','desc')->limit(1)->get();
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/product_m/'.$res[0]->id; 
		echo "<script>window.location='".$url."'</script>";
	}
}