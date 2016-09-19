<?php
/**
m1 add by tangzhe 2016-06-14 登录带推荐人ID和平台ID
m2 add by tangzhe 2016-06-17 csp统计用，记录有效登录和注册
m3 add by tangzhe 2016-08-03 增加注册渠道来源区分
m4 add by tangzhe 2016-08-10 增加第三方登录invite_code
*/
namespace App\Http\Controllers\h5\Service;

use Validator;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Userpoint;
use App\Http\Controllers\ForeController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Mspecs\M3Result;
use App\Http\Tools\Captcha\BspCaptcha;
use Cookie;
use DB;

class AuthController extends ForeController
{
    public $reg_add_bean = 50;   //推荐人注册送块乐豆数量
    public $login_time = '';
	
    /**
     * 注册信息提交保存session
     * @param json $request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11|regex:/^1[34578][0-9]{9}$/',
            //'password' => 'required|min:8|max:20'
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            if ($messages->has('mobile')) {
                return response()->json(array('status' => -1, 'msg' => '请输入正确的手机号！'));
            }

            if ($messages->has('password')) {
                return response()->json(array('status' => -2, 'msg' => '密码为6-16位字符，必须要包含字母和数字'));
            }
        }
        
        //短信验证码
        $code = $this->getParam('code');
        if(empty($code) || $code != session('verifyCode')){
			if($_SERVER['HTTP_HOST']!='ykg.tz' && $_SERVER['HTTP_HOST']!='2kg.muyouguanxi.com')
				return response()->json(array('status' => -3, 'msg' => '短信验证码错误'));
        }
        
        //注册手机
        $mobile = $this->getParam('mobile');
        if($mobile != session('verifyCode_mobile')){
            return response()->json(array('status' => -5, 'msg' => '注册手机与接收验证码手机不同！'));
        }

        $base_url  =  config('global.api.base_url');
        //m4
		$regi_check = $this->recommend($this->getParam('registerCode'));
		if($regi_check){
			$recommend_id = $regi_check['recommend_id'];
		}else{
			return response()->json(array('status' => -4, 'msg' => '您填写的推荐人有误'));
		}
 
        session(['h5_reg.mobile' => $this->getParam('mobile')]);
        session(['h5_reg.user_phone' => $this->getParam('mobile')]);
		session(['h5_reg.recommend_id' => $recommend_id]);

		return response()->json(array('status'=>0, 'message' => 'ok'));
    }
    
    /**
     * 密码提交，执行注册
     */
    public function regSubmit_m(Request $request){ 
        $validator = Validator::make($request->all(), [
                'password' => 'required|min:6|max:16',
                'newpassword' => 'required|min:6|max:16',
        ]);
        
        if ($validator->fails()) {
            $messages = $validator->messages();
            if ($messages->has('password')) {
                return response()->json(array('status' => -1, 'msg' => '密码为6-16位字符，必须要包含字母和数字'));
            }
        }
        
        if($this->getParam('password') != $this->getParam('newpassword')){
            return response()->json(array('status' => -2, 'msg' => '两次输入密码不一致'));
        }
        
        $return = array();
        if(session('h5_reg.mobile') && session('h5_reg.user_phone')){
            $data = array();
            $data['user_name']  = session('h5_reg.mobile');
            $data['user_pass']  = md5($this->getParam('password'));
            $data['user_phone'] = session('h5_reg.user_phone');
            if(session('h5_reg.recommend_id')){
                $data['recommend_id'] = session('h5_reg.recommend_id');
                //推荐人存在，判断来源是否为天天免费
                $is_freeday = empty(session('is_freeday')) ? 0 : session('is_freeday');
                if($is_freeday == 1){
                    $data['if_add_inite_integral'] = 1;  //积分增加
                }
//                session()->forget('is_freeday');
            }
            $data['platform_source'] = 3;  //平台来源一块购
			$data['equipment_source'] = 1;
            $data['equipment'] = $this->order_source(); //m3
            
            //调用api进行注册
            $base_url  =  config('global.api.base_url');
            $api_url   =  config('global.api.register');
            $result = $this->api($base_url,$api_url,$data,'GET');
            
            if ($result['code'] > 0) {
                $login_time = time();
                //插入数据库
                $member = new Member();
                $member->usr_id = $result['code'];
				$member->recommend_id = isset($data['recommend_id'])?$data['recommend_id']:'';
                $member->nickname = substr_replace($data['user_phone'], '****', 3, 4);
                $member->is_firstbuy = 1;
               // $member->kl_bean = 100;  //注册赠送块乐豆 16.6.14 不送快乐豆 by byl
                $member->mobile = $data['user_phone'];
                $member->user_name = $data['user_phone'];
                $member->reg_ip = $_SERVER['REMOTE_ADDR'];
                $member->user_photo = config('global.default_photo');
                $member->login_time = $login_time;
                $member->reg_time = $login_time;
                !empty(session('openid')) && $member->openid = session('openid');  //微信openid标识
                if($member->save()){
                    //保存块乐豆记录 16.6.14 不送快乐豆 by byl
//                    $log_reg = new Userpoint();
//                    $log_reg->usr_id = $result['code'];
//                    $log_reg->type = 7;
//                    $log_reg->pay = '注册赠送';
//                    $log_reg->content = '用户注册赠送块乐豆';
//                    $log_reg->money = config('global.reg_give_bean');
//                    $log_reg->time = time();
//                    
//                    $log_reg->save();
                    
                    //推荐人增加快乐豆
//                     if(session('h5_reg.recommend_id')){
//                         $recommender = $member->where('usr_id', session('h5_reg.recommend_id'))->first();
//                         $recommender->kl_bean += $this->reg_add_bean;
//                         $recommender->save();
//                         //写块乐豆log
//                         $log = new Userpoint();
//                         $log->usr_id = session('h5_reg.recommend_id');
//                         $log->type = 3;
//                         $log->pay = '邀请好友';
//                         $log->content = '邀请好友送块乐豆，被邀请人id：'.$result['code'];
//                         $log->money = $this->reg_add_bean;
//                         $log->time = time();
            
//                         $log->save();
//                     }
                    //注册成功，保存session登陆
                    session(['user.id' => $result['code']]);
                    session(['user.phone' => $data['user_phone']]);
                    session(['user.user_name' => $data['user_name']]);
                    session(['user.reg_time'  => time()]);
                    session(['user.login_time'=> $login_time]);
                    session(['user.nickname'  => substr_replace($data['user_phone'], '****', 3, 4)]);
                    session(['user.photo'  => config('global.default_photo')]);
                    
					//m2
					if($data['recommend_id']!=''){
						DB::table('ykg_cps')->insert(['time'=>time(),'salesman_usrid'=>$data['recommend_id'],'valid'=>'register','usr_id'=>$result['code']]);
					}
					
                    //注册成功天天免费提示flag
                    session(["reg_flag_freeday" => 1]);
	                session(["is_new" => 1]);

	                //注册登陆成功
	                DB::table('tab_login_log')->insert(['usr_id' => $result['code'], 'is_reg' => 1, 'platform' => 1, 'time' => time()]);   //插入登陆记录
            
                    $return['status'] = 0;
                }
                
                session()->forget('h5_reg');
                session()->forget('invite_code');
            } else {
                $return['msg'] =  $result['resultText'];
            }
        }else{
            $return['status'] =  -1;
            $return['msg'] =  '非法请求';
        }
        
        return response()->json($return);
    }

