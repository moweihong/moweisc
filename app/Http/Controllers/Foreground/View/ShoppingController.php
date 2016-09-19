<?php
namespace App\Http\Controllers\Foreground\View;
/*
 * 购物相关控制器
 * */
use App\Models\Red;
use App\Models\Cart;
use App\Models\Member;
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
        //获取用户的相关信息，包括红包、购物卡、余额
        $user = $this->memberModel->where('usr_id', session('user.id'))->first()->toArray();
        $red  = $this->redModel->getRedList();
        
        session(['user.info' => $user]);
        session(['user.red' => $red]);

        //获取用户所有购物车记录
        $list = $this->cartModel->getAllCart();

        //保存session
        session(['cart.list' => $list]);

        session(['cart.choose_ids' => array_keys($list)]);
        
        //计算所有总价格
        $total = $this->getTotalAmount();
        $total_amount = $total['total_amount'];
        
        return view ('foreground.shopcart', array('list' => $list, 'user' => $user, 'red' => $red, 'total_amount' => $total_amount));
    }

}