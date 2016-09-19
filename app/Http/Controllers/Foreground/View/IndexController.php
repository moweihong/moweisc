<?php
/*
m1 add by tangzhe 2016-08-10 增加首页邀请注册
*/
namespace App\Http\Controllers\Foreground\View;
use App\Facades\ProductRepositoryFacade;
use App\Facades\OrderRepositoryFacade;
use App\Facades\UserRepositoryFacade;
use App\Models\Article;
use App\Models\Article_cat;
use App\Models\Link;
use App\Models\Goods;
use App\Models\Order;
use App\Models\Bid_record;
use App\Models\Recharge;
use Log;
use App\Http\Tools\Recharge\RechargeMobile;
use App\Http\Controllers\ForeController;
use App\Facades\IndexRepositoryFacade;
use Cookie;
use DB;
class IndexController extends ForeController
{
    //首页
    public function index()
    {    
        $data = array();
        //轮播
        $data['slide'] = IndexRepositoryFacade::findSlide();//0.08S
		invite_code(); //M1 
        return view('foreground.index', array('data' => $data,'is_mobile' => 1, 'invite_code_m' => 0));
    }


    //新手指南页面
    public function guide()
    {
    	$model=new Goods();
    	$data['shopCheap']=$model->getCheapShop();
        return view('foreground.guide',$data);
    }
	
	 //APP下载页面
    public function app()
    {
        return view('foreground.app');
    }

    //最新揭晓页面

    public function announcement()
    {
        $data=ProductRepositoryFacade::findAnnouncement(6);
        $paginate=$data['paginate'];
        $data['goods']=$data['goods'];
        $data['goods_cp']=$data['goods'];
        $data['goods']=$data['goods']['data'];
        foreach ($data['goods'] as $k=>$v){
            $data['goods'][$k]['fetchuser']=OrderRepositoryFacade::findFetchUser($v['id']);
            if(!empty($data['goods'][$k]['fetchuser'])){
                $userinfo=UserRepositoryFacade::findUserInfo($data['goods'][$k]['fetchuser'][0]['usr_id']);
                //多次购买的总数
                $data['goods'][$k]['fetchuser'][0]['buycount'] = Order::where(['o_id'=>$data['goods'][$k]['id'],'usr_id'=>$data['goods'][$k]['fetchuser'][0]['usr_id']])->sum('buycount');
                $data['goods'][$k]['fetchuser'][0]['nickname']=!empty($userinfo['nickname'])?$userinfo['nickname']:config('global.default_nickname');
				$data['goods'][$k]['fetchuser'][0]['usr_id']=$data['goods'][$k]['fetchuser'][0]['usr_id'];
                $data['goods'][$k]['fetchuser'][0]['user_photo']=!empty($userinfo['user_photo'])?$userinfo['user_photo']:config('global.default_photo');
                $data['goods'][$k]['fetchuser'][0]['bid_time']=date('Y年m月d日 H:i',floor($data['goods'][$k]['fetchuser'][0]['bid_time']/1000));
                //计算回报率
                $data['goods'][$k]['fetchuser'][0]['rate']=sprintf("%.2f", round($data['goods'][$k]['total_person']/$data['goods'][$k]['fetchuser'][0]['buycount'],2));
            }
        }
        $data['goods_cp']['data']=$data['goods'];
        $data['goods']=$data['goods_cp'];
        unset($data['goods_cp']);
        $data['goods_right']=ProductRepositoryFacade::findOverPlusGoods(2);
        $data['latest_count']= IndexRepositoryFacade::findLatestCount();
        return view('foreground.announcement',array('data'=>$data,'paginate'=>$paginate));
    }

