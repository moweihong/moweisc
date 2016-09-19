<?php
namespace App\Http\Controllers\h5\Service;

use DB;
use App\Models\Object;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;
//use function Symfony\Component\Debug\header;
class WxAppPayController extends ForeController {
    public function pay(){
            $code = $this->getParam('code');
            $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
            if($code && !empty($order)){
                if($order->status == 0){
                    $data['appid'] = config('pay.weixin_app.APPID');
                    //$data['attach'] = '';
                    $data['body'] = '特速一块购';
                    $data['mch_id'] = config('pay.weixin_app.MCH_ID');
                    $data['nonce_str'] = $this->getNonceStr(32);
                    $data['notify_url'] = config('pay.weixin_app.NOTIFY_URL');
                    $data['out_trade_no'] = $code;
                    $data['spbill_create_ip'] = strpos($_SERVER["REMOTE_ADDR"],'::1')!==false?'192.168.1.1':$_SERVER["REMOTE_ADDR"];
                    $data['total_fee'] = $order->money * 100;  //单位为分
                    //$data['total_fee'] = 1;   //测试1分钱，上线注释
                    $data['trade_type'] = 'APP';
                    $data['time_start'] = date('YmdHis', $order->time);
                    $data['time_expire'] = date('YmdHis', $order->expired_time);
                    ksort($data);
                    
                    //组装签名字符串
                    $str = '';
                    foreach ($data as $key => $val){
                        $str .= $key.'='.$val.'&';
                    }
                    $str .= 'key='.config('pay.weixin_app.KEY');
                    
                    $sign = strtoupper(md5($str));
                    
                    $xml = "<xml>
               <appid><![CDATA[". $data['appid'] ."]]></appid>
        
               <body><![CDATA[". $data['body'] ."]]></body>
               <mch_id><![CDATA[". $data['mch_id'] ."]]></mch_id>
               <nonce_str><![CDATA[". $data['nonce_str'] ."]]></nonce_str>
               <notify_url><![CDATA[". $data['notify_url'] ."]]></notify_url>
               <out_trade_no><![CDATA[". $data['out_trade_no'] ."]]></out_trade_no>
               <spbill_create_ip><![CDATA[". $data['spbill_create_ip'] ."]]></spbill_create_ip>
               <total_fee><![CDATA[". $data['total_fee'] ."]]></total_fee>
               <trade_type><![CDATA[". $data['trade_type'] ."]]></trade_type>
               <time_start><![CDATA[". $data['time_start'] ."]]></time_start>
               <time_expire><![CDATA[". $data['time_expire'] ."]]></time_expire>
               <sign><![CDATA[". $sign ."]]></sign>
            </xml>";
                    
                    $result = $this->postCurl(config('pay.weixin_app.WX_PAY_URL'), $xml);
                    $obj = simplexml_load_string($result,'SimpleXMLElement',LIBXML_NOCDATA);
                    if($obj->return_code == 'SUCCESS' && $obj->result_code == 'SUCCESS'){
                        $dataPackage = array();
                        $dataPackage['appid'] = config('pay.weixin_app.APPID');
                        $dataPackage['partnerid'] = config('pay.weixin_app.MCH_ID');
                        $dataPackage['timestamp'] = time();
                        $dataPackage['noncestr'] = $this->getNonceStr(18);
                        $dataPackage['package'] = "Sign=WXPay";
                        $dataPackage['prepayid'] = (string)$obj->prepay_id;
                    
                        ksort($dataPackage);
                    
                        //组装签名字符串
                        $str = '';
                        foreach ($dataPackage as $key => $val){
                            $str .= $key.'='.$val.'&';
                        }
                        $str .= 'key='.config('pay.weixin_app.KEY');
                    
                        $dataPackage['sign'] = strtoupper(md5($str));
                    
                        return view('h5.weixinapppay', array('data' => $dataPackage, 'is_charge' => $order->type == 'charge' ? 1 : 2));
                    }else{
                        exit('支付接口调用失败');
                    }
                    
                }else{
//                     $msg = ($order->status == 1 || $order->status == 4) ? '订单已支付，请勿重复提交' : '订单已过期';
//                     return view('h5.pay_fail', array('msg' => $msg));
                   if($order->type == 'charge'){
                       return redirect('user_m/usercenter2');
                   }else{
                       $scookies = json_decode($order->scookies, true);
                       $g_id = $scookies['cart_list'][count($scookies['cart_list'])-1]['g_id'];
                       $periods = Object::where('g_id', $g_id)->orderBy('id', 'desc')->limit(1)->take(1)->first();
                       
                       return redirect('product_m/'.$periods->id);
                   }
                }
            }
    }
    
//     public function notify(){
//         $result = file_get_contents("php://input");
//         $obj = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
//         //file_put_contents('log.txt', $result);
//         if($obj->return_code == 'SUCCESS'){  //支付成功
//             $params = json_decode(json_encode((array) $obj), true);
            
//             unset($params['sign']);
//             ksort($params);
            
//             $str = '';
//             foreach ($params as $k => $v){
//                 $str .= $k . '=' . $v . '&';
//             }
//             $str .= 'key=' . config('pay.KEY');
//             $sign = strtoupper(md5($str));
            
//             if($sign == (string)$obj->sign){  //签名验证成功
//                 //file_put_contents('log_id.txt', $order->id);
//                 $res = $this->payNotify($params['out_trade_no']);
                
//                 $return_xml = "<xml>
//                                   <return_code><![CDATA[SUCCESS]]></return_code>
//                                   <return_msg><![CDATA[OK]]></return_msg>
//                                 </xml>";
//             }else{
//                 $return_xml = "<xml>
//                                   <return_code><![CDATA[FAIL]]></return_code>
//                                   <return_msg><![CDATA[SIGNERROR]]></return_msg>
//                               </xml>";
//             }
            
//             header('Content-type: text/xml');
//             echo $return_xml;
//             die();
//         }
//     }
    
    public function wx_pay_s(){
        $is_charge = $this->getParam('is_charge', 1);
        return view('h5.pay_success',array('is_charge' => $is_charge));
    }
    
    public function wx_pay_f(){
        return view('h5.pay_fail');
    }
    
    /**this
     * post请求
     * @param string $url
     * @param array $data
     */
    private function postCurl($url, $data){
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // grab URL, and print
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}