    public function login(Request $request)
    {

        //获取request参数，调用api进行登陆
        $base_url  =  config('global.api.base_url');
        $api_url   =  config('global.api.login');
        $method    =  'GET';
        $data['user_name']      = $this->getParam('username');
        $data['user_pass'] = md5($this->getParam('password'));
		//m1
		$recommend_id = Cookie::get('recommend_id');
		if($recommend_id!=''){
			$data['platform_source'] = 3;		
			$data['recommend_id'] = $recommend_id;
		}
		
        $result = $this->api($base_url,$api_url,$data,$method);
        //如果登陆成功,将用户信息存入session中
        if($result['code'] > 0)
        {  
            $login_time = time();
            $member = new Member();
            $res=$member->where('usr_id',$result['code'])->select('user_photo','nickname','login_time','is_unusual')->first();
            
            if(empty($res)){
                //如果是其他平台的账号，插入记录
                $member->usr_id = $result['code'];
                $member->nickname = substr_replace($data['user_name'], '****', 3, 4);
                $member->is_firstbuy = 1;
               // $member->kl_bean = 100;  //注册赠送100块乐豆 16.6.14 不送快乐豆 by byl
                $member->mobile = $data['user_name'];
                $member->user_name = $data['user_name'];
                $member->reg_ip = $_SERVER['REMOTE_ADDR'];
                $member->user_photo = config('global.default_photo');
                $member->login_time = $login_time;
                //$member->reg_time = $login_time;
                $member->save();
                
                //保存块乐豆记录 16.6.14 不送快乐豆 by byl
//                $log_reg = new Userpoint();
//                $log_reg->usr_id = $result['code'];
//                $log_reg->type = 7;
//                $log_reg->pay = '注册赠送';
//                $log_reg->content = '用户注册赠送块乐豆';
//                $log_reg->money = 100;
//                $log_reg->time = time();
//                 
//                $log_reg->save();
                 
                $res = $member->where('usr_id',$result['code'])->select('user_photo','nickname','login_time','is_unusual')->first();
                $other_paltform_reg = 1;

	            session(["is_new" => 1]);  //新用户注册赠送大转盘免费次数
            }
            
            /*检测账户是否异常START*/
            if($res['is_unusual']>0){
                $return['status'] = -1;
                $return['msg'] = '您的账号异常已锁定登录，请联系客服人员！';
                return response()->json($return);
            }
            /*检测账户是否异常END*/
            	
            session()->forget('invite_code');
            
			$getUsrinf = config('global.api.getUsrinf');
            $user_info = $this->api($base_url,$getUsrinf,array('usr_id'=>$result['code']),$method);
            $user_info = json_decode($user_info['resultText'], true);
            
            session(['user.id'        => $user_info['usr_id']]);
            session(['user.user_name' => $user_info['user_name']]);
            //session(['user.regtype'   => $user_info['user_regtype']]);
            !empty($user_info['user_email']) && session(['user.email'     => $user_info['user_email']]);
            session(['user.phone'     => $user_info['user_phone']]);
            session(['user.reg_time'  => strtotime($user_info['reg_time'])]);
            //session(['user.reg_ip'    => $user_info['reg_ip']]);
            //session(['user.equipment' => $user_info['equipment']]);
			@session(['user.photo'     => $res->user_photo]);
			@session(['user.nickname'  =>  $res->nickname]);
	        @session(['user.platform_source'  =>  $user_info['platform_source']]);

            //更新用户登陆时间
            session(['user.login_time'=>$login_time]);
            $res->login_time=$login_time;
            $res->user_name = $user_info['user_name'];
	        $res->last_login_ip = $_SERVER['REMOTE_ADDR'];
	        $res->reg_time = strtotime($user_info['reg_time']);
	        $res->where('usr_id',$user_info['usr_id'])->update(['login_time'=>$login_time, 'user_name'=>$user_info['user_name'], 'last_login_ip' => $_SERVER['REMOTE_ADDR'], 'reg_time' => strtotime($user_info['reg_time']), 'platform_source' => $user_info['platform_source']]);
            
            //如果是其他平台用户第一次登陆，更新用户手机（防止用户用用户名登录，导致mobile字段为非手机号），更新用户注册平台
            if(isset($other_paltform_reg) && $other_paltform_reg == 1){
	            $res->where('usr_id',$user_info['usr_id'])->update(['mobile'=>$user_info['user_phone']]);
            }

	        //如果绑定了邮箱，更新
	        if(!empty($user_info['user_email'])){
		        $res->where('usr_id',$user_info['usr_id'])->update(['email'=>$user_info['user_email']]);
	        }
			
			//M2 cps用，记录有效登录流水
			if($recommend_id!=''){
				DB::table('ykg_cps')->insert(['time'=>time(),'salesman_usrid'=>$recommend_id,'valid'=>'login','usr_id'=>$user_info['usr_id']]);
			}
            
            //登陆成功
	        DB::table('tab_login_log')->insert(['usr_id' => $user_info['usr_id'], 'is_reg' => 0, 'platform' => 1,  'time' => time()]);   //插入登陆记录

            $return['status'] = 0;
            $return['msg'] = 'success';
            $return['refer'] = session('url_refer');
            session()->forget('url_refer');
		
        }else{
            //登陆失败
            $return['status'] = -1;
			if(empty($result['resultText']))
			{
				$result['resultText']='用户名或密码错误';
			}
            $return['msg'] = $result['resultText'];
        }
        
        return response()->json($return);
    }
    public  function destoryLogin(){
        session()->flush();
        return redirect('index_m');
    }

