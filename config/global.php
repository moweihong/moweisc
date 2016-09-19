<?php
/*
 * 全局变量
 */
if(strpos($_SERVER['SERVER_NAME'], 'ts1kg.com') !== false || strpos($_SERVER['SERVER_NAME'], 'm.ts1kg.com') !== false){
//if(strpos($_SERVER['SERVER_NAME'], 'ts1kg.cn') !== false){
    $base_url = 'http://115.159.54.52:8080/';
    $base_buy = 'http://115.159.93.116:8080/';
    $domain = 'http://www.ts1kg.com';
    $domain2 = 'www.ts1kg.com';
    $domain_m = 'http://m.ts1kg.com';
    $domain_m2 = 'm.ts1kg.com';
    $qq_appid = '101327486';
    $qq_app_key = '5aa2e9309b574841a699686394ed921f';
    $wx_appid = 'wx7d511853e681ae97';
    $wx_app_key = '093b61d86d34ed5509aa4b43464d2fa7';
}else{
    $base_url = 'http://182.254.131.15:8080/';
    $base_buy = 'http://182.254.131.15:8080/';
    $domain = 'http://1kg.muyouguanxi.com';
    $domain2 = '1kg.muyouguanxi.com';
    $domain_m = 'http://1kg.muyouguanxi.com';
    $domain_m2 = '1kg.muyouguanxi.com';
    $qq_appid = '101327522';
    $qq_app_key = '7fd08daff7b3bcba3274022c7b82c5cc';
    $wx_appid = 'wx1e15d9691f58a46a';
    $wx_app_key = '634c9c61d78e9b6b63d22508554ede9b';
}
    $server_url = $_SERVER['SERVER_NAME'];
return [

    //本地调试路径
    'base_url' => '/',
    //增加css和js版本号控制，每次更新投产环境需更改版本号，尾数递增，如 1.0.1 , 1.0.2 ...
    'version' => '1.0.2',
	//域名
    'domain'=>$domain,
    'domain2'=>$domain2,
    'domain_m' => $domain_m,
    'domain_m2' => $domain_m2,
        
    //默认头像路径
    'default_photo'=>'/foreground/img/def.jpg',
    //默认用户名
    'default_nickname'=>'mystery',
    //新注册用户赠送块乐豆
    'reg_give_bean' => 100,
    //天天免费第一次抽奖未中奖赠送红包码
    'freeday_red' => [8,9],
        
    //邀请人第一次消费赠送块乐豆
    'invite_first_buy_bean' => 100,
        
    //红包有效天数
    'red_expired_days' => 15,
    
    //Java接口
    'api' => [
        //'base_url' => 'http://182.254.131.15:8080/',
		//'base_url' => 'http://192.168.0.85:8080',
        'base_url' => $base_url,
        'register' => 'unify_interface/user/register.do',
        'login' => 'unify_interface/user/login.do',
		'getUsrinf'=>'unify_interface/user/getUsrinf.do', //获取用户信息
        'sendMessage'=>'SmsService/message/send.do',//短信接口
		'getUsrid'=>'unify_interface/user/getUsrid.do',  //根据用户名获取用户id
		'getInviteInterval'=>'unify_interface/user/getUsrIniteIntegral.do',
        'subUsrIniteInterval'=>'unify_interface/user/subUsrIniteIntegral.do',
        'setUsrpwd'=>'unify_interface/user/setUsrpwd.do',
		'isRegister'=>'unify_interface/user/isRegister.do',//查询手机号是否注册  参数user_name
		'getRecommend'=>'unify_interface/user/getRecommend.do',  //获取推荐人id
		'base_buy'=>$base_buy,  //购买接口url
        //'base_buy'=>'http://192.168.0.85:8080/',  //购买接口url
		'buy'=>'ykgou/shoppingcart/buy.do',  //支付java回调接口
	    'setRecommend'=>'unify_interface/user/setRecommend.do',
    ],

    'message_platform'=>'ykg',
    'message_key'=>'10407D4E658E49DBBEF0FCB970C7F639',

    //所有Ajax接口地址
    'ajax_path' => [
        'index_latest' => 'index/getlatest', //首页最新揭晓接口地址
        'index_soon'=>'index/getsoon', //首页热门推荐接口地址
        'index_isbuy'=>'index/getisbuy',//首页正在购买接口地址
        'index_all'=>'index/getall',//首页全部商品接口地址
        'index_new'=>'index/getnew',//首页最新上架商品接口地址
        'index_show'=>'index/getshow',//首页晒单分享接口地址
        'index_footer'=>'index/getfooter',//首页底部文章接口地址
        'index_navigata'=>'index/getnavigata',//首页导航接口地址
        'index_articles'=>'index/getarticles',//首页公告接口地址
        'index_header'=>'index/getheader',//首页header导航条数据
		
		'activity/sendMsg'=>'activity/sendMessage',//活动页面发送短信ajax接口
		'activity/sendPayMessage'=>'activity/sendPayMessage',
        'product_buyrecord'=>'product/getbuyrecord',//获取商品购买记录，需要传递商品id
        'product_showrecord'=>'product/getshoworder',//获取商品购买记录，需要传递商品id

		'product_checkstatus'=>'product/checkstatus',//获取商品开奖状态
    ],

    //支付方式
    'pay_type' => [
        'weixin' => ['name' => '微信', 'url' => '/weixin/pay'],
        'unionpay' => ['name' => '银联', 'url' => '/unionpay/pay'],
        'yue' => ['name' => '余额', 'url' => '/money/pay'],
	    'jdpay' => ['name' => '网银在线', 'url' => '/jdpay/pay'],
    ],
    //微信 Pc登陆 16.6.14 by  baoyaoling
    'weixin'=>[
        'AppID'=>$wx_appid,
        'AppSecret'=>$wx_app_key,
        'access_token'=>'https://api.weixin.qq.com/sns/oauth2/access_token',
        'wx_callback'=>'http://' . $server_url . '/wxcallback',
        'center_callback'=>'http://' . $server_url . '/centercallback',
    ],
    //微信浏览器登陆 16.6.14 by  baoyaoling
    'weixin_m'=>[
        'access_token'=>'https://api.weixin.qq.com/sns/oauth2/access_token',
        'wx_callback'=>'http://' . $server_url . '/wxcallback_m',
    ],
    //qq登陆 16.6.14 by  baoyaoling
    'qq'=>[
        'AppID'=>$qq_appid,
        'AppKey'=>$qq_app_key,
        'qq_callback'=>'http://' . $server_url . '/qqcallback',
        'qq_callback_m'=>'http://' . $server_url . '/qqcallback_m',
        'center_callback'=>'http://' . $server_url . '/centerqqcallback',
    ],
];
