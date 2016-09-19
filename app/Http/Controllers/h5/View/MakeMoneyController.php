<?php
namespace App\Http\Controllers\h5\view;


use App\Http\Controllers\ForeController;
class MakeMoneyController extends ForeController {


    public function makeMoney(){
    	if(session('user.id'))
		{
			$data['longintrue']=base64_encode(session('user.id'));
			$data['url']=$_SERVER['HTTP_HOST'].'/freeday?code='.session('user.id');
		}
		else
		{
			$data['longintrue']=0;
			$data['url']='亲，你还没登录啦';
		}
        return view('h5.make_money_m',$data);
    }
	
	public function partner(){
        return view('h5.partner');
    }
}