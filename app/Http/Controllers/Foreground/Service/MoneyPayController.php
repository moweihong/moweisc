<?php
namespace App\Http\Controllers\Foreground\Service;

use App\Models\Object;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;

class MoneyPayController extends ForeController {
    public function index(){
        $code = $this->getParam('code');
        $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
        
        if($code && !empty($order) && $order->pay_type == 'yue' && $order->money == 0 && $order->type == 'buy'){   //支付类型为余额，充值金额为0，且类型为夺宝
            //更新记录的最新期数
//             $scookies = json_decode($order->scookies, true);
//             foreach ($scookies['cart_list'] as &$good){
//                 $object = Object::where('g_id', $good['g_id'])->where('is_lottery', 0)->first();
//                 $good['periods'] = $object->periods;
//             }
//             $order->scookies = json_encode($scookies);
//             $order->save();
            
            $res = $this->payNotify($code);
            
            if($res){
                //支付回调成功
                return view('foreground.pay_success');
            }else{
	            //购买失败
	            $order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
	            $message = '';
	            if($order->status == 5){
					$message = '您的余额不足，购买失败';
	            }else{
		            $message = '您购买的期数库存不足';
	            }

	            return view('foreground.pay_fail', array('message' => $message));
            }
        }else{
            return view('errors.403');
        }
    }
}