    /**
     * 检测手机号是否已被注册
     */
    public function checkMobileExist()
    {
        $base_url  =  config('global.api.base_url');
        $api_url   =  config('global.api.getUsrid');//根据手机获取推荐人uid
        $recommend_res   = $this->api($base_url,$api_url,array('user_name'=>$this->getParam('mobile')),'GET');
        if($recommend_res['code'] > 0){
            //用户名已被注册
            $return['status'] = -1;
            $return['msg'] = '该手机号已被注册';
        }else{
            $return['status'] = 0;
            $return['msg'] = '该手机号可以使用';
        }
        
        return response()->json($return);
    }
    
    /**
     * 检测手机号是否已被注册 16.5.28 by byl
     */
    public function checkUserExist($mobile)
    {
        $base_url  =  config('global.api.base_url');
        $api_url   =  config('global.api.getUsrid');//根据手机获取推荐人uid
        $recommend_res   = $this->api($base_url,$api_url,array('user_name'=>$mobile),'GET');
        if($recommend_res['code'] > 0){
            //用户名已被注册
            $userid = $recommend_res['code'];
        }else{
            $userid = $recommend_res['code'];
        }
        
        return $userid;
    }
    
    /**
     * check验证码
     */
    public function checkCaptcha(){
        $captcha = $this->getParam('captcha');
        if(session('milkcaptcha') == $captcha){
            return response()->json(array('status'=>0, 'message'=>'验证成功'));
        }else{
            return response()->json(array('status'=>-1, 'message'=>'验证失败'));
        }
    }
    
