<?php
namespace App\Http\Controllers\h5\Service;

use Request;
use App\Models\Goods;
use App\Models\Object;
use App\Models\Member;
use App\Models\Red;
use App\Models\Cart;
use App\Mspecs\M3Result;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;

class PayController extends ForeController {
    public  $order;
    public  $code;
    
    public function __construct(Request $request){
        parent::__construct();
        $this->jsonMspecs = new M3Result();
        
        $this->code = $this->getParam('code');
        $this->order = AddMoneyRecord::where('code', $this->code)->where('usr_id', session('user.id'))->first();
        
        if(empty($this->code) || empty($this->order)){
            if($request::ajax()){
                $this->jsonMspecs->status = -10086;
                $this->jsonMspecs->message = '非法请求';
                echo $this->jsonMspecs->toJson();
                exit();
            }else{
                echo view('errors.h5_403');
                exit();
            }
        }
    }
    //支付页
    public function pay()
    {
        $total_amount = 0;   //商品总额
        $count = 0;  //商品总数
        $goods_info = array();  //商品信息
        
        //更新记录
        $scookies = json_decode($this->order->scookies, true);
        foreach ($scookies['cart_list'] as &$good){
            $object = Object::leftjoin('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')->where('tab_object.g_id', $good['g_id'])->where('tab_object.is_lottery', 0)->first(['tab_object.*', 'ykg_goods.title']);
            $good['periods'] = $object->periods;
            $total_amount += intval($good['bid_cnt']) * intval($object->minimum);
            $goods_info[] = array('title' => $object->title, 'periods' => $object->periods, 'bid_cnt' => $good['bid_cnt']);
        }
        
        $count = count($scookies['cart_list']);
        $this->order->scookies = json_encode($scookies);
        //$this->order->money = $total_amount;
        $this->order->save();
        
        //获取用户的相关信息，包括红包、购物卡、余额
        $user = Member::where('usr_id', session('user.id'))->first()->toArray();
        $redModel = new Red();
        $red  = $redModel->getRedList();
        
        foreach ($red as $key => $row){
            if($total_amount < $row['xiaxian']){  //不满足抵扣条件
                unset($red[$key]);
            }
        }
        
        $minis_money = $user['money'] >= $total_amount ? $total_amount : $user['money'];
        
        $is_show_pay = $total_amount <= $user['money'] ? 0 : 1;
        
        return view('h5.pay', array(
                'total_amount' => $total_amount, 'count' => $count, 'goods_info' => $goods_info, 
                'user' => $user, 'red' => $red, 'is_show_pay' => $is_show_pay, 'code' => $this->code,
                'minus_money' => $minis_money
        ));
    }
    
