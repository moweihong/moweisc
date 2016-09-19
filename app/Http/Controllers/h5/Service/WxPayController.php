<?php
namespace App\Http\Controllers\h5\Service;

use DB;
use Omnipay;
use App\Models\Object;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;
//use function Symfony\Component\Debug\header;
class WxPayController extends ForeController {
    public function pay(){
        if(session('openid')){
            $code = $this->getParam('code');
            $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
            if($code && !empty($order)){
                if($order->status == 0){
                    $gateway = Omnipay::gateway('weixin_m');
                    $gateway->setAppId(config('pay.APPID'));
                    $gateway->setMchId(config('pay.MCH_ID'));
                    $gateway->setApiKey(config('pay.KEY'));
                    $gateway->setNotifyUrl(config('pay.NOTIFY_URL'));
                    
                    $pakage = [
                            'body'              => '特速一块购',
                            'out_trade_no'      => $code,
                            //'total_fee'         => 1, //=0.01
                            'total_fee'         => $order->money * 100,
                            'spbill_create_ip'  => strpos($_SERVER["REMOTE_ADDR"],'::1')!==false?'192.168.1.1':$_SERVER["REMOTE_ADDR"],
                            'fee_type'          => 'CNY',
                            //'open_id'           => 'oYzNIxEZEPL7bOF49NAsE-Iont88',
                            'open_id'           => session('openid')
                    ];
                    
                    /**
                     * @var Omnipay\WechatPay\Message\CreateOrderRequest $request
                     * @var Omnipay\WechatPay\Message\CreateOrderResponse $response
                     */
                    $request  = $gateway->purchase($pakage);
                    $response = $request->send();
                    
                    if($response->isSuccessful()){
                        $data = $response->getData();
                    
                        $dataPackage = array();
                        $dataPackage['appId'] = config('pay.APPID');
                        $dataPackage['timeStamp'] = time();
                        $dataPackage['nonceStr'] = $this->getNonceStr(18);
                        $dataPackage['package'] = "prepay_id=".$data['prepay_id'];
                        //$dataPackage['package'] = "prepay_id=123456";
                        $dataPackage['signType'] = 'MD5';
                    
                        ksort($dataPackage);
                    
                        //组装签名字符串
                        $str = '';
                        foreach ($dataPackage as $key => $val){
                            $str .= $key.'='.$val.'&';
                        }
                        $str .= 'key='.config('pay.KEY');
                    
                        $dataPackage['paySign'] = strtoupper(md5($str));
                    
                        return view('h5.weixinpay', array('data' => $dataPackage, 'is_charge' => $order->type == 'charge' ? 1 : 2));
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
        }else{
            return view('errors.h5_403');
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

	/**
	 * 不支持微信支付跳转页
	 */
	public function unsuport(){
		return view('h5.wechaterror');
	}
}