    /**
     * 发送注册验证码
     */
    public function sendSmsCode(){
        $mobile = $this->getParam('mobile');
        $code = $this->getNonceStr(6, 2);

//        $captcha = strtolower($this->getParam('captcha'));
//        if(session('milkcaptcha') == $captcha){
        //腾迅 bsp 天御验证码 校验 by baoyaoling
        $captcha = $this->getParam('captcha');
        $bspCaptcha = new BspCaptcha();
        $result = $bspCaptcha->Check($captcha);
        if($result['code'] == 0){
            //短信发送时间间隔
            if(empty(session('sms_send_time_h5'))){
                session(['sms_send_time_h5' => time()]);
            }else{
                if(time() - session('sms_send_time_h5') < 110){   //发送间隔小于120s，预留10s
                    return response()->json(array('status' => -2, 'message' => '短信发送间隔小于2分钟'));
                }else{
                    session(['sms_send_time_h5' => time()]);
                }
            }

            $result = $this->sendverifysms($mobile, $code);

            $data = array();
            if($result['code'] == 0){
                $data['status'] = 0;
                $data['message'] = 'ok';
                //保存session
                session(['verifyCode' => $code]);
                session(['verifyCode_mobile' => $mobile]);
            }else{
                $data['status'] = -1;
                $data['message'] = '短信发送失败';
            }

            return response()->json($data);
        }else{
            return response()->json(array('status'=>-1, 'message'=>'验证已失效，请再次点击完成验证'));
        }
    }
    
    /**
     * 发送注册验证码（忘记密码）
     */
    public function sendSmsCodeForget(){
        $mobile = $this->getParam('mobile');
        $code = $this->getNonceStr(6, 2);
    
        //         $captcha = strtolower($this->getParam('captcha'));
        //         if(session('milkcaptcha') == $captcha){
        //短信发送时间间隔
        if(empty(session('sms_send_time'))){
            session(['sms_send_time' => time()]);
        }else{
            if(time() - session('sms_send_time') < 110){   //发送间隔小于120s，预留10s
                return response()->json(array('status' => -2, 'message' => '短信发送间隔小于2分钟'));
            }else{
                session(['sms_send_time' => time()]);
            }
        }
    
        $result = $this->sendverifysms($mobile, $code);
    
        $data = array();
        if($result['code'] == 0){
            $data['status'] = 0;
            $data['message'] = 'ok';
            //保存session
            session(['verifyCode' => $code]);
            session(['verifyCode_mobile' => $mobile]);
        }else{
            $data['status'] = -1;
            $data['message'] = '短信发送失败';
        }
    
        return response()->json($data);
        //         }else{
        //             return response()->json(array('status'=>-1, 'message'=>'验证码错误'));
        //         }
    }
    
    /**
     * check短信验证码
     */
    public function checkVerifyCode(){
        $verifyCode = $this->getParam('verifyCode');
        if(!empty(session('verifyCode')) && session('verifyCode') == $verifyCode){
            return response()->json(array('status'=>0, 'message'=>'验证码验证成功'));
        }else{
           return response()->json(array('status'=>-1, 'message'=>'验证码输入错误'));
        }
    }
    
    /**
     * 重置用户密码
     */
    public function setPass(){
        $mobile = $this->getParam('mobile');
        $pass = $this->getParam('pass');

        $this->checkVerifyCode();
        
        $base_url  =  config('global.api.base_url');
        
        $api_url   =  config('global.api.getUsrid');//根据手机获取推荐人uid
        $recommend_res   = $this->api($base_url,$api_url,array('user_name'=>$mobile),'GET');
        if($recommend_res['code'] > 0){
            $usr_id = $recommend_res['code'];
        }else{
            return response()->json(array('status'=>-2, 'message'=>'用户手机号不存在'));
        }
        
        $data['usr_id'] = $usr_id;
        $data['user_name'] = $mobile;
        $data['user_pass'] = '123456';    //重置密码，旧密码留空
        $data['user_pass_new'] = md5($pass);
        $data['is_checkoldpass'] = 0;  //不检查旧密码
        
        $api_url   =  config('global.api.setUsrpwd');//重置用户密码
        $setpass_res   = $this->api($base_url,$api_url,$data,'GET');
        if($setpass_res['code'] == 0){
            return response()->json(array('status'=>0, 'message'=>'密码修改成功'));
        }else{
            return response()->json(array('status'=>-1, 'message'=>'密码修改失败'));
        }
    }

    /**ajax 轮询登录状态*/
    public function synchronize(){

        if(session('user.id')>0){
            $mspecs = new M3Result();
            $mspecs->status = 1;
            $mspecs->message = '已登录';
            echo $mspecs->toJson();
            exit();
        }

    }
    
     /**
     * 第三方绑定   短信发送   16.6.28 by byl
     */ 
    public function mobileSendCode(){
        $mobile = $this->getParam('mobile');
        $statueCode = $this->getParam('statueCode');
        $code = $this->getNonceStr(6, 2);
        if(!empty($statueCode) && $statueCode == session('login_state')){
            //短信发送时间间隔
            if(empty(session('other_code_time'))){
                session(['other_code_time' => time()]);
            }else{
                if(time() - session('other_code_time') < 110){   //发送间隔小于120s，预留10s
                    return response()->json(array('status' => -2, 'message' => '短信发送间隔小于2分钟'));
                }else{
                    session(['other_code_time' => time()]);
                }
            }
            $result = $this->sendverifysms($mobile, $code);
            $data = array();
            if($result['code'] == 0){
                $data['status'] = 0;
                $data['message'] = 'ok';
                //保存session
                session(['otherVerifyCode' => $code]);
                session(['otherVerifyCode_mobile' => $mobile]);
            }else{
                $data['status'] = -1;
                $data['message'] = '短信发送失败';
            }
            return response()->json($data);            
        }else{
            return response()->json(array('status'=>-1, 'message'=>'非法操作'));
        }
    }
    
