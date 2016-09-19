<?php
namespace App\Http\Controllers\Foreground\View;
use App\Models\Member;
use App\Models\ShowOrder;
use App\Models\Bid_record;
use App\Models\Article_cat;
use App\Models\Address;
use App\Models\Order;
use App\Models\Red;
use App\Models\Recharge;
use App\Models\Commission;
use App\Models\Userpoint;
use App\Models\Bank;
use Carbon\Carbon;
use App\Models\AddMoneyRecord;
use Request,Validator;  
use App\Http\Controllers\ForeController;
use Mail;
use DB;
use App\Repositories\FunctionRepository;
use App\Models\Goods;
use App\Models\Message;
use App\Models\MessageRead;
use App\Models\WithdrawCash;
use View;
use App\Http\Tools\Recharge\RechargeMobile;
class UserController extends ForeController {
   
    //用户唯一id
    protected $uid;
    
    public function __construct()
    {
        $this->uid = session('user.id');
        parent::__construct();
        
        //查询是否存在已过期未支付记录未更新状态
        $expire = AddMoneyRecord::where('usr_id',$this->uid)->where('status', 0)->where('expired_time', '<', time())->get();
        if($expire){
            foreach ($expire as $row){
                $row->status = 2;
                $row->save();
            }
        }
        //未支付订单数量
        $no_pay_count = AddMoneyRecord::where('usr_id',$this->uid)->where('status', 0)->where('source', 'pc')->count();
        View::share('no_pay_count', $no_pay_count);
		
		//中标并且未领取数量
        $prize = DB::table('tab_bid_record')->where('usr_id',$this->uid)->where('fetchno','<>','')->where('status','<=',2)->whereNotIn('pay_type',['invite'])->get();
        
        $myprize = count($prize);
        View::share('myprize', $myprize);
        //增加中奖提示信息 16.7.4 by byl
        if($myprize>0){
            foreach ($prize as $key=>$val){
                $my_prize_list[$key]=$val->g_name;
            }
            View::share('my_prize_list', $my_prize_list);
        }
		
		//未晒单数量
		$myshownum=Bid_record::where('fetchno','<>','0')
	   ->where('ykg_goods.is_virtual','0')
	   ->where('tab_bid_record.status',5)
	   ->where('tab_bid_record.usr_id',$this->uid)
	   ->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
	   ->count();
	    View::share('myshownum', $myshownum);
    }
    /*
     * @param :   $user 用户信息  $redtotal：红包总数   $orderSure：待确认的订单数  $orderSend：待发货数  $orderGet：待收货数 
     * $obtainOrder：获得的商品   $yunOrder：一块购记录
     */
    //默认首页，我的账户页面
    public function index(){
        $user = Member::where('usr_id',$this->uid)->first();
        $timenow = time();
        $redtotal = Red::where('usr_id',$this->uid)->where('status','=',0)->where('end_time','>',$timenow)->count();
        $orderSure = Order::where(['usr_id'=>$this->uid,'status'=>2])->where('fetchno','>',0)->count();
        $orderSend = Order::where(['usr_id'=>$this->uid,'status'=>3])->where('fetchno','>',0)->count();
        $orderGet = Order::where(['usr_id'=>$this->uid,'status'=>4])->where('fetchno','>',0)->count();
        //获得商品
        $obtainOrder = Order::where('usr_id',$this->uid)->where('fetchno','>',0)->orderBy('bid_time','desc')->limit(2)->get();
        $yunOrder = Order::where('usr_id',$this->uid)->where('status','>=','2')->whereNotIn('pay_type',['invite'])->orderBy('bid_time','desc')->limit(10)->get();
        //佣金大于100 显示窗口提示升级为聚到用户 资料未完善要先完善资料
        $commission = Commission::where('usr_id',$this->uid)->whereIn('source_type',[3,4])->sum('commission')+$user->commission;//佣金提现或转余额之后 也可以升级
        $isshow = 0;
        if ($user->usr_level == 0 && ($user->commission>=100||$commission>=100)){
            if(empty($user->nickname)||empty($user->sex)||empty($user->birthday)||empty($user->now_address)||empty($user->home_address))
            {
                $isshow = 1;
            } else {
                $isshow = 2;
            }
        }
        return view('foreground.user_account',['user'=>$user,'obtainOrder'=>$obtainOrder,'yunOrder'=>$yunOrder,'redtotal'=>$redtotal,'orderSure'=>$orderSure,'orderSend'=>$orderSend,'orderGet'=>$orderGet,'isshow'=>$isshow]);
    }
    
	//确认收货  
	public function confirmGood()
	{
		$res=Order::find($_POST['id']);
        if($res->usr_id==$this->uid)
        {
        	$res->status=5;
			if($res->save())
			{
				$result['msg']='确认成功';
			    $result['code']=1;
			}
			else
			{
				$result['msg']='确认失败';
			    $result['code']=-2;
			}
        }
		else
		{
			$result['msg']='非法操作';
			$result['code']=-1;
		}
		echo json_encode($result);
		
	}
    
    /*
     * 用户升级为渠道用户
     */
    public function levelUp()
    {
        $user = Member::where('usr_id',$this->uid)->first();
        if($user){
            $commission = Commission::where('usr_id',$this->uid)->whereIn('source_type',[3,4])->sum('commission')+$user->commission;//佣金提现或转余额之后 也可以升级
            if ($user->usr_level == 0 && $commission>=100){
                if(empty($user->nickname)||empty($user->sex)||empty($user->birthday)||empty($user->now_address)||empty($user->home_address))
                {
                    $data['status'] = 0;
                    $data['msg'] = '资料未完善';
                } else {
                    $user->usr_level = 2;
                    if($user->update()){
                        $data['status'] =  1;
                        $data['msg'] = '恭喜，申请成功，等待审核';
                    }else {
                        $data['status'] =  0;
                        $data['msg'] = '申请失败，请稍后重试';
                    }
                }
            } else {
                $data['status'] = 0;
                $data['msg'] = '您不符合升级要求';
            }
            return json_encode($data);
        }
    }


