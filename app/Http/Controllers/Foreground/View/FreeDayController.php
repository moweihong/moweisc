<?php
/*
 M1 add by tangzhe 2016-06-14 分销系统入口处理
*/
namespace App\Http\Controllers\Foreground\View;

use DB;
use App\Models\Member;
use App\Models\Object;
use App\Models\FreeDay;
use App\Models\Bid_record;
use App\Models\InviteGoods;
use App\Http\Controllers\ForeController;
use Cookie;

class FreeDayController extends ForeController {
    public $price = 100;  //每次抽奖消耗块乐豆
    public $invite_goods = array();
    
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
		$kl_bean = 0;
		$is_get = 0;
		$is_first_lottery = 0;
        if(session('user.id')){
        	
            //判断是否第一次抽奖，第一次抽奖免费，如果未中奖，赠送10元的红包
            $count = FreeDay::where('usr_id', session('user.id'))->count();
            $is_first_lottery = $count > 0 ? 0 : 1;
            session(['is_first_lottery' => $is_first_lottery]);
            
            //抽奖数据
            $member = Member::where('usr_id', session('user.id'))->first();
            $flag = 0;   //是否满足抽奖条件标识
            if($member->kl_bean >= $this->price || session('is_first_lottery') == 1){
                $flag = 1;
            }
			$kl_bean = $member->kl_bean;
           
            //邀请数据
            $base_url  =  config('global.api.base_url');
            $api_url   =  config('global.api.getInviteInterval');
            $invite_res = $this->api($base_url,$api_url,array('usr_id' => session('user.id')),'GET');
            
            if($invite_res['code'] >= 0){
                $total_invite = $invite_res['code'];
                session(['userInviteInterval' => $total_invite]);
            }else{
                $total_invite = 0;
            }
            
            $invite_url = url('/freeday?code='.$member->usr_id.'&is_freeday=1');  //邀请链接
            $btn_class = 'invite_friend_grey';  //登陆后邀请及领取的按钮class
            
            $is_get = Bid_record::where('usr_id',session('user.id'))->where('pay_type', 'invite')->count();;  //是否领取
            
        }else{
            $member = array();
            $flag = -1;
            $total_invite = 0;
            $invite_url = url('/register');
            $btn_class = 'invite_friend_login';  //未登录按钮class
        }
        
        $lucky_num = date('nd', time());
        $nums['one'] = substr($lucky_num, 0, 1);
        $nums['two'] = substr($lucky_num, 1, 1);
        $nums['three'] = substr($lucky_num, 2, 1);
        
        //一元夺宝最快揭晓的的商品
        $objects = Object::leftjoin('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')->where('tab_object.is_lottery', 0)->orderBy('tab_object.end_time', 'asc')->skip(0)->take(4)->get(['ykg_goods.*', 'tab_object.id as oid', 'tab_object.participate_person', 'tab_object.total_person']);
        foreach ($objects as &$obj){
            $obj->rate = floor(round($obj->participate_person/$obj->total_person, 4) * 100);
        }
        
        //邀请奖品信息
        $invite_goods = InviteGoods::where('status', '1')->skip(0)->orderBy('invite_need','ASC')->take(4)->get();
        $is_get_flag = 0;
        foreach ($invite_goods as &$invite_good){
            $invite_good->width = $total_invite <= $invite_good->invite_need ? floor(round($total_invite/$invite_good->invite_need, 4) * 100).'%' : '100%';
            $invite_good->btn_class = $btn_class;
            $invite_good->btn_name = '立即领取';
            
            if($btn_class == 'invite_friend_login'){
                //$invite_good->btn_name = '立即领取';
            }else{
                //$invite_good->btn_name = '立即领取';
                if($total_invite >= $invite_good->invite_need){
                    if($invite_good->stock > 0){
                        $invite_good->btn_class = 'invite_friend_success';
                        //$invite_good->btn_name = '领取奖品';  
                    }
                    
                    if(session('user.id')){
                        if($is_get_flag = 1){  //已领取商品只显示一个 
                            $count = Bid_record::where('usr_id',session('user.id'))->where('pay_type', 'invite')->where('g_id', $invite_good->id)->count();
                            $is_get_flag = $invite_good->is_get = $count > 0 ? 1 : 0;  //该商品是否领取
                        }
                    }
                }
            }
        }
        
        //最新获奖信息
        $prize_log = DB::select('SELECT m.nickname FROM  `tab_freeday_log` as f left join tab_member as m on m.usr_id=f.usr_id  where f.happy_num=f.lucky_num and f.status=1 and f.user_phone > 0 order by f.id desc limit 10');
        //最新红包信息
        $red_log = DB::select('SELECT m.nickname, f.red_code FROM  `tab_member_red` as f left join tab_member as m on m.usr_id=f.usr_id where f.red_code in (8,9) and f.status=0 order by f.id desc limit 10');

        $anouncement = array();
        foreach ($prize_log as $row){
            $anouncement[] = array('nickname'=>$row->nickname, 'desc'=>'999元现金红包');
        }
        foreach ($red_log as $row){
            $name = $row->red_code == 8 ? '2元红包' : '3元红包';
            $anouncement[] = array('nickname'=>$row->nickname, 'desc'=>$name);
        }
        shuffle($anouncement);
        
        $reg_flag_freeday = 0;
        if(session('reg_flag_freeday')){
            $reg_flag_freeday = 1;
            session()->forget('reg_flag_freeday');
        }
        
        return view(
            'foreground.freeday', 
            array('lucky_num' => $lucky_num, 
                  'nums' => $nums, 
                  'flag' => $flag,
                  'objects' => $objects,
                  'member' => $member,
                  'invite_url' => $invite_url,
                  'total_invite' => $total_invite,
                  'invite_goods' => $invite_goods,
                  'anouncement' => $anouncement,
				  'kl_bean' => $kl_bean,
                  'is_mobile' => 2,
                  'invite_code_m' => empty(session('invite_code')) ? 0 : session('invite_code'),
                  'is_freeday' => empty(session('is_freeday')) ? 0 : session('is_freeday'),
                  'is_get' => $is_get,
                  'reg_flag_freeday' => $reg_flag_freeday,
                  'is_first_lottery' => $is_first_lottery
            )
        );
    }
}