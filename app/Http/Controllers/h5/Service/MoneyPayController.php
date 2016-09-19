<?php
namespace App\Http\Controllers\H5\Service;

use App\Models\Object;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;

class MoneyPayController extends ForeController {
    public function pay(){
        $code = $this->getParam('code');
        $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
        
        if($code && !empty($order) && $order->pay_type == 'yue' && $order->money == 0 && $order->type == 'buy'){   //支付类型为余额，充值金额为0，且类型为夺宝
            if($order->status == 0){
                //更新记录的最新期数
//                 $scookies = json_decode($order->scookies, true);
//                 foreach ($scookies['cart_list'] as &$good){
//                     $object = Object::where('g_id', $good['g_id'])->where('is_lottery', 0)->first();
//                     $good['periods'] = $object->periods;
//                 }
//                 $order->scookies = json_encode($scookies);
//                 $order->save();
                
                $res = $this->payNotify($code);
                
                if($res){
                    //支付回调成功
                    return view('h5.pay_success');
                }else{
                    //购买失败
                    return view('h5.pay_fail');
                }
            }else{
//                 $msg = ($order->status == 1 || $order->status == 4) ? '订单已支付，请勿重复提交' : '订单已过期';
//                 return view('h5.pay_fail', array('msg' => $msg));
                if($order->type == 'charge'){
                    return redirect('user_m/usercenter2');
                }else{
                    $scookies = json_decode($order->scookies, true);
                    $g_id = $scookies['cart_list'][count($scookies['cart_list'])-1]['g_id'];
                    $periods = Object::where('g_id', $g_id)->orderBy('id', 'desc')->limit(1)->take(1)->first();
                     
                    return redirect('product_m/'.$periods->id);
                }
            }
        }else{
            return view('errors.h5_403');
        }
    }
    
}