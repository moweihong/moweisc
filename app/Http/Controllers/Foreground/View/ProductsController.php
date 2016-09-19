<?php
/*
	M1 add by tangzhe 2016-07-20 根据商品ID跳转到当前正在购买期数
*/
namespace App\Http\Controllers\Foreground\View;

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
use DB;

class Productscontroller extends ForeController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $id
     * @return  商品购买页面
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
        $gid=ProductRepositoryFacade::findGidWithObjectId($id);
        //获取所有期数
        $data['goods_periods']=ProductRepositoryFacade::findAllPeriodsByGid($gid,1000);
        switch ($status) {
            case '0':
                //商品处于未开奖状态，可以购买
                $data['goods'] = ProductRepositoryFacade::findObjectBelongsGoods($id);
                $data['goods']['belongs_to_goods']['picarr'] = unserialize($data['goods']['belongs_to_goods']['picarr']) ?: [];
                //查出当前期当前商品的购买记录10条
                $data['allbuy'] = UserRepositoryFacade::findBuyRecordAllLimit($id,$data['goods']['belongs_to_goods']['id'],10);
                //是否显示查看全部
                $buytotal = Order::where(['o_id'=>$id,'g_id'=>$data['goods']['belongs_to_goods']['id']])->count();
                if($buytotal>10){
                   $data['buytotal'] = 1;
                }
                //是否显示查看全部 end
                foreach ($data['allbuy'] as $key => $val) {
                    array_push($usr_ids, $val['usr_id']);
                }
                //批量添加昵称和头像
                if ($usr_ids) {
                    $userinfo = UserRepositoryFacade::findUserInfoWithArray($usr_ids);
                    foreach ($userinfo as $key => $val) {
                        foreach ($data['allbuy'] as $key2 => $val2) {
                            if ($val['usr_id'] == $val2['usr_id']) {
                                $data['allbuy'][$key2]['nickname'] = !empty($val['nickname']) ? $val['nickname'] : config('global.default_nickname');
                                $data['allbuy'][$key2]['user_photo'] = !empty($val['user_photo']) ? $val['user_photo'] : config('global.default_photo');
                            }
                        }
                    }
                }
                //查出最新一起商品id
                $latest_id = ProductRepositoryFacade::findLatestGoods($id);
                $data['goods_latest'] = ProductRepositoryFacade::findObjectBelongsGoods($latest_id);
                //根据o_id获取之前五期商品的id和期数
                $data['beforelottery'] = array();
                $data['beforelottery'] = ProductRepositoryFacade::findOidAndPeriods($id, 5);
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
	            $seo_index = config('seo.index');
	            $seo['web_title'] = $data['goods']['belongs_to_goods']['seo_title'] ? $data['goods']['belongs_to_goods']['seo_title'] : $seo_index['web_title'];
	            $seo['web_keyword'] = $data['goods']['belongs_to_goods']['seo_keyword'] ? $data['goods']['belongs_to_goods']['seo_keyword'] : $seo_index['web_keyword'];
	            $seo['web_description'] = $data['goods']['belongs_to_goods']['seo_descript'] ? $data['goods']['belongs_to_goods']['seo_descript'] : $seo_index['web_description'];

				
                return view('foreground.product', array('data' => $data, 'userid' => $usr_id, 'id' => $id, 'seo' => $seo));
                break;
            case '1':
                //商品处于开奖中
                $latest_id = ProductRepositoryFacade::findLatestGoods($id);
                $data['goods_will'] = ProductRepositoryFacade::findObjectBelongsGoods($id);
                foreach ($data['goods_will'] as $key => $val) {
                    $lottime = !empty($val['lottery_time']) ? $val['lottery_time'] : '0';
                    $lottime = floor($lottime/1000);
                    $data['goods_will']['min1'] = substr(date("i", $lottime), 0, 1);
                    $data['goods_will']['min2'] = substr(date("i", $lottime), 1, 2);
                    $data['goods_will']['sec1'] = substr(date("s", $lottime), 0, 1);
                    $data['goods_will']['sec2'] = substr(date("s", $lottime), 1, 2);
                }
                //根据o_id获取之前五期商品的id和期数
                $data['beforelottery'] = array();
                $data['beforelottery'] = ProductRepositoryFacade::findOidAndPeriods($id, 5);
                //查出商品最新一期状态
                $data['goods'] = ProductRepositoryFacade::findObjectBelongsGoods($latest_id);
                //获取热门推荐商品四条
                $data['hot'] = IndexRepositoryFacade::findNew(4);
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
                        shuffle($data['buyno']);
                    }else{
                        $data['buyno'] = [];
                    }
                } else {
                    //显示用户未登陆，提示去登陆界面。
                }

	            //seo配置
	            $seo_index = config('seo.index');
	            $seo['web_title'] = $data['goods_will']['belongs_to_goods']['seo_title'] ? $data['goods_will']['belongs_to_goods']['seo_title'] : $seo_index['web_title'];
	            $seo['web_keyword'] = $data['goods_will']['belongs_to_goods']['seo_keyword'] ? $data['goods_will']['belongs_to_goods']['seo_keyword'] : $seo_index['web_keyword'];
	            $seo['web_description'] = $data['goods_will']['belongs_to_goods']['seo_descript'] ? $data['goods_will']['belongs_to_goods']['seo_descript'] : $seo_index['web_description'];

                return view('foreground.lotteryago', array('data' => $data, 'usr_id' => $usr_id, 'id' => $id, 'seo' => $seo));
                break;
            case '2':
                //当前商品gid
                $latest_id = ProductRepositoryFacade::findLatestGoods($id);
                $data['goods_will'] = ProductRepositoryFacade::findObjectBelongsGoods($id);
                foreach ($data['goods_will'] as $key => $val) {
                    $lottime = !empty($val['lottery_time']) ? $val['lottery_time'] : '0';
                    $data['goods_will']['min1'] = substr(date("i", $lottime), 0, 1);
                    $data['goods_will']['min2'] = substr(date("i", $lottime), 1, 2);
                    $data['goods_will']['sec1'] = substr(date("s", $lottime), 0, 1);
                    $data['goods_will']['sec2'] = substr(date("s", $lottime), 1, 2);
                }
                //根据o_id获取之前五期商品的id和期数
                $data['beforelottery'] = array();
                $data['beforelottery'] = ProductRepositoryFacade::findOidAndPeriods($id, 5);

                //查出商品最新一期状态
                $data['goods'] = ProductRepositoryFacade::findObjectBelongsGoods($latest_id);

                //获取商品的100条购买记录
                $data['buyrecord'] = OrderRepositoryFacade::findLotteryRecord($id, 105);
                
                $usr_ids = array();
                foreach ($data['buyrecord'] as $k => $v) {
                    array_push($usr_ids, $v['usr_id']);
                }

                //通过用户id批量获取用户名和头像
                $userarr = UserRepositoryFacade::findUserInfoWithArray($usr_ids);
                $total_time = 0;
                foreach ($data['buyrecord'] as $k => $v) {
                    foreach ($userarr as $k2 => $v2) {
                        if ($v2['usr_id'] == $v['usr_id']) {
                            //对data['buyrecord']进行用户名赋值
                            $data['buyrecord'][$k]['nickname'] = !empty($v2['nickname']) ? $v2['nickname'] : config('global.default_nickname');
                            $data['buyrecord'][$k]['user_photo'] = !empty($v2['user_photo']) ? $v2['user_photo'] : config('global.default_photo');
                        }
                    }

                    //对bid_time进行处理
                    $data['buyrecord'][$k]['lottery_time1'] = date('Y-m-d', floor($v['bid_time']/1000));
                    $data['buyrecord'][$k]['lottery_time2'] = date('H:i:s', floor($v['bid_time']/1000)) . '.' . substr($v['bid_time'], -3);
                    preg_match_all('/\d+/is', date('H:i:s', floor($v['bid_time']/1000)) . '.' . substr($v['bid_time'], -3), $string);
                    $data['buyrecord'][$k]['lottery_time3'] = implode($string[0]);
                    if($k<100){
                    $total_time += $data['buyrecord'][$k]['lottery_time3'];
                    }
                }

                $data['total_time'] = $total_time;

                //获取商品最后成交时间
                $lasttime = OrderRepositoryFacade::findDealTime($id);
                $data['lasttime'] = date('Y-m-d H:i:s', floor($lasttime/1000)) . '.' . substr($lasttime, -3);

                //获取热门推荐商品四条
                $data['hot'] = IndexRepositoryFacade::findNew(4);

                //获取中奖者信息
                $fetchuser = OrderRepositoryFacade::findFetchUser($id);
				
                //获取中奖用户信息
                if (!empty($fetchuser) && is_array($fetchuser)) {
                    $userinfo = UserRepositoryFacade::findUserInfo($fetchuser[0]['usr_id']);
                    foreach ($fetchuser as $key => $val) {
                        $fetchuser[$key]['nickname'] = !empty($userinfo['nickname']) ? $userinfo['nickname'] : config('global.default_nickname');
                        $fetchuser[$key]['user_photo'] = !empty($userinfo['user_photo']) ? $userinfo['user_photo'] : config('global.default_photo');
            
                        $fetchuser[$key]['bid_time'] = date('Y-m-d H:i:s', floor($val['bid_time']/1000)) . '.' . substr($val['bid_time'], -3);
                        $fetchuser[$key]['kaijiang_time'] = date('Y-m-d H:i:s', floor($data['goods_will']['lottery_time']/1000)) . '.' . substr($data['goods_will']['lottery_time'], -3);
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
	            $seo_index = config('seo.index');
	            $seo['web_title'] = $data['goods_will']['belongs_to_goods']['seo_title'] ? $data['goods_will']['belongs_to_goods']['seo_title'] : $seo_index['web_title'];
	            $seo['web_keyword'] = $data['goods_will']['belongs_to_goods']['seo_keyword'] ? $data['goods_will']['belongs_to_goods']['seo_keyword'] : $seo_index['web_keyword'];
	            $seo['web_description'] = $data['goods_will']['belongs_to_goods']['seo_descript'] ? $data['goods_will']['belongs_to_goods']['seo_descript'] : $seo_index['web_description'];

                return view('foreground.lotteryafter', array('data' => $data, 'usr_id' => $usr_id, 'id' => $id, 'fetchuser' => $fetchuser, 'seo' => $seo));
                break;
            default:
                return view('foreground.product_notfound');
        }


    }

    //所有商品分类
    public function productCatgory($cateid = '')
    {
        //获取全部商品可用数量
        $data['count'] = ProductRepositoryFacade::findAllGoods();
        $data['cateid']=!empty($_REQUEST['cateid'])?$_REQUEST['cateid']:'';

	    if(empty($data['cateid'])){
		    //seo 链接伪静态
		    //$cate_arr = ['shouji' => 99, 'diannao' => 100, 'shipin' => 101, 'chongzhi' => 102, 'touzi' => 103, 'shoushibao' => 104, 'huazhuang' => 105, 'muying' => 106, 'jiaju' => 107, 'qita' => 108];
		    $data['cateid'] = $cateid ? $cateid : '';
	    }

        return view('foreground.product_all', array('data' => $data));
    }

    /*
     * search 商品搜索 $type: 0:即将揭晓 1:剩余人次 2:热卖 3:最新商品 4:价格 升序 5：价格 降序
     * strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) 转义
     */
    public function search($type = 0, $p = null)
    {
        $pages = 40;
        if ($p) {
            if ($type == 0) {
                $list = Object::where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.title', 'like', '%'.strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%')
                    ->select('ykg_goods.*', 'tab_object.*')->paginate($pages);
            } else {
                if ($type == 1) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->where('ykg_goods.title', 'like', '%' . strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%')
                        ->select('ykg_goods.*', 'tab_object.*', DB::raw('tab_object.total_person-tab_object.participate_person as subperson'))
                        ->orderBy('subperson', 'asc')
                        ->paginate($pages);
                } else if ($type == 2) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->where('ykg_goods.title', 'like', '%' . strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%')->orderBy('tab_object.periods', 'desc')
                        ->select('ykg_goods.*', 'tab_object.*')
                        ->paginate($pages);
                } else if ($type == 3) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->where('ykg_goods.title', 'like', '%' . strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%')->orderBy('ykg_goods.time', 'desc')
                        ->select('ykg_goods.*', 'tab_object.*')
                        ->paginate($pages);
                } else if ($type == 4) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->where('ykg_goods.title', 'like', '%' . strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%')->orderBy('ykg_goods.money', 'asc')
                        ->select('ykg_goods.*', 'tab_object.*')
                        ->paginate($pages);
                } else if ($type == 5) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->where('ykg_goods.title', 'like', '%' . strtr($p,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%')->orderBy('ykg_goods.money', 'desc')
                        ->select('ykg_goods.*', 'tab_object.*')
                        ->paginate($pages);
                }
            }
        } else {
            if ($type == 0) {
                $list = Object::where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')->select('ykg_goods.*', 'tab_object.*')->paginate($pages);
            } else {
                if ($type == 1) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->select('ykg_goods.*', 'tab_object.*', DB::raw('tab_object.total_person-tab_object.participate_person as subperson'))
                        ->orderBy('subperson', 'asc')
                        ->paginate($pages);
                } else if ($type == 2) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->select('ykg_goods.*', 'tab_object.*')->orderBy('tab_object.periods', 'desc')
                        ->paginate($pages);
                } else if ($type == 3) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->select('ykg_goods.*', 'tab_object.*')->orderBy('ykg_goods.time', 'desc')
                        ->paginate($pages);
                } else if ($type == 4) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->select('ykg_goods.*', 'tab_object.*')->orderBy('ykg_goods.money', 'asc')
                        ->paginate($pages);
                } else if ($type == 5) {
                    $list = DB::table('tab_object')->where('is_lottery', 0)->join('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')
                        ->select('ykg_goods.*', 'tab_object.*')->orderBy('ykg_goods.money', 'desc')
                        ->paginate($pages);
                }
            }

        }
        return view('foreground.search', ['list' => $list, 'searchval' => $p, 'type' => $type]);
    }
	
	//M1
	public function proCurObj($id){
		$res  = DB::table('tab_object')->where('g_id',$id)->where('is_lottery',0)->orderBy('periods','desc')->limit(1)->get();
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/product/'.$res[0]->id; 
		echo "<script>window.location='".$url."'</script>";
	}

}