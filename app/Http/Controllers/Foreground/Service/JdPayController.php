<?php
/**
 * Created by liuchen.
 * User: liuchen
 * Date: 2016/7/26 0026
 * Time: 15:29
 */
namespace App\Http\Controllers\Foreground\Service;

use DB;
use Log;
use App\Models\Object;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;
//use function Symfony\Component\Debug\header;
class JdPayController extends ForeController {
	public function index(){
		$code = $this->getParam('code');
		$order = AddMoneyRecord::where('code', $code)->where('usr_id', session('user.id'))->first();
		if($code && !empty($order)){
			$charge_amount = number_format($order->money, 2, '.', '');

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

			$key = config('jdpay.key');  //秘钥
			$jump_url = config('jdpay.jump_url');

			$data['v_mid'] = config('jdpay.merId');
			$data['v_moneytype'] = 'CNY';
			$data['v_oid'] = $code;
			$data['v_amount'] = $charge_amount;
			//$data['v_amount'] = 0.01;  //测试1分钱
			//$data['v_url'] = 'http://115.159.114.87/jdpay/redirect';       //同步回调地址 （测试）
			$data['v_url'] = 'http://www.ts1kg.com/jdpay/redirect';       //同步回调地址 （正式）
			$data['remark2'] = config('jdpay.pay_notify');   //异步回调地址

			$str = $data['v_amount'].$data['v_moneytype'].$data['v_oid'].$data['v_mid'].$data['v_url'].$key;   //md5加密拼凑串,注意顺序不能变
			$data['v_md5info'] = strtoupper(md5($str));            //md5函数加密并转化成大写字母



			return view('foreground.jdpay', array('data' => $data, 'jump_url' => $jump_url));
		}else{
			return view('errors.403');
		}
	}

	public function redirect(){
		$key = config('jdpay.key');  //秘钥

		$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号
		$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
		$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）；
		$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
		$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种
		$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值

		/**
		 * 重新计算md5的值
		 */

		$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

		/**
		 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
		 */


		if ($v_md5str==$md5string) {
			if ($v_pstatus == "20") {
				//支付成功，可进行逻辑处理！
				//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......

				//直接跳转购买记录
				return redirect('/user/buy');
			} else {
				return view('foreground.pay_fail', array('message' => "支付失败"));
			}
		}
	}

	public function notify(){
		$key = config('jdpay.key');  //秘钥

		$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号
		$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
		$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）；
		$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
		$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种
		$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值

		/**
		 * 重新计算md5的值
		 */

		$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

		/**
		 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
		 */


		if ($v_md5str==$md5string) {
			if ($v_pstatus == "20") {
				//支付成功，可进行逻辑处理！
				//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......

				//是否重复请求
				$record = DB::select("select * from pay_notify_test where val='".$v_oid."' limit 1");
				if(empty($record)){
					//第一次回调插入记录
					DB::insert("insert into pay_notify_test (val) values ('".$v_oid."')");

					//检测支付金额
					$order = AddMoneyRecord::where('code', $v_oid)->first();
					$order_money = $order->money * 100;
					//if(1 != $v_amount * 100){
					if($order_money != $v_amount * 100){
						//订单支付金额异常，购买失败
						$order->status = 4;
						$order->save();

						echo "error";die();
					}

					$this->payNotify($v_oid);
				}

				echo "ok";die();
			} else {
				Log::info('jdpay failed:'.$v_oid.'---'.$v_pstring);
				echo "error";die();
			}
		}
	}
}