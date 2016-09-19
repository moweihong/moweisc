<?php
namespace App\Http\Controllers\Foreground\View;

use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\ForeController;
use App\Http\Tools\Captcha\BspCaptcha;
use Cookie;

class AuthController extends ForeController {

    public function login(){ 
        if(session('user.id')){
            return redirect('index');
        }else{
            $refer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
            if(strpos($refer,'localhost')!==false || strpos($refer,'ykg.muyouguanxi.com'!==false)){
                $refer='/';
            }
            if(!session('url_refer')){
                if(strpos($refer, 'login') != false || strpos($refer, 'register') != false){
                    session(['url_refer' => '/']);
                }else{
                    session(['url_refer' => $refer]);
                }
            }
            //微信/QQ登陆 16.6.14 by  baoyaoling
          //  $code = $this->getParam('code');
          //  if(empty($code)){
                $state = md5(uniqid(rand(), TRUE));
                session(['login_state' => $state]);
                $wx_callback = config('global.weixin.wx_callback');
                $qq_callback = config('global.qq.qq_callback');
                $wx_login_url ='https://open.weixin.qq.com/connect/qrconnect?appid=' . config('global.weixin.AppID') . '&redirect_uri=' . urlencode($wx_callback) . '&response_type=code&scope=snsapi_login&state=' . session('login_state') . '#wechat_redirect';
                $qq_login_url ="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" . config('global.qq.AppID') . "&redirect_uri=" . urlencode($qq_callback) . "&state=" . session('login_state');
          //  }
            return view('foreground.login',['wx_login_url'=>$wx_login_url,'qq_login_url'=>$qq_login_url]);
        }
    }
    
    public function register(){ 
        if(session('user.id')){
            return redirect('index');
        }else{
            if(!empty(session('sms_send_time')) && time() - session('sms_send_time') < 120){
                $time = 120 - (time() - session('sms_send_time'));
            }else{
                $time = -1;
                session()->forget('sms_send_time');
            }
            
            $code = $this->getParam('code', 0);
            
            if(!$code && session('invite_code')){
                $code = session('invite_code');
            }
            //腾迅 bsp 天御验证码 by baoyaoling
            $bspCaptcha = new BspCaptcha();
            $imgjsUrl = $bspCaptcha->getJsUrl();
			$recommend_id = Cookie::get('recommend_id'); 
			if(!$recommend_id){
				$recommend_id = session('invite_code');
			}
			if($recommend_id!='' or $recommend_id!=0){
				$rid = $recommend_id;
			}else{
				$rid = '';
			}
            return view('foreground.register', array('time' => $time,'recommend_id'=>$rid,'code' => $code,'imgjsUrl'=>$imgjsUrl));
        }
    }
    
	//第三方合作账号登录绑定
	public function binduser(){
        $bspCaptcha = new BspCaptcha();
        $imgjsUrl = $bspCaptcha->getJsUrl();
		return view('foreground.binduser',['imgjsUrl'=>$imgjsUrl]);
	}
    
    
    /**
     * 测试用注册接口
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function register_for_test(){
    if(!empty(session('sms_send_time')) && time() - session('sms_send_time') < 120){
        $time = 120 - (time() - session('sms_send_time'));
    }else{
        $time = -1;
        session()->forget('sms_send_time');
    }
    
    $code = $this->getParam('code', 0);
    
    //if($this->h5)
    //	return view('foreground.mobile.register');
    //else
    return view('foreground.register', array('time' => $time, 'code' => $code));
    }
	
	public function forgetpwd(){
	    if(!empty(session('sms_send_time')) && time() - session('sms_send_time') < 120){
	        $time = 120 - (time() - session('sms_send_time'));
	    }else{
	        $time = -1;
	        session()->forget('sms_send_time');
	    }
	    
        return view('foreground.forgetpwd', array('time' => $time));
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