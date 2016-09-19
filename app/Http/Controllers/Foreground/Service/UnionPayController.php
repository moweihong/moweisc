<?php
namespace App\Http\Controllers\Foreground\Service;

use DB;
use App\Models\Object;
use App\Models\AddMoneyRecord;
use Omnipay;
use App\Http\Controllers\ForeController;

class UnionPayController extends ForeController {
    public function pay(){
        $code = $this->getParam('code');
        $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
        if($code && !empty($order)){
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
            
            $gateway = Omnipay::gateway('unionpay');
            
            $order = [
                    'orderId' => $code,
                    'txnTime' => date('YmdHis'),
                    'orderDesc' => '特速一块购', //订单名称
                    'txnAmt' => $order->money * 100, //订单价格
                    //'txnAmt' => 1,   //1分钱测试，上线注释
            ];
            
            $response = $gateway->purchase($order)->send();
            $response->redirect();
        }else{
            return view('errors.403');
        }
    }
    
    public function result(){
    
        $gateway = Omnipay::gateway('unionpay');
        $response = $gateway->completePurchase(['request_params'=>$_REQUEST])->send();
        //file_put_contents('log.txt', json_encode($response->getData()));
        if ($response->isPaid()) {
            $data = $response->getData();
            //是否重复请求
            $record = DB::select("select * from pay_notify_test where val='".$data['orderId']."' limit 1");
            if(empty($record)){
                //第一次回调插入记录
                DB::insert("insert into pay_notify_test (val) values ('".$data['orderId']."')");
                
                $res = $this->payNotify($data['orderId']);
                
                if($res){
                    exit('支付成功！');
                }else{
                    exit('支付成功，购买失败！');
                }
            }else{
                exit('支付成功！');
            }
            
        }else{
            exit('支付失败！');
        }
    }
    
    public function redirect(){
        return redirect('user/buy');
    }
}