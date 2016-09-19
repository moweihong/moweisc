<?php
namespace App\Http\Controllers\h5\Service;
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
	 * 更新购物车
	 * @return string
	 */
	public function updateCart(){
		$g_id = $this->getParam('g_id', 0);
		$bid_cnt = $this->getParam('bid_cnt', 0);
		$type = $this->getParam('type', 0);

		$info = $this->cartModel->where('usr_id', session('user.id'))->where('g_id', $g_id)->first();
		if($g_id && $bid_cnt && !empty($info)){
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
				$this->jsonMspecs->status = 0;
				$this->jsonMspecs->message = '更新成功';
			}else{
				$this->jsonMspecs->status = -2;
				$this->jsonMspecs->message = '服务器异常';
			}

			return $this->jsonMspecs->toJson();
		}else{
			$this->jsonMspecs->status = -1;
			$this->jsonMspecs->message = '请求参数错误';
			return $this->jsonMspecs->toJson();
		}
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
        if($res){
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
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '购物车商品删除失败';
        }

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
     * 创建订单
     * @return string
     */
    public function createOrder(){
        $g_ids = $this->getParam('g_ids');
        
        if(!empty($g_ids)){
            $scookies = array();
            $total_amount = 0;
            foreach ($g_ids as $key => $val){
                $scookies['cart_list'][] = array('g_id' => intval($key), 'periods' => 0, 'bid_cnt' => intval($val['bid_cnt']));
                $total_amount += intval($val['bid_cnt']) * intval($val['minimum']);
            }
            $scookies['red_id'] = 0;
	        $scookies['klbean'] = 0;
            
            //创建订单
            $code = $this->createCode();
            $this->addmoneyrecordModel->usr_id = session('user.id');
            $this->addmoneyrecordModel->code = $code;
            $this->addmoneyrecordModel->money = 0;
            $this->addmoneyrecordModel->pay_type = '';
            $this->addmoneyrecordModel->status = 0;
            $this->addmoneyrecordModel->time = time();
            $this->addmoneyrecordModel->scookies = json_encode($scookies);
            $this->addmoneyrecordModel->type = 'buy';
            $this->addmoneyrecordModel->expired_time = time() + 1800;   //30分钟未支付过期
            $this->addmoneyrecordModel->source = 'wap';
            
            if($this->addmoneyrecordModel->save()){
                $this->jsonMspecs->status = 0;
                $this->jsonMspecs->message = '订单创建成功';
                $this->jsonMspecs->data = $this->creatPayHtml($code);
                //$this->clearCart();  //删除购物车
            }else{
                $this->jsonMspecs->status = -1;
                $this->jsonMspecs->message = '订单创建失败';
            } 
        }else{
            $this->jsonMspecs->status = -2;
            $this->jsonMspecs->message = '购物车为空';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    /**
     * 充值提交
     */
    public function chargeSubmit(){
        $pay_type = $this->getParam('paytype');
        $recharge_money = $this->getParam('recharge_money', 0);
        if($pay_type){
	        if($pay_type == 'weixin' && !$this->is_weixin()){   //非微信浏览器使用微信支付跳转提示页
		        $this->jsonMspecs->status = 0;
		        $this->jsonMspecs->message = 'unsuport';
		        $html = $this->creatPayHtml('000000', '/weixin_m/unsuport');
		        $this->jsonMspecs->data = array('form' => $html);
		        return $this->jsonMspecs->toJson();
	        }

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
            $this->addmoneyrecordModel->source = 'wap';
    
            if($this->addmoneyrecordModel->save()){
                $this->jsonMspecs->status = 0;
                $this->jsonMspecs->message = '充值订单创建成功';
                
                if($pay_type == 'weixin'){
                    $action = '/weixin_m/pay/';
                }else if($pay_type == 'unionpay'){
                    $action = '/unionpay_m/pay';  //银联支付pc和wap接口统一
                }else if($pay_type == 'weixin_app'){
                    $action = '/weixin_app/pay';
                }else if($pay_type == 'alipay'){
                    $action = '/alipay_m/pay';
                }
                
                $html = $this->creatPayHtml($code, $action);
                $this->jsonMspecs->data = array('form' => $html);
            }else{
                $this->jsonMspecs->status = -1;
                $this->jsonMspecs->message = '订单创建失败';
            }
            
            return $this->jsonMspecs->toJson();
        }else{
            echo view('errors.h5_403');
            exit();
        }
    }
	
	public function creatPayHtml($code, $action = '/pay_m'){
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