    /**
     * ajax刷新购物车付款金额
     * @return string
     */
    public function refreshPayAmount(){
        $result = $this->_deduction();
        
        $this->jsonMspecs->status = $this->jsonMspecs->status ? $this->jsonMspecs->status : 0;
        $this->jsonMspecs->message = $this->jsonMspecs->message ? $this->jsonMspecs->message : '购物车付款金额获取成功';
        $this->jsonMspecs->data = array('pay_amount' => $result['pay_amount'], 'minus_money' => $result['minus_money'], 'minus_klbean' => $result['minus_klbean']);

        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 支付提交
     * @return string
     */
    public function paySubmit(){
	    $red = $this->getParam('red', 0);
	    $paytype = $this->getParam('paytype', '');
	    $klbean = $this->getParam('klbean', 0);

        if($this->order->status == 0){
            $result = $this->_deduction();

	        if($result['pay_amount'] > 0 && $paytype == 'weixin' && !$this->is_weixin()){    //非微信浏览器使用微信支付，跳转提示页
		        $this->jsonMspecs->status = 0;
		        $this->jsonMspecs->message = 'success';
		        $html = $this->creatPayHtml('unsuport');
		        $this->jsonMspecs->data = array('form' => $html);
		        return $this->jsonMspecs->toJson();
	        }
            
            if(isset($this->jsonMspecs->status) && $this->jsonMspecs->status !=0){  //抵扣失败
                $this->jsonMspecs->data = array('pay_amount' => $result['pay_amount'], 'minus_money' => $result['minus_money'], 'minus_klbean' => $result['minus_klbean']);
            }else{  //抵扣成功
                //更新订单信息
                if($red){
                    $scookeis = json_decode($this->order->scookies, true);
                    $scookeis['red_id'] = $red;
                    $this->order->scookies = json_encode($scookeis);
                }else if($klbean){
	                $scookeis = json_decode($this->order->scookies, true);
	                $scookeis['klbean'] = 1;
	                $this->order->scookies = json_encode($scookeis);
                }

                $this->order->money = $result['pay_amount'];//更新支付金额
                $this->order->pay_type = $result['pay_amount'] == 0 ? 'yue' : $paytype;
                
                if($this->order->save()){
                    $this->clearCart();  //清空购物车
                    
                    $this->jsonMspecs->status = 0;
                    $this->jsonMspecs->message = 'success';
                    $html = $this->creatPayHtml($paytype);
                    $this->jsonMspecs->data = array('form' => $html);
                }else{
                    $this->jsonMspecs->status = -3;
                    $this->jsonMspecs->message = '支付提交失败';
                }
            }
        }else{
            $this->jsonMspecs->status = -2;
            $this->jsonMspecs->message = '订单已支付，请勿重复提交';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 清空购物车
     * @return string
     */
    public function clearCart(){
        $delete = Cart::where('usr_id', session('user.id'))->delete();
		session()->forget('cart');
    }
    
    public function creatPayHtml($type){
        if($type == 'weixin'){
            $action = '/weixin_m/pay/';
        }else if($type == 'unionpay'){
            $action = '/unionpay_m/pay';  //银联支付pc和wap接口统一
        }else if($type == 'alipay'){
            $action = '/alipay_m/pay';
        }elseif($type == 'weixin_app'){
            $action = '/weixin_app/pay';
        }elseif($type == 'unsuport'){
	        $action = '/weixin_m/unsuport';
        }else{
            $action = '/money_m/pay';
        }
         
        $html  = '<form action="'.$action.'" method="post" style="display:none" id="subform">';
        $html .= '<input type="text" name="code" value="'.$this->code.'">';
        $html .= csrf_field();
        $html .= '<input type="submit" value="提交" id="pay_sub">';
        $html .= '</form>';
    
        return $html;
    }
    
    private function _deduction(){
        //抵扣逻辑顺序，红包最先，余额最后
        //计算购物车所有商品的总金额
        $scookies = json_decode($this->order->scookies, true);
        $pay_amount = $minus_klbean = 0.00;
        
        $has_virtual = 0;  //是否包含虚拟商品
        foreach ($scookies['cart_list'] as $key => $val){
            $object = Object::where('g_id', $val['g_id'])->where('is_lottery', 0)->first();
            $pay_amount += intval($val['bid_cnt']) * intval($object->minimum);
            if($has_virtual == 0){
                $g_info = Goods::find($val['g_id']);
                $has_virtual = $g_info->is_virtual;
            }
        }

	    $red = $this->getParam('red');
	    $klbean = $this->getParam('klbean');

	    if($red && $klbean){
		    $this->jsonMspecs->status = -4;
		    $this->jsonMspecs->message = '红包抵扣和块乐豆抵扣不能同时使用';
	    }else {
		    //红包抵扣逻辑
		    if ($red) {
			    if ($has_virtual == 0) {
				    $red_info = Red::leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')
					    ->where('tab_member_red.usr_id', session('user.id'))
					    ->where('tab_member_red.id', $red)
					    ->where('tab_member_red.status', 0)
					    ->first();

				    if ($red_info) {
					    if ($red_info->xiaxian > $pay_amount) {   //不满足使用最低消费金额
						    $this->jsonMspecs->status = -2;
						    $this->jsonMspecs->message = '当前消费金额不满足该红包使用条件';
					    } else {
						    $pay_amount -= $red_info->money;
					    }
				    } else {
					    $this->jsonMspecs->status = -1;
					    $this->jsonMspecs->message = '未找到该红包';
				    }
			    } else {
				    $this->jsonMspecs->status = -3;
				    $this->jsonMspecs->message = '虚拟商品不能使用红包';
			    }
		    }

		    //块乐豆抵扣逻辑
		    if ($klbean) {
			    $member = Member::where('usr_id', session('user.id'))->first();
			    if (intval($member->kl_bean/100) >= $pay_amount) {
				    $minus_klbean = $pay_amount;
				    $pay_amount = 0;
			    } else {
				    $pay_amount = round(($pay_amount * 100 - intval($member->kl_bean/100)*100) / 100, 2);
				    $minus_klbean = intval($member->kl_bean/100).'.00';
			    }
		    }
	    }
        
        //余额抵扣逻辑
        $minus_money = 0;  //抵扣的余额
        $member = Member::where('usr_id', session('user.id'))->first();
	    if($member->money > 0 && $pay_amount > 0){
		    if($member->money >= $pay_amount){
			    $minus_money = $pay_amount;
			    $pay_amount = 0;
		    }else{
			    $pay_amount = round(($pay_amount*100 - $member->money*100)/100, 2);
			    $minus_money = $member->money;
		    }
	    }
        
        $minus_money = number_format(floatval($minus_money), 2);
        
        return array('pay_amount' => $pay_amount, 'minus_money' => $minus_money, 'minus_klbean' => $minus_klbean);
    }
}