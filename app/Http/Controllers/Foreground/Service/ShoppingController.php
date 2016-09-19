<?php
namespace App\Http\Controllers\Foreground\Service;
/*
 * 购物相关控制器
 * */
use DB;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\Object;
use App\Models\Red;
use App\Models\Member;
use App\Models\AddMoneyRecord;
use App\Mspecs\M3Result;
use App\Http\Controllers\ForeController;

class ShoppingController extends ForeController {

    public function __construct()
    {
        parent::__construct();
        $this->cartModel  = new Cart();
        $this->goodsModel = new Goods();
        $this->objectModel = new Object();
        $this->redModel  = new Red();
        $this->memberModel = new Member();
        $this->addmoneyrecordModel = new AddMoneyRecord();
        $this->jsonMspecs = new M3Result();
    }
    
    /**
     * 添加购物车
     * @return string
     */
    public function addCart(){
        $g_id = $this->getParam('g_id');
        //查询是否存在该商品的购物车信息
        $info = $this->cartModel->where('usr_id', session('user.id'))
                                ->where('g_id', $g_id)
                                ->first();
        //获取该商品信息
        $goods = $this->goodsModel->find($g_id);
        
        //获取商品最新期数
        $periods = $this->objectModel->where('g_id', $g_id)->max('periods');

        if(empty($info)){  //不存在，插入购物车
            $this->cartModel->usr_id   =  session('user.id');
            $this->cartModel->g_id     =  $g_id;
            $this->cartModel->bid_cnt  =  $this->getParam('bid_cnt');
            $this->cartModel->periods  =  $periods;
            
            $result = $this->cartModel->save();
        }else{   
            //存在该商品的购物车记录，购买人次+1
            $info->bid_cnt += $this->getParam('bid_cnt');
            $info->periods  = $periods;
            $result = $info->save();
        }
        
        if($result){
            $list = $this->cartModel->getAllCart();
            session(['cart.list' => $list]);
            //添加成功，返回该用户购物车所有记录，刷新购物车显示信息
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '添加购物车成功';
            $this->jsonMspecs->data = array('count' => count($list), 'list' => $list);
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '添加购物车失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 更新购物车信息
     * @return string
     */
    public function updateCart(){
        $g_id = $this->getParam('g_id');
        $bid_cnt = $this->getParam('bid_cnt');
        $type = $this->getParam('type');    //type为0时，为直接修改数量，为1时增加一个，为2时减少一个
        
        $info = $this->cartModel->where('usr_id', session('user.id'))->where('g_id', $g_id)->first();
        if($info){
            if($type == 0){
                $info->bid_cnt = $bid_cnt;
                $result = $info->save();
            }else if($type == 1){   //并发较高，使用原生sql直接update
                $result = DB::update('update tab_shopping_cart set bid_cnt = bid_cnt + 1 where usr_id=:usr_id and g_id=:g_id', [':usr_id' => session('user.id'), ':g_id' => $g_id]);
            }else {
                if($info->bid_cnt <= 0)
                    $result = DB::update('update tab_shopping_cart set bid_cnt = 1 where usr_id=:usr_id and g_id=:g_id', [':usr_id' => session('user.id'), ':g_id' => $g_id]);
                else
                    $result = DB::update('update tab_shopping_cart set bid_cnt = bid_cnt - 1 where usr_id=:usr_id and g_id=:g_id', [':usr_id' => session('user.id'), ':g_id' => $g_id]);
            }
            
            if($result){
	            $info = $this->cartModel->where('usr_id', session('user.id'))->where('g_id', $g_id)->first();
                //更新session
                $list = $this->getAllCart();
                $list[$g_id]['bid_cnt'] = $info->bid_cnt;
                session(['cart.list' => $list]);

                //计算支付金额
                $pay = $this->getPayAmount();
                if(!empty($pay['red']) && $pay['red']['status'] != 0){
                    $this->jsonMspecs->status = -3;
                    $this->jsonMspecs->message = $pay['red']['msg'];
                }else{
                    $this->jsonMspecs->status = 0;
                    $this->jsonMspecs->message = '购买人次修改成功';
                }
                
                $total = $this->getTotalAmount();
                $this->jsonMspecs->data = array('total' => $total, 'pay_amount' => $pay['pay_amount'], 'pay_money' => $pay['pay_money'], 'pay_klbean' => $pay['pay_klbean']);
            }else{
                $this->jsonMspecs->status = -1;
                $this->jsonMspecs->message = '购物车更新失败';
            }
        }else{
            $this->jsonMspecs->status = -2;
            $this->jsonMspecs->message = '购物车获取失败，页面超时';
        }
        
        return $this->jsonMspecs->toJson();
    }    
    /**
     * 获取用户购物车信息
     * @return string
     */
    public function getCartList(){
        $list = $this->getAllCart();
        $total = $this->getTotalAmount();
        
        $this->jsonMspecs->status = 0;
        $this->jsonMspecs->message = '购物车拉取成功';
        $this->jsonMspecs->data = array('count' => count($list), 'list' => $list, 'total' => $total);
        
        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 删除购物车指定商品
     * @return string
     */
    public function deleteCart(){
        $g_id = $this->getParam('g_id');
        $g_ids = $this->getParam('g_ids');
        if($g_id){
            $g_ids = array($g_id);
        }
        
        $res = $this->cartModel->where('usr_id', session('user.id'))->whereIn('g_id', $g_ids)->delete();
//        if($res){
            //更新session
            $list = $this->getAllCart();
            $choose_list = session('cart.choose_ids');
            
            //更新购物车列表
            foreach ($g_ids as $id){
                if(isset($list[$g_id])){
                    unset($list[$g_id]);
                }
            }
            session(['cart.list' => $list]);
            
            $choose_list = array_diff($choose_list, $g_ids);   //更新已选中的商品session
            session(['cart.choose_ids' => $choose_list]);
            
            $total = $this->getTotalAmount();
            
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '购物车商品删除成功';
            $this->jsonMspecs->data = array('total' => $total);
//        }else{
//            $this->jsonMspecs->status = -1;
//            $this->jsonMspecs->message = '购物车商品删除失败';
//        }

        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 删除购物车表指定商品
     * @return string
     */
    public function clearCart($g_ids = array()){
        if(empty($g_ids)){
            $delete = $this->cartModel->where('usr_id', session('user.id'))->delete();
        }else{
            $delete = $this->cartModel->where('usr_id', session('user.id'))->whereIn('g_id', $g_ids)->delete();
        }
    }
    
    /**
     * 购物车商品勾选更新
     * @return string
     */
    public function updateChoose(){
        $g_ids = $this->getParam('g_ids', array());
        
        //更新session
        session(['cart.choose_ids' => $g_ids]);
        
        //获取支付金额
        $pay = $this->getPayAmount();
        if(!empty($pay['red']) && $pay['red']['status'] != 0){
            $this->jsonMspecs->status = -3;
            $this->jsonMspecs->message = $pay['red']['msg'];
        }else{
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '购买人次修改成功';
        }
        
        $total = $this->getTotalAmount();
        $this->jsonMspecs->data = array('total' => $total, 'pay_amount' => $pay['pay_amount'], 'pay_money' => $pay['pay_money'], 'pay_klbean' => $pay['pay_klbean']);

        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 获取购物车付款金额
     * @return string
     */
    private function getPayAmount(){
        //抵扣逻辑顺序，红包最先，余额最后
        //计算购物车所有商品的总金额
        $total = $this->getTotalAmount();
        $pay_amount = $total['total_amount'];
        
        //查询是否包含虚拟商品
        $has_virtual = 0;
        $choose_ids = session('cart.choose_ids');
        foreach ($choose_ids as $g_id){
            $g_info = Goods::find($g_id);
            if($g_info->is_virtual == 1){
                $has_virtual = 1;
                break;
            }
        }

	    $result = array();
	    $result['pay_money'] = $result['pay_klbean'] = 0.00;
	    $red = $this->getParam('red');
	    $klbean = $this->getParam('klbean');
	    if($red && $klbean){
		    $result['red']['status'] = -4;
		    $result['red']['message'] = '红包抵扣和块乐豆抵扣不能同时使用';
	    }else{
		    //红包抵扣逻辑
		    if($red){
			    if($has_virtual == 0){
				    $red_info = $this->redModel->leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')
					    ->where('tab_member_red.usr_id', session('user.id'))
					    ->where('tab_member_red.id', $red)
					    ->where('tab_member_red.status', 0)
					    ->first();
				    if($red_info){
					    if($red_info->xiaxian > $pay_amount){   //不满足使用最低消费金额
						    $result['red']['status'] = -2;
						    $result['red']['msg'] = '当前消费金额不满足该红包使用条件';
					    }else{
						    $pay_amount -= $red_info->money;
						    $result['red']['status'] = 0;
					    }
				    }else{
					    $result['red']['status'] = -1;
					    $result['red']['msg'] = '未找到该红包';
				    }
			    }else{
				    $result['red']['status'] = -3;
				    $result['red']['msg'] = '虚拟商品不能使用红包';
			    }
		    }

		    //块乐豆抵扣逻辑
		    if($klbean){
			    $member = $this->memberModel->where('usr_id', session('user.id'))->first();
			    if(intval($member->kl_bean/100) >= $pay_amount){
				    $result['pay_klbean'] = $pay_amount;
				    $pay_amount = 0;
			    }else{
				    $pay_amount = round(($pay_amount*100 - intval($member->kl_bean/100)*100)/100, 2);
				    $result['pay_klbean'] = intval($member->kl_bean/100);
			    }
		    }
	    }

	    //余额抵扣逻辑
	    $is_money = $this->getParam('is_money');
	    if($is_money && $pay_amount > 0){
		    $member = $this->memberModel->where('usr_id', session('user.id'))->first();
		    if($member->money >= $pay_amount){
			    $result['pay_money'] = $pay_amount;
			    $pay_amount = 0;
		    }else{
			    $pay_amount = round(($pay_amount*100 - $member->money*100)/100, 2);
			    $result['pay_money'] = $member->money;
		    }
	    }
        
        $result['pay_amount'] = $pay_amount;
        
        return $result;
    }
    
    /**
     * ajax刷新购物车付款金额
     * @return string
     */
    public function refreshPayAmount(){
        //抵扣逻辑顺序，红包最先，余额最后
        //计算购物车所有商品的总金额
        $total = $this->getTotalAmount();
        $pay_amount = $total['total_amount'];
        
        //查询是否包含虚拟商品
        $has_virtual = 0;
        $choose_ids = session('cart.choose_ids');
        foreach ($choose_ids as $g_id){
            $g_info = Goods::find($g_id);
            if($g_info->is_virtual == 1){
                $has_virtual = 1;
                break;
            }
        }
    
        $result = array();
        $result['pay_money'] = $result['pay_klbean'] = 0.00;
        $red = $this->getParam('red');
	    $klbean = $this->getParam('klbean');
	    if($red && $klbean){
		    $this->jsonMspecs->status = -4;
		    $this->jsonMspecs->message = '红包抵扣和块乐豆抵扣不能同时使用';
		    return $this->jsonMspecs->toJson();
	    }

	    //红包抵扣逻辑
        if($red){
            if($has_virtual == 0){
                $red_info = $this->redModel->leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')
                ->where('tab_member_red.usr_id', session('user.id'))
                ->where('tab_member_red.id', $red)
                ->where('tab_member_red.status', 0)
                ->first();
                
                if($red_info){
                    if($red_info->xiaxian > $pay_amount){   //不满足使用最低消费金额
                        $this->jsonMspecs->status = -2;
                        $this->jsonMspecs->message = '当前消费金额不满足该红包使用条件';
                    }else{
                        $pay_amount -= $red_info->money;
                        $result['red']['status'] = 0;
                    }
                }else{
                    $this->jsonMspecs->status = -1;
                    $this->jsonMspecs->message = '未找到该红包';
                }
            }else{
                $this->jsonMspecs->status = -3;
                $this->jsonMspecs->message = '虚拟商品不能使用红包';
            }
        }

	    $member = $this->memberModel->where('usr_id', session('user.id'))->first();
	    //块乐豆抵扣逻辑
	    if($klbean){
		    if(intval($member->kl_bean/100) >= $pay_amount){
			    $result['pay_klbean'] = $pay_amount;
			    $pay_amount = 0;
		    }else{
			    $pay_amount = round(($pay_amount*100 - intval($member->kl_bean/100)*100)/100, 2);
			    $result['pay_klbean'] = intval($member->kl_bean/100);
		    }
	    }
    
        //余额抵扣逻辑
        $is_money = $this->getParam('is_money');
        if($is_money && $pay_amount > 0){
            if($member->money >= $pay_amount){
                $result['pay_money'] = $pay_amount;
                $pay_amount = 0;
            }else{
                $pay_amount = round(($pay_amount*100 - $member->money*100)/100, 2);
                $result['pay_money'] = $member->money;
            }
        }
    
        $result['pay_amount'] = $pay_amount;
    
        $this->jsonMspecs->status = $this->jsonMspecs->status ? $this->jsonMspecs->status : 0;
        $this->jsonMspecs->message = $this->jsonMspecs->message ? $this->jsonMspecs->message : '购物车付款金额获取成功';
        $this->jsonMspecs->data = array('pay_amount' => $pay_amount, 'pay_money' => $result['pay_money'], 'pay_klbean' => $result['pay_klbean']);

        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 确认提交订单
     * @return string
     */
    public function orderSubmit(){
        @$g_ids    = $_POST['g_ids'];
        @$recharge = $_POST['recharge'];
        @$pay_type = $this->getParam('paytype');
        
        if(!empty($g_ids) && !empty(session('cart.choose_ids'))){
            session(['cart.choose_ids' => $g_ids]);
            
            $list = $this->getAllCart();
            $total = $this->getTotalAmount();
            $pay_amount = $total['total_amount'];
            
            //查询是否包含虚拟商品
            $has_virtual = 0;
            $choose_ids = session('cart.choose_ids');
            foreach ($choose_ids as $g_id){
                $g_info = Goods::find($g_id);
                if($g_info->is_virtual == 1){
                    $has_virtual = 1;
                    break;
                }
            }
            
            $order = array();
            
            $choose_list = array();
            foreach ($g_ids as $g_id){
                $choose_list[$g_id] = $list[$g_id];
                $order['cart_list'][] = array("g_id"=>intval($g_id), "periods"=>intval($list[$g_id]['cur_periods']), "bid_cnt"=>intval($list[$g_id]['bid_cnt']));
                unset($list[$g_id]);
            }
            
            //更新充值购物车session
            session()->forget('cart.choose_ids');
            session(['cart.list' => $list]);
            
            $red = $this->getParam('red');
	        $klbean = $this->getParam('klbean');
            $order['red_id'] = 0;
            $order['klbean'] = 0;

	        if($red && $klbean){
		        $this->jsonMspecs->status = -3;
		        $this->jsonMspecs->message = '红包抵扣和块乐豆抵扣不能同时使用';
		        return $this->jsonMspecs->toJson();
	        }else{
		        if($red && $has_virtual == 0){
			        $red_info = $this->redModel->leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')
				        ->where('tab_member_red.usr_id', session('user.id'))
				        ->where('tab_member_red.id', $red)
				        ->where('tab_member_red.status', 0)
				        ->first(['tab_member_red.*', 'tab_redbao.xiaxian', 'tab_redbao.money']);

			        if($red_info && $red_info->xiaxian <= $pay_amount){  //满足红包抵扣条件
				        $pay_amount -= $red_info->money;
				        $order['red_id'] = $red_info->id;
			        }
		        }

		        //块乐豆抵扣逻辑
		        if($klbean){
			        $member = $this->memberModel->where('usr_id', session('user.id'))->first();
			        if(intval($member->kl_bean/100) >= $pay_amount){
				        $pay_amount = 0;
				        $pay_type = 'yue';
			        }else{
				        $pay_amount = round(($pay_amount*100 - intval($member->kl_bean/100)*100)/100, 2);
			        }
			        $order['klbean'] = 1;
		        }
	        }
            
            $is_money = $this->getParam('is_money');
            if($is_money && $pay_amount > 0){
                $member = $this->memberModel->where('usr_id', session('user.id'))->first();
                if($member->money > 0){
                    if($member->money >= $pay_amount){
                        $pay_amount = 0;
                        $pay_type = 'yue';
                    }else{
                        $pay_amount = round(($pay_amount*100 - $member->money*100)/100, 2);
                    }
                }
            }
            
            //创建订单
            $code = $this->createCode();
            $this->addmoneyrecordModel->usr_id = session('user.id');
            $this->addmoneyrecordModel->code = $code;
            $this->addmoneyrecordModel->money = $pay_amount;
            $this->addmoneyrecordModel->pay_type = $pay_type;
            $this->addmoneyrecordModel->status = 0;
            $this->addmoneyrecordModel->time = time();
            $this->addmoneyrecordModel->scookies = json_encode($order);
            $this->addmoneyrecordModel->type = 'buy';
            $this->addmoneyrecordModel->expired_time = time() + 1800;   //30分钟未支付过期
            
            if($this->addmoneyrecordModel->save()){
                $this->jsonMspecs->status = 0;
                $this->jsonMspecs->message = '订单创建成功';
                $this->clearCart($g_ids);  //删除购物车中已创建订单的商品
                $html = $this->creatPayHtml($pay_type, $code);
                $this->jsonMspecs->data = array('form' => $html);
            }else{
                $this->jsonMspecs->status = -1;
                $this->jsonMspecs->message = '订单创建失败';
            }
        }elseif(!empty($recharge)){
            $recharge_money = $this->getParam('recharge_money', 0);
            //创建订单
            $code = $this->createCode();
            $this->addmoneyrecordModel->usr_id = session('user.id');
            $this->addmoneyrecordModel->code = $code;
            $this->addmoneyrecordModel->money = $recharge_money;
            $this->addmoneyrecordModel->pay_type = $pay_type;
            $this->addmoneyrecordModel->status = 0;
            $this->addmoneyrecordModel->time = time();
            $this->addmoneyrecordModel->type = 'charge';
            $this->addmoneyrecordModel->expired_time = time() + 1800;   //30分钟未支付过期
            
            if($this->addmoneyrecordModel->save()){
                $this->jsonMspecs->status = 0;
                $this->jsonMspecs->message = '订单创建成功';
                $html = $this->creatPayHtml($pay_type, $code);
                $this->jsonMspecs->data = array('form' => $html);
            }else{
                $this->jsonMspecs->status = -1;
                $this->jsonMspecs->message = '订单创建失败';
            }
		}else{
            $this->jsonMspecs->status = -2;
            $this->jsonMspecs->message = '重复提交';
        }
        
        return $this->jsonMspecs->toJson();
    }
	
	public function creatPayHtml($type, $code = ''){
	    if($type == 'weixin'){
	        $action = '/weixin/pay';
	    }else if($type == 'unionpay'){
	        $action = '/unionpay/pay';
	    }else if($type == 'jdpay'){
		    $action = '/jdpay/pay';
	    }else if($type == 'yue'){
	        $action = '/money/pay';
	    }
	    
		$html  = '<form action="'.$action.'" method="post" style="display:none" id="subform">';
		$html .= '<input type="text" name="code" value="'.$code.'">';
		$html .= csrf_field();
		$html .= '<input type="submit" value="提交" id="pay_sub">';
		$html .= '</form>';

		return $html;
	}
	
	
	private function createCode(){
	    $time = date('YmdHis');
	    $numstr = $this->getNonceStr(8, 2);
        $code = $time.$numstr;
        
	    return $code;
	}
}