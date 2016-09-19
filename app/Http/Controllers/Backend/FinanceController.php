<?php
namespace App\Http\Controllers\Backend;
use App\Models\AddMoneyRecord;
use App\Models\Bid_record;
use Request,Validator;
use App\Http\Controllers\BaseController;
use DB;
use App\Http\Controllers\Backend\Common\pageclass;
use App\Http\Controllers\Backend\Common\FunController;
use Excel;
use Session;
use App\Models\Red;
use App\Models\Rotarylog;
use App\Models\Rotaryprize;
use App\Models\Object;
class FinanceController extends BaseController
{
    //充值记录
    public function chage(Request $request)
    {
    	//$uid=1887;
//		$sql='select `tab_member_addmoney_record`.*, `tab_member`.`mobile`, `tab_member`.`nickname` from `tab_member_addmoney_record` 
//		inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id` where `tab_member_addmoney_record`.`money` <> 0 order by `tab_member_addmoney_record`.`id` desc';
//  	$result=DB::select($sql);
//		dd($result);
//		$page=isset($_GET['page'])?$_GET['page']:1;
//		$page=new pageclass(130,$page);
//		$res=$page->GetPagerContent();
//		echo $res;exit;
		$request::session()->forget('chage');
		$url['type']='chage';
		$data['url']=http_build_query($url);
   		$chagelist = AddMoneyRecord::
	    where('tab_member_addmoney_record.money','<>','0')
		->wherein('tab_member_addmoney_record.status',[1,4])
	   ->join('tab_member','tab_member.usr_id','=','tab_member_addmoney_record.usr_id')
       ->select('tab_member_addmoney_record.*','tab_member.mobile','tab_member.nickname')
	   ->orderBy('tab_member_addmoney_record.id','desc')
       ->paginate(50);
	   $data['chagelist']=$chagelist;
	    $data['allmoney'] = AddMoneyRecord::
	    where('tab_member_addmoney_record.money','<>','0')
		->whereIn('tab_member_addmoney_record.status',[1,4])
		->sum('money');
	   return view('backend.finance.chagelist',$data);
    }
	
    //消费记录  
	public function buy(Request $request)
    {
    	$request::session()->forget('buy');
		$url['type']='buy';
		$data['url']=http_build_query($url);
   		$chagelist = Bid_record::
	    where('tab_bid_record.status','<>','0')
	    //->join('tab_member','tab_member.usr_id','=','tab_member_addmoney_record.usr_id')
		->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
        ->select('tab_bid_record.*','tab_member.mobile','tab_member.nickname')
	    ->orderBy('tab_bid_record.id','desc')
        ->paginate(50);
		
	    $data['chagelist']=$chagelist;
	   $data['allmoney'] = AddMoneyRecord::
			    where('tab_member_addmoney_record.money','<>','0')
		        ->wherein('tab_member_addmoney_record.status',[1,4,5])
				->where('type','buy')
				->sum('amount');
	   return view('backend.finance.buylist',$data);
    }  
	
	//中奖记录
	public function lottery(Request $request)
    {
   		 $chagelist = AddMoneyRecord::
	     where('tab_member_addmoney_record.type','lottery')
	   ->join('tab_member','tab_member.usr_id','=','tab_member_addmoney_record.usr_id')
       ->select('tab_member_addmoney_record.*','tab_member.mobile','tab_member.nickname')
	   ->orderBy('tab_member_addmoney_record.id','desc')
       ->paginate(50);
	   $data['chagelist']=$chagelist;
	   
	   return view('backend.finance.lotterylist',$data);
    } 

