<?php

/**
 * 前台控制器基类
 * M1 add by tangzhe 2016-3-18 增加判断是否移动设备访问
 * M2 modify by tangzhe 2016-06-28 修复每次登陆后购物车商品数量为0
 * M3 add by tangzhe 2016-07-20 生产环境前台排除框架的NOTICE级别报错
 */

namespace App\Http\Controllers;

use DB;
use Log;
use App\Facades\ProductRepositoryFacade;
use App\Models\Cart;
use App\Models\Red;
use App\Models\Object;
use App\Models\Article_cat;
use App\Models\Userpoint;
use App\Models\AddMoneyRecord;
use View;
use App\Facades\IndexRepositoryFacade;
use App\Facades\FunctionRepositoryFacade;
use Request;
use App\Models\Member;


class ForeController extends Controller
{
    /**
     * 前台url前缀，用于模板
     *
     * @var object
     */
    public $url_prefix  =  '/foreground/';
    public $h5_prefix   =  '/H5/';
	public $h5          = false;
	public $h5_category_conf = array(
	        99=>'menu_img_phone',100=>'menu_img_pc',101=>'menu_img_food',
	        102=>'menu_img_outdoor',103=>'menu_img_furnish',104=>'menu_img_markup',
	        105=>'menu_img_luggage',106=>'menu_img_car',107=>'menu_img_invest',
	        108=>'menu_img_virtual',109=>'menu_img_pc'
	);
    
    public function __construct() { 
		//M3
		if(env('APP_DEBUG')==false){
			error_reporting(E_ALL & ~E_NOTICE);
		}

        View::share('url_prefix', $this->url_prefix);
        View::share('h5_prefix', $this->h5_prefix);

        //$total = $this->getTotalAmount(true);
		//$this->h5 = $this->is_mobile_request();
        //View::share('total_amount', $total['total_amount']);
     
		//m2
	    $total_count = 0;
		if(session('cart.list')){
			$total_count = count(session('cart.list'));
		}else{
			//$total_count = DB::table('tab_shopping_cart')->leftjoin('ykg_goods', 'tab_shopping_cart.g_id', '=', 'ykg_goods.id')->where('tab_shopping_cart.usr_id',session('user.id'))->where('ykg_goods.isdeleted', 0)->count();
			if(session('user.id')){
				$list = $this->getAllCart();
				$total_count = count($list);
			}
		}
		
        View::share('total_count', $total_count);

        $request_uri = Request::getRequestUri();
        $menu_active = 'index_m';
        if(strpos($request_uri, 'category_m') != false){
            $menu_active = 'category_m';
        }else if(strpos($request_uri, 'find_m') != false){
            $menu_active = 'find_m';
        }else if(strpos($request_uri, 'mycart_m') != false){
            $menu_active = 'mycart_m';
        }else if(strpos($request_uri, 'usercenter') != false){
            $menu_active = 'usercenter';
        }
        
		//获取一级分类和二级分类导航
		//获取导航，二级导航
	    $data['category']=IndexRepositoryFacade::findNavigata('sort_order');
	    if(strpos($_SERVER['SERVER_NAME'], 'm.ts1kg.com') === false){   //h5不加载导航栏
		    foreach ($data['category'] as $key => $val){
			    $data['category'][$key]['brand']=ProductRepositoryFacade::findLimitProductByCatid($val['cateid'],10);
		    }
	    }

	    //网站seo配置
	    $seo = $this->getSeoInfo();
	    View::share('seo', $seo);

		//检测是否微信浏览器
		if($this->is_weixin()){
		    if(strpos($_SERVER["REQUEST_URI"], 'unionpay_m/result') == false || strpos($_SERVER["REQUEST_URI"], 'unionpay_m/return') == false || strpos($_SERVER["REQUEST_URI"], 'weixin/notify') == false){
    		    if(empty(session('openid')) && empty($_GET['openid'])){
    		        $scope='snsapi_base';
    		        $appid = config('pay.APPID');
    		        $redirect_uri = config('global.domain_m').'/oauth';//授权回调
    		        $redirect_uri = urlencode($redirect_uri);
    		        $state = base64_encode($_SERVER['REQUEST_URI']);
    		        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    		        header("Location:$url");//跳转后得到$_GET['code']参数，5分钟有效,使用$_GET['code']去获得oauth access_token。
    		        exit();
    		    }else{
    		        if(empty(session('openid'))){
    		            session(['openid' => $_GET['openid']]);
    		        }
    		    }
		    }
		    $jspackage = $this->jsSdkPackage();
		    View::share('jspackage', $jspackage);
		}

	    //检测是否app
	    $source = $this->getParam('source', '');
	    if($source && $source == 'ios'){
		    //session(['is_ios' => 1]);
//		    header("Location: http://app.ts1kg.com?source=ios");
//		    exit();
	    }

        View::share('category',$data);
        View::share('h5_category_conf',$this->h5_category_conf);
        View::share('menu_active', $menu_active);
        View::share('is_weixin', $this->is_weixin());
	}

