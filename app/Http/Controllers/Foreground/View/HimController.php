<?php
namespace App\Http\Controllers\Foreground\View;
use App\Facades\ProductRepositoryFacade;
use App\Facades\OrderRepositoryFacade;
use App\Facades\UserRepositoryFacade;
use App\Models\Goods;
use App\Models\Order;
use App\Models\Bid_record;
use App\Models\ShowOrder;
use App\Models\Member;
use App\Models\AddMoneyRecord;
use App\Http\Controllers\ForeController;
use App\Facades\IndexRepositoryFacade;
use Request;
use View;
use DB;

class HimController extends ForeController
{
	
	
	public function index($uid)
	{
		$list = Order::where('usr_id',$uid)->where('status','>=','2')
                ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                ->orderBy('id','desc')
                ->select('tab_bid_record.*','is_lottery')->paginate(10);
        $himinfo=$this->gethiminfo($uid);
		$data['himinfo']=$himinfo;
		$data['list']=$list;
		$data['type']=0;
        return view('foreground.him_account_buy_record',$data);
	}
	
	 //夺宝记录
    public function  buyRecord($uid){
        
        $list = Order::where('usr_id',$uid)->where('status','>=','2')
                ->join('tab_object','tab_object.id', '=','tab_bid_record.o_id')
                ->orderBy('id','desc')
                ->select('tab_bid_record.*','is_lottery')->paginate(10);
		
        $himinfo=$this->gethiminfo($uid);
		$data['himinfo']=$himinfo;
		$data['list']=$list;
		$data['type']=0;
        return view('foreground.him_account_buy_record',$data);
    }

	//中奖记录 
    public function  prizeRecord($uid){
        $list =Order::where('usr_id',$uid)->where('fetchno', '>', 0)->orderBy('id','desc')->paginate(10);
        $himinfo=$this->gethiminfo($uid);
		$data['himinfo']=$himinfo;
		$data['list']=$list;
		$data['type']=0;
        return view('foreground.him_account_prize_record',$data);
    }

	//晒单列表
	public function show($uid)
	{

		$himinfo=$this->gethiminfo($uid);
		$data['himinfo']=$himinfo;
		//print_r($himinfo);exit;
    	$model=new ShowOrder();
		$data['myshow']=$model->getHisShow($uid);
		//print_r($data['noshow']);exit;
        return view('foreground.him_account_show_record',$data);
	}

	public function gethiminfo($uid)
	{
		$himinfo=Member::where('usr_id',$uid)->first();
		return $himinfo;
	}
		
}
?>
	