<?php
namespace App\Http\Controllers\h5\Service;

use App\Models\Object;
use App\Models\AddMoneyRecord;
use Omnipay;
use App\Http\Controllers\ForeController;

class AlipayController extends ForeController {
    public function pay(){
        $code = $this->getParam('code');
        $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
        
        if($code && !empty($code)){
            //如果为购买订单，更新最新期数
            if($order->type != 'charge'){
                $scookies = json_decode($order->scookies, true);
                foreach ($scookies['cart_list'] as &$good){
                    $object = Object::where('g_id', $good['g_id'])->where('is_lottery', 0)->first();
                    $good['periods'] = $object->periods;
                }
                $order->scookies = json_encode($scookies);
                $order->save();
            }
        
            $gateway = Omnipay::gateway('alipay_m');
            
            $order = [
                    'out_trade_no' => $code,
                    'subject' => '特速一块购', //订单名称
                    //'total_fee' => $order->money, //订单价格(单位为元)
                    'total_fee' => '0.01',   //1分钱测试，上线注释
            ];
            
            $response = $gateway->purchase($order)->send();
            $response->redirect();
        }else{
            return view('errors.h5_403');
        }
    }
}