<?php
namespace App\Http\Controllers\h5\View;
use App\Models\Member;
use App\Models\ShowOrder;
use App\Models\Bid_record;
use App\Models\Article_cat;
use App\Models\Address;
use App\Models\Order;
use App\Models\Object;
use App\Models\Red;
use App\Models\Commission;
use App\Models\Userpoint;
use App\Models\Bank;
use Carbon\Carbon;
use App\Models\AddMoneyRecord;
use Request,Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\ForeController;
use Mail;
use DB;
use App\Repositories\FunctionRepository;
use App\Models\Goods;
use App\Models\WithdrawCash;
use View;
use App\Models\Recharge;
use App\Http\Tools\Recharge\RechargeMobile;
use App\Models\Message;
use App\Models\MessageRead;
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
        $no_pay_count = AddMoneyRecord::where('usr_id',$this->uid)->where('status', 0)->where('source', 'wap')->count();
        View::share('no_pay_count', $no_pay_count);
		
		//中标并且未领取数量
        $myprize = DB::table('tab_bid_record')->where('usr_id',$this->uid)->where('fetchno','<>','')->where('status','<=',2)->count();
        View::share('myprize', $myprize);
    }
    
    //默认首页，我的账户页面
    public function index(){
        $user = Member::where('usr_id',$this->uid)->first();
        $redtotal = Red::where('usr_id',$this->uid)->count();
        $orderSure = Order::where(['usr_id'=>$this->uid,'status'=>2])->where('fetchno','>',0)->count();
        $orderSend = Order::where(['usr_id'=>$this->uid,'status'=>3])->where('fetchno','>',0)->count();
        $orderGet = Order::where(['usr_id'=>$this->uid,'status'=>4])->where('fetchno','>',0)->count();
        //获得商品
        $obtainOrder = Order::where('usr_id',$this->uid)->where('fetchno','>',0)->orderBy('bid_time','desc')->limit(2)->get();
        $yunOrder = Order::where('usr_id',$this->uid)->where('status','>=','2')->orderBy('bid_time','desc')->limit(10)->get();
        //佣金大于100 显示窗口提示升级为聚到用户 资料未完善要先完善资料
        $isshow = 0;
        if ($user->usr_level == 0 && $user->commission>=100){
            if(empty($user->nickname)||empty($user->sex)||empty($user->birthday)||empty($user->now_address)||empty($user->home_address))
            {
                $isshow = 1;
            } else {
                $isshow = 2;
            }
        }
        return view('h5.user_m',['user'=>$user,'obtainOrder'=>$obtainOrder,'yunOrder'=>$yunOrder,'redtotal'=>$redtotal,'orderSure'=>$orderSure,'orderSend'=>$orderSend,'orderGet'=>$orderGet,'isshow'=>$isshow]);
    }
	//云购中心登录
	public function usercenter2(){
        $user = Member::find($this->uid);
        $data['kl_been'] = $user->kl_bean;
        $data['money'] = $user->money;
        $data['commission'] = $user->commission;
        $data['nickname'] = $user->nickname;
        $data['img'] = $user->user_photo;
        //红包总数 过期和使用的不统计
        $timenow = time();
        $data['redtotal'] = Red::where('usr_id',$this->uid)->where('status','=',0)->where('end_time','>',$timenow)->count();
        //总获的商品还没有完善地址
		$data['prizeTotal'] = Order::where(['usr_id'=>$this->uid,'status'=>2])->where('fetchno','>',0)->count();
        //未晒单
		$orders = Order::where('usr_id',$this->uid)->where('fetchno', '>', 0)->where('status', '=', 5)->get();
        $data['noshow'] = 0;
        foreach ($orders as $val){
            if($val->goods->is_virtual != 1){
                $data['noshow']++;
            }
        }
        //未读消息
        $user = $this->getUserByjava(); 
        $reg_time = strtotime($user['reg_time']);
        $allMsg = Message::where('usr_id',$this->uid)->where('send_time', '<' ,$timenow)->where('r_type',0)
            ->orWhere('msg_type',0)->whereBetween('send_time',[$reg_time,$timenow])->count();
        $userReadMsg = MessageRead::where('usr_id',$this->uid)->count();//用户阅读的系统消息数量
        $data['allMsg'] = $allMsg - $userReadMsg;
        
		return view('h5.member.usercenter2',$data);
	}
    
    //云购中心
	public function usercenter(){
	    if($this->uid){
	        return $this->usercenter2();
	    }else{
		    return view('h5.usercenter');
	    }
	}

	//设置昵称
	public function setnickname(){
		return view('h5.setnickname');
	}
	//个人信息
	public function userInfo(){
        $user = Member::find($this->uid);
        $data['photo'] = $user->user_photo;
        $data['username'] = $user->nickname;
        $data['nowaddress'] = $user->now_address;
        $data['homeaddress'] = $user->home_address;
        $data['salary'] = $user->salary;
        $data['sex'] = $user->sex;
        $data['birthday'] = $user->birthday;
        $userinfo = $this->getUserByjava();
        $data['mobile'] = !empty($userinfo['user_phone']) ? $userinfo['user_phone']:null;
        $data['user_email'] = !empty($userinfo['user_email']) ? $userinfo['user_email']:null;
		return view('h5.member.user_m',$data);
	}
    //修改个人信息
	public function setUserInfo(){
        $user = Member::find($this->uid);
        $data['username'] = $user->nickname;
        $data['nowaddress'] = $user->now_address;
        $data['homeaddress'] = $user->home_address;
        $data['salary'] = $user->salary;
        $data['sex'] = $user->sex;
        if($user->birthday){
            $time = explode('-',$user->birthday);
            $data['year'] = $time[0];
            $data['month'] = $time[1];
            $data['day'] = $time[2];
        }else{
            $data['year'] = '年';
            $data['month'] = '月';
            $data['day'] = '日';
        }
        return view('h5.member.set_user_info',$data);
	}
    
    /*
     * 保存用户信息
     */
    public function saveUserInfo(){  
        $form_data = Input::all();
        $validator = Validator::make($form_data,Member::$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        } 
        $user = Member::find($this->uid);      
        $user->salary = $form_data['salary'];
        $time = $form_data['year'].'-'.$form_data['month'].'-'.$form_data['day'];
        $user->nickname = $form_data['nickname'];
        $user->home_address = $form_data['home_address'];
        $user->now_address = $form_data['now_address'];
        $user->sex = $form_data['sex'];
        $user->birthday = $time;
        if($user->update()){
            session(['user.nickname'  =>  $form_data['nickname']]);  //更新session
            
			$model=new Userpoint();
			$where['type']=4;
			$where['usr_id']=$this->uid;
			$res=$model->where($where)->first();
			if(!$res)
			{
				$arr['content']='完善用户信息送块乐豆';
				$arr['pay']='完善用户信息';
				$arr['usr_id']=$this->uid;
				$arr['type']=4;
				$arr['money']=30;
				$arr['time']=time();
				$id=$model->insertGetId($arr);
				$res=Member::where('usr_id', $this->uid)->select('kl_bean')->first();
				$kl_bean=$res->kl_bean+30;
				Member::where('usr_id', $this->uid)->update(['kl_bean' => $kl_bean]);
			}
            return redirect('user_m/userinfo');
        }
    }
    /*
     *保存用户图像
     */
	public function saveFace(Request $request){
        if($request::hasFile('photo')){
            //有选择图片 校验图片格式
            $validator = Validator::make($request::all(), ['photo' => 'mimes:png,gif,jpeg,jpg,bmp|max:2048'], ['photo.mimes' => '上传的图片格式不正确','photo.max' => '图片大小不能超过2M']);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
            $file = $request::file('photo');
            //文件扩展名
            $photoext = $file->getClientOriginalExtension();
            //生成新的文件名
            $newname = time().rand( 1 , 10000 ).'.'.$photoext;
            //新的文件目录，存在就返回原有的文件目录
            $pathStr = 'backend/upload/userimg/';
            $newPath = $this->getFolder($pathStr);
            if(!$newPath){
                $validator->errors()->add('photo', '保存图片时创建目录失败');
                return redirect()->back()->withErrors($validator);
            }
            $file->move($newPath,$newname);
            $user = Member::find($this->uid);
            if($user->user_photo!=null&&$user->user_photo!='/foreground/img/def.jpg'){
                if(file_exists(substr($user->user_photo, 1))){
                    //更新图片 删除之前的图片
                    unlink(substr($user->user_photo, 1));
                }
            }
            $user->user_photo = '/'.$newPath.'/'.$newname;
            $user->update();
        } 
        return redirect('user_m/userinfo');
	}
    
    /**
     * 按照日期自动创建存储文件夹
     * @return string
     */
    private function getFolder($pathStr)
    {        
        if ( strrchr( $pathStr , "/" ) != "/" ) {
            $pathStr .= "/";
        }
        $pathStr .= date( "Ymd" );
        if ( !file_exists( $pathStr ) ) {
            if ( !mkdir( $pathStr , 0777 , true ) ) {
                return false;
            }
        }
        return $pathStr;
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
            if ($user->usr_level == 0 && $user->commission>=100){
                if(empty($user->nickname)||empty($user->sex)||empty($user->birthday)||empty($user->now_address)||empty($user->home_address))
                {
                    $data['status'] = 0;
                    $data['msg'] = '资料未完善';
                } else {
                    $user->usr_level = 1;
                    if($user->update()){
                        $data['status'] =  1;
                        $data['msg'] = '恭喜，升级成功';
                    }else {
                        $data['status'] =  0;
                        $data['msg'] = '升级失败，请稍后重试';
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
	public function recharge_now(){
		$uid = session('user.id');  
		if($uid>0)
			return view('h5.recharge_now');
		else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/login';
			echo '<script>window.location="'.$url.'"</script>';
		}
    }

    //充值记录页面 0全部 1今天 2本周 3是本月 4最近3个月
    public function rechargeRecord($type=0){
        if($type == 0){
            $list = AddMoneyRecord::where('usr_id',$this->uid)->where('type', 'charge')->where('status', 1)->paginate(10);
        }else{
            $timenow = time();
            $beforetime = $this->getTime($type);
            $list = AddMoneyRecord::where('usr_id',$this->uid)->where('type', 'charge')->where('status', 1)->whereBetween('time', [$beforetime, $timenow])->paginate(10); 
        }
        return view('h5.user_account_recharge_record',['list'=>$list,'type'=>$type]);
    }

    //云购记录
    public function  buyRecord(Request $request){
        if($request::ajax()){
            $type = $request::input('type');
            if ($type == 0){
                //进行中
                $orders =Order::where(['usr_id'=>$this->uid,'status'=>2])
                        ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                        ->where('tab_object.is_lottery','=',0)->orderBy('id','desc')
                        ->select('tab_bid_record.*')->paginate(10);
            }else if($type == 1){
                //即将揭晓
                $orders = Order::where(['usr_id'=>$this->uid,'status'=>2])
                          ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                          ->where('tab_object.is_lottery','=',1)->orderBy('id','desc')
                          ->select('tab_bid_record.*')->paginate(10);
            }else if($type == 2){
                //已揭晓
                $orders = Order::where('usr_id',$this->uid)->where('status','>=','2')
                          ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                          ->where('tab_object.is_lottery','=',2)->orderBy('id','desc')
                          ->select('tab_bid_record.*')->paginate(10);
            }
            if($orders->count()>0){
                foreach ($orders as $key=>$val){
                    $data['data'][$key]['productname'] = '（第'.$val->g_periods.'期）'.$val->g_name;
                    if($type == 2){
                        $lotteryorder = Order::where(['o_id'=>$val->o_id,'fetchno'=>$val->object->lottery_code])->first();
                        if($lotteryorder){
                            $data['data'][$key]['winner'] = $lotteryorder->user->nickname;
                        } else {
                            $data['data'][$key]['winner'] = '';
                        }                       
                    }else{
                        $data['data'][$key]['width'] = round($val->object->participate_person/$val->object->total_person*100,2);
                        $data['data'][$key]['total'] = $val->object->total_person;
                        $data['data'][$key]['last'] = $val->object->total_person-$val->object->participate_person;
                    }
                    $data['data'][$key]['person'] = count(json_decode($val->buyno));
                    $data['data'][$key]['img'] = $val->goods->thumb;
                    $data['data'][$key]['id'] = $val->id;
                    $data['data'][$key]['o_id'] = $val->object->id;
                    $data['data'][$key]['g_id'] = $val->g_id;
                }
            }else{
                $data['data'] = [];
            }
            $data['current_page'] = $orders->currentPage();
            //数据为空lastpage 为0
            $data['last_page'] = $orders->lastPage();
            $data['type'] = $type; //避免用户点击过快或网络慢，出现加载出错
            return json_encode($data);
        }else{
            $list = Object::where('is_lottery',0)->orderBy('id','desc')->limit(3)->get();
        }
        return view('h5.member.buy',['list'=>$list]);
    }
    

	//云购码详情
	public function buyDetail($id){
        $order = Order::where(['usr_id'=>$this->uid,'id'=>$id])->first();
        if($order){
            $data['periods'] = $order->g_periods;
            $data['money'] = $order->goods->money;
            $data['title'] = $order->goods->title;
            $data['img'] = $order->goods->thumb;
            $data['time'] =date('Y-m-d H:i:s',(int)($order->bid_time/1000));
            $data['is_lottery'] =$order->object->is_lottery;
            if ($order->object->is_lottery == 2){
                //开奖之后 中奖的订单和用户
                $lotteryorder = Order::where(['o_id'=>$order->o_id,'fetchno'=>$order->object->lottery_code])->first();
                if($lotteryorder){
                    $data['name'] = $lotteryorder->user->nickname;                      
                }else{
                    $data['name'] = '';  
                }
                $data['lottery'] =$order->object->is_lottery;
                $data['code'] =$order->object->lottery_code;
                $data['lotterytime'] =date('Y-m-d H:i:s',(int)($order->object->lottery_time/1000));  
            }
            $data['buyno'] = json_decode($order->buyno);
            return view('h5.member.buydetail',$data);
        }        
	}
   
    //中奖记录
    public function  prizeRecord(Request $request){
        if($request::ajax()){
            $orders = Order::where('usr_id',$this->uid)->where('fetchno', '>', 0)->orderBy('id','desc')->paginate(10);
            if($orders->count()>0){
                foreach ($orders as $key=>$val){
                    $data['data'][$key]['productname'] = '（第'.$val->g_periods.'期）'.$val->goods->title;
                    $data['data'][$key]['yunnum'] = $val->fetchno;
                    $data['data'][$key]['lotterytime'] = date('Y-m-d H:i:s',(int)($val->object->lottery_time/1000));
                    $data['data'][$key]['addressid'] = $val->addressid;
                    $data['data'][$key]['status'] = $val->status;
                    $data['data'][$key]['id'] = $val->id;
                    $data['data'][$key]['o_id'] = $val->object->id;
                    if($val->status == 5 && $val->goods->g_type==1 && $val->addressjson!=NULL){
                        $data['data'][$key]['mobile'] = json_decode($val->addressjson)->mobile;
                    }
                    $data['data'][$key]['is_rebate'] = $val->goods->is_virtual;
                    $data['data'][$key]['g_type'] = $val->goods->g_type;//话费时：为1
                    $data['data'][$key]['img'] = $val->goods->thumb;
                }
            }else{
                $data['data']=[];
            }
            $data['current_page'] = $orders->currentPage();
            $data['last_page'] = $orders->lastPage();
            return json_encode($data);
        }
        //总获得商品
		$prizeTotal = Order::where('usr_id',$this->uid)->where('fetchno', '>', 0)->count();
        //未晒单
		$orders = Order::where('usr_id',$this->uid)->where('fetchno', '>', 0)->where('status', '=', 5)->get();
        $noshow = 0;
        foreach ($orders as $val){
            if($val->goods->is_virtual != 1){
                $noshow++;
            }
        }
        $list = Object::where('is_lottery',0)->orderBy('id','desc')->limit(3)->get();
        return view('h5.member.prize',['prizeTotal'=>$prizeTotal,'noshow'=>$noshow,'list'=>$list]);
    }
	
	//虚拟奖品自动充值
	public function virtualprize($id){
        $order = Order::where(['id'=>$id,'usr_id'=>$this->uid])->first();
        if($order){
            $data['g_periods'] = $order->g_periods;
            $data['g_name'] = $order->g_name;
            $data['buycount'] = Order::where(['id'=>$id,'o_id'=>$order->o_id])->sum('buycount');
            $data['kaijiang_time'] = date('Y-m-d H:i:s',$order->kaijiang_time/1000). '.' . substr($order->kaijiang_time, -3);
            $data['fetchno'] = $order->fetchno;
            $data['img'] = $order->goods->thumb;
            $data['id'] = $order->id;
            $data['g_money'] = $this->getRechargeValue($order->goods->money);
        }else{
            return;
        }
		return view('h5.member.virtualprize',$data);
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
    public function  invitePrize(Request $request){
        if($request::ajax()){
            $orders =Order::where(['usr_id'=>$this->uid,'pay_type'=>'invite'])->orderBy('id','desc')->paginate(10);
            if($orders->count()>0){
                foreach ($orders as $key=>$val){
                    $data['data'][$key]['productname'] = $val->g_name;
                    $data['data'][$key]['lotterytime'] = date('Y-m-d H:i:s',(int)($val->bid_time/1000));
                    $data['data'][$key]['addressid'] = $val->addressid;
                    $data['data'][$key]['status'] = $val->status;
                    $data['data'][$key]['id'] = $val->id;
                    $data['data'][$key]['img'] = $val->inviteGoods->img;
                }
            }else{
                $data['data']=[];
            }
            $data['current_page'] = $orders->currentPage();
            $data['last_page'] = $orders->lastPage();
            return json_encode($data);
        }
        $list = Object::where('is_lottery',0)->orderBy('id','desc')->limit(3)->get();
        return view('h5.member.invite_prize',['list'=>$list]);
    }
    /*
     * 获取订单收货地址
     */
    public function orderAddres(Request $request)
    {
        $order = Order::where(['usr_id'=>$this->uid,'id'=>$request::input('id')])->first();
        if($order->relateAddress){
            $data['status'] = 1;
            $data['receiver'] = $order->relateAddress->receiver;
            $data['country'] = $order->relateAddress->country;
            $data['province'] = $order->relateAddress->province;
            $data['city'] = $order->relateAddress->city;
            $data['area'] = $order->relateAddress->area;
            $data['mobile'] = $order->relateAddress->mobile;
            return json_encode($data);
        }else{
            $data['status'] = 0;
            $data['msg'] = '收货地址不存在！';
            return json_encode($data);;
        }
    }
    //我的晒单
    public function  showRecord(Request $request){
		//print_r($data['noshow']);exit;
        if($request::ajax()){
            $show = ShowOrder::where('sd_uid',$this->uid)->paginate(10);
            if($show->count()>0){
                foreach ($show as $key=>$val){
                    $data['data'][$key]['productname'] = '（第'.$val->sd_periods.'期）'.$val->relateGood->title;
                    $data['data'][$key]['yunnum'] = $val->object->lottery_code;
                    $data['data'][$key]['lotterytime'] = date('Y-m-d H:i:s',(int)($val->object->lottery_time/1000));
                    $data['data'][$key]['is_show'] = $val->is_show;
                    $data['data'][$key]['kl_bean'] = $val->kl_bean;
                    $data['data'][$key]['img'] = $val->relateGood->thumb;
                    $data['data'][$key]['id'] = $val->id;
                }
            }else{
                $data['data']=[];
            }
            $data['current_page'] = $show->currentPage();
            $data['last_page'] = $show->lastPage();
            return json_encode($data);
        }
        $list = Object::where('is_lottery',0)->orderBy('id','desc')->limit(3)->get();
        return view('h5.member.show',['list'=>$list]);
    }
	
	//晒单详情
	public function showDetail($id){
        $show = ShowOrder::where(['id'=>$id,'sd_uid'=>$this->uid])->get()->first();
        $show->sd_photolist = unserialize($show->sd_photolist);
		return view('h5.member.showdetail',['show'=>$show]);
	}
	
	//设置
	public function setting(){
		return view('h5.member.setting');
	}
    //晒单上传图片
	public function showOrder($oid)
	{
		return view('h5.member.showorder',['o_id'=>$oid]);
	}
    /*
     * 保存晒单的图片第一步
     */
    public function showPic(Request $request)
    {
        if($request::hasFile('file')){
            //有选择图片 校验图片格式
            $validator = Validator::make($request::all(), ['file' => 'mimes:png,gif,jpeg,jpg,bmp|max:5120'], ['file.mimes' => '上传的图片格式不正确','file.max' => '图片大小不能超过5M']);
            if($validator->fails()){
                $data['status'] = 0;
                $data['msg'] = $validator->errors()->first();
                return json_encode($data);
            }
            $file = $request::file('file');
            //文件扩展名
            $photoext = $file->getClientOriginalExtension();
            //生成新的文件名
            $newname = time().rand( 1 , 10000 ).'.'.$photoext;
            //新的文件目录，存在就返回原有的文件目录
            $pathStr = 'backend/upload/showpic/';
            $newPath = $this->getFolder($pathStr);
            if(!$newPath){
                $data['status'] = 0;
                $data['msg'] =  '保存图片时创建目录失败';
                return json_encode($data);
            }
            $file->move($newPath,$newname);
//            $user = Member::find($this->uid);
//            if($user->user_photo!=null){
//                if(file_exists(substr($user->user_photo, 1))){
//                    //更新图片 删除之前的图片
//                    unlink(substr($user->user_photo, 1)); 
//                }
//            }            
            $data['photo'] = '/'.$newPath.'/'.$newname;
            $data['status'] = 1;
            $data['msg'] =  '上传成功';
           return json_encode($data);
        } 
    }

    /*
     * 保存晒单的图片第二步
     */
    public function savePics()
    {
        $form_data = Input::all();
        $validator = Validator::make($form_data,['title'=>'required','content'=>'required|min:20']);
        if($validator->fails()){
            $data['status'] =0;
            $data['msg'] =$validator->errors()->first();
            return json_encode($data);
        }else{
            if(count($form_data['pics'])<3){
                $data['status'] =0;
                $data['msg'] ='晒单图片不能少于3张';
                return json_encode($data); 
            }else{
                if($form_data['action'] == 'update'){
                    $showOrder['sd_title'] = $form_data['title'];
                    $showOrder['sd_thumbs'] =$form_data['pics'][0];
                    $showOrder['sd_content'] = $form_data['content'];
                    $showOrder['sd_photolist'] = serialize($form_data['pics']);
                    $showOrder['is_show'] = 0;
                    $showOrder['pic_num'] = count($form_data['pics']);
                    $result = ShowOrder::where(['sd_uid'=>$this->uid,'id'=>$form_data['id']])->
                             update($showOrder);
                    if($result){
                        $data['status'] =1;
                        $data['msg'] ='晒单成功';
                        return json_encode($data); 
                    }else{
                        $data['status'] =0;
                        $data['msg'] ='请先编辑内容';
                        return json_encode($data); 
                    }
                }else if($form_data['action'] == 'save'){
                    $order = Order::where(['usr_id'=>$this->uid,'id'=>$form_data['o_id']])->first();
                    $isShow =ShowOrder::where(['o_id'=>$order->o_id,'sd_uid'=>$this->uid])->first();
                    if(empty($isShow)){
                            $show = new ShowOrder();
                            $show->sd_uid = $this->uid;
                            $show->sd_gid = $order->g_id;
                            $show->o_id = $order->o_id;
                            $show->sd_periods = $order->g_periods;
                            $show->sd_title = $form_data['title'];
                            $show->sd_thumbs = $form_data['pics'][0];
                            $show->sd_content = $form_data['content'];
                            $show->pic_num = count($form_data['pics']);
                            $show->sd_photolist = serialize($form_data['pics']);
                            $show->sd_time = time();
                            if($show->save()){
                                $result = Order::where(['usr_id'=>$this->uid,'id'=>$form_data['o_id']])->update(['status'=>6]);
                                if($result){
                                    $data['status'] =1;
                                    $data['msg'] ='晒单成功';
                                    return json_encode($data); 
                                }
                            }
                            $data['status'] =0;
                            $data['msg'] ='晒单失败';
                            return json_encode($data); 
                    }else{
                        $data['status'] =0;
                        $data['msg'] ='请不要重复晒单！';
                        return json_encode($data);
                    }
                }                
            }
        }
    }

    /*
     * 编辑晒单
     */
    public function editShowOrder($id)
    {
        $show = ShowOrder::where(['id'=>$id,'sd_uid'=>$this->uid])->first();
        $show->sd_photolist = unserialize($show->sd_photolist);
        return view('h5.member.showorder_edit',['show'=>$show]);
    }

    /*
     * 我的块乐豆
     */
    public function  myScore(Request $request){
        if($request::ajax()){
                //我的块乐豆记录
                $userPoint = Userpoint::where('usr_id',$this->uid)->orderBy('id','desc')->paginate(10);
                if($userPoint->count()>0){
                    foreach ($userPoint as $key=>$val){
                        $data['data'][$key]['pay'] = $val->pay;
                        $data['data'][$key]['type'] = $val->type;
                        $data['data'][$key]['money'] = $val->money;
                    }
                }else{
                    $data['data'] = [];
                }
                $data['current_page'] = $userPoint->currentPage();
                $data['last_page'] = $userPoint->lastPage();
                return json_encode($data);
        }
        $totalScore = Member::find($this->uid)->kl_bean;
	    $profile = Userpoint::where('usr_id',$this->uid)->where('type',4)->count();
        return view('h5.member.score',['totalScore'=>$totalScore, 'profile' => $profile]);
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
    

    //我的红包
    public function  myBriberyMoney(Request $request){
        if($request::ajax()){
            if($request::input('type')==0){
                //未使用的红包
                $timenow = time();
                $red = Red::where('usr_id',$this->uid)->where('status','=',0)->where('end_time','>',$timenow)->paginate(10);
                if($red->count()>0){
                    foreach ($red as $key=>$val){
                        $data['data'][$key]['money'] = $val->redbao->money;
                        $data['data'][$key]['name'] = $val->redbao->name;
                        $data['data'][$key]['desc'] = $val->redbao->desc;
	                    $data['data'][$key]['starttime'] = date('Y-m-d',$val->start_time);
                        $data['data'][$key]['endtime'] = date('Y-m-d',$val->end_time);
                        $data['data'][$key]['status'] = 1;//红包跳转
                        $data['data'][$key]['enddays'] = $this->redLastTime($timenow,$val->end_time);
                    }
                }else{
                    $data['data'] = [];
                }
            }else if($request::input('type')==1){
                //已使用或已过期的红包
                $timenow =time();
                $red =  Red::where('usr_id',$this->uid)->where('status', [1])->orWhere(function ($query) use($timenow){
                                    $query->where('usr_id',$this->uid)
                                        ->where('end_time', '<', $timenow);
                                    })->paginate(10);
                if($red->count()>0){
                    foreach ($red as $key=>$val){
                        $data['data'][$key]['money'] = $val->redbao->money;
                        $data['data'][$key]['name'] = $val->redbao->name;
                        $data['data'][$key]['desc'] = $val->redbao->desc;
                        $data['data'][$key]['status'] = 0;//红包不跳转
	                    $data['data'][$key]['starttime'] = date('Y-m-d',$val->start_time);
                        $data['data'][$key]['endtime'] = date('Y-m-d',$val->end_time);
                        if($val->status == 1){
                            $data['data'][$key]['enddays'] = '已使用';
                        }else{
                            $data['data'][$key]['enddays'] = '已过期';
                        }
                    }
                }else{
                    $data['data'] = [];
                }
            }
            $data['current_page'] = $red->currentPage();
            $data['last_page'] = $red->lastPage();
            $data['type'] = $request::input('type');//避免用户点击过快或网络慢，出现加载出错
            return json_encode($data);
        }
        $list = Object::where('is_lottery',0)->orderBy('id','desc')->limit(3)->get();
        return view('h5.member.bribery',['list'=>$list]);
    }
    /*
     * 红包技算剩余天数
     */
    public function redLastTime($timenow,$endtime)
    {
        $num = $endtime-$timenow;
        if($num > 86400){
            //大于一天
            $days = $num/86400;
            $str = '还有'.(int)$days.'天过期';
        }else{
            if($num>3600){
               //大于一个小时
               $days = $num/3600;
               $str = '还有'.(int)$days.'小时过期';
            }else{
               if($num>60){
                  //大于一分钟 
                   $days=$num/60;
                   $str = '还有'.(int)$days.'分钟过期';
               }else{
                   $str = '即将过期';
               }
            }
        }
        return $str;
    }

    //邀请好友
    public function  myInvite(Request $request){
        $url='unify_interface/user/getUsrLowerlist.do';
        $result=$this->javaUrl($url,['usr_id'=>$this->uid]);
        $resultText=json_decode($result,TRUE);
        if ($resultText['code'] == 0){
            $list = json_decode($resultText['resultText'],TRUE);
            $friendtotal =count($list);
        }else{
            $friendtotal = 0;
        }
        
        return view('h5.member.invite',['friendtotal'=>$friendtotal]);
    }
    
    public function myInvite_ajax(){
        $url='unify_interface/user/getUsrLowerlist.do';
        $result=$this->javaUrl($url,['usr_id'=>$this->uid]);
        $resultText=json_decode($result,TRUE);
        $total = json_decode($resultText['resultText'],TRUE);
        if (count($total) > 0){
            $list = json_decode($resultText['resultText'],TRUE);
            foreach($list as $key=>$val){
                $data['data'][$key]['username'] = preg_replace("/(1\d{2})(\d{4})(\d{4})/", "\$1****\$3", $val['user_name']);
                $data['data'][$key]['phone'] = preg_replace("/(1\d{2})(\d{4})(\d{4})/", "\$1****\$3", $val['user_phone']);//$val['user_phone'];
                $data['data'][$key]['time'] = explode(' ',$val['reg_time'])[0];
            }
        }else{
            //无数据
            $data['data'] = [];
        }
        return json_encode($data);
    }
    
    //积分邀请结果
    public function  myInviteScore(){
		return view('h5.invite');
         $invitescore = Userpoint::where('usr_id',$this->uid)->where('type','=',3)->sum('money');
        $invitenum = Userpoint::where('usr_id',$this->uid)->where('type','=',3)->count();
        $url='unify_interface/user/getUsrLowerlist.do';
        $result=$this->javaUrl($url,['usr_id'=>$this->uid]);
        $resultText=json_decode($result,TRUE);
      //  dd($resultText);
        if ($resultText['code'] == 0){
            $list = json_decode($resultText['resultText'],TRUE);
        }else{
            $list = null;
        }
        return view('h5.invite',['list'=>$list,'invitescore'=>$invitescore,'invitenum'=>$invitenum]);
    }
    //我的佣金
    public function  myCommission(Request $request){
        if($request::ajax()){
            if($request::input('type')==0){
                //佣金明细
                $mycommsion = Commission::where('usr_id',$this->uid)->where('is_pay','=',0)->orderBy('id','desc')->paginate(10);
                if($mycommsion->count()>0){
                    foreach($mycommsion as $key=>$val){
                        $data['data'][$key]['commission'] = $val->commission;
                        $data['data'][$key]['time'] = date('Y.m.d H:i:s',$val->time);
                        switch ($val->source_type) {
                            case 0:  $data['data'][$key]['source'] = '推广收益';break;
                            case 1:  $data['data'][$key]['source'] = '好友夺宝';break;
                            case 2:  $data['data'][$key]['source'] = '好友充值';break;
                            default:
                                break;
                        }
                        $data['data'][$key]['friend'] = $val->member->nickname;
                    }
                }else{
                    //无数据
                    $data['data'] = [];
                }
            }else if($request::input('type')==1){
                //提现记录
                $mycommsion = WithdrawCash::where('uid',$this->uid)->paginate(10);
                if($mycommsion->count()>0){                    
                    foreach($mycommsion as $key=>$val){
                        $data['data'][$key]['money'] = $val->money;
                        $data['data'][$key]['timeday'] = date('Y-m-d',$val->time);
                        $data['data'][$key]['timeh'] = date('H:i:s',$val->time);
                        $data['data'][$key]['bank'] = preg_replace('/(\d{3})(\d+)(\d{4})/', '$1***$3', $val->banknum);
                        switch ($val->cashtype) {
                            case 0:  $data['data'][$key]['cashtype'] = '审核中';break;
                            case 1:  $data['data'][$key]['cashtype'] = '已通过';break;
                            case 2:  $data['data'][$key]['cashtype'] = '不通过';break;
                            default:
                                break;
                        }
                    }
                }else{
                    //无数据
                    $data['data'] = [];
                } 
            }
            $data['current_page'] = $mycommsion->currentPage();
            $data['last_page'] = $mycommsion->lastPage();
            $data['type'] = $request::input('type');//避免用户点击过快或网络慢，出现加载出错
            return json_encode($data);
        }
        //总佣金
        $commission = Member::find($this->uid)->commission;
        $today = strtotime(Carbon::today());
        $yesterday = strtotime(Carbon::yesterday());
        //昨日佣金
        $yesCommission = Commission::where('usr_id',$this->uid)->whereBetween('time',[$yesterday,$today])->where('is_pay','=',0)->sum('commission');
        return view('h5.member.my_commission',['commission'=>$commission,'yesCommission'=>$yesCommission]);
    }

	
	 //账户明细
    public function account(Request $request)
    {
        if($request::ajax()){
            $recordMoney = AddMoneyRecord::where(['usr_id'=>$this->uid,'status'=>1])->orderBy('id','desc')->paginate(10);
            if($recordMoney->count()>0){
                foreach ($recordMoney as $key=>$val){
                    switch ($val->type) {
                        case 'buy': $data['data'][$key]['type'] = '众筹'; break;
                        case 'charge': $data['data'][$key]['type'] = '充值'; break;
                        default:
                            break;
                    }
                    $data['data'][$key]['money'] = $val->user->money;
                    $data['data'][$key]['time'] = date('Y-m-d H:i:s',$val->time);
                    $data['data'][$key]['amount'] = $val->amount;
                }
                $data['current_page'] = $recordMoney->currentPage();
                $data['last_page'] = $recordMoney->lastPage();
            }else{
                $data['data'] = [];
            }
            return json_encode($data);
        }
        return view('h5.member.account');
    }
	
  
    /*
     * 佣金来源
     * $inviteNums：邀请好友人数  $makeInviteCommi：邀请推广收益 $makeCommi：累计赚取佣金  $snatchCommi 好友夺宝赚取佣金
     * is_pay  收入还是取现 0：收入，1：取现 
     * source_type 赚取和消费状态 0:推广收益 1:好友夺宝赚取佣金 2:好友充值赚取佣金 3:提现佣金 4:转余额佣金 5:冻结佣金
     */
    public function  myCommissionsource(){
        $inviteNums =  Userpoint::where('usr_id',$this->uid)->where('type','=',3)->count();
        $makeInviteCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',0)->sum('commission');
        $makeCommi = Member::where('usr_id',$this->uid)->first()->commission;
        $snatchCommi =  Commission::where('usr_id',$this->uid)->where('source_type','=',1)->sum('commission');
        $list =  Commission::where('usr_id',$this->uid)->where('is_pay','=',0)->paginate(10);
        return view('h5.user_account_commission_source',['list'=>$list,'inviteNums'=>$inviteNums,'makeInviteCommi'=>$makeInviteCommi,'makeCommi'=>$makeCommi,'snatchCommi'=>$snatchCommi]);
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
        $list = Commission::where('usr_id',$this->uid)->where('is_pay','=',1)->paginate(10);
        return view('h5.user_account_commission_buy',['list'=>$list,'useCommiTotal'=>$useCommiTotal,'cashCommi'=>$cashCommi,'balanceCommi'=>$balanceCommi,'frozenCommi'=>$frozenCommi,]);
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
        return view('h5.user_account_commission_mybankcard',['list'=>$banks,'banknum'=>$banknum]);
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
        return view('h5.user_account_commission_addbankcard',['banktotal'=>$banktotal]);
    }
    
    //修改银行卡
    public function editBank($id){
        $bank = Bank::where('id',$id)->where('uid',$this->uid)->first();
        $banktotal = Bank::where('uid',$this->uid)->count();
        $bankinfo = $this->searchBank($bank->bankname);
        return view('h5.user_editbank',['banktotal'=>$banktotal,'bankinfo'=>$bankinfo,'bank'=>$bank]);
    }
    /*
     * 保存银行卡
     */
    public function saveBank(Request $request)
    {
        if($request::isMethod('post')){
            //错误验证
            $validator = Validator::make($request::all(), [
                'username' => 'required|max:4',
                'bankname' => 'required',
                'banknum' => 'required|digits:19',
                'subbranch' => 'required|max:30',
            ],['username.max'=>'用户名不能超过4个汉字','subbranch.max'=>'支行输入不能超过30个汉字']);
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
	
	//设置密码
    public function setpwd(Request $request){
    	 if($request::isMethod('post')){
            $array = [
                    'title'=>       '填写密码',
                    'pwdTips'=>     '请输入6-16位登录密码',
                    'cpwdTips'=>    '请再次输入6-16位登录密码',
                    'nextBottom'=>  '下一步',
                    'pwd'       =>  'setpwd',
                    'mobile'=>$request::input('mobile'),
                    'smsCode'=>$request::input('smsCode'),
                    'registerCode'=>$request::input('registerCode')
            ];
            return view('h5.setpwd',$array);
        }else{
            return redirect('reg_m');
        }
    } 

    //重置密码
    public function resetpwd(Request $request){
         if($request::isMethod('post')){
            $array = [
                    'title'=>       '重置密码',
                    'pwdTips'=>     '请输入6-16位登录密码',
                    'cpwdTips'=>    '请再次输入6-16位登录密码',
                    'nextBottom'=>  '确认',
                    'pwd'       =>  'resetpwd',
                    'mobile'=>$request::input('mobile'),
                    'smsCode'=>$request::input('smsCode')
            ];
            return view('h5.setpwd',$array);
        }else{
            return redirect('forgetpwd_m');
        }
    } 

    //修改密码
    public function editpwd(){
        $array = [
                'title'=>       '修改密码',
                'pwdTips'=>     '请输入旧密码',
                'cpwdTips'=>    '请输入6-16位登录密码',
                'nextBottom'=>  '确认',
                'pwd'       =>  'editpwd',
        ];
        return view('h5.setpwd',$array);
    }
	
    //验证手机验证码
    private function checkMobileCode(){
        //短信验证码
        $code = $this->getParam('smsCode');
        if(empty($code) || $code != session('verifyCode')){
            return response()->json(array('status' => -3, 'msg' => '短信验证码错误'));
        }
    }
	//地址列表
    public function addresslist(Request $request){
        if($request::ajax()){
            $address = Address::where('usr_id',$this->uid)->where('is_delete',0)->orderBy('id','desc')->paginate(10);
            if($address->count()>0){
                foreach($address as $key=>$val){
                    $data['data'][$key]['name'] = $val->receiver;
                    $data['data'][$key]['id'] = $val->id;
                    $data['data'][$key]['phone'] = $val->mobile;
					$data['data'][$key]['notice'] = $val->notice;
                    if($val->is_default == 1){
                       $data['data'][$key]['default'] = 'checked';
                    }else{
                       $data['data'][$key]['default'] = '';
                    }
                    $data['data'][$key]['addr'] = $val->province.$val->city.$val->country.$val->area.' 备注：'.$val->notice;
                }
                $data['current_page'] = $address->currentPage();
                $data['last_page'] = $address->lastPage();
            } else {
              $data['data'] = [];  
            }
            return json_encode($data);
        }        
        return view('h5.member.addresslist');
    }
    
    //确认收货地址 显示页
    public function addressOrderConfirm($id)
    {
        return view('h5.member.address_order_confirm',['o_id'=>$id]);
    }
    /*
     * 保存订单收货地址
     */
    public function orderAddress(Request $request)
    {        
//        $result = Order::where(['usr_id'=>$this->uid,'id'=>$request::input('o_id')])
//                ->update(['addressid'=>$request::input('id'),'status'=>3]);
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
                    $data['type'] = 0;//地址跳去/user_m/inviteprize
                }else{
                   $data['type'] = 1;//地址跳去/user_m/prize
                }
                $data['status'] = 1;
                $data['msg'] = '设置成功';
            }else{
                $data['status'] = 0;
                $data['msg'] = '请勿重复提交';
            }
            return json_encode($data);
        } else {
            $data['status'] = 0;
            $data['msg'] = '订单不存在';
            return json_encode($data);
        }
    }
    //添加地址
    public function addAddress()
    {
        return view('h5.member.address');
    }
    //编辑地址
    public function editAddress($id=0)
    {
        $address = Address::where(['id'=>$id,'usr_id'=>$this->uid])->first();
        $data['name'] = $address->receiver;
        $data['phone'] = $address->mobile;
        $data['area'] = $address->area;
		$data['notice'] = $address->nobice;
        $data['id'] = $id;
        $data['address'] = $address->province.' '.$address->city.' '.$address->country;
        return view('h5.member.address_edit',$data);
    }
    
    //保存地址
    public function saveAddress()
    {
        //错误验证
        $form_data = Input::all();
        $validator = Validator::make($form_data, [
            'name' => 'required|max:20',
            'phone' => 'required|size:11',
            'address' => 'required|max:40',
            'addrDetail' => 'required|max:70',
        ]);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }
        $addr = explode(' ', $form_data['address']);
        if($form_data['action'] == 'save'){
            //新增用户地址
            $address = new Address();
            $address->usr_id = $this->uid;
            $address->province = $addr[0];
            $address->city = $addr[1];
            $address->country = $addr[2];
            $address->area = $form_data['addrDetail'];
            $address->receiver = $form_data['name'];
            $address->mobile = $form_data['phone'];
			$address->notice = $form_data['notice'];
            $address->time = time();
            $result = Address::where('usr_id',$this->uid)->count();
            if($result==0){
                $address->is_default = 1;
            }
            if($address->save()){
                $data['status'] = 1;
                $data['msg'] = '添加成功';
                return json_encode($data);
            }else{
                $data['status'] = 0;
                $data['msg'] = '添加失败';
                return json_encode($data);
            }     
        }else if($form_data['action'] == 'update'){
            $result = Address::where(['id'=>$form_data['id'],'usr_id'=>$this->uid])
                       ->update(['province'=>$addr[0],'city'=>$addr[1],'country'=>$addr[2],'area'=>$form_data['addrDetail'],'notice'=>$form_data['notice'],'receiver'=>$form_data['name'],'mobile'=>$form_data['phone']]);
            if($result){
                $data['status'] = 1;
                $data['msg'] = '修改成功';
                return json_encode($data);
            }else{
                $data['status'] = 0;
                $data['msg'] = '修改失败';
                return json_encode($data);
            }
        }

   
    }
	
	//删除收货地址
	public function deleteAddress(Request $request)
	{
        $res = Address::where(['id'=>$request::input('id'),'usr_id'=>$this->uid])->update(['is_delete' => 1,'is_default'=>0]);
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
		return json_encode($data);
	}
	//设置为默认地址
	public function setDefault(Request $request)
	{        
        if(Address::where(['id'=>$request::input('id'),'usr_id'=>$this->uid])->count()>0){
          //用户地址存在 就把之前的默认地址取消
            Address::where(['usr_id'=>$this->uid,'is_default'=>1])->update(['is_default' => 0]);
             //设置新的默认地址
            $res = Address::where(['id'=>$request::input('id'),'usr_id'=>$this->uid])->update(['is_default' => 1]);
            if($res)
            {
                $data['status'] = 1;
                $data['msg'] = '设置成功';
                return json_encode($data);
            }
        }
        $data['status'] = -1;
        $data['msg'] = '操作失败';
		return json_encode($data);
	}
    
    /*
     *提现到银行卡
     */
    public function commiTobank(Request $request)
    {
        $commission = Member::find($this->uid)->commission;
        return view('h5.member.withdraw',['commission'=>$commission]);
    }
    
    
    /*
     *ajax提现到银行卡
     */
    public function ajaxCommiTobank(Request $request)
    {
        //错误验证
        $validator = Validator::make($request::all(), [
            'username' => 'required|max:10',
            'bankname' => 'required',
            'banknum' => 'required|digits_between:16,19',
            'subbranch' => 'required|max:30',
            'money' => 'required',
        ]);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }
        $money = $request::input('money');
        $user = Member::find($this->uid);
        if ($money < 100){
            $data['status'] = 0;
            $data['msg'] = '转出佣金不能低于100<BR>请正确输入！';
            return json_encode($data);
        }
        if($user->commission < $money){
            $data['status'] = 0;    
            $data['msg'] = '转出佣金不能超出账户现有佣金，请正确输入！';
            return json_encode($data);
        } else {
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
                $withdrawCash =new WithdrawCash();
                $withdrawCash->uid = $this->uid;
                $withdrawCash->username = $request::input('username');
                $withdrawCash->bankname = $request::input('bankname');
                $withdrawCash->banknum = $request::input('banknum');
                $withdrawCash->subbranch = $request::input('subbranch');
                $withdrawCash->money = $money;
                $withdrawCash->cashtype = 0;
                $withdrawCash->time = time();
                if ($withdrawCash->save()){
                    $data['status'] = 1;
                    $data['msg'] = '提现申请成功，会尽快帮你处理';
                    return json_encode($data);
                } else {
                    $data['status'] = 0;
                    $data['msg'] = '申请失败，请稍后重新操作';
                    return json_encode($data);
                }
            }
        }
    }


    /*
     *佣金提现到余额
     */
    public function commiToMoney()
    {
        $commission = Member::find($this->uid)->commission;
        return view('h5.member.commission_tomoney',['commission'=>$commission]);
    }
    //ajax佣金提现到余额
    public function ajaxCommiToMoney(Request $request)
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
                    $data['msg'] = $user->money;
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
        return view('h5.member.user_security',$data);
    }

    //安全中心修改密码
    public function updatePwd()
    {
        return view('h5.member.updatepwd');
    }


    //绑定手机
    public function  bindtel(){
        $user = $this->getUserByjava();//java获取用户信息       
        return view('h5.member.update_tel',['mobile'=>$user['user_phone']]);
    }
    /*
     * 手机号更新进入第二步，输入新的手机号
     */
     public function updateTel(Request $request){
        $code = $request::session()->get('phoneCode');
        $phone = $request::session()->get('userPhone');
        if($code == null){
            $data['status'] = 0;
            $data['msg'] = '请先获取验证码';
            return json_encode($data);
        }
        $user = $this->getUserByjava();//java获取用户信息
		$form_data = Input::all();
        //错误验证
        $validator = Validator::make($form_data, [
            'code' => 'required|size:6',
        ]);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }
        if($phone != $user['user_phone']){
            $data['status'] = 0;
            $data['msg'] = '手机号错误';
            return json_encode($data);
        }
        if($code != $form_data['code']){
            $data['status'] = 0;
            $data['msg'] = '验证码输入错误';
            return json_encode($data);
        }else{
            //验证码正确
            if($form_data['type'] == 'phone'){
                $request::session()->put('verifyPhonePass', 1);
            }else{
                $request::session()->put('verifyMailPass', 1);
            }
            //消除时间
            if($request::session()->has('phoneCodeTime')){
                 $request::session()->pull('phoneCodeTime');
            }
            $data['status'] = 1;
            $data['msg'] = '验证码输入正确';
            return json_encode($data);
        }
     }
     
     //手机号更细第二步，设置新手机号
     public function setTel(Request $request)
     {  
        if($request::session()->has('verifyPhonePass')&&$request::session()->get('verifyPhonePass')===1){
            $request::session()->pull('verifyPhonePass');
            return view('h5.member.set_tel');
        }else{
            return redirect('user_m/bindtel');
        }       
     }
     
    //保存新的手机号
     public function updateNewTel(Request $request){
        $code = $request::session()->get('phoneCode');
        $phone = $request::session()->get('userPhone');
        $user = Member::find($this->uid);
		$form_data = Input::all();
        //错误验证
        $validator = Validator::make($form_data, [
            'code' => 'required|size:6',
            'phone' => 'required|size:11|unique:tab_member,mobile'
        ]);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }
        if($code != $form_data['code']){
            $data['status'] = 0;
            $data['msg'] = '验证码输入错误';
            return json_encode($data);
        }else{
            //验证码正确
            $data['user_phone']=$form_data['phone'];
            $data['usr_id']=$this->uid;
            $url='unify_interface/user/setUsrphone.do';
            $res=  json_decode($this->javaUrl($url,$data),true);
            if($res['code'] == 0){
                $user->mobile = $form_data['phone'];
                $user->update();
                $data['status'] = 1;
                $data['msg'] = '验证码输入正确';
            }else{
                $data['status'] = 0;
                $data['msg'] = $res['resultText'];
            }
            return json_encode($data);
        }
     }

     //绑定邮箱
    public function  bindmail(){
 //       $mobile = Member::find($this->uid)->mobile;
        $user = $this->getUserByjava();//java获取用户信息 
        return view('h5.member.bindmail',['mobile'=>$user['user_phone']]);
    }
    
    //设置邮箱第一步
    public function setMail(Request $request){
        if($request::session()->has('verifyMailPass')&&$request::session()->get('verifyMailPass')===1){
            //$request::session()->pull('verifyMailPass');
            return view('h5.member.setmail');
        }else{
            return redirect('user_m/bindmail');
        }  
    }
    //保存新的邮箱
    public function updateNewEmail(Request $request)
    {
        $code = $request::session()->get('emailCode');
		$form_data = Input::all();
        //错误验证
        $validator = Validator::make($form_data, [
            'code' => 'required|size:6',
            'email' => 'required|email|max:30'
        ]);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }
        if($code != $form_data['code']){
            $data['status'] = 0;
            $data['msg'] = '验证码输入错误';
            return json_encode($data);
        }else{
            //验证码正确            
            $data['user_email']=$form_data['email'];
            $data['usr_id']=$this->uid;
            $url='unify_interface/user/setUsremail.do';
            $resutl=json_decode($this->javaUrl($url,$data));
            //第一次绑送块乐豆
            if($resutl->code==0)
            {
                $model=new Userpoint();
                $where['type']=5;
                $where['usr_id']=$this->uid;
                $res=$model->where($where)->first();
                if(!$res)
                {
                    $arr['content']='绑定邮箱送块乐豆';
                    $arr['pay']='绑定邮箱';
                    $arr['usr_id']=$this->uid;
                    $arr['type']=5;
                    $arr['money']=5;
                    $arr['time']=time();
                    $id=$model->insertGetId($arr);
                    $Member=new Member();
                    $res=$Member->find($this->uid);
                    $res->kl_bean=$res->kl_bean+5;
                    $result=$res->save();
                }
                $data['status'] = 1;
                $data['msg'] = '设置成功';
            }else{
                $data['status'] = 0;
                $data['msg'] = $resutl->resultText;
            }
            return json_encode($data);
        }
    }
	
	//通过java接口获取用户信息
	public function getUserByjava()
	{
		
		$url='unify_interface/user/getUsrinf.do';
		$data['usr_id']=$this->uid;
		$res=$this->javaUrl($url,$data);
		$res=json_decode($res,TRUE);
		$res['resultText']=json_decode($res['resultText'], true);
       	return $res['resultText'];
	}
	
	//更改密码调java接口
	public function updatePassWord()
	{
		$form_data = Input::all();
        //错误验证
        $validator = Validator::make($form_data, [
            'oldpass' => 'required|min:6|max:16',
            'newpass' => 'required|min:6|max:16',
            'repasswd' => 'required|min:6|max:16|same:newpass',
        ]);
        if ($validator->fails()) {
            $data['status'] = -1;
            $data['msg'] = $validator->errors()->first();
            return json_encode($data);
        }
        //java接口获取用户信息
        $user = $this->getUserByjava();
		$data['user_pass_new']=md5($form_data['newpass']);
		$data['user_name']=$user['user_name'];
		$data['user_pass']=md5($form_data['oldpass']);
		$data['is_checkoldpass']=1;
		$data['usr_id']=session('user.id');
        $url='unify_interface/user/setUsrpwd.do';
		
		$res=$this->javaUrl($url,$data);
        $res= json_decode($res, true);
        if($res['code']==0){
            //密码修改成功
            $data['status'] = 0;
            $data['msg'] = '修改成功';
            return json_encode($data);
        }else{
            $data['status'] = -1;
            $data['msg'] = $res['resultText'];
            return json_encode($data);
        }
	}
	/*
     * 发送短信或邮箱验证码
     */
    public function sendCode(Request $request)
    {
        $type = Input::get('type');        
        if($type == 'phone'){
            //校验手机号
            $phone = Input::get('phone');
            $validator = Validator::make(Input::all(), [
                'phone' => 'required|size:11',
            ]);
            if ($validator->fails()) {
                $data['status'] = 0;
                $data['msg'] = $validator->errors()->first();
                return json_encode($data);
            }
            //手机发送验证码
            $code=rand('100000','999999');
            $timeNow = time();
            if($request::session()->has('phoneCodeTime')){
                $time = $request::session()->get('phoneCodeTime');
                if($timeNow<$time){
                    $data['status'] =0;
                    $data['msg'] ='间隔太短，请稍后获取';
                    return json_encode($data);
                }
            }
            $result = $this->sendverifysms($phone, $code);
            if($result['code'] == 0){
                $timeNow+=120;//时间间隔120秒
                $request::session()->put('phoneCodeTime', $timeNow);
                $request::session()->put('phoneCode', $code);
                $request::session()->put('userPhone', $phone);
                $data['status'] =1;
                $data['msg'] ='发送成功';
                return json_encode($data);              
            }else {
                $data['status'] =0;
                $data['msg'] ='发送失败';
                return json_encode($data); 
            }
        }else if( $type == 'email'){
            //校验邮箱
            $email = Input::get('email');
            $validator = Validator::make(Input::all(), [
                'email' => 'required|email|max:30',
            ]);
            if ($validator->fails()) {
                $data['status'] = 0;
                $data['msg'] = $validator->errors()->first();
                return json_encode($data);
            }
            //手机发送验证码
            $code=rand('100000','999999');
            $timeNow = time();
            if($request::session()->has('emailCodeTime')){
                $time = $request::session()->get('emailCodeTime');
                if($timeNow<$time){
                    $data['status'] =0;
                    $data['msg'] ='间隔太短，请稍后获取';
                    return json_encode($data);
                }
            }
            $data['code'] = $code;
            $data['email'] = $email;
            $result = $this->sendEmail($data);
            if($result == 0){
                $timeNow+=120;//时间间隔120秒
                $request::session()->put('emailCodeTime', $timeNow);
                $request::session()->put('emailCode', $code);
                $request::session()->put('userEmail', $email);
                $data['status'] =1;
                $data['msg'] ='发送成功';
                return json_encode($data);              
            }else {
                $data['status'] =0;
                $data['msg'] ='发送失败';
                return json_encode($data); 
            }
        }
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
	    $list = AddMoneyRecord::where('usr_id',$this->uid)->where('status', 0)->where('source', 'wap')->get()->toArray();
	    foreach ($list as $key => &$record){
	        $record['total_amount'] = 0;  //消费总额
	        $record['pay_money'] = 0;  //使用余额
	        $record['red_amount'] = 0;   //红包金额
	        
	        //处理非充值记录
	        if($record['type'] == 'buy'){
	           $scookies = json_decode($record['scookies'], true);
	         //  dd($scookies);
    	       foreach ($scookies['cart_list'] as $cart){
    	           $g_id = $cart['g_id'];
    	           $good = Goods::leftjoin('tab_object', 'tab_object.g_id', '=', 'ykg_goods.id')->where('ykg_goods.id', $g_id)->where('ykg_goods.isdeleted', 0)->where('tab_object.is_lottery', '0')->first();
    	           if(empty($good)){
    	               unset($list[$key]);   //商品已下架，不显示
    	           }else{
    	               $record['good'][$g_id]['title'] = $good->title;
    	               $record['good'][$g_id]['bid_cnt'] = $cart['bid_cnt'];
    	           }
    	           $record['total_amount'] += $cart['bid_cnt'] * $good->minimum * 100;
    	       }
	        }
	        
	        //红包信息
	        if($scookies['red_id'] > 0){
	            $red_info = Red::leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')->where('tab_member_red.id', $scookies['red_id'])->first(['tab_member_red.*', 'tab_redbao.money']);
	            $record['red_amount'] = $red_info->money * 100;
	        }
	        
	        if($record['total_amount'] > $record['red_amount'] + $record['money'] * 100){
	             $record['pay_money'] = number_format(round(($record['total_amount'] - $record['red_amount'] - $record['money'] * 100)/100, 2), 2);
	        }
	        
	        $record['total_amount'] = number_format(round($record['total_amount']/100, 2), 2);
	        $record['red_amount'] = number_format(round($record['red_amount']/100, 2), 2);
	        
	        $type = $record['pay_type'];
	        $record['pay_type'] = $pay_type[$type]['name'];
	        $record['pay_url'] = $pay_type[$type]['url'];
	    }
	    
	    return view('h5.user_account_unpay_records', array('list' => $list));
	}

     //获取公益基金
     public function getFund()
     {
		$money = AddMoneyRecord::where('type', 'buy')->where('status', 1)->sum('amount');
		$result['money']=floor($money);
		echo json_encode($result);
     }
     
     //我的等级
     public function mylevel(){
         $level_config = array(2000 => '土豪', 9999 => '铁豪', 29999 => '铜豪', 59999 => '银豪', 99999 => '金豪', 100000 => '砖豪');
         $total = DB::table('tab_member_addmoney_record')->where('usr_id', session('user.id'))->where('type', 'buy')->where('amount', '>', 0)->where('bid', '<>', '')->sum('amount');
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
         
         //获取用户信息
         $member = Member::where('usr_id', session('user.id'))->first();
         
         return view('h5.member.mylevel', array('total'=>$total, 'level'=>$level, 'member'=>$member));
     }

	//块乐豆充值
	public function klBeanCharge(){
		//查询用户是否满足充值条件
		$flag = 0;
		$message = '';

		$info = DB::select("select card_num from tab_klbean_charge where usr_id = ".session('user.id')." limit 1");
		if(empty($info)){
			if(session('user.reg_time') + 86400 < time()){   //注册时间大于24小时，不可符合新用户定义，不可使用
				$flag = 2;
				$message = '亲~该充值卡仅限24小时内注册用户使用。';
			}
		}else{
			$flag = 1;   //已使用过充值卡，不可重复使用
			$message = '亲~同一账号不可重复使用充值卡。';
		}

		return view('h5.klcharge', array('flag' => $flag, 'message' => $message));
	}

	//块乐豆充值post提交
	public function klBeanChargeSubmit(){
		$card_num = str_replace(' ', '', lcfirst($this->getParam('card_num', '')));
		$card_pass = strtolower($this->getParam('card_pass', ''));
		$captcha = strtolower($this->getParam('captcha'));

		if(empty($card_num) || empty($card_pass)){
			return response()->json(array('status' => -1, 'message' => '卡号和密码不能为空'));
		}

		if(session('milkcaptcha') != $captcha){
			return response()->json(array('status' => -2, 'message' => '验证码错误'));
		}

		$info = DB::table('tab_klbean_charge')->where('card_num', $card_num)->first();
		//账号不存在
		if(empty($info)){
			return response()->json(array('status' => -3, 'message' => '该卡号无效'));
		}
		//密码输入错误达5次，锁定2小时
		if(session('kl_charge_locked') && session('kl_charge_locked') > time()){
			return response()->json(array('status' => -4, 'message' => '亲~操作频繁请2小时候再操作。'));
		}else{
			session()->forget('kl_charge_locked');
		}
		//卡密错误
		if($info->card_pass != $card_pass){
			$error_times = session('error_times') ? session('error_times') + 1 : 1;
			session(['error_times' => $error_times]);
			if($error_times >= 5){
				session(['kl_charge_locked' => time() + 7200]);
			}

			return response()->json(array('status' => -5, 'message' => '密码错误，请重新输入'));
		}
		//充值卡不可使用
		if($info->status != 0){
			if($info->status == 1){
				return response()->json(array('status' => -6, 'message' => '该卡号已被使用'));
			}else{
				return response()->json(array('status' => -7, 'message' => '该卡号无效，请联系客服400-6626-985'));
			}
		}

		//检测用户是否满足使用条件
		$use_log = DB::table('tab_klbean_charge')->where('usr_id', session('user.id'))->first();
		if(!empty($use_log)){
			return response()->json(array('status' => -9, 'message' => '亲~同一账号不可重复使用充值卡。'));
		}
		if(session('user.reg_time') + 86400 < time()){   //注册时间大于24小时，不可符合新用户定义，不可使用
			return response()->json(array('status' => -10, 'message' => '亲~该充值卡仅限24小时内注册用户使用。'));
		}

		DB::beginTransaction();  //开启事务
		try {
			$up_res = DB::update("update tab_klbean_charge set usr_id = ".session('user.id').", use_time = ".time().", status = 1 where card_num = '".$card_num."' and card_pass = '".$card_pass."' and status = 0");
			if($up_res){
				//更新成功，修改块乐豆余额，插入记录
				$content = '充值卡充值'.$info->money.'块乐豆，充值卡号：'.$card_num.'，密码：'.$card_pass;
				DB::update("update tab_member set kl_bean = kl_bean + ".$info->money." where usr_id = ".session('user.id'));
				DB::insert("insert into tab_member_account (usr_id, type, pay, content, money, time) values (".session('user.id').", 8, '块乐豆充值', '".$content."', ".$info->money.", ".time().")");
				DB::commit();

				//更新用户推荐人（若存在则不更新）
				$base_url  =  config('global.api.base_url');
				$api_url   =  config('global.api.setRecommend');
				$res   = $this->api($base_url,$api_url,array('usr_id' => session('user.id'), 'recommend_id' => $info->recommend_id, 'platform_source' => 3, 'is_override' => 0),'GET');

				return response()->json(array('status' => 0, 'message' => '充值成功'));
			}else{
				//更新失败，status不为0，回滚
				DB::rollback();
				$info = DB::table('tab_klbean_charge')->where('card_num', $card_num)->first();
				if($info->status == 1){
					return response()->json(array('status' => -6, 'message' => '该卡号已被使用'));
				}else{
					return response()->json(array('status' => -7, 'message' => '该卡号无效，请联系客服400-6626-985'));
				}
			}
		}catch (Exception $e){
			DB::rollback();
			return response()->json(array('status' => -8, 'message' => '系统异常请稍候再试，客服400-6626-985'));
		}

	}
    
    /*
     * 系统消息  16.7.7  by byl
     */
    public function sysMessage(){
        if(Request::ajax()){
            $user = $this->getUserByjava(); 
            $reg_time = strtotime($user['reg_time']);
            $time = time();
            $list = Message::where('usr_id',$this->uid)->where('send_time', '<' ,$time)
                ->orWhere('msg_type',0)->whereBetween('send_time',[$reg_time,$time])->orderBy('send_time','desc')->paginate(10);  
            if($list->count()>0){
                foreach ($list as $key=>$val){
                    $data['data'][$key]['id'] = $val->id;
                    $data['data'][$key]['title'] = str_limit($val->title,24);
                    $data['data'][$key]['time'] = date('Y-m-d',$val->send_time);
                    $data['data'][$key]['msg'] = $val->msg;
                    $data['data'][$key]['r_type'] = $val->r_type;
                    if($val->msg_type == 0){
                        //查系统消息这个用户是否已读
                        $msgRead = MessageRead::where(['msg_id'=>$val->id, 'usr_id'=>$this->uid])->first();
                        if($msgRead){
                            $data['data'][$key]['r_type'] = 1;
                        }else{
                            $data['data'][$key]['r_type'] = 0;
                        }
                    }
                }
                $data['current_page'] = $list->currentPage();
                $data['last_page'] = $list->lastPage();
            }else{
                $data['data'] = [];
            }
            return json_encode($data);
        }
        return view('h5.member.system_msg');
    }
    /*
     * 系统消息详情  16.7.7 by byl
     */
    public function messageInfo($id){
        $msg = Message::where('id',$id)->first();
        if($msg){
            if($msg->msg_type == 0){
               $msgRead = MessageRead::where(['msg_id'=>$id, 'usr_id'=>$this->uid])->first();
               if(empty($msgRead)){
                    $newMsgRead = new MessageRead();
                    $newMsgRead->msg_id = $id;
                    $newMsgRead->usr_id = $this->uid;
                    $newMsgRead->save();
                }
                return view('h5.member.system_info',['msg'=>$msg]);
            }else{
                if(($msg->r_type == 0) && ($msg->usr_id == $this->uid)){
                    $msg->r_type = 1;
                    $msg->update();
                }
                if($msg->usr_id == $this->uid){
                    return view('h5.member.system_info',['msg'=>$msg]);
                }
            }
        }
    }
}