	//搜索
	public function search(Request $request)
	{
		$sessions = $request::session()->all();
		
		if($request::isMethod('post'))
		{
			
			if($_POST['type']=="chage")//充值
			{
				$request::session()->forget('chage');
				if($_POST['end_time']){@session(['chage.endtime'    => $_POST['end_time']]);$chage_endtime=strtotime($_POST['end_time']);}
				if($_POST['start_time']){@session(['chage.starttime'    => $_POST['start_time']]);$chage_starttime=strtotime($_POST['start_time']);}
				if($_POST['phonenum']){@session(['chage.phonenum'    => $_POST['phonenum']]);$chage_phonenum=$_POST['phonenum'];}
				if($_POST['pay_type']!='false'){@session(['chage.paytype'    => $_POST['pay_type']]);$chage_paytype=$_POST['pay_type'];}
			}
			if($_POST['type']=="buy")//消费
			{
				$request::session()->forget('buy');
				if($_POST['end_time']){@session(['buy.endtime'    => $_POST['end_time']]);$buy_endtime=strtotime($_POST['end_time'])*1000;}
				if($_POST['start_time']){@session(['buy.starttime'    => $_POST['start_time']]);$buy_starttime=strtotime($_POST['start_time'])*1000;}
				if($_POST['phonenum']){@session(['buy.phonenum'    => $_POST['phonenum']]);$buy_phonenum=$_POST['phonenum'];}
				if($_POST['shopname']){@session(['buy.shopname'    => $_POST['shopname']]);$buy_shopname=$_POST['shopname'];}
				if($_POST['qishu']){@session(['buy.qishu'    => $_POST['qishu']]);$buy_qishu=$_POST['qishu'];}
			}

			if($_POST['type']=="lottery")//红包中奖
			{
				$request::session()->forget('lottery');
				if($_POST['end_time']){@session(['lottery.endtime'    => $_POST['end_time']]);$lottery_endtime=strtotime($_POST['end_time'])*1000;}
				if($_POST['start_time']){@session(['lottery.starttime'    => $_POST['start_time']]);$lottery_starttime=strtotime($_POST['start_time'])*1000;}
			}
			
			//print_r($_POST['pay_type']);
			@session(['type'  => $_POST['type']]);
			$type=$_POST['type'];
			//if(session('phonenum')){echo  111;};exit;
			
		}
		else
		{
			if(empty(session('type')))
			{
				echo '搜索条件过期了，请重新查询咯，亲';//session出问题了			
				exit;
			}
			else
			{
				$type=session('type');
				//充值
				if($type=="chage")
				{
					if(session('chage.endtime')){$chage_endtime=strtotime(session('chage.endtime'));}
					if(session('chage.starttime')){$chage_starttime=strtotime(session('chage.starttime'));}
					if(session('chage.phonenum')){$chage_phonenum=session('chage.phonenum');}
					if(session('chage.paytype')){$chage_paytype=session('chage.paytype');}
				}
				//消费
				if($type=="buy")
				{
					if(session('buy.endtime')){$buy_endtime=strtotime(session('buy.endtime'))*1000;}
					if(session('buy.starttime')){$buy_starttime=strtotime(session('buy.starttime'))*1000;}
					if(session('buy.phonenum')){$buy_phonenum=session('buy.phonenum');}
					if(session('buy.shopname')){$buy_shopname=session('buy.shopname');}
					if(session('buy.qishu')){$buy_qishu=session('buy.qishu');}
				}
				if($type=="lottery")
				{
					if(session('lottery.endtime')){$lottery_endtime=strtotime(session('lottery.endtime'))*1000;}
					if(session('lottery.starttime')){$lottery_starttime=strtotime(session('lottery.starttime'))*1000;}
				}
				
			
			}
			
		}
		
		$page=isset($_GET['page'])?$_GET['page']:1;
		$limit=50;
		$offset=$limit*($page-1);
		//var_dump(session('endtime'));
		//echo $type;exit;
    switch($type)
		{
			case "chage":
				//var_dump($chage_paytype);
				$url['type']='chage';
				$where='';
				if(isset($chage_starttime) && isset($chage_endtime)){$where=$where.' and `tab_member_addmoney_record`.`time` >='.$chage_starttime. ' and `tab_member_addmoney_record`.`time`<'.$chage_endtime;$url['endtime']=$chage_endtime;$url['starttime']=$chage_starttime;}
				if(isset($chage_phonenum)){$where=$where.' and `tab_member`.`mobile`='.$chage_phonenum; $url['phonenum']=$chage_phonenum;}
				if(isset($chage_paytype)){$where=$where.' and `tab_member_addmoney_record`.`pay_type`="'.$chage_paytype.'"';$url['paytype']=$chage_paytype;}
				$sql='select `tab_member_addmoney_record`.*, `tab_member`.`mobile`, `tab_member`.`nickname` from `tab_member_addmoney_record` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id` where `tab_member_addmoney_record`.`money` <> 0 and `tab_member_addmoney_record`.`status` in (1,4,5)  '.$where.' order by `tab_member_addmoney_record`.`id` desc limit '.$offset.','.$limit;
		    	
		    	$chagelist=DB::select($sql);
				$data['chagelist']=$chagelist;
				//总金融
				$data['allmoney'] = AddMoneyRecord::
			    where('tab_member_addmoney_record.money','<>','0')
		        ->wherein('tab_member_addmoney_record.status',[1,4,5])
				->sum('money');
			    //echo $sql;
				//分页
				$sql2='select count(*) as num from `tab_member_addmoney_record` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id` where `tab_member_addmoney_record`.`money` <> 0 and `tab_member_addmoney_record`.`status` in (1,4,5) '.$where;
				$countobj=DB::select($sql2);
				$num=$countobj[0]->num;
				//echo $num;
				//echo $page;
	        	$page=new pageclass($num,$page);
				$data['page']=$page->GetPagerContent();
				
				$data['url']=http_build_query($url);
				$view='backend.finance.chagelist';
				break;
			case 'buy':
			    $url['type']='buy';
				$where='';
				if(isset($buy_starttime) && isset($buy_endtime)){$where=$where.' and `tab_bid_record`.`bid_time` >'.$buy_starttime. ' and `tab_bid_record`.`bid_time`<'.$buy_endtime;$url['endtime']=$buy_endtime;$url['starttime']=$buy_starttime;}
				if(isset($buy_phonenum)){$where=$where.' and `tab_member`.`mobile`='.$buy_phonenum; $url['phonenum']=$buy_phonenum;}
				if(isset($buy_shopname)){$where=$where.' and `tab_bid_record`.`g_id`="'.$buy_shopname.'"';$url['shopname']=$buy_shopname;}
				if(isset($buy_qishu)){$where=$where.' and `tab_bid_record`.`g_periods`="'.$buy_qishu.'"';$url['qishu']=$buy_qishu;}
				
				$sql='select `tab_bid_record`.*, `tab_member`.`mobile`, `tab_member`.`nickname` from `tab_bid_record` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` where `tab_bid_record`.`status` <> 0'.$where.' order by `tab_bid_record`.`id` desc limit '.$offset.','.$limit;
				//echo $sql;exit;
				$chagelist=DB::select($sql);
				//print_r($chagelist);exit;
				foreach($chagelist as $key=>$val)
				{
					$goodprice=Object::where('id',$val->o_id)->select('minimum')->first();
					$chagelist[$key]->buycount=$val->buycount*$goodprice['minimum'];
				}
			
				$data['chagelist']=$chagelist;
				
				//消费总额
				$data['allmoney'] = AddMoneyRecord::
	    		where('bid','<>','')->where('status',1)
				->sum('amount');
				
				//分页
				$sql2='select count(*) as num from `tab_bid_record` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` where `tab_bid_record`.`status` <> 0'.$where;
				$countobj=DB::select($sql2);
				$num=$countobj[0]->num;
				//echo $num;exit;
				
	        	$page=new pageclass($num,$page);
				$data['page']=$page->GetPagerContent();
				
				$data['url']=http_build_query($url);
				$view='backend.finance.buylist';
				
				
				break;
			case 'lottery':
				$chagelist = AddMoneyRecord::where('tab_member_addmoney_record.type','lottery');
				isset($lottery_starttime) && $chagelist=$chagelist->where('tab_member_addmoney_record.time','>',$lottery_starttime);
		  		isset($lottery_endtime) && $chagelist=$chagelist->where('tab_member_addmoney_record.time','<',$lottery_endtime);
			  
	      $chagelist=$chagelist->join('tab_member','tab_member.usr_id','=','tab_member_addmoney_record.usr_id')
        ->select('tab_member_addmoney_record.*','tab_member.mobile','tab_member.nickname')
	      ->orderBy('tab_member_addmoney_record.id','desc')
        ->paginate(50);
	      $data['chagelist']=$chagelist;
				$view='backend.finance.lotterylist';
				break;
			default:
				break;
			
		}	
		
		return view($view,$data);
	}

