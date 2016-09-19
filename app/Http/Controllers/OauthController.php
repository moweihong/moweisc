<?php
namespace App\Http\Controllers;

class OauthController extends Controller {
    public function index(){
        if(!empty($_GET['code'])){
            /*用户同意授权后得到code，code作为换取access_token的票据，每次用户授权带上的code将不一样。
             code只能使用一次，5分钟未被使用自动过期。*/
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".config('pay.APPID')."&secret=".config('pay.APPSECRET')."&code={$_GET['code']}&grant_type=authorization_code";
            $rs  				= $this->get_curl($url);
            $auth2_access_token = $rs['access_token'];
            $refresh_token	    = $rs['refresh_token'];
            $openid				= $rs['openid'];
            	
            /*刷新oauth_access_token有效期（7天、30天、60天、90天）*/
//             $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".config('pay.APPID')."&grant_type=refresh_token&refresh_token={$refresh_token}";
//             $refArr       = $this->get_curl($url);
//             $auth2_access_token = $refArr['access_token']; //使用刷新后的新auth2_access_token干活
            	
            /*使用oauth_access_token授权拉取用户头像昵称等信息，但拉取不到subscribe
             $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$auth2_access_token}&openid={$openid}&lang=zh_CN";
             $wxUser = get_curl($url);*/
            $state = base64_decode($_GET['state']);
            
            $url = config('global.domain_m');
            if(strpos($state, '?') !== false){
                $url .= $state . '&openid=' . $openid;
            }else{
                $url .= $state . '?openid=' . $openid;
            }	
            
            header("Location:$url");
            exit();
        }
    }
    
    /**
     * curl发送http请求
     * @param string $url   请求链接
     * @return array $arr   请求返回
     */
    public function get_curl($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $json_str = curl_exec($ch);
        $arr = json_decode($json_str, true);
        return $arr;
    }
}