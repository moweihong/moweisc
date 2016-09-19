<?php
/**
 * Created by liuchen.
 * User: liuchen
 * Date: 2016/6/27 0027
 * Time: 14:58
 */

namespace App\Http\Controllers\h5\View;

use DB;
use App\Models\Member;
use App\Models\Object;
use App\Models\Rotary;
use App\Http\Controllers\ForeController;
use Cookie;

class RotaryController extends ForeController{
	public $price = 10;  //每次抽奖消耗块乐豆

	public function __construct(){
		parent::__construct();

		if(empty(session('user.id'))){  //未登录状态
			//获取用户邀请码
			$invite_code = $this->getParam('code', '');
			$is_freeday = $this->getParam('is_freeday', 0);
			if(!empty($invite_code)){
				$member = Member::where('usr_id', $invite_code)->first();
				if(!empty($member)){
					session(['invite_code' => $invite_code]);
					session(['is_freeday' => $is_freeday]);
				}
			}
		}
	}

	public function index(){
		//M1 START
		if(isset($_GET['salesman_usrid'])){
			Cookie::queue('recommend_id',(int)$_GET['salesman_usrid']);
		}else{
			Cookie::queue('recommend_id','');
		}
		if(isset($_GET['salesman_usrid']) && isset($_GET['way']) ){
			DB::table('ykg_cps')->insert(['time'=>time(),'salesman_usrid'=>(int)$_GET['salesman_usrid'],'way'=>(int)$_GET['way']]);
		}
		//M1 END

		$flag = 0;  //是否满足抽奖条件标识（-1：未登录 0：块乐豆不足 1：使用免费次数抽奖 2：使用块乐豆抽奖）
		$rotary_request = '';  //抽奖请求url
		$total_free_times = 0;  //总获得免费抽取次数
		$last_free_times = 0;  //剩余免费抽取次数
		$kl_bean_times = 0;  //剩余块乐豆抽取次数
		$invite_total = 0;  //邀请总人数
		$member = array();  //个人信息
		if(session('user.id')){
			//获取抽奖用户信息
			$rotary_member = DB::table('tab_rotary_member')->where('usr_id', session('user.id'))->first();
			if(empty($rotary_member)){
				$is_freeday = session('is_freeday') ? 1 : 0;   //是否通过天天免费分享渠道邀请注册
				$is_new = session('is_new') ? 1 : 0;   //是否新用户
				session()->forget('is_freeday');
				session()->forget('is_new');
				DB::insert("insert into tab_rotary_member (usr_id,invite_total,invite_last,is_new,is_freeday,time) values (".session('user.id').",0,0," . $is_new . "," . $is_freeday . ",".time().")");
				$total_free_times = $last_free_times = $flag = $is_new == 1 ? 1 : 0;//第一次抽奖免费
			}else{
				$last_free_times = $rotary_member->is_new == 1 ? 1 : intval($rotary_member->invite_last/3);  //每3人折算为一次免费抽奖次数
				$total_free_times = intval($rotary_member->invite_total/3) + 1;  //总获取免费次数，需要加上第一次注册赠送的免费次数
				$invite_total = $rotary_member->invite_total;
			}

			//判断抽奖条件
			$member = Member::where('usr_id', session('user.id'))->first();
			$kl_bean_times = intval($member->kl_bean/$this->price);
			//$today_free_times = DB::table('tab_rotary_log')->where('usr_id', session('user.id'))->where('is_free', 1)->where('time', '>=', strtotime(date('Y-m-d 00:00:00')))->count();//当天使用过的免费次数
			if(($last_free_times > 0) || $flag == 1){
				$flag = 1; //满足使用免费次数条件
				$rotary_request = '/rotary/run_o';
			}else if($member->kl_bean >= $this->price){
				$flag = 2;  //使用块乐豆
				$rotary_request = '/rotary/run_t';
			}

			$invite_url = url('/freeday_m?code='.$member->usr_id.'&is_freeday=1');  //邀请链接
		}else{
			$flag = -1;   //未登录
			$invite_url = url('/reg_m');
		}

		//一元夺宝最快揭晓的的商品
		$products = array();
		$objects = Object::leftjoin('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')->where('tab_object.is_lottery', 0)->orderBy('tab_object.end_time', 'asc')->skip(0)->take(4)->get(['ykg_goods.*', 'tab_object.id as oid', 'tab_object.participate_person', 'tab_object.total_person']);
		foreach ($objects as $key => $obj){
			$obj->rate = floor(round($obj->participate_person/$obj->total_person, 4) * 100);
			$products[] = $obj;
		}

		//最新获奖信息
		$prize_log = DB::select('SELECT m.nickname, m.mobile, p.name, f.time FROM  `tab_rotary_log` as f left join tab_member as m on m.usr_id=f.usr_id left join tab_rotary_prize as p on p.id = f.prize_id  where f.prize_id > 0 and f.status = 1 order by f.id desc limit 8');

		$anouncement = array();
		$fake_prize = array('iphone 6', 'ipad mini 2', '小米（MI）平衡车', '暴风魔镜VR');
		$fake_user = array('186****8593', '134****9104', '188****7710', '150****5235', '177****1125', '137****1061','186****7635','150****8636','186****3598');
		foreach ($prize_log as $k => $row){
			$anouncement[intval($k/3) + 2][] = array('nickname'=>$row->nickname, 'mobile' => substr_replace($row->mobile, '****', 3, 4), 'prize'=>$row->name, 'time' => date('Y/m/d H:i:s', $row->time));
		}

		if(empty(session('fake_prize_info'))){
			$rand_user = mt_rand(0, 8);
			$anouncement[4][] = array('nickname' => $fake_user[$rand_user], 'mobile' => $fake_user[$rand_user], 'prize' => $fake_prize[mt_rand(0,3)], 'time' => date('Y/m/d H:i:s'));
			session(['fake_prize_info' => $anouncement[4][2]]);
		}else{
			$anouncement[4][] = session('fake_prize_info');
		}


		$state = session('login_state') ? session('login_state') : md5(uniqid(rand(), TRUE));
		session(['login_state' => $state]);
		$wx_callback = config('global.weixin_m.wx_callback');
		$qq_callback = config('global.qq.qq_callback_m');
		$wx_login_url ='https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . config('pay.APPID') . '&redirect_uri=' . urlencode($wx_callback) . '&response_type=code&scope=snsapi_userinfo&state=' . session('login_state') . '#wechat_redirect';
		$qq_login_url ="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" . config('global.qq.AppID') . "&redirect_uri=" . urlencode($qq_callback) . "&state=" . session('login_state') ;
		$total_last_times = $last_free_times + $kl_bean_times;

		return view(
			'h5.rotary',
			array(
				'flag' => $flag,
				'member' => $member,
				'products' => $products,
				'rotary_request' => $rotary_request,
				'invite_url' => $invite_url,
				'invite_total' => $invite_total,
				'last_free_times' => $last_free_times,
				'total_free_times' => $total_free_times,
				'total_last_times' => $total_last_times,
				'anouncement' => $anouncement,
				'invite_code_m' => empty(session('invite_code')) ? 0 : session('invite_code'),
				'is_freeday' => empty(session('is_freeday')) ? 0 : session('is_freeday'),
				'wx_login_url' => $wx_login_url,
				'qq_login_url' => $qq_login_url
			)
		);
	}
}