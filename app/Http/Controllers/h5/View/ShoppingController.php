<?php
namespace App\Http\Controllers\h5\View;
/*
 * 购物相关控制器
 * */
use App\Models\Red;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Object;
use App\Http\Controllers\ForeController;

class ShoppingController extends ForeController {

    public function __construct()
    {
        parent::__construct();
        $this->memberModel = new Member();
        $this->cartModel = new Cart();
        $this->redModel  = new Red();
    }

    public function mycart(){
        $data = array();
        if(empty(session('cart.list')) || empty(session('user.info')) || empty(session('user.red'))){
            //获取用户所有购物车记录
            $list = $this->cartModel->getAllCart();
            //保存session
            session(['cart.list' => $list]);
        }else{
            $list = session('cart.list');
        }

        session(['cart.choose_ids' => array_keys($list)]);
        
        //计算所有总价格
        $total = $this->getTotalAmount();
        $total_amount = $total['total_amount'];
        
        if(empty($list)){
            return $this->mycart_m_empty();
        }
        
        return view ('h5.mycart_m', array('list' => $list, 'total_amount' => $total_amount));
    }
	
	 public function mycart_m_empty(){
	     //一元夺宝最快揭晓的的商品
	     $objects = Object::leftjoin('ykg_goods', 'ykg_goods.id', '=', 'tab_object.g_id')->where('tab_object.is_lottery', 0)->orderBy('tab_object.end_time', 'asc')->skip(0)->take(3)->get(['ykg_goods.*', 'tab_object.id as oid', 'tab_object.participate_person', 'tab_object.total_person']);
	     foreach ($objects as &$obj){
	         $obj->rate = floor(round($obj->participate_person/$obj->total_person, 4) * 100);
	     }
	     
		 return view ('h5.mycart_m_empty', array('objects' => $objects));
	 }

}