	public function export(){
//	$data=array('ab'=>1,'a'=>1,'b'=>1);
//	echo http_build_query($data);
	
	$where='';
	if($_GET['type']=='chage')
	{
		if(isset($_GET['starttime']) && isset($_GET['endtime'])){$where=$where.' and `tab_member_addmoney_record`.`pay_time` >='.$_GET['starttime']. ' and `tab_member_addmoney_record`.`pay_time`<'.$_GET['endtime'];}
		if(isset($_GET['phonenum'])){$where=$where.' and `tab_member`.`mobile`='.$_GET['phonenum'];}
		if(isset($_GET['paytype'])){$where=$where.' and `tab_member_addmoney_record`.`pay_type`="'.$_GET['paytype'].'"';}
		$sql='select `tab_member_addmoney_record`.code, `tab_member_addmoney_record`.money,`tab_member_addmoney_record`.pay_type,`tab_member`.`mobile`, `tab_member`.`nickname`,FROM_UNIXTIME(`tab_member_addmoney_record`.`pay_time`,"%Y年%m月%d日%H时%i分%s秒") as time from `tab_member_addmoney_record` inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id` where `tab_member_addmoney_record`.`money` <> 0 and `tab_member_addmoney_record`.`status` in (1,4,5)  '. $where.' order by `tab_member_addmoney_record`.`id` desc ';
		$array=array('订单号','充值金额','充值来源','手机号码','用户名','时间');
		$name='充值';
	}
	else if($_GET['type']=='buy')
	{
		$where='';
		if(isset($_GET['starttime']) && isset($_GET['endtime'])){$where=$where.' and `tab_bid_record`.`bid_time` >'.$_GET['starttime']. ' and `tab_bid_record`.`bid_time`<'.$_GET['endtime'];}
		if(isset($_GET['phonenum'])){$where=$where.' and `tab_member`.`mobile`='.$_GET['phonenum'];}
		if(isset($_GET['shopname'])){$where=$where.' and `tab_bid_record`.`g_id`="'.$_GET['shopname'].'"';}
		if(isset($_GET['qishu'])){$where=$where.' and `tab_bid_record`.`g_periods`="'.$_GET['qishu'].'"';}
		
		$sql='select `tab_bid_record`.o_id,`tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.buycount, `tab_member`.`mobile`, `tab_member`.`nickname` , FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time from `tab_bid_record` 
		inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` where `tab_bid_record`.`status` <> 0'.$where.' order by `tab_bid_record`.`id` desc';
		$array=array('订单号','商品名称','商品期数','消费金额','手机号码','用户名','时间');
		$name='消费';
	}
    
	
		
	$result=DB::select($sql);
	$result=$this->object_array($result);
	//消费价格问题：人次*价格
	if($_GET['type']=='buy')
	{
		
		foreach($result as $key=>$val)
				{
					$goodprice=Object::where('id',$val['o_id'])->select('minimum')->first();
					$result[$key]['buycount']=$val['buycount']*$goodprice['minimum'];
					unset($result[$key]['o_id']);
				}
	}
	//print_r($result);exit;
	array_unshift($result,$array);
	$time=date('Y-m-d',time());
    //print_r($result);exit;
    Excel::create($time.$name,function($excel) use ($result){
      $excel->sheet('score', function($sheet) use ($result){
        $sheet->rows($result);
      });
    })->export('xls');
  }
	
	//数据统计
	public function tongji(request $request)
	{
		if($request::isMethod('post'))
		{
		
			$starttime=strtotime($_POST['start_time']);
			$endtime=strtotime($_POST['end_time']);
			
			$starttimet=$starttime*1000;
			$endtimet=$endtime*1000;
			//注册总数
			$sql='SELECT count(1) as rgnum FROM `tab_member`';
			$result=DB::select($sql);
			$data['rgnum']='无法统计';
			
			//消费用户数
			$sql="SELECT count(DISTINCT usr_id) as xfunum FROM `tab_member_addmoney_record` where amount > 0 and bid<>'' and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['xfunum']=$result[0]->xfunum;
			
			//网站销售额
			$sql="SELECT sum(amount) as xftsum FROM `tab_member_addmoney_record`  where amount > 0 and bid<>'' and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['xftsum']=$result[0]->xftsum;
			
			/***************大转盘***************/
			
			
			
			/*******
			//天天免费参与用户数
			$sql="SELECT count(DISTINCT usr_id) as atunum FROM `tab_freeday_log` where time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['atunum']='无法统计';
			
			//天天免费参二次用户数
			$sql="SELECT count(DISTINCT usr_id) as atunum_s FROM `tab_member_account` where type = 6 and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['atunum_s']=$result[0]->atunum_s;
			
			
			//天天免费抢红包中奖次数
			$sql="select count(*) as rbnum from tab_freeday_log where happy_num=lucky_num and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['rbnum']=$result[0]->rbnum;
			
			//天天免费参与次数
			$sql="SELECT count(1) as atnum FROM `tab_freeday_log` where time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['atnum']=$result[0]->atnum;
			
			//天天免费送出块乐豆
			$sql="SELECT sum(money) as klsnum FROM `tab_member_account` where type <> 6 and type <> 9 and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['klsnum']=$result[0]->klsnum;
			
			//天天免费奖品兑换人数
			$sql="SELECT count(DISTINCT usr_id) as pzunum FROM `tab_bid_record` where pay_type = 'invite' and bid_time>".$starttime.' and bid_time<'.$endtime;
			$result=DB::select($sql);
			$data['pzunum']=$result[0]->pzunum;*****/
			
			//总消费块乐豆
			$sql="SELECT sum(money) as klxfnum FROM `tab_member_account` where type in (6,9) and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['klxfnum']=$result[0]->klxfnum;
			
			//活动发现参与用户数
			$sql="SELECT count(DISTINCT send_uid) as atfnum FROM `activitylog` where time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['atfnum']=$result[0]->atfnum;
			//发送短信数
			$sql="SELECT count(1) as smsnum FROM `activitylog` where time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['smsnum']=$result[0]->smsnum;
			//用户充值数量(人数)
			$sql="SELECT count(DISTINCT usr_id) as czunum FROM `tab_member_addmoney_record` where status in (1,4,5) and money>0 and time>".$starttime.' and time<'.$endtime;;
			$result=DB::select($sql);
			$data['czunum']=$result[0]->czunum;
			//用户总充值金额
			$sql="SELECT sum(money) as zcmsum FROM `tab_member_addmoney_record` where status in (1,4,5) and money>0 and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['zcmsum']=$result[0]->zcmsum;
			//用户账户总余额
			$sql="select sum(money) as symsum from tab_member";
			$result=DB::select($sql);
			$data['symsum']='无法统计';
			//邀请总佣金
			$sql="SELECT sum(commission) as yjsum FROM `tab_member`";
			$result=DB::select($sql);
			$data['yjsum']='无法统计';
			//每日新增佣金
			$sql="SELECT sum(commission) as commission FROM `tab_member_commission_record` where is_pay=0 and time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			
			if($result[0]->commission==null)
			{
				$result[0]->commission='0';
			}
			$data['everydayincyongjing']=$result[0]->commission;
			//var_dump($data['everydayincyongjing']);exit;
			//3日登陆用户数
			$sql="SELECT count(1) as srunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 2 day))";
			$result=DB::select($sql);
			$data['srunum']=$result[0]->srunum;
			//7日登陆用户数
			$sql="SELECT count(1) as qrunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 6 day))";
			$result=DB::select($sql);
			$data['qrunum']=$result[0]->qrunum;
			
			//15日登陆用户数
			$sql="SELECT count(1) as swrunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 15 day))";
			$result=DB::select($sql);
			$data['swrunum']=$result[0]->swrunum;
			//30日登陆用户数
			$sql="SELECT count(1) as ssrunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 30 day))";
			$result=DB::select($sql);
			$data['ssrunum']=$result[0]->ssrunum;
			
			//新增注册人数
			$sql="SELECT count(1) as rgnum FROM `tab_member` where  reg_time>".$starttime.' and reg_time<'.$endtime;
			//echo $sql;exit;
			$result=DB::select($sql);
			$data['xzrgnum']=$result[0]->rgnum;
			
			//新增注册消费人数
			$sql="select count(DISTINCT `tab_member_addmoney_record`.`usr_id`) as xzxfnum from `tab_member_addmoney_record` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id` where  amount > 0 and bid<>'' and reg_time>".$starttime.' and reg_time<'.$endtime;
			$result=DB::select($sql);
			$data['xzxfnum']=$result[0]->xzxfnum;
			
			//幸运转盘每日参与人数
			$sql="SELECT count(distinct usr_id) as peopleofbigwheeleveryday FROM `tab_rotary_log` where  time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['peopleofbigwheeleveryday']=$result[0]->peopleofbigwheeleveryday;
			
			//幸运转盘每日参与次数
			$sql="SELECT count(1) as numofbigwheeleveryday FROM `tab_rotary_log` where  time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['numofbigwheeleveryday']=$result[0]->numofbigwheeleveryday;
			
			//幸运转盘参与二次人数
			$sql="SELECT count(1) as pepoleofbigwheeleverydayagain FROM `tab_rotary_log` where  time>".$starttime.' and time<'.$endtime."  group by usr_id having count(1)>1";
			$result=DB::select($sql);
			$data['pepoleofbigwheeleverydayagain']=count($result);
			
			
			//幸运转盘老用户每日参与人数
			$sql="select count(DISTINCT `tab_rotary_log`.`usr_id`) as oldpepoleofbigwheeleveryday from `tab_rotary_log` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_rotary_log`.`usr_id` where   reg_time<".$starttime.' and  time>'.$starttime.' and time<'.$endtime.
				" or reg_time is null and  time>".$starttime.' and time<'.$endtime;
			$result=DB::select($sql);
			$data['oldpepoleofbigwheeleveryday']=$result[0]->oldpepoleofbigwheeleveryday;
			
			//幸运转盘老用户每日参与次数
			$sql="select count(1) as oldpepolenumofbigwheeleveryday from `tab_rotary_log` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_rotary_log`.`usr_id` where   reg_time<".$starttime.' and  time>'.$starttime.' and time<'.$endtime. " or reg_time is null and  time>".$starttime.' and time<'.$endtime;;
			$result=DB::select($sql);
			$data['oldpepolenumofbigwheeleveryday']=$result[0]->oldpepolenumofbigwheeleveryday;
			
			//每日新增注册用户幸运转盘参与人数
			$sql="select count(DISTINCT `tab_rotary_log`.`usr_id`) as newpepoleofbigwheeleveryday from `tab_rotary_log` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_rotary_log`.`usr_id` where  reg_time>".$starttime." and reg_time<".$endtime.' and  time>'.$starttime.' and time<'.$endtime;
		
			$result=DB::select($sql);
			$data['newpepoleofbigwheeleveryday']=$result[0]->newpepoleofbigwheeleveryday;
			
			
			//每日新增注册用户幸运转盘二次参与人数
			$sql="select count(1) as newpepoleofbigwheeleverydayagain from `tab_rotary_log` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_rotary_log`.`usr_id` 
				where   reg_time>".$starttime." and reg_time<".$endtime.' and  time>'.$starttime.' and time<'.$endtime.' group by `tab_rotary_log`.`usr_id` having count(1)>1';
			$result=DB::select($sql);
			$data['newpepoleofbigwheeleverydayagain']=count($result);
			
			
		}
		else
		{
			
			
			//注册总数
			$sql='SELECT count(1) as rgnum FROM `tab_member`';
			$result=DB::select($sql);
			$data['rgnum']=$result[0]->rgnum;
			
			//新增注册总数
			$sql='SELECT count(1) as rgnum FROM `tab_member`';
			$result=DB::select($sql);
			$data['xzrgnum']=$result[0]->rgnum;
			
			//新增注册消费人数
			$sql="select count(DISTINCT `tab_member_addmoney_record`.`usr_id`) as xzxfnum from `tab_member_addmoney_record` 
				inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id` where  amount > 0 and bid<>''";
			$result=DB::select($sql);
			$data['xzxfnum']=$result[0]->xzxfnum;
			//消费用户数
			$sql="SELECT count(DISTINCT usr_id) as xfunum FROM `tab_member_addmoney_record` where amount > 0 and bid<>''";
			$result=DB::select($sql);
			$data['xfunum']=$result[0]->xfunum;
			
			//网站销售额
			$sql="SELECT sum(amount) as xftsum FROM `tab_member_addmoney_record`  where amount > 0 and bid<>''";
			$result=DB::select($sql);
			$data['xftsum']=$result[0]->xftsum;
			
			/*******************大转盘*************/
			
			//幸运转盘每日参与人数
			$sql="SELECT count(distinct usr_id) as peopleofbigwheeleveryday FROM `tab_rotary_log`";
			$result=DB::select($sql);
			$data['peopleofbigwheeleveryday']=$result[0]->peopleofbigwheeleveryday;
			
			//幸运转盘每日参与次数
			$sql="SELECT count(1) as numofbigwheeleveryday FROM `tab_rotary_log`";
			$result=DB::select($sql);
			$data['numofbigwheeleveryday']=$result[0]->numofbigwheeleveryday;
			
			//幸运转盘参与二次人数
			$sql="SELECT count(1) as pepoleofbigwheeleverydayagain FROM `tab_rotary_log` group by usr_id having count(1)>1";
			$result=DB::select($sql);
			//print_r($result);exit;
			$data['pepoleofbigwheeleverydayagain']=count($result);
			
			//幸运转盘老用户每日参与人数
			
			$data['oldpepoleofbigwheeleveryday']='请选择时间段';
			
			//幸运转盘老用户每日参与次数
			$data['oldpepolenumofbigwheeleveryday']='请选择时间段';
			
			//每日新增注册用户幸运转盘参与人数
			$data['newpepoleofbigwheeleveryday']='请选择时间段';
			
			//每日新增注册用户幸运转盘二次参与人数
			$data['newpepoleofbigwheeleverydayagain']='请选择时间段';
			
			//每日新增佣金
			$data['everydayincyongjing']='请选择时间段';
			

			
			
			/**
			//天天免费参与用户数
			$sql="SELECT count(DISTINCT usr_id) as atunum FROM `tab_freeday_log`";
			$result=DB::select($sql);
			$data['atunum']=$result[0]->atunum;
			
			//天天免费参二次用户数
			$sql="SELECT count(DISTINCT usr_id) as atunum_s FROM `tab_member_account` where type = 6";
			$result=DB::select($sql);
			$data['atunum_s']=$result[0]->atunum_s;
			
			
			//天天免费抢红包中奖次数
			$sql="select count(*) as rbnum from tab_freeday_log where happy_num=lucky_num";
			$result=DB::select($sql);
			$data['rbnum']=$result[0]->rbnum;
			
			//天天免费参与次数
			$sql="SELECT count(1) as atnum FROM `tab_freeday_log`";
			$result=DB::select($sql);
			$data['atnum']=$result[0]->atnum;
			
			//天天免费送出块乐豆
			$sql="SELECT sum(money) as klsnum FROM `tab_member_account` where type <> 6 and type <> 9";
			$result=DB::select($sql);
			$data['klsnum']=$result[0]->klsnum;
			//天天免费奖品兑换人数
			$sql="SELECT count(DISTINCT usr_id) as pzunum FROM `tab_bid_record` where pay_type = 'invite'";
			$result=DB::select($sql);
			$data['pzunum']=$result[0]->pzunum;******/
			
			//总消费块乐豆
			$sql="SELECT sum(money) as klxfnum FROM `tab_member_account` where type in (6,9)";
			$result=DB::select($sql);
			$data['klxfnum']=$result[0]->klxfnum;
			
			//活动发现参与用户数
			$sql="SELECT count(DISTINCT send_uid) as atfnum FROM `activitylog`";
			$result=DB::select($sql);
			$data['atfnum']=$result[0]->atfnum;
			//发送短信数
			$sql="SELECT count(1) as smsnum FROM `activitylog`";
			$result=DB::select($sql);
			$data['smsnum']=$result[0]->smsnum;
			//用户充值数量(人数)
			$sql="SELECT count(DISTINCT usr_id) as czunum FROM `tab_member_addmoney_record` where status in (1,4,5) and money>0";
			$result=DB::select($sql);
			$data['czunum']=$result[0]->czunum;
			//用户总充值金额
			$sql="SELECT sum(money) as zcmsum FROM `tab_member_addmoney_record` where status in (1,4,5) and money>0";
			$result=DB::select($sql);
			$data['zcmsum']=$result[0]->zcmsum;
			//用户账户总余额
			$sql="select sum(money) as symsum from tab_member";
			$result=DB::select($sql);
			$data['symsum']=$result[0]->symsum;
			//邀请总佣金
			$sql="SELECT sum(commission) as yjsum FROM `tab_member`";
			$result=DB::select($sql);
			$data['yjsum']=$result[0]->yjsum;
			//3日登陆用户数
			$sql="SELECT count(1) as srunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 2 day))";
			$result=DB::select($sql);
			$data['srunum']=$result[0]->srunum;
			//7日登陆用户数
			$sql="SELECT count(1) as qrunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 6 day))";
			$result=DB::select($sql);
			$data['qrunum']=$result[0]->qrunum;
			//15日登陆用户数
			$sql="SELECT count(1) as swrunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 15 day))";
			$result=DB::select($sql);
			$data['swrunum']=$result[0]->swrunum;
			//30日登陆用户数
			$sql="SELECT count(1) as ssrunum FROM `tab_member` where login_time>=UNIX_TIMESTAMP(date_sub(now(),interval 30 day))";
			$result=DB::select($sql);
			$data['ssrunum']=$result[0]->ssrunum;
			
		}
		

		//print_r($data);
		return view('backend.finance.datasum',$data);
	}
	
	//幸运转盘红包明细
	public function bigWheelIfno(Request $request)
	{
		$request::session()->forget('bigwheel');
		$list=Rotarylog::orderBy('time','desc')->where('tab_rotary_log.status',1)->join('tab_member','tab_member.usr_id','=','tab_rotary_log.usr_id')
		->join('tab_rotary_prize','tab_rotary_prize.id','=','tab_rotary_log.prize_id')->select('tab_rotary_log.*','nickname','mobile','reg_time','tab_rotary_prize.money')->paginate(100);
		//总红包
		$summoney=Rotarylog::where('tab_rotary_log.status',1)->join('tab_member','tab_member.usr_id','=','tab_rotary_log.usr_id')
		->join('tab_rotary_prize','tab_rotary_prize.id','=','tab_rotary_log.prize_id')->sum('tab_rotary_prize.money');
		
		//总参加人数
		$membernum=Rotarylog::where('tab_rotary_log.status',1)->join('tab_member','tab_member.usr_id','=','tab_rotary_log.usr_id')
		->join('tab_rotary_prize','tab_rotary_prize.id','=','tab_rotary_log.prize_id')->groupBy('tab_rotary_log.usr_id')->select('tab_rotary_log.usr_id')->get();
		//print_r(count($membernum));exit;
		
		//总参加次数
		$canjiacishu=Rotarylog::where('tab_rotary_log.status',1)->join('tab_member','tab_member.usr_id','=','tab_rotary_log.usr_id')
		->join('tab_rotary_prize','tab_rotary_prize.id','=','tab_rotary_log.prize_id')->count();
		$prizetype=Rotaryprize::where('status',1)->select('id','name')->get();
		$data['prizetype']=$prizetype;
		$data['list']=$list;
		$data['canjiacishu']=$canjiacishu;
		$data['summoney']=$summoney;
		$data['membernum']=count($membernum);
		$data['url']='';
		//print_r($data);exit;
		return view('backend.finance.bigwheellist',$data);
	}
	
	
	//幸运转盘红包明细带搜索条件
	public function bigWheelInfoSearch(Request $request)
	{
		
		if ($request::isMethod('post'))
		{
			//echo 1111;exit;
			//print_r($_POST);exit;
			$request::session()->forget('bigwheel');
			if($_POST['prize_type']){@session(['bigwheel.prizetype'    => $_POST['prize_type']]);}
			if($_POST['phone']){@session(['bigwheel.phone'    => $_POST['phone']]);}
			if($_POST['start_time']){@session(['bigwheel.starttime'    => $_POST['start_time']]);}
			if($_POST['end_time']){@session(['bigwheel.endtime'    => $_POST['end_time']]);}
			if($_POST['regstarttime']){@session(['bigwheel.regstarttime'    => $_POST['regstarttime']]);}
			if($_POST['regendtime']){@session(['bigwheel.regendtime'    => $_POST['regendtime']]);}
		}
		$url=array();
		$list=Rotarylog::orderBy('time','desc')->where('tab_rotary_log.status',1)->join('tab_member','tab_member.usr_id','=','tab_rotary_log.usr_id')
		->join('tab_rotary_prize','tab_rotary_prize.id','=','tab_rotary_log.prize_id');
		if(session('bigwheel.starttime'))
		{
			$end_time=strtotime(session('bigwheel.endtime'));
			$start_time=strtotime(session('bigwheel.starttime'));
			$list=$list->where('tab_rotary_log.time','>',$start_time)->where('tab_rotary_log.time','<',$end_time);
			$url['starttime']=$start_time;
			$url['end_time']=$end_time;
		}

		if(session('bigwheel.regstarttime'))
		{
			$regendtime=strtotime(session('bigwheel.regendtime'));
			$regstarttime=strtotime(session('bigwheel.regstarttime'));
			$list=$list->where('tab_member.reg_time','>',$regstarttime)->where('tab_member.reg_time','<',$regendtime);
			$url['regstarttime']=$regstarttime;
			$url['regendtime']=$regendtime;
		}
	
		if(session('bigwheel.phone'))
		{
			
			$list=$list->where('tab_member.mobile',session('bigwheel.phone'));
			$url['phone']=session('bigwheel.phone');
		}
		
		if(session('bigwheel.prizetype'))
		{
			
			$list=$list->where('tab_rotary_log.prize_id',session('bigwheel.prizetype'));
			$url['prizetype']=session('bigwheel.prizetype');
		}	
		$result=$list->select('tab_rotary_log.*','nickname','mobile','reg_time','tab_rotary_prize.money')->paginate(100);
		$summoney=$list->sum('tab_rotary_prize.money');
		$canjiacishu=$list->count();
		$membernum=$list->groupBy('tab_rotary_log.usr_id')->select('tab_rotary_log.usr_id')->get();
		$data['canjiacishu']=$canjiacishu;
		$data['summoney']=$summoney;
		$data['membernum']=count($membernum);
		$prizetype=Rotaryprize::where('status',1)->select('id','name')->get();
		$data['prizetype']=$prizetype;
		$url=http_build_query($url);
		$data['list']=$result;
		$data['url']=$url;
		return view('backend.finance.bigwheellist',$data);
	}


	public function exportBigWheel()
	{
		
		if(count($_GET)==0)
		{
			echo '请选择条件再导表，数目太多';exit;
		}
		$array=array('用户id','用户手机','用户名','红包金额','注册时间','抽奖时间','损耗');
		$name='大转盘';
		$list=Rotarylog::orderBy('time','desc')->where('tab_rotary_log.status',1)->join('tab_member','tab_member.usr_id','=','tab_rotary_log.usr_id')
		->join('tab_rotary_prize','tab_rotary_prize.id','=','tab_rotary_log.prize_id');
		if(isset($_GET['starttime']))
		{
			$end_time=$_GET['end_time'];
			$start_time=$_GET['starttime'];
			$list=$list->where('tab_rotary_log.time','>',$start_time)->where('tab_rotary_log.time','<',$end_time);
			
		}

		if(isset($_GET['regstarttime']))
		{
			$regendtime=$_GET['regendtime'];
			$regstarttime=$_GET['regstarttime'];
			$list=$list->where('tab_member.reg_time','>',$regstarttime)->where('tab_member.reg_time','<',$regendtime);
			
		}
	
		if(isset($_GET['phone']))
		{
			
			$list=$list->where('tab_member.mobile',$_GET['phone']);
			
		}
		
		if(isset($_GET['prizetype']))
		{
			
			$list=$list->where('tab_rotary_log.prize_id',$_GET['prizetype']);
			
		}
	
		$result=$list->select('tab_rotary_log.usr_id','mobile','nickname','tab_rotary_prize.money','reg_time','tab_rotary_log.time','tab_rotary_log.is_free')->get()->toArray();
	   // print_r($result);exit;
	    foreach($result as $key=>$val)
	    {
	    	$result[$key]['time']=date('Y-m-d H:i:s',$val['time']);
	    	$result[$key]['reg_time']=date('Y-m-d H:i:s',$val['reg_time']);
			if($val['is_free']==1)
			{
				$result[$key]['is_free']='奖励次数';
			}
			else
			{
				$result[$key]['is_free']='消费10块乐豆';
			}
			
//			$sql="SELECT invite_last as num FROM `tab_rotary_member` where usr_id=".$val->usr_id;
//			$result=DB::select($sql);
//			$data['swrunum']=$result[0]->num;
			
			
	    }
	    //print_r($result);exit;
		array_unshift($result,$array);
		$time=date('Y-m-d',time());
	    //print_r($result);exit;
        Excel::create($time.$name,function($excel) use ($result){
        $excel->sheet('score', function($sheet) use ($result){
        $sheet->rows($result);
        });
        })->export('xls');
	}
	
	
	
	//红包购买商品
	public function redBadBuyShop(request $request)
	{
		if($request::isMethod('post'))
		{
		    //块乐豆购买商品
		    $request::session()->forget('dikou');
			if($_POST['end_time']){@session(['dikou.endtime'    => $_POST['end_time']]);}
			if($_POST['start_time']){@session(['dikou.starttime'    => $_POST['start_time']]);}
			
			$starttime=strtotime($_POST['start_time']);
			$endtime=strtotime($_POST['end_time']);
			
			$sql="SELECT sum(money) as kldbyshop FROM `tab_member_account` where type=9 and money>0 and time>".$starttime." and time<".$endtime;
			$result=DB::select($sql);
			$data['kldbuyshop']=$result[0]->kldbyshop;
			//红包购买商品
			$orderlist=AddMoneyRecord::whereNotNull('bid')->where('type','buy')->where('amount','>',0)->where('time','>',$starttime)->where('time','<',$endtime)->orderBy('tab_member_addmoney_record.id','desc')->select('tab_member_addmoney_record.*')->paginate(1000);
			//print_r($orderlist);exit;
			$money=0;
		    foreach($orderlist as $key=>$val)
		    {
			   	$orderlist[$key]->scookies=json_decode($val->scookies,TRUE);
				
				//抵扣红包
				if($orderlist[$key]->scookies['red_id']!=0)
				{
					$redinfo=red::where('tab_member_red.id',$orderlist[$key]->scookies['red_id'])
					->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
					->select('money')->first();
					$orderlist[$key]->redbao=$redinfo['money'];
					$money=$money+$redinfo['money'];
				}
				
			}
		    $data['redbaobuyshop']=$money;
		}
		else
		{
			if(session('dikou.endtime') || session('dikou.starttime'))
			{
				
				$starttime=strtotime(session('dikou.starttime'));
				$endtime=strtotime(session('dikou.endtime'));
				
				$sql="SELECT sum(money) as kldbyshop FROM `tab_member_account` where type=9 and money>0 and time>".$starttime." and time<".$endtime;
				$result=DB::select($sql);
				$data['kldbuyshop']=$result[0]->kldbyshop;
				//红包购买商品
				$orderlist=AddMoneyRecord::whereNotNull('bid')->where('type','buy')->where('amount','>',0)->where('time','>',$starttime)->where('time','<',$endtime)->orderBy('tab_member_addmoney_record.id','desc')->select('tab_member_addmoney_record.*')->paginate(1000);
				//print_r($orderlist);exit;
				$money=0;
			    foreach($orderlist as $key=>$val)
			    {
				   	$orderlist[$key]->scookies=json_decode($val->scookies,TRUE);
					
					//抵扣红包
					if($orderlist[$key]->scookies['red_id']!=0)
					{
						$redinfo=red::where('tab_member_red.id',$orderlist[$key]->scookies['red_id'])
						->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
						->select('money')->first();
						$orderlist[$key]->redbao=$redinfo['money'];
						$money=$money+$redinfo['money'];
					}
					
				}
			    $data['redbaobuyshop']=$money;
			}
			else
			{
				$sql="SELECT sum(money) as kldbyshop FROM `tab_member_account` where type=9 and money>0";
				$result=DB::select($sql);
				$data['kldbuyshop']=$result[0]->kldbyshop;
				//红包购买商品
				$orderlist=AddMoneyRecord::whereNotNull('bid')->where('type','buy')->where('amount','>',0)->orderBy('tab_member_addmoney_record.id','desc')->select('tab_member_addmoney_record.*')->paginate(1000);
				//print_r($orderlist);exit;
				$money=0;
			    foreach($orderlist as $key=>$val)
			    {
				   	$orderlist[$key]->scookies=json_decode($val->scookies,TRUE);
					
					//抵扣红包
					if($orderlist[$key]->scookies['red_id']!=0)
					{
						$redinfo=red::where('tab_member_red.id',$orderlist[$key]->scookies['red_id'])
						->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
						->select('money')->first();
						$orderlist[$key]->redbao=$redinfo['money'];
						$money=$money+$redinfo['money'];
					}
					
				}
		    	$data['redbaobuyshop']=$money;
			}
			
		}
			$data['orderlist']=$orderlist;
			return view('backend.finance.datasumshop',$data);
	}
			 
	
	//对象转数组	
	protected function object_array($array) 
	{  
	    if(is_object($array)) 
	    {  
	        $array = (array)$array;  
	    } 
	     if(is_array($array)) 
	     {  
	         foreach($array as $key=>$value) 
	         {  
	             $array[$key] = $this->object_array($value);  
	             
			 }  
	     }  
	     return $array;  
	} 
}