    //微信登陆回调  16.6.14 by  baoyaoling
    public function wxCallBack()
    { 
        $code = $this->getParam('code');
        $state = $this->getParam('state');
        if(session('login_state') == $state && $state != NULL){
            //session()->forget('login_state');
            $url = config('global.weixin_m.access_token').'?appid='.config('pay.APPID').'&secret='.config('pay.APPSECRET').'&code='.$code.'&grant_type=authorization_code';
            $result = json_decode($this->httpGet($url),true);
            if(!empty($result['errcode'])){
               return redirect('/login');
            }
            //获取用户信息
            $getUserinfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $result['access_token'] . '&openid=' . $result['openid'] . '&lang=zh_CN';
            $userInfo = json_decode($this->httpGet($getUserinfoUrl),true);
            $openid =$userInfo['openid'];
            $unionid =$userInfo['unionid'];
            session(['wx_openid' => $openid]);
            session(['wx_unionid' => $unionid]);
            $res = Member::where('wx_unionid', '=', $unionid)->first();
            if($res){
                //存在就直接登陆
                
                $login_time = time();
                $method    =  'GET';
                /*检测账户是否异常START*/
                if($res['is_unusual']>0){
                   echo '您的账号异常已锁定登录，请联系客服人员！'; exit;
                }
                /*检测账户是否异常END*/

                session()->forget('invite_code');
                $base_url  =  config('global.api.base_url');
                $getUsrinf = config('global.api.getUsrinf');
                $user_info = $this->api($base_url,$getUsrinf,array('usr_id'=>$res->usr_id),$method);
                $user_info = json_decode($user_info['resultText'], true);

                session(['user.id'        => $user_info['usr_id']]);
                session(['user.user_name' => $user_info['user_name']]);
                //session(['user.regtype'   => $user_info['user_regtype']]);
                !empty($user_info['user_email']) && session(['user.email'     => $user_info['user_email']]);
                session(['user.phone'     => $user_info['user_phone']]);
                session(['user.reg_time'  => $user_info['reg_time']]);
                //session(['user.reg_ip'    => $user_info['reg_ip']]);
                //session(['user.equipment' => $user_info['equipment']]);
                @session(['user.photo'     => $res->user_photo]);
                @session(['user.nickname'  =>  $res->nickname]);

                //更新用户登陆时间
                session(['user.login_time'=>$login_time]);
                $res->login_time=$login_time;
                $res->user_name = $user_info['user_name'];
                $res->last_login_ip = $_SERVER['REMOTE_ADDR'];
                $res->where('usr_id',$user_info['usr_id'])->update(['login_time'=>$login_time, 'user_name'=>$user_info['user_name'],'last_login_ip' => $_SERVER['REMOTE_ADDR']]);

                //登陆成功
                $refer = session('url_refer');
                session()->forget('url_refer');
                if(empty($refer) or $refer=='null'){
                    $refer = '/freeday_m';
                }
                return redirect($refer);                
            }else{
                //不存在就绑定手机
                if(!empty($userInfo['errcode'])){
                    echo $userInfo['errmsg'];exit;
                }else{
                    $headimgurl = $userInfo['headimgurl'];
                    $nickname = $userInfo['nickname'];
                    return view('h5.union2',['headimgurl'=>$headimgurl,'nickname'=>$nickname,'statueCode'=>session('login_state')]);
                }
            }
        }else{
            return redirect('/login_m');
           // echo("The state does not match. You may be a victim of CSRF.");
        }
    }
    