	/**
	 * 获取seo信息
	 */
	public function getSeoInfo(){
		$seo_arr = config('seo');
		$route = Request::path();
		$keys = array_keys($seo_arr);

		$info = array();
		if($route == '/'){
			$info = $seo_arr['index'];
		}else{
			foreach ($keys as $key) {
				if(strpos($key, $route) !== false){
					$info = $seo_arr[$key];
					break;
				}
			}
			$info = empty($info) ? $seo_arr['index'] : $info;
		}

		return $info;
	}
    
    /**
     * 计算购物车商品数量和总价格
     * @param array $list
     * @return array $data
     */
    protected function getTotalAmount($flag = false){
        if(session('user.id')){
            $list = $this->getAllCart($flag);
            //计算所选商品总价格
            $total_amount = 0;
            
            if(!empty($list)){
                $choose_ids = $flag ? array_keys($list) : session('cart.choose_ids');
                foreach ($list as $id => $good){
                    if(in_array($id, $choose_ids)){
                        $total_amount += $good['bid_cnt'] * $good['minimum'];
                    }
                }
            }
        }else{
            $list = array();
            $total_amount = 0;
        }

        return array('total_amount' => $total_amount, 'total_count' => count($list));
    }
    
    /**
     * 获取购物车列表
     * @return array
     */
    public function getAllCart($flag = false){
        if(empty(session('cart.list')) || $flag){
            $list = (new Cart())->getAllCart();
            session(['cart.list' => $list]);
        }else{
            $list = session('cart.list');
        }
        
        return $list;
    }
	
