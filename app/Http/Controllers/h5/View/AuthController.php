<?php
namespace App\Http\Controllers\h5\View;

use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\ForeController;
use App\Http\Tools\Captcha\BspCaptcha;
use Cookie;

class AuthController extends ForeController {

    public function login(){
        if(session('user.id')){
            return redirect('index_m');
        }else{
            $refer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/index_m';

	        $get_prefix = $this->getParam('url_prefix', '');
	        if($get_prefix){
		        $refer = $get_prefix;
	        }
            //微信公众号  用户未登录时 点击户中心的链接 记住此链接 登陆之后跳转这个链接  16.6.26 by byl
            $url = $this->getParam('url');
            if($url){
                $refer = urldecode($url);
            }
            //end
            if(!session('url_refer')){
                if(strpos($refer, 'login') != false || strpos($refer, 'register') != false){
                    session(['url_refer' => '/index_m']);
                }else{
                    $refer = strpos($refer, 'usercenter') != false ? '/user_m/usercenter2' : $refer;
                    session(['url_refer' => $refer]);
                } 
            }
            //微信登陆 16.6.14 by  baoyaoling
            $code = $this->getParam('code');
            if(empty($code)){
                $state = md5(uniqid(rand(), TRUE));
                session(['login_state' => $state]);
                $wx_callback = config('global.weixin_m.wx_callback');
                $qq_callback = config('global.qq.qq_callback_m');
                $wx_login_url ='https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . config('pay.APPID') . '&redirect_uri=' . urlencode($wx_callback) . '&response_type=code&scope=snsapi_userinfo&state=' . session('login_state') . '#wechat_redirect';
                $qq_login_url ="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" . config('global.qq.AppID') . "&redirect_uri=" . urlencode($qq_callback) . "&state=" . session('login_state') ;
            }
            return view('h5.login',['wx_login_url'=>$wx_login_url,'qq_login_url'=>$qq_login_url]);
        }
    }
	
	public function union(){
		return view('h5.union2',['statueCode'=>'123456']);
	}
    
    public function register(){
        if(session('user.id')){
            return redirect('index_m');
        }else{
            if(!empty(session('sms_send_time_h5')) && time() - session('sms_send_time_h5') < 120){
                $time = 120 - (time() - session('sms_send_time_h5'));
            }else{
                $time = -1;
                session()->forget('sms_send_time_h5');
            }
            
            $code = $this->getParam('code', 0);
            
            if(!$code && session('invite_code')){
                $code = session('invite_code');
            }
            //腾迅 bsp 天御验证码 by baoyaoling
            $bspCaptcha = new BspCaptcha();
            $imgjsUrl = $bspCaptcha->getJsUrl();
			$recommend_id = Cookie::get('recommend_id'); 
			if($recommend_id!='no' or $recommend_id!=0){
				$rid = $recommend_id;
			}else{
				$rid = '';
			}
    		return view('h5.register', array('time' => $time,'recommend_id'=>$rid,'code' => $code,'imgjsUrl'=>$imgjsUrl));
        }
    }
	
	public function forgetpwd(){
	    if(!empty(session('sms_send_time')) && time() - session('sms_send_time') < 120){
	        $time = 120 - (time() - session('sms_send_time'));
	    }else{
	        $time = -1;
	        session()->forget('sms_send_time');
	    }
	    
        return view('h5.forgetpwd', array('time' => $time));
    }
    
    
    /**
     * Display a listing of the resource.
    *
    * @return Response
    */
    public function captcha($tmp)
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
    
        //把内容存入session
        session(['milkcaptcha' => $phrase]);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
}