    //qq登陆回调  16.6.14 by  baoyaoling
    public function qqCallBack()
    {
        $code = $this->getParam('code');
        $state = $this->getParam('state');
        if(session('login_state') == $state && $state != NULL){
           // session()->forget('login_state');
           //拼接URL 
           $app_id = 
           $qq_callback = config('global.qq.qq_callback');
           $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
           . "client_id=" . config('global.qq.AppID') . "&redirect_uri=" . urlencode($qq_callback)
           . "&client_secret=" . config('global.qq.AppKey') . "&code=" . $code;
           $response = file_get_contents($token_url);
           if (strpos($response, "callback") !== false)
           {
              $lpos = strpos($response, "(");
              $rpos = strrpos($response, ")");
              $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
              $msg = json_decode($response);
              if (isset($msg->error))
              {
                 echo "<h3>error:</h3>" . $msg->error;
                 echo "<h3>msg  :</h3>" . $msg->error_description;
                 exit;
              }
           }

           //Step3：使用Access Token来获取用户的OpenID
           $params = array();
           parse_str($response, $params);
           $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $params['access_token'];
           $str  = file_get_contents($graph_url);
           if (strpos($str, "callback") !== false)
           {
              $lpos = strpos($str, "(");
              $rpos = strrpos($str, ")");
              $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
           }
           $user = json_decode($str);
           if (isset($user->error))
           {
              echo "<h3>error:</h3>" . $user->error;
              echo "<h3>msg  :</h3>" . $user->error_description;
              exit;
           }
           $openid = $user->openid;
           $res = Member::where('qq_openid', '=' , $openid)->first();
           if($res){
               //绑定了 就直接登陆
                
                $login_time = time();
                $method    =  'GET';
                /*检测账户是否异常START*/
                if($res['is_unusual']>0){
                   echo '您的账号异常已锁定登录，请联系客服人员！'; exit;
                }
                /*检测账户是否异常END*/

                session()->forget('invite_code');
                $base_url  =  config('global.api.base_url');
                $getUsrinf = config('global.api.getUsrinf');
                $user_info = $this->api($base_url,$getUsrinf,array('usr_id'=>$res->usr_id),$method);
                $user_info = json_decode($user_info['resultText'], true);

                session(['user.id'        => $user_info['usr_id']]);
                session(['user.user_name' => $user_info['user_name']]);
                //session(['user.regtype'   => $user_info['user_regtype']]);
                !empty($user_info['user_email']) && session(['user.email'     => $user_info['user_email']]);
                session(['user.phone'     => $user_info['user_phone']]);
                session(['user.reg_time'  => $user_info['reg_time']]);
                //session(['user.reg_ip'    => $user_info['reg_ip']]);
                //session(['user.equipment' => $user_info['equipment']]);
                @session(['user.photo'     => $res->user_photo]);
                @session(['user.nickname'  =>  $res->nickname]);

                //更新用户登陆时间
                session(['user.login_time'=>$login_time]);
                $res->login_time=$login_time;
                $res->user_name = $user_info['user_name'];
                $res->last_login_ip = $_SERVER['REMOTE_ADDR'];
                $res->where('usr_id',$user_info['usr_id'])->update(['login_time'=>$login_time, 'user_name'=>$user_info['user_name'],'last_login_ip' => $_SERVER['REMOTE_ADDR']]);

                //登陆成功
                $refer = session('url_refer');
                if(empty($refer) or $refer=='null'){
                    $refer = '/freeday_m';
                }
                session()->forget('url_refer');
                return redirect($refer);
           }else{                   
               session(['qq_openid' => $openid]);
               //获取用户信息
               $user_info_url = 'https://graph.qq.com/user/get_user_info?access_token='
               . $params['access_token'] .'&oauth_consumer_key=' . config('global.qq.AppID') . '&openid=' . $openid;
               $userInfo = json_decode($this->httpGet($user_info_url),true);
               if($userInfo['ret'] == 0){
                    $headimgurl = $userInfo['figureurl_2'];
                    $nickname = $userInfo['nickname'];
                    return view('h5.union2',['headimgurl'=>$headimgurl,'nickname'=>$nickname,'statueCode'=>session('login_state')]);
               }else{
                    echo("The state does not match. You may be a victim of CSRF.");
               }

           }
               
        }else{
            return redirect('/login_m');
            //echo("The state does not match. You may be a victim of CSRF.");
        }
    }

   //第三方绑定 有账户 16.6.14 by byl
    public function bindUser(Request $request)
    {
        $mobile = $this->getParam('mobile');
        $code = $this->getParam('code');
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:11|regex:/^1[34578][0-9]{9}$/',
            'code' => 'required|min:6|max:6'
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            if ($messages->has('mobile')) {
                return response()->json(array('status' => -1, 'msg' => '请输入正确的手机号！'));
            }

            if ($messages->has('code')) {
                return response()->json(array('status' => -2, 'msg' => '请输入正确的验证码！'));
            }
        }
        
        //短信验证码
        if(empty($code) || $code != session('otherVerifyCode')){
            return response()->json(array('status' => -3, 'msg' => '短信验证码错误'));
        }
        