    //充值页
	public function recharge_now($type=0){
		$uid = session('user.id');  
		if($uid>0){
			if($type == 0){  
				$list = AddMoneyRecord::where('usr_id',$this->uid)->where('type', 'charge')->where('status', 1)->orderBy('id','desc')->paginate(10);
			}else{ 
				$timenow = time();
				$beforetime = $this->getTime($type);
				$list = AddMoneyRecord::where('usr_id',$this->uid)->where('type', 'charge')->where('status', 1)->whereBetween('time', [$beforetime, $timenow])->paginate(10); 
			}
			return view('foreground.recharge_now',['list'=>$list,'type'=>$type]);
		}
		else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/login';
			echo '<script>window.location="'.$url.'"</script>';
		}
    }

    /*充值记录页面 0全部 1今天 2本周 3是本月 4最近3个月
    public function rechargeRecord($type=0){
        if($type == 0){  
            $list = AddMoneyRecord::where('usr_id',$this->uid)->where('type', 'charge')->where('status', 1)->orderBy('id','desc')->paginate(10);
        }else{
            $timenow = time();
            $beforetime = $this->getTime($type);
            $list = AddMoneyRecord::where('usr_id',$this->uid)->where('type', 'charge')->where('status', 1)->whereBetween('time', [$beforetime, $timenow])->paginate(10); 
        }
        return view('foreground.user_account_recharge_record',['list'=>$list,'type'=>$type]);
    }*/

    //夺宝记录
    public function  buyRecord($type=0){
        //进行中
        $beforoLottery = Order::where(['usr_id'=>$this->uid,'status'=>2])->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')->where('tab_object.is_lottery','=',0) ->count();
        //即将揭晓
        $startLottery = Order::where(['usr_id'=>$this->uid,'status'=>2])->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')->where('tab_object.is_lottery','=',1)->count();
        //已揭晓
        $overLottery =Order::where('usr_id',$this->uid)->where('status','>=','2')->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')->where('tab_object.is_lottery','=',2)->count();
        if ($type == 0){
            //进行中
            $list =Order::where(['usr_id'=>$this->uid,'status'=>2])
                    ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                    ->where('tab_object.is_lottery','=',0)->orderBy('id','desc')
                    ->select('tab_bid_record.*')->paginate(10);
        }else if($type == 1){
            //即将揭晓
            $list = Order::where(['usr_id'=>$this->uid,'status'=>2])
                    ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                    ->where('tab_object.is_lottery','=',1)->orderBy('id','desc')
                    ->select('tab_bid_record.*')->paginate(10);
        }else if($type == 2){
            //已揭晓
            $list = Order::where('usr_id',$this->uid)->where('status','>=','2')
                    ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                    ->where('tab_object.is_lottery','=',2)->orderBy('id','desc')
                    ->select('tab_bid_record.*')->paginate(10);
			foreach($list as $val){
				$order = Order::where('o_id',$val->object->id)->where('fetchno','>','0')->first();
				$val->usr_id = $order->usr_id;
			}
       }  
        return view('foreground.user_account_buy_record',['list'=>$list,'beforoLottery'=>$beforoLottery,'startLottery'=>$startLottery,'overLottery'=>$overLottery,'type'=>$type]);
    }
    
    /*
     * 根据订单号获取订单信息
     */
    public function  ajaxObtainOrderInfo(Request $request)
    {
        if($request::isMethod('post')){
            $order = Order::where(['usr_id'=>$this->uid,'id'=>$request::input('id')])->first();
            if($order){
                $data['status'] = 1;
                $data['periods'] = $order->g_periods;
                $data['money'] = $order->goods->money;
                $data['title'] = $order->goods->title;
                $data['img'] = $order->goods->thumb;
                $data['time'] =date('Y-m-d H:i:s',(int)($order->bid_time/1000));
                if ($order->object->is_lottery == 2){
                    //开奖之后 中奖的订单和用户
                    $lotteryorder = Order::where(['o_id'=>$order->o_id,'fetchno'=>$order->object->lottery_code])->first();
                    if($lotteryorder){
                        $data['name'] = $lotteryorder->user->nickname;
                        $data['lottery'] =$order->object->is_lottery;
                        $data['code'] =$order->object->lottery_code;
                        $data['lotterytime'] =date('Y-m-d H:i:s',(int)($order->object->lottery_time/1000));                        
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '没有中奖订单';
                    }
                }
                $data['buyno'] = json_decode($order->buyno, true);
                shuffle($data['buyno']);
            }else {
                $data['status'] = 0;
                $data['msg'] = '没有此订单';
            }
            return json_encode($data);
        }
    }

    //中奖记录 0全部 1今天 2本周 3是本月 4最近3个月
    public function  prizeRecord($type=0){
        if($type == 0){
            $list =Order::where('usr_id',$this->uid)->where('fetchno', '>', 0)->orderBy('id','desc')->paginate(10);
        }else{
            $timenow = time();
            $beforetime = $this->getTime($type);
            $list =Order::where('usr_id',$this->uid)->whereBetween('bid_time', [$beforetime, $timenow])->where('fetchno', '>', 0)->paginate(10);
        }  
		 
        return view('foreground.user_account_prize_record',['list'=>$list,'type'=>$type]);
    }
    
    /*
     * 手机话费自动充值
     */
    public function autoRecharge(Request $request)
    {
        $validator = Validator::make($request::all(), [ 'mobile' => 'required|digits:11']);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }else{
            $mobile = $request::input('mobile');
            $id = $request::input('id');
            $is_ok = $this->cheakMobile($mobile);
            if($is_ok){
                $order = Order::where(['id'=>$id,'usr_id'=>$this->uid])->first();
                if($order->status == 2 && $order->fetchno > 0){
                    //充值金额
                    $rechargeValue = $this->getRechargeValue($order->goods->money);
	                $quantity = $rechargeValue > 100 ? intval($rechargeValue/100) : 1;
	                $rechargeMoney = $rechargeValue > 100 ? 100 : $rechargeValue;
                    $recharge =new Recharge();
                    $rechargeMobile = new RechargeMobile();
                    $msg = '';
                    $time = time();
                    $trade_id = 'ts'.$time.rand('10000','99999');
                    $result = $rechargeMobile->Huafei($trade_id, $mobile, '', $quantity, $rechargeMoney, $request::ip(), 1, $msg);
                    //充值记录
                    $recharge->usr_id = $order->usr_id;
                    $recharge->trade_id = $trade_id;
                    $recharge->order_id =  $order->id;
                    $recharge->o_id =  $order->o_id;
                    $recharge->g_id =  $order->g_id;
                    $recharge->mobile = $mobile;
                    $recharge->money = $rechargeValue;
                    $recharge->client_ip = $request::ip();
                    $recharge->create_time = $time;
                    if($result == 0){
                        $recharge->r_type = 1;
                        $recharge->log_msg = date('Y-m-d H:i:s',$time).$msg;
                        $recharge->save();
                        $order->status = 5;
                        $data['mobile'] = $mobile;
                        $order->addressjson=json_encode($data);
                        $order->update();
                        $data['status'] = 1;
                        $data['msg'] = '充值成功!';
                        return json_encode($data);
                    }else{
                        $recharge->r_type = 2;
                        $recharge->log_msg = date('Y-m-d H:i:s',$time).$msg;
                        $recharge->save();
                        $data['status'] = 0;
                        $data['msg'] = '充值失败!';
                        return json_encode($data);
                    }                    
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '操作失败!';
                    return json_encode($data);
                }
            }else{
                 $data['status'] = 0;
                 $data['msg'] = '手机号格式错误!';
                 return json_encode($data);
            }
        }            
    }
    
    public function testRecharge(Request $request)
    {
       // echo $request::ip();
        $str = substr('15012345678', 0,3);
      //  return '123'.$this->cheakMobile('15012345678');
        $out_trade_id = 'tesu12345678910';
        $recharge = new RechargeMobile();
        $msg = '';
        $result = $recharge->Huafei('tesu12345678910', '15018741670', '', 1, 10, '192.168.0.52', 1, $msg);
         echo $msg.'-----'.$result;
        $success_qty=0;
        $fail_qty=0;

        $result = $recharge->Query($out_trade_id,$success_qty,$fail_qty,$msg);

        echo "查询返回:".$result." ;消息：".$msg.";success_qty:".$success_qty.";fail_qty:".$fail_qty;
    }
    /*
     * 获取充值金额
     */
    public function getRechargeValue($g_money)
    {
        if($g_money >= 10 && $g_money < 20){
            return 10;
        }else if($g_money >= 30 && $g_money < 40){
            return 30;
        }else if($g_money >= 50 && $g_money < 70){
            return 50;
        }else if($g_money >= 100 && $g_money < 130){
            return 100;
        }else if($g_money >= 200 && $g_money < 300){
	        return 200;
        }else if($g_money >= 300 && $g_money < 400){
			return 300;
        }else if($g_money >= 500){
	        return 500;
        }
    }
    /*
     * 检测手机号的有效性
     */
    public function cheakMobile($mobile)
    {
        $mobile_arr = ['139','138','137','136','135','134','159','158','152','151','150','157','182','183','188','187','147','130','131','132','155','156','186','185','133','153','189','180'];
        $str = substr($mobile, 0,3);
        if (in_array($str,$mobile_arr)) {
            return true;
        }else{
            return false;
        }
    }
    /*
     *邀友获奖记录
     */
    public function  invitePrize(){
        
        $list =Order::where(['usr_id'=>$this->uid,'pay_type'=>'invite'])->orderBy('id','desc')->paginate(10);
        return view('foreground.user_account_invite_prize',['list'=>$list]);
    }
    
    /*
     * 获取订单收货地址
     */
    public function orderAddres(Request $request)
    {
    	//$order = Order::where(['usr_id'=>$this->uid,'id'=>1176])->first();
        $order = Order::where(['usr_id'=>$this->uid,'id'=>$request::input('id')])->first();
        if(!empty($order['addressjson']))
		{
		    $result=json_decode($order['addressjson']);
			$data['status'] = 1;
			$data['receiver'] = $result->receiver;
	        $data['country'] = $result->country;
	        $data['province'] = $result->province;
	        $data['city'] = $result->city;
	        $data['area'] = $result->area;
	        $data['mobile'] = $result->mobile;
			if(isset($result->notice))
			{
				$data['notice'] =$result->notice;
			}else
			{
				$data['notice'] ='';
			}
			
			return json_encode($data);
		}
		else
		{
	        if($order->relateAddress){
	            
	            $data['receiver'] = $order->relateAddress->receiver;
	            $data['country'] = $order->relateAddress->country;
	            $data['province'] = $order->relateAddress->province;
	            $data['city'] = $order->relateAddress->city;
	            $data['area'] = $order->relateAddress->area;
	            $data['mobile'] = $order->relateAddress->mobile;
				$data['notice'] = $order->relateAddress->notice;
				$order->addressjson=json_encode($data);
				$order->update();
				$data['status'] = 1;
	            return json_encode($data);
				
	        }else{
	            $data['status'] = 0;
	            $data['msg'] = '收货地址不存在！';
	            return json_encode($data);;
	        }
        }
    }
    //我的晒单
    public function  showRecord(){
    	$uid=$sessionid=session('user.id');
    	$model=new ShowOrder();
		$data['myshow']=$model->getMyShow($uid);
		$noshow=new Bid_record();
		$data['noshow']=$noshow->getUserNoShow($uid);
		//print_r($data['noshow']);exit;
        return view('foreground.user_account_show_record',$data);
    }

	//晒单操作
	public function saveShowInfo(Request $request)
	{

		$validator = Validator::make($request::all(), [
                    'sd_title'=>'required',
			        'sd_content'=>'required',
                ]);
				
		if($validator->fails()) 
		{
		    return redirect()->back()->withErrors($validator);
		}
		else
		{            
            if($request::has('showid')){
                $data['sd_title'] = $request::input('sd_title');
                $data['sd_content'] = $request::input('sd_content');
                $data['sd_photolist'] = serialize($request::input('pic'));
                $data['sd_thumbs'] = $request::input('pic')[0];
                $data['pic_num'] = count($request::input('pic'));
                $data['sd_time'] = time();
                $data['is_show'] = 0;
                $result = ShowOrder::where(['sd_uid'=>$this->uid,'id'=>$request::input('showid')])
                        ->update($data);
                if ($result){
                    return redirect('/user/show')->with('status', '编辑成功');
                }
            }else {
                $show = ShowOrder::where(['o_id'=>$request::input('o_id'),'sd_uid'=>$this->uid])->first();
                if(empty($show)){
                    $showmodel=new ShowOrder();
                    $res=$showmodel->saveShowInfo($_POST);
                    $bmodel=new Bid_record();
                    $res=$bmodel->find($_POST['bid']);
                    $res->status=6;
                    $res->save();
                    return redirect('/user/show')->with('status', 'update Success！ 成功！');
                }else{
                    return redirect()->back();
                }
            }
		}
	}

	

    /*
     * 编辑未审核通过的晒单
     */
    public function editShow(Request $request)
    {
        if($request::has('id')){
            $show = ShowOrder::where(['sd_uid'=>$this->uid,'id'=>$request::input('id')])->first();
            if($show){
                $data['status'] = 1;
                $data['title'] =$show->sd_title;
                $data['content'] =$show->sd_content;
                $data['pics'] =  unserialize($show->sd_photolist);
            }else{
                $data['status'] = 0;
                $data['msg'] = '没有找到晒单';
            }
        }
        return json_encode($data);
    }


    /*
     * 晒单详情
     */
    public function showDetail(Request $request)
    {   
        if($request::has('id')){
           $show = ShowOrder::where(['id'=>$request::input('id'),'sd_uid'=>$this->uid])->first();
           if($show){
               $data['status'] = 1;
               $data['sd_title'] = $show->sd_title;
               $data['sd_content'] = $show->sd_content;
               $data['sd_photolist'] = unserialize($show->sd_photolist);
           }else{
               $data['status'] = 0;
               $data['msg'] = '没有晒单信息';
           }
        }
        return json_encode($data);
    }

    /*
     * 我的块乐豆 $type 0全部 1今天 2本周 3是本月 4最近3个月
     * $status 0:块乐豆来源  1:块乐豆使用  2:块乐豆任务
     * Carbon::today() 获取今天的凌晨时间如：2016-03-16 00:00:00
     */
    public function  myScore($status=2,$type=0){
        if ($type == 0){
                $totalScore = Member::where('usr_id',$this->uid)->first()->kl_bean;
//                $buyScore = Userpoint::where('usr_id',$this->uid)->where('type','=',1)->sum('money');
//                $signScore =Userpoint::where('usr_id',$this->uid)->where('type','=',2)->sum('money');
//                $inviteScore =Userpoint::where('usr_id',$this->uid)->where('type','=',3)->sum('money');
		        $totalGet = Userpoint::where('usr_id',$this->uid)->whereIn('type',[0,1,2,3,4,5,7,8,10])->sum('money');
		        $totalUse = Userpoint::where('usr_id',$this->uid)->whereIn('type',[6,9])->sum('money');
	            $profile = Userpoint::where('usr_id',$this->uid)->where('type',4)->count();
            if($status == 0){
                $list = Userpoint::where('usr_id',$this->uid)->whereIn('type',[0,1,2,3,4,5,7,8,10])->orderBy('id','desc')->paginate(10);
            } else if($status == 1) {
                $list = Userpoint::where('usr_id',$this->uid)->whereIn('type',[6,9])->orderBy('id','desc')->paginate(10);
            }else{
	            $list = [];
            }
        }else {
            $timenow = time();
            $beforetime = $this->getTime($type);
            $list = Userpoint::where('usr_id',$this->uid)->whereBetween('time', [$beforetime, $timenow])->paginate(10);
            $totalScore = Userpoint::where('usr_id',$this->uid)->whereBetween('time', [$beforetime, $timenow])->sum('money');
            $buyScore = Userpoint::where('usr_id',$this->uid)->whereBetween('time', [$beforetime, $timenow])->where('type','=',1)->sum('money');
            $signScore =Userpoint::where('usr_id',$this->uid)->whereBetween('time', [$beforetime, $timenow])->where('type','=',2)->sum('money');
            $inviteScore =Userpoint::where('usr_id',$this->uid)->whereBetween('time', [$beforetime, $timenow])->where('type','=',3)->sum('money');
        }

        return view('foreground.user_account_score',['list'=>$list,'type'=>$type,'status'=>$status,'totalScore'=>$totalScore, 'totalGet' => $totalGet, 'totalUse' => $totalUse, 'profile' => $profile]);
    }
 
    //获取时间戳 1今天时间戳 2获取上周时间戳 3获取上个月时间戳 4获取上三个月时间戳
    public function getTime($value)
    {
        $carbon = new Carbon();
        switch ($value) {
            case 1:
                $time = strtotime(Carbon::today());
                break;
            case 2:
                $time = strtotime($carbon->subWeek());
                break;
            case 3:
                $time = strtotime($carbon->subMonths(1));
                break;
            case 4:
                $time = strtotime($carbon->subMonths(3));
                break;
            default:
                $time = null;
                break;
        }
        return $time;
    }
    

    //我的红包 0全部 1今天 2本周 3是本月 4最近3个月
    public function  myBriberyMoney($state=0,$type=0){
        if($state){
            //已使用的红包或已过期
            if($type == 0){
                $timenow =time();
                $list =  Red::where('usr_id',$this->uid)->where('status', [1])->orWhere(function ($query) use($timenow){
                                    $query->where('usr_id',$this->uid)
                                        ->where('end_time', '<', $timenow);
                                    })->orderBy('id','desc')->paginate(10);
            }else {
                $timenow = time();
                $beforetime = $this->getTime($type);
                $list =  Red::where('usr_id',$this->uid)->whereBetween('start_time', [$beforetime, $timenow])->whereIn('status', [1, 2])->orderBy('id','desc')->paginate(10);    
            }            
        } else {
            //未使用的红包
            if($type == 0){
                $timenow = time();
                $list = Red::where('usr_id',$this->uid)->where('status','=',0)->where('end_time','>',$timenow)->orderBy('id','desc')->paginate(10);
            }else {
                $timenow = time();
                $beforetime = $this->getTime($type);
                $list = Red::where('usr_id',$this->uid)->whereBetween('start_time', [$beforetime, $timenow])->where('status','=',0)->orderBy('id','desc')->paginate(10);
            }
            
        }        
        return view('foreground.user_account_bribery_money',['list'=>$list,'state'=>$state,'type'=>$type]);
    }

    //邀请好友
    public function  myInvite(){
        return view('foreground.user_account_invite');
    }
    //积分邀请结果
    public function  myInviteScore(){
        $invitescore = Userpoint::where('usr_id',$this->uid)->where('type','=',3)->sum('money');
       // $invitenum = Userpoint::where('usr_id',$this->uid)->where('type','=',3)->count();
        $url='unify_interface/user/getUsrLowerlist.do';
        $result=$this->javaUrl($url,['usr_id'=>$this->uid]);
        $resultText=json_decode($result,TRUE);
        if ($resultText['code'] == 0){
            $list = json_decode($resultText['resultText'],TRUE);
            $invitenum = count($list);
        }else{
            $list = null;
            $invitenum = 0; 
        }
        return view('foreground.user_account_invite_score',['list'=>$list,'invitescore'=>$invitescore,'invitenum'=>$invitenum]);
    }
    //我的佣金
    public function  myCommission(){
        return view('foreground.user_account_commission');
    }
    
    /*
     * 佣金来源
     * $inviteNums：邀请好友人数  $makeInviteCommi：邀请推广收益 $makeCommi：累计赚取佣金  $snatchCommi 好友夺宝赚取佣金
     * is_pay  收入还是取现 0：收入，1：取现 
     * source_type 赚取和消费状态 0:推广收益 1:好友夺宝赚取佣金 2:好友充值赚取佣金 3:提现佣金 4:转余额佣金 5:冻结佣金
     */
    public function  myCommissionsource(){
        $url='unify_interface/user/getUsrLowerlist.do';
        $result=$this->javaUrl($url,['usr_id'=>$this->uid]);
        $resultText=json_decode($result,TRUE);
        if ($resultText['code'] == 0){
            $users = json_decode($resultText['resultText'],TRUE);
            $inviteNums = count($users);
        }else{
            $inviteNums = 0; 
        }
       
        $makeInviteCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',0)->sum('commission');
        $makeCommi = Member::where('usr_id',$this->uid)->first()->commission;
        $snatchCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',1)->sum('commission');
        $list =  Commission::where('usr_id',$this->uid)->where('is_pay','=',0)->orderBy('id','desc')->paginate(10);
        return view('foreground.user_account_commission_source',['list'=>$list,'inviteNums'=>$inviteNums,'makeInviteCommi'=>$makeInviteCommi,'makeCommi'=>$makeCommi,'snatchCommi'=>$snatchCommi]);
    }
    
    /*
     * 佣金消费
     * $useCommiTotal:佣金累计消费 $cashCommi:提现佣金 $balanceCommi:转余额  $frozenCommi：冻结
     * is_pay  收入还是取现 0：收入，1：取现 
     * source_type 赚取和消费状态 0:推广收益 1:好友夺宝赚取佣金 2:好友充值赚取佣金 3:提现佣金 4:转余额佣金 5:冻结佣金
     */
    public function  commissionbuy(){
        $useCommiTotal =  Commission::where('usr_id',$this->uid)->where('is_pay','=',1)->sum('commission');
        $cashCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',3)->sum('commission');
        $balanceCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',4)->sum('commission');
        $frozenCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',5)->sum('commission');
        $list = Commission::where('usr_id',$this->uid)->where('is_pay','=',1)->orderBy('id','desc')->paginate(10);
        return view('foreground.user_account_commission_buy',['list'=>$list,'useCommiTotal'=>$useCommiTotal,'cashCommi'=>$cashCommi,'balanceCommi'=>$balanceCommi,'frozenCommi'=>$frozenCommi,]);
    }
    
    //我的银行卡
    public function  mybankcard(){
        $banks = array();
        $list = Bank::where('uid',$this->uid)->get();
        $banknum = $list->count();
        if($list->count()>0){
            $i = 0;
            foreach ($list as $val){
                $banks[$i]['id'] = $val->id;
                $banks[$i]['uid'] = $val->uid;
                $banks[$i]['bankname'] = $val->bankname;
                $banks[$i]['banknum'] = preg_replace('/(\d{4})(\d+)(\d{3})/', '$1*********$3', $val->banknum);
                $banks[$i]['bankinfo'] =$this->searchBank($val->bankname);
                $i++;
            }
        }
        return view('foreground.user_account_commission_mybankcard',['list'=>$banks,'banknum'=>$banknum]);
    }
    
    //需找银行卡对应的信息
    public function searchBank($bankname)
    {
        $bankInfo  = array(
                "中国农业银行"=>"ABC","交通银行"=>"COMM","中国银行"=>"BOC","中国建设银行"=>"CCB","中国光大银行"=>"CEB","兴业银行"=>"CIB","招商银行"=>"CMB","中国民生银行"=>"CMBC",
		"广发银行"=>"GDB","华夏银行"=>"HXBANK","中国工商银行"=>"ICBC","中国邮政储蓄银行"=>"PSBC","浦发银行"=>"SPDB","北京银行"=>"BJBANK",	"台州银行"=>"TZYH","济宁银行"=>"JNYH",         
		"中信银行"=>"CITIC","平安银行"=>"SPABANK"
        );
        return $bankInfo[$bankname];
    }

    //添加新银行卡
    public function  addbankcard(){
        $banktotal = Bank::where('uid',$this->uid)->count();
        return view('foreground.user_account_commission_addbankcard',['banktotal'=>$banktotal]);
    }
    
    //修改银行卡
    public function editBank($id){
        $bank = Bank::where('id',$id)->where('uid',$this->uid)->first();
        $banktotal = Bank::where('uid',$this->uid)->count();
        $bankinfo = $this->searchBank($bank->bankname);
        return view('foreground.user_editbank',['banktotal'=>$banktotal,'bankinfo'=>$bankinfo,'bank'=>$bank]);
    }
    /*
     * 保存银行卡
     */
    public function saveBank(Request $request)
    {
        if($request::isMethod('post')){
            //错误验证
            $validator = Validator::make($request::all(), [
                'username' => 'required|max:10',
                'bankname' => 'required',
                'banknum' => 'required|digits_between:16,19',
                'subbranch' => 'required|max:30',
            ],['username.max'=>'用户名太长，不能超过10个字符','subbranch.max'=>'支行输入不能超过30个字符']);
            if ($validator->fails()) {
                $data['status'] = 0;
                $data['msg'] = $validator->errors()->first();
                return json_encode($data);
            }
            if('save' == $request::input('action')){
                //保存银行卡
                $bank = new Bank();
                $bank->uid = $this->uid;
                $bank ->username = $request::input('username');
                $bank ->bankname = $request::input('bankname');
                $bank ->banknum = $request::input('banknum');
                $bank ->subbranch = $request::input('subbranch');
                if ($bank->save()){
                    $data['status'] = 1;
                    $data['msg'] = '保存成功';
                    return json_encode($data);
                } else {
                    $data['status'] = 0;
                    $data['msg'] = '保存失败请稍后重新填写';
                    return json_encode($data);
                }
            } else if('update' == $request::input('action')){
                //修改银行卡
                $result = Bank::where('id',$request::input('id'))->where('uid',$this->uid)
                        ->update(['username' =>$request::input('username'),'bankname' =>$request::input('bankname'),'banknum'=>$request::input('banknum'),'subbranch'=>$request::input('subbranch')]);
                if ($result){
                    $data['status'] = 1;
                    $data['msg'] = '修改成功';
                    return json_encode($data);
                } else {
                    $data['status'] = 0;
                    $data['msg'] = '保存失败请稍后重新修改';
                    return json_encode($data);
                }
            }
        }
    }
    /*
     * 删除银行卡
     */
    public function delBank(Request $request)
    {
        if($request::isMethod('post')){
            $result = Bank::where('id',$request::input('id'))->where('uid',$this->uid)->delete();
            if ($result){
                $data['status'] = 1;
                $data['msg'] = '删除成功';
                return json_encode($data);
            } else {
                $data['status'] = 0;
                $data['msg'] = '删除失败请稍后重新删除';
                return json_encode($data);
            }
        }
    }

    //我的地址
    public function  myAddress($orderid=null){
    	$model=new Address();
		$address=$model->getUserAddress($this->uid);
		//print_r($address);exit;
        return view('foreground.user_account_address',['address'=>$address,'userid'=>$this->uid,'orderid'=>$orderid]);
    }
    
	//保存地址
	public function saveAddress()
	{
		if($_POST['province']=="省份" || $_POST['city']=="地级市" )
		{
			$data['result']=-1;
			$data['message']="地址填写不正确";
		}
		else
		{
			$model=new Address();
		    $res=$model->saveAddress($_POST);
			if($res>0)
			{
				$data['result']=1;
			    $data['message']="success";
			}
			else
			{
				$data['result']=-2;
			    $data['message']="保存地址失败";
			}
		}
		//$result=1;
		echo json_encode($data);
	}
    /*
     * 保存订单地址
     */
    public function orderAddress(Request $request)
    {        
        $result = Order::where(['usr_id'=>$this->uid,'id'=>$request::input('o_id')])->first();
        if($result){
	        $addressid = $request::input('id');
	        $ainfo=Address::where('id',$addressid)->first();
	        $addressone['province']=$ainfo->province;
	        $addressone['city']=$ainfo->city;
	        $addressone['area']=$ainfo->area;
	        $addressone['mobile']=$ainfo->mobile;
	        $addressone['receiver']=$ainfo->receiver;
	        $addressone['country']=$ainfo->country;
			$addressone['notice']=$ainfo->notice;
	        $addressone=json_encode($addressone, JSON_UNESCAPED_UNICODE);
	        $affirm_time = time();

	        $affected = DB::update("update tab_bid_record set status = 3, addressjson = '".$addressone."', affirm_time = ".$affirm_time.",  addressid = ".$addressid." where status = 2 and usr_id = ".$this->uid." and id = ".$request::input('o_id'));
	        if($affected){
                if ($result->pay_type == 'invite'){
                    $data['type'] = 0;//地址跳去/user/inviteprize
                }else{
                   $data['type'] = 1;//地址跳去/user/prize
                }
                $data['status'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['status'] = 0;
                $data['msg'] = '请勿重复提交';
            }
        } else {
            $data['status'] = 0;
            $data['msg'] = '订单不存在';
        }
        return json_encode($data);
    }
	
	//删除收货地址
	public function deleteAddress()
	{
		$id=$_POST['id'];
		$usrid=$_POST['userid'];	
		if($usrid!=$this->uid)
		{
			$data['status'] = 0;
            $data['msg'] = '用户非法';
		}
		else
		{
			
			$res=Address::where('id', $id)->update(['is_delete' => 1]);
			if($res)
			{
				$data['status'] = 1;
                $data['msg'] = '操作成功';
			}
		    else
		    {
				$data['status'] = -1;
                $data['msg'] = '操作失败';
			}
 
		}
		return json_encode($data);
	}
    
    /*
     * 佣金提现
     */
    public function withdrawCash()
    {
        $bank = Bank::where('uid',$this->uid)->get();
        $list = array();
        if($bank->count() > 0){
            $i = 0;
            foreach ($bank as $val){
                $list[$i]['banknum'] = preg_replace('/(\d{4})(\d+)(\d{3})/', '$1*********$3', $val->banknum);
                $list[$i]['bank'] =$this->searchBank($val->bankname);
                $list[$i]['bankname'] =$val->bankname;
                $i++;
            }
        }
        $commission = Member::where(['usr_id'=>$this->uid])->first()->commission;
        return view('foreground.withdraw',['commission'=>$commission,'list'=>$list]);
    }
    
    /*
     *提现到银行卡
     */
    public function commiTobank(Request $request)
    {
        $money = $request::input('money');
          $user = Member::where('usr_id',$this->uid)->first();
        if ($money < 100){
            $data['status'] = 0;
            $data['msg'] = '转出佣金不能低于100，请正确输入！';
            return json_encode($data);
        }
        if($user->commission < $money){
            $data['status'] = 0;
            $data['msg'] = '转出佣金不能超出账户现有佣金，请正确输入！';
            return json_encode($data);
        } else {          
            $bank = Bank::where(['uid'=>$this->uid,'bankname'=>$request::input('bankname')])->first();
            if ($bank){
                $user->commission -= $money;
                if($user->update()){
                    //佣金记录
                    $commission = new Commission();
                    $commission->usr_id = $this->uid;
                    $commission->commission = $money;
                    $commission->is_pay = 1;
                    $commission->source_usr_id = $this->uid;
                    $commission->time  =  time();
                    $commission->source_type = 3;
                    $commission->save();
                    //佣金记录 end
                    //插入佣金提现表
                    $withdrawCash =new WithdrawCash();
                    $withdrawCash->uid = $bank->uid;
                    $withdrawCash->username = $bank->username;
                    $withdrawCash->bankname = $bank->bankname;
                    $withdrawCash->banknum = $bank->banknum;
                    $withdrawCash->subbranch = $bank->subbranch;
                    $withdrawCash->money = $money;
                    $withdrawCash->cashtype = 0;
                    $withdrawCash->time = time();
                    if ($withdrawCash->save()){
                        $data['status'] = 1;
                        $data['msg'] = '提交成功，后台审核中，预计1-7个工作日到账';
                        return json_encode($data);
                    } else {
                        $data['status'] = 0;
                        $data['msg'] = '申请失败，请稍后重新操作';
                        return json_encode($data);
                    }
                }
            }else {
                $data['status'] = 0;
                $data['msg'] = '非法操作';
                return json_encode($data);
            }

        }
    }


    /*
     *佣金提现到余额
     */
    public function commiToMoney(Request $request)
    {
        $money = $request::input('money');
        $user = Member::where('usr_id',$this->uid)->first();
        if($user->commission < $money && $user->commission>0){
            $data['status'] = 0;
            $data['msg'] = '转入余额佣金不能超出账户现有佣金，请正确输入！';
            return json_encode($data);
        } else {
            $user->commission -= $money;
            $user->money += $money;
            if ($user->update()){
                $commission = new Commission();
                $commission->usr_id = $this->uid;
                $commission->commission = $money;
                $commission->is_pay = 1;
                $commission->source_usr_id = $this->uid;
                $commission->time  =  time();
                $commission->source_type = 4;
                if ($commission->save()){
                    $data['status'] = 1;
                    $data['msg'] = '转入余额成功';
                    return json_encode($data);
                }
            }           
        }       
    }


    //安全中心
    public function  securityCenter(){
        $uid=session('user.id');
  	    $Member=new Member();
        
		$data['userinfo']=$Member->getUserInfo($uid);
		//var_dump(session('smscode')) ;
        
        //微信 state生成  16.6.14 by byl
        $state = md5(uniqid(rand(), TRUE));
        session(['wx_state' => $state]);
        $redirect_uri = config('global.weixin.center_callback');
        $data['state'] = $state;
        $data['redirect_uri'] = urlencode($redirect_uri);
       //qq url
        $qq_callback = config('global.qq.center_callback');
        $qq_login_url ="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" . config('global.qq.AppID') . "&redirect_uri=" . urlencode($qq_callback) . "&state=" . $state;
        $data['qq_login_url'] = $qq_login_url;
        return view('foreground.user_account_security_center',$data);
    }
    
    /*
     * 微信解绑 16.6.16 by byl
     */
    public function wxUnbind()
    {
        $state = $this->getParam('state');
        if(session('wx_state') == $state){
            $member = Member::find($this->uid);
            $member->wx_unionid = NULL;
            if($member->update()){
                $data['status'] = 1;
                $data['msg'] = '解绑成功！';
            }else{
                $data['status'] = 0;
                $data['msg'] = '解绑失败！';
            }
            session()->forget('wx_state');
            return json_encode($data);
        }else{
            $data['status'] = 0;
            $data['msg'] = '非法操作！';
            return json_encode($data);
        }
    }
    /*
     * qq解绑  16.6.16 by byl
     */
    public function qqUnbind()
    {
        $state = $this->getParam('state');
        if(session('wx_state') == $state){
            $member = Member::find($this->uid);
            $member->qq_openid = NULL;
            if($member->update()){
                $data['status'] = 1;
                $data['msg'] = '解绑成功！';
            }else{
                $data['status'] = 0;
                $data['msg'] = '解绑失败！';
            }
            session()->forget('wx_state');
            return json_encode($data);
        }else{
            $data['status'] = 0;
            $data['msg'] = '非法操作！';
            return json_encode($data);
        }
    }

	//修改昵称
	public function updateNickname()
	{
		
		$Member=new Member();
		$data=$Member->updateNickname($_POST);
		//增加块乐豆
		if($data['code']==0)
		{
			$model=new Userpoint();
			$where['type']=4;
			$where['usr_id']=$this->uid;
			$res=$model->where($where)->first();
			if(!$res)
			{
			    session(['user.nickname'  =>  $this->getParam('nickname')]);  //更新session
			    
				$arr['content']='完善用户信息送块乐豆';
				$arr['pay']='完善用户信息';
				$arr['usr_id']=$this->uid;
				$arr['type']=4;
				$arr['money']=30;
				$arr['time']=time();
				$id=$model->insertGetId($arr);
				$res=$Member->where('usr_id', $this->uid)->select('kl_bean')->first();
				$kl_bean=$res->kl_bean+30;
				$Member->where('usr_id', $this->uid)->update(['kl_bean' => $kl_bean]);
			}
		}
		echo json_encode($data);
		
	}
	
	//通过java接口获取用户信息
	public function getUserByjava()
	{
		
		$url='unify_interface/user/getUsrinf.do';
		$data['usr_id']=session('user.id');
		$res=$this->javaUrl($url,$data);
		$res=json_decode($res,TRUE);
		$res['resultText']=json_decode($res['resultText'], true);
		$res=json_encode($res);
		echo $res;
//		$data['resultText']=array('id'=>20,'user_phone'=>'13415759104','user_email'=>'895078501@qq.com','user_name'=>'test');
//		$data['code']=0;
//		echo json_encode($data);
       	
	}
	
	//更改密码调java接口
	public function updatePassWord()
	{
		
		$data['user_pass_new']=md5($_POST['newpass']);
		$data['user_name']=$_POST['username'];
		$data['user_pass']=md5($_POST['oldpass']);
//		$data['user_pass_new']=md5(123789456);
//		$data['user_name']=13580130226;
//		$data['user_pass']=md5(123456789);
		$data['is_checkoldpass']=1;
		
		$data['usr_id']=session('user.id');
        $url='unify_interface/user/setUsrpwd.do';
		
		$res=$this->javaUrl($url,$data);
		echo $res;
	}
	
	/********旧手机验证**************/
	//发送短信验证码
	public function getSmsCode()
	{
		$phone=$_POST['phone'];
		$type=$_POST['type'];
//		$phone='15211103794';
//		$type=2;
		$code=rand('100000','999999');
		$data['code']=$code;
		$data['email']=$phone;
		if($type==1)
		{
			session(['smscode'=>$code]);
			$res=$this->sendverifysms($phone,$code);
			$res['yzmcode']=$code;
			return  json_encode($res);
			
		}
		elseif($type==2)
		{
			
			session(['emailsmscodephone'=>$code]);//绑定邮箱的发送手机的验证码
			$res=$this->sendverifysms($phone,$code);
			$res['yzmcode']=$code;
			return json_encode($res);
			//exit;
		}
		elseif($type==3)
		{
			session(['emailsmscode'=>$code]);//绑定邮箱的发送邮箱的验证码
			$this->sendEmail($data);
			
		}
		else
		{
			session(['emailcode'=>$code]);//邮箱发送验证码修改绑定手机
			$this->sendEmail($data);
		}
		echo $code;
	}
	
	
	//验证码的正确性
	public function submitSmsCode()
	{
		$type=$_POST['type'];
		if($type==1){
		    $codeS=session('smscode');
		}
		elseif($type==2){
			$codeS=session('emailsmscodephone');
		}elseif($type==3)
		{
			$codeS=session('emailsmscode');
		}
		else
		{
			$codeS=session('emailcode');
		}
		$code=intval($_POST['code']);
		if($code==$codeS)
		{
			$result['code']=0;
			$result['message']='验证正确';
			
		}
		else
		{
			$result['code']=-1;
			$result['message']='验证码错误';
			
		}
		echo json_encode($result);
	}
	/*************旧手机验证end***********/
	
	/*************新手机验证start***********/
	//发送短信验证码
	public function getSmsCodeNewPhone()
	{
		$phone=$_POST['phone'];
		$code=rand('100000','999999');
		session(['smscodenewphone'=>$code]);
		$res=$this->sendverifysms($phone,$code);
		echo $code;
	}
	
	//验证码的正确性
	public function submitSmsCodeNewPhone()
	{
		$codeS=session('smscodenewphone');
		$code=$_POST['code'];
		if($code==$codeS)
		{
			$result['code']=0;
			$result['message']='验证正确';
		}
		else
		{
			$result['code']=-1;
			$result['message']='验证码错误';
		}
		echo json_encode($result);
	}
	/*************新手机验证end***********/
    
    //调用java接口修改绑定手机
    public function updateUserPhone()
	{
	
		$data['user_phone']=$_POST['phone'];
		//$data['usr_id']=$_POST['uid'];
		$data['usr_id']=session('user.id');
		//$data['user_phone']=13580130223;
        $url='unify_interface/user/setUsrphone.do';
		$res=$this->javaUrl($url,$data);
		echo $res;
		
	}
	
	//调用java接口修改绑定邮箱
    public function updateUserEmail()
	{
	
		$data['user_email']=$_POST['email'];
		$data['usr_id']=$this->uid;
        $url='unify_interface/user/setUsremail.do';
		$resutl=$this->javaUrl($url,$data);
		//第一次绑送块乐豆
		$crr=json_decode($resutl);
		if($crr->code==0)
		{
			
			$model=new Userpoint();
			$where['type']=5;
			$where['usr_id']=$this->uid;
			$res=$model->where($where)->first();
			if(!$res)
			{
				$arr['content']='绑定邮箱送可乐豆';
				$arr['pay']='绑定邮箱';
				$arr['usr_id']=$this->uid;
				$arr['type']=5;
				$arr['money']=5;
				$arr['time']=time();
				$id=$model->insertGetId($arr);
				$Member=new Member();
				$res=$Member->find(session('user.id'));
				$res->kl_bean=$res->kl_bean+5;
				$result=$res->save();
			}

		}
		echo $resutl;
	
	}
    //常见问题
    public function FAQ(){
    	$articleModel=new Article_cat();
		$articleCatList=$articleModel->getArticleCat();
		$data['articleCatList']=$articleCatList;
        return view('foreground.user_account_faq',$data);
    }
	//通过java接口获取用户注册时间
	public function getUserRegtime()
	{		
		$url='unify_interface/user/getUsrinf.do';
		$data['usr_id']=$this->uid;
		$res=$this->javaUrl($url,$data);
		$res=json_decode($res,TRUE);
		$res['resultText']=json_decode($res['resultText'], true);
       	return $res['resultText']['reg_time'];
	}
    /*
     * 系统消息  16.7.6 by byl
     */
    public function sysMessage()
    {
        $allMsg=0;
        $readMsg=0;
        $time = time();
        $reg_time = strtotime($this->getUserRegtime());
        $allMsg = Message::where('usr_id',$this->uid)->where('send_time', '<' ,$time)->orWhere('msg_type',0)->whereBetween('send_time',[$reg_time,$time])->count();
        $readMsg = Message::where(['usr_id'=>$this->uid,'r_type'=>1])->where('send_time', '<' ,$time)->count();//用户阅读的个人消息数量
        $list = Message::where('usr_id',$this->uid)->where('send_time', '<' ,$time)
            ->orWhere('msg_type',0)->whereBetween('send_time',[$reg_time,$time])->orderBy('send_time','desc')->paginate(10);
        if($list->count() > 0){
            foreach($list as $key=>$val){
                if($val->msg_type == 0){
                    //查系统消息这个用户是否已读
                    $msgRead = MessageRead::where(['msg_id'=>$val->id, 'usr_id'=>$this->uid])->first();
                    if($msgRead){
                        $val->r_type = 1;
                    }else{
                        $val->r_type = 0;
                    }
                }
            }
            //用户已阅读的所有系统消息
            $userReadMsg = MessageRead::where('usr_id',$this->uid)->count();
            $readMsg = $readMsg + $userReadMsg;
        }
        return view('foreground.user_account_message',['list'=>$list, 'allMsg'=>$allMsg, 'readMsg'=>$readMsg]);
    }
    
    /*
     * 设置消息已读  16.7.6 by byl
     */
    public function setMessage()
    {
        $id = Request::input('id');
        $msg = Message::where('id',$id)->first();
        $data['status'] = -1;
        $data['msg'] = '操作失败';
        if($msg){
            if($msg->msg_type == 0){
               $msgRead = MessageRead::where(['msg_id'=>$id, 'usr_id'=>$this->uid])->first();
               if(empty($msgRead)){
                    $newMsgRead = new MessageRead();
                    $newMsgRead->msg_id = $id;
                    $newMsgRead->usr_id = $this->uid;
                    if($newMsgRead->save()){
                         $data['status'] = 0;
                         $data['msg'] = '操作成功';
                    }
                }
            }else{
                if(($msg->r_type == 0) && ($msg->usr_id == $this->uid)){
                    $msg->r_type = 1;
                    if($msg->update()){
                        $data['status'] = 0;
                        $data['msg'] = '操作成功';
                    }
                }               
            }
        }
        return json_encode($data);
    }

    //获取用户头像
	public function getUserPhoto()
	{
		$uid=session('user.id');
		$member = new Member();
		$res=$member->where('usr_id',$uid)->select('user_photo')->first();
		echo json_encode($res);
	}
	
	//邮件发送验证码
	public function sendEmail($data)
	{		 
		 $content=$data['code'];
		 $email=$data['email'];
         $flag = Mail::send('emails.test',['name'=>$content],function($message) use($email){
         $message ->to($email)->subject('深圳特速一块购');
         });
         if($flag){
           return 0;//成功
         }else{
           return -1;
         }
	}

    
	
	
	protected function javaUrl($url,$arr)
	{
        $url_java = config('global.api.base_url');
		
		$readUrl=$url_java.$url.'?';
		
	    foreach($arr as $k=>$v)
		{
			$readUrl=$readUrl.$k.'='.$v.'&';
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch, CURLOPT_URL, $readUrl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec($ch);
		return $output;
		
	}
	
	//测试发送短信
	public function phoneSendCode()
	{
		$model=new FunctionRepository();
		$phone_number='13415759104';
		$template_id='219452';
		$param='123456';
		$res=$this->sendverifysms($phone_number,$param);
		//$res=$model->sendMessage($phone_number, $template_id, $param);
		var_dump($res);
//      $str='{“username”: “Eric”,”age”:23,”sex”: “man”}';
//		var_dump(json_encode($str));

	}
    
	//我的未支付订单(所有金额计算时以分为单位，最后再转换为元)
	public function myUnpayOrder(){
	    $pay_type = config('global.pay_type');

	    //获取未支付订单
	    $list = AddMoneyRecord::where('usr_id',$this->uid)->where('status', 0)->where('source', 'pc')->get()->toArray();
		//print_r($list);exit;
	    foreach ($list as $key => &$record){
	        $record['total_amount'] = 0;  //消费总额
	        $record['pay_money'] = 0;  //使用余额
	        $record['red_amount'] = 0;   //红包金额
	        
	        //处理非充值记录
	        if($record['type'] == 'buy'){
	           $scookies = json_decode($record['scookies'], true);
				
	           //dd($scookies);
    	       foreach ($scookies['cart_list'] as $cart){
    	           $g_id = $cart['g_id'];
    	           $good = Goods::leftjoin('tab_object', 'tab_object.g_id', '=', 'ykg_goods.id')->where('ykg_goods.id', $g_id)->where('ykg_goods.isdeleted', 0)->where('tab_object.is_lottery', '0')->first();
    	           if(empty($good)){
    	               unset($list[$key]);   //商品已下架，不显示
    	           }else{
    	               $record['good'][$g_id]['title'] = $good->title;
    	               $record['good'][$g_id]['bid_cnt'] = $cart['bid_cnt'];
		               $record['total_amount'] += $cart['bid_cnt'] * $good->minimum * 100;
    	           }
    	       }
			   
			    //红包信息
		        if($scookies['red_id'] > 0){
		            $red_info = Red::leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')->where('tab_member_red.id', $scookies['red_id'])->first(['tab_member_red.*', 'tab_redbao.money']);
		            $record['red_amount'] = $red_info->money * 100;
		            $record['red_status'] = $red_info->status;
		        }
		        
		        if($record['total_amount'] > $record['red_amount'] + $record['money'] * 100){
		            $record['pay_money'] = number_format(round(($record['total_amount'] - $record['red_amount'] - $record['money'] * 100)/100, 2), 2);
		        }
			   

	        }
	        

	        if($record['total_amount'] > $record['red_amount'] + $record['money'] * 100){
	             $record['pay_money'] = number_format(round(($record['total_amount'] - $record['red_amount'] - $record['money'] * 100)/100, 2), 2);

	        }else if($record['type'] == 'charge'){
	            $record['total_amount'] = $record['money'] * 100;

	        }
	        
	        $record['total_amount'] = number_format(round($record['total_amount']/100, 2), 2);
	        $record['red_amount'] = number_format(round($record['red_amount']/100, 2), 2);
	        
	        $type = $record['pay_type'];
	        $record['pay_type'] = $pay_type[$type]['name'];
	        $record['pay_url'] = $pay_type[$type]['url'];
	    }
	    
	    return view('foreground.user_account_unpay_records', array('list' => $list));
	}

     //获取公益基金
     public function getFund()
     {
		$money = AddMoneyRecord::where('type', 'buy')->where('status', 1)->sum('amount');
		$result['money']=floor($money/100);
		echo json_encode($result);
     }
	 
	 //他人购买记录
	 public function getHisBuy()
	 {
	 	echo '他人购买记录';
	 }
     
	
	
}