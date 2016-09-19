<?php
namespace App\Http\Controllers\Foreground\Service;

use DB;
use App\Models\Object;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;
//use function Symfony\Component\Debug\header;
class WxPayController extends ForeController {
    public function index(){
        $code = $this->getParam('code');
        $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
        if($code && !empty($order)){
            $charge_amount = $order->money;
            
            //如果为购买订单，更新最新期数
//             if($order->type != 'charge'){
//                 $scookies = json_decode($order->scookies, true);
//                 foreach ($scookies['cart_list'] as &$good){
//                     $object = Object::where('g_id', $good['g_id'])->where('is_lottery', 0)->first();
//                     $good['periods'] = $object->periods;
//                 }
//                 $order->scookies = json_encode($scookies);
//                 $order->save();
//             }
            
            $data['appid'] = config('pay.APPID');
            //$data['attach'] = '';
            $data['body'] = '特速一块购';
            $data['mch_id'] = config('pay.MCH_ID');
            $data['nonce_str'] = $this->getNonceStr(32);
            $data['notify_url'] = config('pay.NOTIFY_URL');
            $data['out_trade_no'] = $code;
            $data['spbill_create_ip'] = strpos($_SERVER["REMOTE_ADDR"],'::1')!==false?'192.168.1.1':$_SERVER["REMOTE_ADDR"];
            $data['total_fee'] = $charge_amount * 100;  //单位为分
            //$data['total_fee'] = 1;   //测试1分钱，上线注释
            $data['trade_type'] = 'NATIVE';
            $data['time_start'] = date('YmdHis', $order->time);
            $data['time_expire'] = date('YmdHis', $order->expired_time);
            ksort($data);
            
            //组装签名字符串
            $str = '';
            foreach ($data as $key => $val){
                $str .= $key.'='.$val.'&';
            }
            $str .= 'key='.config('pay.KEY');
            
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
    
            $result = $this->postCurl(config('pay.WX_PAY_URL'), $xml);
            $obj = simplexml_load_string($result);
    
            if($obj->return_code == 'SUCCESS' && $obj->result_code == 'SUCCESS'){
                $code_url = (string)$obj->code_url;
            }else{
                exit('支付接口调用失败');
            }
            
            return view('foreground.wechatpay', array('url' => $code_url, 'charge_amount' => $charge_amount, 'code' => $code));
        }else{
            return view('errors.403');
        }
    }
    
    public function notify(){
        $result = file_get_contents("php://input");
        $obj = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        //file_put_contents('log.txt', $result);
        if($obj->return_code == 'SUCCESS'){  //支付成功
            $params = json_decode(json_encode((array) $obj), true);
            
            //是否重复请求
            $record = DB::select("select * from pay_notify_test where val='".$params['out_trade_no']."' limit 1");
            if(empty($record)){
                //第一次回调插入记录
                DB::insert("insert into pay_notify_test (val) values ('".$params['out_trade_no']."')");
                
                unset($params['sign']);
                ksort($params);
                
                $str = '';
                foreach ($params as $k => $v){
                    $str .= $k . '=' . $v . '&';
                }
                $str .= 'key=' . config('pay.KEY');
                $sign = strtoupper(md5($str));
                
                if($sign == (string)$obj->sign){  //签名验证成功
                    //file_put_contents('log_id.txt', $order->id);
                    //检测支付金额
                    $order = AddMoneyRecord::where('code', $params['out_trade_no'])->first();
                    $order_money = $order->money * 100;
                    if($order_money != $params['total_fee']){
                        //订单支付金额异常，购买失败
                        $order->status = 4;
                        $order->save();
                        
                        $return_xml = "<xml>
                                      <return_code><![CDATA[FAIL]]></return_code>
                                      <return_msg><![CDATA[TOTAL_FEE_ERROR]]></return_msg>
                                  </xml>";
                        header('Content-type: text/xml');
                        echo $return_xml;
                        die();
                    }
                    
                    $res = $this->payNotify($params['out_trade_no']);
                    
                    $return_xml = "<xml>
                                      <return_code><![CDATA[SUCCESS]]></return_code>
                                      <return_msg><![CDATA[OK]]></return_msg>
                                    </xml>";
                }else{
                    $return_xml = "<xml>
                                      <return_code><![CDATA[FAIL]]></return_code>
                                      <return_msg><![CDATA[SIGNERROR]]></return_msg>
                                  </xml>";
                }
                
                header('Content-type: text/xml');
                echo $return_xml;
                die();
            }else{
                $return_xml = "<xml>
                                  <return_code><![CDATA[SUCCESS]]></return_code>
                                  <return_msg><![CDATA[OK]]></return_msg>
                                </xml>";
                header('Content-type: text/xml');
                echo $return_xml;
                die();
            }
        }
    }
    
    /**
     * 前端轮询查询当前订单状态
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOrder(){
        $code = $this->getParam('code');
        $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
        
        $data = array();

        if($order->status == 1 || $order->status == 4 || $order->status == 5){
            if($order->status == 1){
                //支付成功，购买成功
                session(['weixin_pay_result' => 'success']);
            }else{
                $temp = 'fail';
                if($order->type == 'charge'){
                    $temp = 'charge_fail';
                }
	            if($order->status == 5){
		            $temp = 'not_enough';  //余额不足
	            }
                //支付成功，购买失败
                session(['weixin_pay_result' => $temp]);
            }
        
            $data['status'] = 0;
            $data['message'] = 'ok';
        }else{
            $data['status'] = -1;
            $data['message'] = 'no';
        }

        return response()->json($data);
    }
    
    public function wxResult(){
        if(session('weixin_pay_result') !== null){
            $weixin_pay_result = session('weixin_pay_result');
            session()->forget('weixin_pay_result');
            if($weixin_pay_result == 'success'){
                return view('foreground.pay_success');
            }else if($weixin_pay_result == 'fail'){
                return view('foreground.pay_fail', array('flag' => 1));
            }else if($weixin_pay_result == 'charge_fail'){
                return view('foreground.pay_fail', array('flag' => 2));
            }else if($weixin_pay_result == 'not_enough'){
	            return view('foreground.pay_fail', array('flag' => 3));
            }
        }else{
            return redirect('/');
        }
    }
    
    /**
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