        if($mobile != session('otherVerifyCode_mobile')){
            return response()->json(array('status' => -5, 'msg' => '绑定手机与接收验证码手机不同！'));
        }
        //检测号码是被注册
        $userid = $this->checkUserExist($mobile);
        if($userid > 0)
        { 
            //已注册直接绑定
            if(session()->has('qq_openid')){
                //qq绑定
                $data_result = $this->quickLogin($userid, $mobile, session('qq_openid'));
                session()->forget('qq_openid');
            }else{
                //微信绑定
                $data_result = $this->quickLogin($userid, $mobile, session('wx_openid'),session('wx_unionid'));
                session()->forget('wx_openid');
                session()->forget('wx_unionid');
            }
            return response()->json($data_result);
        }else{
            //未注册
            $data_result = $this->bindNoUser($mobile);
            return response()->json($data_result);
        }
    }
    
    /*
     * 微信绑定的时候 快速登陆 16.6.14  by  byl
     */
    public function quickLogin($user_id,$mobile,$openid,$unionid=NULL)
    {
        $login_time = time();
        $member = new Member();
        $res=$member->where('usr_id',$user_id)->select('user_photo','nickname','login_time','is_unusual')->first();
        if(empty($res)){
             //如果是其他平台的账号，插入记录
             $member->usr_id = $user_id;
             $member->nickname = substr_replace($mobile, '****', 3, 4);
             $member->is_firstbuy = 1;
          //   $member->kl_bean = 100;  //注册赠送100块乐豆
             $member->mobile = $mobile;
             $member->user_name = $mobile;
             $member->reg_ip = $_SERVER['REMOTE_ADDR'];
             $member->user_photo = config('global.default_photo');
             $member->login_time = $login_time;
             $member->reg_time = $login_time;
             if($unionid == NULL){
                //qq绑定
                $member->qq_openid = $openid;
             }else{
                 //微信绑定
                $member->wx_pc_openid = $openid;
                $member->wx_unionid = $unionid;
             }
             $member->save();

             $res = $member->where('usr_id',$user_id)->select('user_photo','nickname','login_time','is_unusual')->first();
             $other_paltform_reg = 1;

	         session(["is_new" => 1]);  //新用户注册赠送大转盘免费次数
         }

         /*检测账户是否异常START*/
         if($res['is_unusual']>0){
             $return['status'] = -1;
             $return['msg'] = '您的账号异常已锁定登录，请联系客服人员！';
             return $return;
         }
         /*检测账户是否异常END*/

         session()->forget('invite_code');
        $base_url  =  config('global.api.base_url');
        $method    =  'GET';
         $getUsrinf = config('global.api.getUsrinf');
         $user_info = $this->api($base_url,$getUsrinf,array('usr_id'=>$user_id),$method);
         $user_info = json_decode($user_info['resultText'], true);

         session(['user.id'        => $user_info['usr_id']]);
         session(['user.user_name' => $user_info['user_name']]);
         //session(['user.regtype'   => $user_info['user_regtype']]);
         !empty($user_info['user_email']) && session(['user.email'     => $user_info['user_email']]);
         session(['user.phone'     => $user_info['user_phone']]);
         session(['user.reg_time'  => $user_info['reg_time']]);
         //session(['user.reg_ip'    => $user_info['reg_ip']]);
         //session(['user.equipment' => $user_info['equipment']]);
         @session(['user.photo'     => $res->user_photo]);
         @session(['user.nickname'  =>  $res->nickname]);

         //更新用户登陆时间
         session(['user.login_time'=>$login_time]);
         $res->login_time=$login_time;
         $res->user_name = $user_info['user_name'];
         $res->last_login_ip = $_SERVER['REMOTE_ADDR'];
        if($unionid == NULL){
           //qq绑定
            $res->qq_openid = $openid;
            $res->where('usr_id',$user_info['usr_id'])->update(['login_time'=>$login_time, 'user_name'=>$user_info['user_name'],'qq_openid'=>$openid,'last_login_ip' => $_SERVER['REMOTE_ADDR']]);
        }else{
            //微信绑定
            $res->wx_pc_openid = $openid;
            $res->wx_unionid = $unionid;
            $res->where('usr_id',$user_info['usr_id'])->update(['login_time'=>$login_time, 'user_name'=>$user_info['user_name'],'wx_pc_openid'=>$openid,'wx_unionid'=>$unionid,'last_login_ip' => $_SERVER['REMOTE_ADDR']]);
        }
         //如果是其他平台用户第一次登陆，更新用户手机（防止用户用用户名登录，导致mobile字段为非手机号）
         if(isset($other_paltform_reg) && $other_paltform_reg == 1){
             $res->where('usr_id',$user_info['usr_id'])->update(['mobile'=>$user_info['user_phone']]);
         }

         //登陆成功
         $return['status'] = 0;
         $return['msg'] = 'success';
         $return['refer'] = !empty(session('url_refer')) ? session('url_refer'):'/freeday_m';
         session()->forget('url_refer');
         return $return;
    }
    
    //第三方绑定 无账户  16.6.14 by byl
    public function bindNoUser($mobile)
    {
        
        //腾迅 bsp 恶意手机号验证 16.6.24 by baoyaoling 
//        $bspCaptcha = new BspCaptcha();
//        $regInfo['accountType'] = 4;
//        $regInfo['uid'] = $mobile;
//        $regInfo['phoneNumber'] = $mobile;
//        $regInfo['registerTime'] = time();
//        $regInfo['registerIp'] = $_SERVER['REMOTE_ADDR'];
//        $regInfo['registerSource'] = 1;
//        $regInfo['referer'] = urlencode($_SERVER['HTTP_REFERER']);
//        $regInfo['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
//        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
//            $regInfo['xForwardedFor'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
//        }
//        $bspResult = $bspCaptcha->register($regInfo);
//        if($bspResult['level'] > 3){
//            $return['status'] = -1;
//            $return['msg'] = '您的手机号码存在异常，请您更换手机号码绑定，或联系客服核实！';
//            return $return;
//        }
        //end
	 
		
        $base_url  =  config('global.api.base_url');
        $api_url   =  config('global.api.register');
		//m4
	    if(session('invite_code')){
		    $regi_check = $this->recommend(session('invite_code'));
		    if($regi_check){
			    $data = $regi_check;
		    }else{
			    return array('status' => -4, 'msg' => '您填写的推荐人有误');
		    }
	    }
 
        $data['user_name']  = $mobile;
        $password = 'ts'.rand(1000,9999);
        $data['user_pass']  = md5($password);
        //$data['user_email'] = 'yikuaigou@ccfax.cn';
        $data['user_phone'] = $mobile;

		$data['platform_source'] = 3;  //平台来源一块购
		$data['equipment_source'] = 1;
		$data['equipment'] = $this->order_source();  //来源  m3

        //调用api进行注册
        $result = $this->api($base_url,$api_url,$data,'GET');

        if($this->h5){
            $return['url'] = '/freeday_m';
        }else{
            $return['url'] = '/freeday';
        }

        if ($result['code'] > 0) {
            $login_time = time();
            //插入数据库
            $member = new Member();
            $member->usr_id = $result['code'];
			$member->recommend_id = isset($data['recommend_id'])?$data['recommend_id']:'';
            $member->nickname = substr_replace($data['user_phone'], '****', 3, 4);
            $member->is_firstbuy = 1;
//            $member->kl_bean = 100;  //注册赠送100块乐豆
            $member->mobile = $mobile;
            $member->user_name = $mobile;
            $member->reg_ip = $_SERVER['REMOTE_ADDR'];
            $member->user_photo = config('global.default_photo');
            $member->login_time = $login_time;
            $member->reg_time = $login_time;
            if(session()->has('qq_openid')){
                //qq绑定
                $member->qq_openid = session('qq_openid');
                session()->forget('qq_openid');
            }else{
                //微信绑定
                $member->wx_pc_openid = session('wx_openid');
                $member->wx_unionid = session('wx_unionid');
                session()->forget('wx_openid');
                session()->forget('wx_unionid');
            }
            if($member->save()){
                //注册成功，保存session登陆
                session(['user.id' => $result['code']]);
                session(['user.phone' => $data['user_phone']]);
                session(['user.user_name' => $data['user_name']]);
                session(['user.reg_time'  => time()]);
                session(['user.login_time'=> $login_time]);
                session(['user.nickname'  => substr_replace($data['user_phone'], '****', 3, 4)]);
                session(['user.photo'  => config('global.default_photo')]);

	            session(["is_new" => 1]);  //新用户注册赠送大转盘免费次数

                //密码发送短信
                $this->sendtplsms($mobile,'25887', $password);
                $return['status'] = 0;
                $return['msg'] = '注册成功';
	            $return['refer'] = !empty(session('url_refer')) ? session('url_refer'):'/index_m';
            }
        } else {
            $return['status'] = -1;
            $return['msg'] =  $result['resultText'];
        }
		return $return;
    }
	
	public function order_source()  
	{  
		$useragent  = strtolower($_SERVER["HTTP_USER_AGENT"]);  
		 // 微信  
		$is_weixin  = strripos($useragent,'micromessenger');  
		if($is_weixin){  
			return 'weixin';  
		}
		// iphone  
		$is_iphone  = strripos($useragent,'iphone');  
		if($is_iphone){  
			return 'iphone';  
		}   
		// android  
		$is_android    = strripos($useragent,'android');  
		if($is_android){  
			return 'android';  
		}   
		// ipad  
		$is_ipad    = strripos($useragent,'ipad');  
		if($is_ipad){  
			return 'ipad';  
		}  
		// ipod  
		$is_ipod    = strripos($useragent,'ipod');  
		if($is_ipod){  
			return 'ipod';  
		}  
		// pc电脑  
		$is_pc = strripos($useragent,'windows nt');  
		if($is_pc){  
			return 'pc';  
		}  
		return 'other';  
	}
    
		/******************************封装函数*****************************************/
	/*
	m3 推荐人逻辑处理
	par $recommend_id int 推荐人的usr_id
	*/
	public function recommend($recommend_id=0){ 
		if($recommend_id==''){
			$recommend_id = Cookie::get('recommend_id');
		}
        if($recommend_id!='' && $recommend_id!=0){
            $api_url   =  config('global.api.getUsrinf'); 
			$base_url  =  config('global.api.base_url');
            $recommend_res   = $this->api($base_url,$api_url,array('usr_id'=>$recommend_id),'GET');
            if($recommend_res['code']==-1){
                return false;
            }
        }
		//推荐人存在
		if($recommend_id){
            $data['recommend_id'] = $recommend_id;
            //判断来源是否为天天免费
            $is_freeday = empty(session('is_freeday')) ? 0 : session('is_freeday');
            if($is_freeday == 1){
                $data['if_add_inite_integral'] = 1;  //积分增加
            }
			return $data;
        }

		return false;
	}
}