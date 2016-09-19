<?php
/*
 * 全局变量
 */
if(strpos($_SERVER['SERVER_NAME'], 'ts1kg.com') !== false || strpos($_SERVER['SERVER_NAME'], 'm.ts1kg.com') !== false){
//if(strpos($_SERVER['SERVER_NAME'], 'ts1kg.cn') !== false){
    $APPID     = 'wx0ec3a00fec9d8db1';//公众号id
    $APPSECRET ='ceefa2bca5748bc257076994190fbe6f';
}else{
    //测试账号 16.6.14 by  baoyaoling
    $APPID     = 'wx53139a6989ded0a5';//公众号id
    $APPSECRET ='ff822586849fc97d990505cd06ad21dd';
}
return [

    //微信支付配置
    'WX_PAY_URL' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',   //统一下单接口地址
    'APPID'      => $APPID,//公众号id
    'APPSECRET'  => $APPSECRET,
    'MCH_ID'     => '1276426501',   //商户id
    'KEY'        => 'C74BF0B8EFA05C05CFDAB693514699B7',   //支付api公钥
    'NOTIFY_URL' => 'http://'.$_SERVER['SERVER_NAME'].'/weixin/notify',   //支付回调url
            
    //app微信支付配置
    'weixin_app' => [
            'WX_PAY_URL' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',
            'APPID'      => 'wx8f75cede632870ab',
            'APPSECRET'  => '63f4d8f446d8ef5df2b1c925fcf476af',
            'MCH_ID'     => '1289101201',
            'KEY'        => 'C74BF0B8EFA05C05CFDAB693514699B7',   //支付api公钥
            'NOTIFY_URL' => 'http://'.$_SERVER['SERVER_NAME'].'/weixin/notify',
    ],
];