    //客服页面
    public function customer()
    {
        return view('foreground.customer');
    }
    /*
     * 帮助中心
     */
    public function help($id)
    {
        $article = Article::where(['article_id'=>$id,'article_type'=>2])->first();
        if($id == 3){//常见问题            
            $articleCats = Article_cat::where('cat_type',2)->orderBy('sort_order', 'desc')->get();
            $questionCats = Article_cat::where('cat_type',4)->orderBy('sort_order', 'desc')->get();
            return view('foreground.question',['article'=>$article,'articleCats'=>$articleCats,'questionCats'=>$questionCats]);
        }else{
            $articleCats = Article_cat::where('cat_type',2)->orderBy('sort_order', 'desc')->get();
            return view('foreground.question',['article'=>$article,'articleCats'=>$articleCats]);
        }
    }
    /*
     * 友情链接
     */
    public function friendLink(){
        $links = Link::all();
        return view('foreground.link',['links'=>$links]);
    }
    /*
     * 公告栏
     */
    public function noticeBoard($id){
        $article = Article::find($id);
        $articles = Article::where('article_type',3)->orderBy('updated_at', 'desc')->paginate(10);
        return view('foreground.noticeboard',['article'=>$article,'articles'=>$articles]);
    }

    //获取最新一百条购买记录
    public function getLatestRecord()
	{
		$data['list'] =Bid_record::
        where('status','<>','0')
       ->where('pay_type','!=','invite')
	   ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
       ->select('tab_bid_record.*','tab_member.nickname')
	   ->orderBy('tab_bid_record.id', 'desc')
	   ->take(100)
	   ->get();
		return view('foreground.latestrecord',$data);
	}
    
	//获取历史购买记录
	public function getHistoryRecord()
	{
		$data['list'] =Bid_record::
        where('status','<>','0')
        ->where('pay_type','!=','invite')
        ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
        ->select('tab_bid_record.*','tab_member.nickname')
	    ->orderBy('tab_bid_record.id', 'desc')
        ->paginate(100);
		return view('foreground.historyrecord',$data);				
	}
	
	public function searchRecord()
	{
        if(empty($_POST['stime'])||empty($_POST['etime'])){
            return redirect('getHistoryRecord');
        }
		$stime=isset($_POST['stime'])?strtotime($_POST['stime'])*1000:0;
		$etime=isset($_POST['etime'])?strtotime($_POST['etime'])*1000:0;
		if($stime!=0 && $etime!=0)
		{
			session(['stime'=>$stime]);
		    session(['etime'=>$etime]);
		}
		if($stime==0 && $etime==0)
		{
			$stime=session('stime');
			$etime=session('etime');
		}
		$data['stime']=date('Y/m/d h:i:s',$stime/1000);
		$data['etime']=date('Y/m/d h:i:s',$etime/1000);
		$data['list'] =Bid_record::
        where('status','<>','0')
	   ->where('bid_time','<',$etime)
	   ->where('bid_time','>',$stime)
	   ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
       ->select('tab_bid_record.*','tab_member.nickname')
	   ->orderBy('tab_bid_record.id', 'desc')
       ->paginate(100);
	   //print_r($data['list']);
		return view('foreground.historyrecord',$data);	
		
	}
	
	public function getSysTime(){
	    return response()->json(array('time' => date('Y/m/d H:i:s')));
	}
	
    /*
     * 99话费自动充值接口回调
     */
	public function recharge(){
        $_99dou = new RechargeMobile();

        $array = array();
        foreach($_POST   as   $key   =>   $value)   { 
            $array[$key] = $value;
        } 
        //print_r($array);

        $msg = "";
        $success_qty = 0;
        $fail_qty = 0;
        $out_trade_id = "";
        Log::info("99话费自动充值",$array);
        $r = $_99dou->VerifyNotify($array, $out_trade_id, $success_qty, $fail_qty, $msg);
        $array['out_trade_id']=$out_trade_id;
        $array['success_qty']=$success_qty;
        $array['fail_qty']=$fail_qty;
        Log::info("99话费自动充值",$array);
        $recharge = Recharge::where('trade_id',$out_trade_id)->update('log_msg',  serialize($array));
	}

	/**
	 * 网站维护页面
	 */
	public function maintain(){
		return view('foreground.maintain');
	}
}