	/** m1
	 * 判断是否移动设备访问 
	 * return boolean 
	 */
	public function is_mobile_request(){ 
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			return true;
		} 
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		{ 
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		} 
		// 脑残法，判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			$clientkeywords = array ('nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
				); 
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				return true;
			} 
		} 
		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{ 
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
			{
				return true;
			} 
		} 
		return false;
	}

	/*
	 * 调用api方法封装
	 * @param string $base_url 路径
	 * @param string $api_url  调用路径
	 * @param string $data 数组
	 * @param string $method post/get
	 * @return array
	 */
	public function api($base_url,$api_url,$data,$method){
		
	    $client = new \GuzzleHttp\Client(['base_uri' => $base_url]);
		
	    $query = http_build_query($data);
		
	    $res = $client->request($method, $api_url, ['query' => $query]);
		
	    return json_decode($res->getBody(), true);
	}

	public function testPhoneSent($phone)
	{
		//$param=888888;
		//$res=$this->sendverifysms($phone,$param);//验证码
		//$phone=13763327765;
		$template_id='22008';
		$param='1000000035';
		$res=$this->sendtplsms($phone,$template_id,$param);
		var_dump($res);
	}
	
	/**
	 * 获取指定长度的唯一字符串
	 * @return string
	 */
	public function getNonceStr($length, $type = 1){
	    if($type == 1){
	        $dictionary = '0123456789abcdefghijklmnopqrstuvwxyz';
	    }else{
	        $dictionary = '0123456789';  //纯数字，用于验证码
	    }
	    $size = strlen($dictionary);
	
	    $str = '';
	    for ($i = 0; $i < $length; $i++){
	        $str .= substr($dictionary, rand(0, $size - 1), 1);
	    }
	
	    return $str;
	}
	
	/**
	 * 支付统一回调方法
	 * @param object $order
	 * @param string $code
	 */
	public function payNotify($code){
	    //file_put_contents('log_code.txt', $code);
	    Log::info('notify code:'.$code);
	    $order = AddMoneyRecord::where('code', $code)->where('status', 0)->first();
	    Log::info('notify order info:'.json_encode($order));
	    if(!empty($order)){
    	    if($order->type == 'buy'){
    	        //获取订单处理前用户余额
    	        $user = Member::where('usr_id', $order->usr_id)->first();
    	        //插入用户余额记录
    	        DB::insert("insert into tab_money_log (usr_id, code, money_before, money_after, amount) values (".$order->usr_id.", '".$code."', ".$user->money.", 0, 0)");
    	        
    	        //请求回调接口
    	        $base_url  =  config('global.api.base_buy');
    	        $api_url   =  config('global.api.buy');
    	        $res   = $this->api($base_url,$api_url,array('usr_id' => $order->usr_id, 'code' => $code),'GET');
    	        //file_put_contents('log_res.txt', json_encode($res));
    	        Log::info('java request result:usr_id:'.$order->usr_id.'---'.'code:'.$code.'---res:'.json_encode($res));
    	        
    	        $order = AddMoneyRecord::where('code', $code)->first();  //获取最新的订单状态
    	        
    	        //获取订单处理后用户余额
    	        $user = Member::where('usr_id', $order->usr_id)->first();
    	        //更新用户余额记录
    	        if($order->amount){
    	            DB::update("update tab_money_log set money_after = ".$user->money.", amount = ".$order->amount." where code = '".$code."'");
    	        }else{
    	            DB::update("update tab_money_log set money_after = ".$user->money." where code = '".$code."'");
    	        }
    	        
    	        if($res['code'] == 0 || ($order->bid && $order->status == 1 && $order->amount > 0)){
    	            //                     DB::insert('insert into pay_notify_test (val) values (?)',
    	            //                             [1]);   //测试回调

		            //更新支付时间
		            $order->pay_time = time();
		            $order->save();

    	            $this->inviteFirstBuy($order);
    	            
    	            //购买赠送块乐豆
    	            if($order->status == 1 && $order->amount > 0){
		                $add_klbean = $order->amount;  //夺宝赠送块乐豆

		                $scookies = json_decode($order->scookies, true);
		                if($scookies['klbean'] == 1){  //使用了块乐豆
							$klbean_log = DB::table('tab_member_account')->where('usr_id', $order->usr_id)->where('type', 9)->where('content','like','%'.$order->id)->first();
			                if(!empty($klbean_log)){
				                $add_klbean = $add_klbean - intval($klbean_log->money/100);   //块乐豆抵扣部分不参与赠送
			                }
		                }

		                if($add_klbean > 0){
			                $up_result = DB::update('update tab_member set kl_bean = kl_bean + '.$add_klbean.' where usr_id = :id', [':id' => $order->usr_id]);

			                $msg = '用户夺宝支付赠送'.$add_klbean.'块乐豆，充值记录id：'.$order->id;
			                $msg .= $up_result ? '，赠送成功' : '，赠送失败';

			                $userpoint = new Userpoint();
			                $userpoint->usr_id = $order->usr_id;
			                $userpoint->type = 0;
			                $userpoint->pay = '众筹赠送';
			                $userpoint->content = $msg;
			                $userpoint->money = $add_klbean;
			                $userpoint->time = time();
			                $userpoint->save();
		                }
    	            }

		            //更新订单记录购买ip
		            if(!empty($order->bid)){
			            //获取登陆的ip
			            $member = Member::where('usr_id', $order->usr_id)->first();
			            $last_login_ip = $member->last_login_ip;

			            $bid = array();
			            eval("\$bid = " . $order->bid . ";");
			            foreach ($bid as $bid_id) {
				            DB::update("update tab_bid_record set login_ip = '".$last_login_ip."' where id = " . $bid_id);
			            }
		            }
    	             
    	            return true;
    	        }else{
		            if(strpos($res['resultText'], '余额不足') !== false){
			            $order->status = 5;
		            }else{
			            $order->status = 4;
			            $order->pay_time = time();
		            }
		            $order->save();
	                 
	                return false;
    	        }
    	    }else if($order->type == 'charge'){
	            //获取订单处理前用户余额
	            $user = Member::where('usr_id', $order->usr_id)->first();
	            //插入用户余额记录
	            DB::insert("insert into tab_money_log (usr_id, code, money_before, money_after, amount) values (".$order->usr_id.", '".$code."', ".$user->money.", 0, 0)");
    	        
    	        //充值金额到用户余额账户
    	        $result = DB::update('update tab_member set money = money + '.$order->money.' where usr_id = :id', [':id' => $order->usr_id]);
    	        Log::info('charge result:usr_id:'.$order->usr_id.'---'.'code:'.$code.'---update result:'.$result);
    	        
    	        //充值成功，修改状态
    	        $order->status = 1;
    	        $order->amount = $order->money;
		        $order->pay_time = time();
    	        $order->save();
    	        
    	        //获取订单处理后用户余额
    	        $user = Member::where('usr_id', $order->usr_id)->first();
    	        //更新用户余额记录
    	        DB::update("update tab_money_log set money_after = ".$user->money.", amount = ".$order->amount." where code = '".$code."'");
    	        
    	        //$this->inviteFirstBuy($order);
    	        
    	        return true;
    	    }
	    }else{
	        return false;
	    }
	}
	
	/**
	 * 被邀请人首次充值赠送块乐豆
	 * @param object $order
	 */
	public function inviteFirstBuy($order){
	    //支付成功，第一次购买赠送推荐人块乐豆
	    $count = AddMoneyRecord::where('usr_id', $order->usr_id)->where('type', 'buy')->where('status', 1)->count();
	    if($count == 1){
	        //file_put_contents('log_order.txt', json_encode($order));
//		    $klbean_deduct = $red_deduct = 0;
//		    $scookies = json_decode($order->scookies, true);
//		    if($scookies['klbean'] == 1){  //使用了块乐豆
//			    $klbean_log = DB::table('tab_member_account')->where('usr_id', $order->usr_id)->where('type', 9)->where('content','like','%'.$order->id)->first();
//			    if(!empty($klbean_log)){
//				    $klbean_deduct = intval($klbean_log->money/100);
//			    }
//		    }
//
//		    if($scookies['red'] > 0){
//			    $red_log = DB::table('tab_member_account')->leftjoin('tab_redbao','tab_redbao.id','=','tab_member_red.red_code')->where('tab_member_red.usr_id', $order->usr_id)->where('tab_member_red.id', $scookies['red'])->first(['tab_redbao.money as money']);
//			    if(!empty($red_log)){
//				    $red_deduct = $red_log->money;
//			    }
//		    }
//
//		    if($order->amount <= $red_deduct + $klbean_deduct){
//			    return false;   //块乐豆和红包完全抵扣，不赠送块乐豆
//		    }

	        //获取推荐人
	        $base_url  =  config('global.api.base_url');
	        $api_url   =  config('global.api.getRecommend');
	        $res   = $this->api($base_url,$api_url,array('usr_id' => $order->usr_id),'GET');
	        //file_put_contents('log_res.txt', json_encode($res));
	        
	        if($res['code'] == 0){
	            $res['resultText'] = json_decode($res['resultText'], true);
	            if(!empty($res['resultText']['recommend_id'])){
	                //file_put_contents('sql_up.txt', 222222);
	                $up_result = DB::update('update tab_member set kl_bean = kl_bean + '.config('global.invite_first_buy_bean').' where usr_id = :id', [':id' => $res['resultText']['recommend_id']]);
	                
	                $type = $order->type == 'charge' ? '充值' : '消费';
	                
	                $msg = '被邀请人'.$order->usr_id.'第一次'.$type.'赠送'.config('global.invite_first_buy_bean').'块乐豆，充值记录id：'.$order->id;
	                $msg .= $up_result ? '，赠送成功' : '，赠送失败';
	                 
	                $userpoint_first = new Userpoint();
	                $userpoint_first->usr_id = $res['resultText']['recommend_id'];
	                $userpoint_first->type = 0;
	                $userpoint_first->pay = '邀请人首次'.$type.'赠送';
	                $userpoint_first->content = $msg;
	                $userpoint_first->money = config('global.invite_first_buy_bean');
	                $userpoint_first->time = time();
	                $userpoint_first->save();
	                 
	                // 	            $insert = [
	                // 	                    'usr_id'=>$res['resultText']['recommend_id'],
	                // 	                    'type'=>0,
	                // 	                    'pay'=>'邀请人首次消费赠送',
	                // 	                    'content'=>$msg,
	                // 	                    'money'=>config('global.invite_first_buy_bean'),
	                // 	                    'time'=>time()
	                // 	            ];
	                 
	                // 	            Userpoint::create($insert);
	            }
	        }
	    }
	}
	
	/**
	 * 判断是否微信浏览器
	 */
    function is_weixin(){ 
    	if ( isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
    	    return true;
    	}	
    	return false;
    }
    
    /**
     * jssdk配置
     */
    public function jsSdkPackage(){
        $jsapiTicket = $this->getJsApiTicket();
        
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $timestamp = time();
        $nonceStr = $this->getNonceStr(16);
        
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        
        $signature = sha1($string);
        
        $signPackage = array(
                "appId"     => config('pay.APPID'),
                "nonceStr"  => $nonceStr,
                "timestamp" => $timestamp,
                "url"       => $url,
                "signature" => $signature,
                "rawString" => $string
        );
        return $signPackage;
    }
    
    /**
     * 获取accesstoken
     * @return string
     */
    private function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("access_token.json"), true);
        if (empty($data) || $data['expire_time'] < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".config('pay.APPID')."&secret=".config('pay.APPSECRET');
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data['expire_time'] = time() + 7000;
                $data['access_token'] = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data['access_token'];
        }
        return $access_token;
    }
    
    /**
     * 获取jsapitoken
     * @return unknown
     */
    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("jsapi_ticket.json"), true);
        if (empty($data) || $data['expire_time'] < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data['expire_time'] = time() + 7000;
                $data['jsapi_ticket'] = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data['jsapi_ticket'];
        }
    
        return $ticket;
    }
    
    public function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
    
        $res = curl_exec($curl);
        curl_close($curl);
    
        return $res;
    }
}
