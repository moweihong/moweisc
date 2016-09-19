<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\BaseController;
use App\Models\Redbao;
use Request,Validator;
use App\Models\AddMoneyRecord;
use App\Models\Order;
use App\Models\Goods;
use App\Models\Red;
use App\Models\Memberaccount;
use Excel;
use DB;



class OrdernewController extends BaseController {
	public function __construct()
	{
       parent::__construct();
       
  
    }
    
	public function index2(Request $request)
	{
		$url['page']=isset($_GET['page'])?$_GET['page']:1;
		if ($request::isMethod('post'))
		{
			//echo 1111;exit;
			//print_r($_POST);exit;
			$request::session()->forget('ordernew');
			if($_POST['end_time']){@session(['ordernew.endtime'    => $_POST['end_time']]);}
			if($_POST['start_time']){@session(['ordernew.starttime'    => $_POST['start_time']]);}
			if($_POST['phones']){@session(['ordernew.phones'    => $_POST['phones']]);}
		}
		
		//print_r(session('ordernew.endtime'));
			$orderlist=AddMoneyRecord::whereNotNull('bid')->where('type','buy')->where('amount','>',0);
//			if(isset($order_endtime) && isset($order_starttime))
//			{
//				//echo  1;
//				$orderlist=$orderlist->where('time','>',$order_starttime)->where('time','<',$order_endtime);
//			}
			if(session('ordernew.endtime') || session('ordernew.starttime') )
			{
				//echo 2;
				//print_r(session('ordernew.endtime'));
				//print_r(session('ordernew.starttime'));
				$order_endtime=strtotime(session('ordernew.endtime'));
				$order_starttime=strtotime(session('ordernew.starttime'));
				$orderlist=$orderlist->where('time','>',$order_starttime)->where('time','<',$order_endtime);
				$url['endtime']=$order_endtime;
				$url['starttime']=$order_starttime;
				//exit;
				
			}
			if(session('ordernew.phones'))
			{
				$phonearr=explode(',', session('ordernew.phones'));
				//print_r($phonearr);
				$orderlist=$orderlist->join('tab_member','tab_member.usr_id','=','tab_member_addmoney_record.usr_id')->wherein('mobile',$phonearr);
				$url['phones']=session('ordernew.phones');
			}
//			if(isset($order_endtime) && isset($order_starttime))
//			{
//				$url['endtime']=$order_endtime;
//				$url['starttime']=$order_starttime;
//			}
			
			//->where('id',2768)
			
		    $orderlist=$orderlist->orderBy('tab_member_addmoney_record.id','desc')->select('tab_member_addmoney_record.*')->paginate(50);
			//print_r(count($orderlist));exit;
				   foreach($orderlist as $key=>$val)
				   {
				   	$orderlist[$key]->scookies=json_decode($val->scookies,TRUE);
					$orderlist[$key]->bid=json_decode($val->bid,TRUE);
					//抵扣红包
					//echo $key;
					//echo $orderlist[$key]->scookies['red_id'];
					
					if($orderlist[$key]->scookies['red_id']!=0)
					{
						
						$redinfo=red::where('tab_member_red.id',$orderlist[$key]->scookies['red_id'])
						->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
						->select('money')->first();
						$orderlist[$key]->redbao=$redinfo['money'];
					}
					else
					{
						$orderlist[$key]->redbao=0;
					}
					
					//抵扣快乐豆
					if(isset($orderlist[$key]->scookies['klbean']) && $orderlist[$key]->scookies['klbean']==1)
					{
						$id='%'.$orderlist[$key]->id.'%';
						$kldinfo=Memberaccount::where('content','like',$id)->where('type',9)
						         ->sum('money');
						
						$orderlist[$key]->kld=$kldinfo;
						
					}
					else
					{
						$orderlist[$key]->kld=0;
					}
					
					//echo $orderlist[$key]->kld;exit;
					
					//订单信息
					$dindan=Order::wherein('id',$orderlist[$key]->bid)->get();
					
					$orderlist[$key]->dindan=$dindan;
					//print_r($orderlist[$key]);exit;
					//把没有抵扣的订单去掉
//					if($orderlist[$key]->redbao==0 && $orderlist[$key]->kld==0)
//					{
//						unset($orderlist[$key]);
//					}
					
				   	//print_r(json_decode($val->scookies,TRUE));
				   	//print_r($orderlist);exit;
				   }
			$data['url']=http_build_query($url);
		   	$data['orderlist']=$orderlist;
			//print_r($orderlist);exit;
			//exit;
			//print_r($orderlist);exit;	
		    return view('backend.order.ordernewindex',$data);
	}
	
	
	//清空搜索条件
	public function unsetSearchOrdernew(Request $request)
	{
		$request::session()->forget('ordernew');
		
	}
	
	//导表：
	public function daoBiaonew1111()
	{
		//print_r($_GET);exit;
		$array=array('商品名称','商品期数','结果','本次参与','注册用户','昵称','订单号','开奖时间','商品价格','下单时间','总金额','红包','块乐豆','实际消费','收货地址','联系方式','收货人','账号异常');
		
		$name='含抵扣订单表';
		$where='';
		$contab='';
		
		if(isset($_GET['phones']))
		{
			$phonearr=explode(',', $_GET['phones']);
			$length=count($phonearr);
			$phonestr='';
			if($length>1)
			{
				foreach($phonearr as $kp=>$vp)
				{
					if($kp==$length-1)
					{
						$phonestr=$phonestr.$vp;
					}
					else
					{
						$phonestr=$phonestr.$vp.',';
					}
					
				}
			
			}
			else
			{
				$phonestr=$phonearr[0];
			}
			$contab='inner join `tab_member` on `tab_member`.`usr_id` = `tab_member_addmoney_record`.`usr_id`';
			$where=$where.' and mobile in ('.$phonestr.')';
		}
		//echo $phonestr;
		if(isset($_GET['starttime'])&&$_GET['starttime']!=0){$where=$where.' and time >'.$_GET['starttime'];}
		if(isset($_GET['endtime'])&&$_GET['endtime']!=0){$where=$where.'  and time<'.$_GET['endtime'];}
		$offset=($_GET['page']-1)*50;
		//$sql='select `tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.g_id,`tab_member`.`mobile`,`tab_member`.`nickname` ,`tab_bid_record`.buycount,`tab_bid_record`.fetchno,`tab_bid_record`.addressid,   FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time from `tab_bid_record` 
		//inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` '.$where.' order by `tab_bid_record`.`id` desc limit '.$offset.',50';
		
		$sql='select `tab_member_addmoney_record`.* from `tab_member_addmoney_record` '.$contab.' where  type="buy"  and amount > 0 and bid is not null '. $where.' order by `tab_member_addmoney_record`.id desc limit '.$offset.',50';
		//echo $sql;exit;
		$result=DB::select($sql);
	    $res=array();
		$result=$this->object_array($result);
		foreach($result as $key=>$val)
		{
			$result[$key]['bid']=json_decode($val['bid'],TRUE);
			$result[$key]['scookies']=json_decode($val['scookies'],TRUE);
			//红包
			if($result[$key]['scookies']['red_id']>0)
			{
				//echo $result[$key]['scookies']['red_id'];exit;
				$redinfo=red::where('tab_member_red.id',$result[$key]['scookies']['red_id'])
						->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
						->select('money')->first();
						$result[$key]['redbao']=$redinfo['money'];
				//print_r($redinfo['money']);exit;
			}
			else
			{
				$result[$key]['redbao']=0;
			}
			//块乐豆
			if(isset($result[$key]['scookies']['klbean']) && $result[$key]['scookies']['klbean']==1)
			{
				
				$id='%'.$result[$key]['id'].'%';
						$kldinfo=Memberaccount::where('content','like',$id)->where('type',9)
						         ->sum('money');
						$result[$key]['klbean']=$kldinfo;
				
			}
			else
			{
				$result[$key]['klbean']=0;
			}
			//订单信息
			$length=count($result[$key]['bid']);
			$bidstr='';
			if($length>1)
			{
				foreach($result[$key]['bid'] as $k=>$v)
				{
					if($k==$length-1)
					{
						$bidstr=$bidstr.$v;
					}
					else
					{
						$bidstr=$bidstr.$v.',';
					}
					
				}
			
			}
			else
			{
				$bidstr=$result[$key]['bid'][0];
			}
			//echo $bidstr;exit;
			$sql2="select `g_name`,`g_periods`,`fetchno`, `buycount`, `mobile`, `nickname`,`is_unusual`, `code`, `kaijiang_time`, `ykg_goods`.`money`,`addressjson`, `kaijiang_time` from `tab_bid_record` inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` inner join `ykg_goods` on `ykg_goods`.`id` = `tab_bid_record`.`g_id` where `tab_bid_record`.`id` in (".$bidstr.")";
			/*
			$info=Order::wherein('tab_bid_record.id',$result[$key]['bid'])
			  ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
			  ->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
			  ->select('g_name','mobile','nickname','code','kaijiang_time','ykg_goods.money')
			  ->get();*/
			$info=DB::select($sql2);  
			$result[$key]['info']=$this->object_array($info);
			
			
		}
		
		$res=array();
		//重组数组
		foreach($result as $kk=>$val)
		{
			if($result[$kk]['redbao']!=0 || $result[$kk]['klbean']!=0)
			{
				foreach($val['info'] as $rkey=>$row)
				{
					//echo $rkey;
					$val['info'][$rkey]['xiadantime']=date('Y-m-d H:i:s',$result[$kk]['time']);//下单时间
					if(!empty($row['kaijiang_time']))
					{
						$val['info'][$rkey]['kaijiang_time']=date('Y-m-d H:i:s',$row['kaijiang_time']/1000);//开奖时间
					}
					
					if($rkey==0)
					{
						$val['info'][$rkey]['amount']=$result[$kk]['amount'];//总额
						$val['info'][$rkey]['redbao']=$result[$kk]['redbao'];
						$val['info'][$rkey]['klbean']=$result[$kk]['klbean'];
						$val['info'][$rkey]['shijimoney']=$result[$kk]['amount']-$val['info'][$rkey]['redbao']-$val['info'][$rkey]['klbean']/100;//实际交易金融
						//print_r($val['info']);exit;
						
					}else
					{
						$val['info'][$rkey]['amount']=0;//总额
						$val['info'][$rkey]['redbao']=0;
						$val['info'][$rkey]['klbean']=0;
						$val['info'][$rkey]['shijimoney']=0;
						
					}
					
					if(empty($row['addressjson']))
					{
						$val['info'][$rkey]['address']='';
						$val['info'][$rkey]['addressmobile']='';
						$val['info'][$rkey]['addressreceiver']='';
					}
					else
					{
						$address=json_decode($row['addressjson'],TRUE);
						$val['info'][$rkey]['address']=$address['province'].$address['city'].$address['country'].$address['area'];
						$val['info'][$rkey]['addressmobile']=$address['mobile'];
						$val['info'][$rkey]['addressreceiver']=$address['receiver'];
					}
					
					if($row['is_unusual']==0)
					{
						$val['info'][$rkey]['usersign']='正常';
					}else
					{
						$val['info'][$rkey]['usersign']='封号';
					}
					
					if($row['fetchno']>0)
					{
						$val['info'][$rkey]['fetchno']='中奖';
					}else
					{
						$val['info'][$rkey]['fetchno']='';
					}
					
					unset($val['info'][$rkey]['addressjson']);
					unset($val['info'][$rkey]['is_unusual']);
					array_push($res,$val['info'][$rkey]);
				}
			}
		}
		
		//print_r($res);exit;
		
		//print_r($result);exit;
		array_unshift($res,$array);
		$time=date('Y-m-d',time());
	    //print_r($result);exit;
        Excel::create($time.$name,function($excel) use ($res){
        $excel->sheet('score', function($sheet) use ($res){
        $sheet->rows($res);
        });
        })->export('xls');
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
	
	
	
	//宝马退款
	public function index(Request $request)
	{ 
			$goods="'".'%"g_id":808,%'."'";
			//echo $goods;
		
			$sql='SELECT * FROM `tab_member_addmoney_record` where status=1 and scookies like ' .$goods. ' and NOT EXISTS (SELECT usr_id FROM `tab_member` where tab_member.usr_id = tab_member_addmoney_record.usr_id and mobile in (18087575118,
18087575115,
18087575125,
18087575113,
18087575112,
15016573338,
13577544587,
15887504919,
18469141204,
15087509685,
13710481227,
13710480521,
13538751984,
13538753420,
13710481245,
13538753146,
13710480948,
18565297386,
18565266250,
18565295525,
18565295336,
18023567763,
15089455791,
15089455790,
15219121462,
15219121471,
15219121490,
13694246799,
18125565332,
18125566992,
18127631832,
18265911375,
15206801375,
15192992375,
15192912375,
15589014194,
15563683941,
15562916548,
13287178194,
15589015165,
13021575142,
13021570624,
13713745887,
13823647313,
13534243845,
13534243712,
13554849740,
13534236872,
13923846886,
13602565958,
13631572054,
13530663672,
13288572705,
13288572548,
13288572551,
13288572913,
13288572591,
13288572560,
13169271606,
13169271713,
13169271446,
13169271265,
18312443892,
13751676976,
15219632987,
18312358154,
18312190024,
15218641380,
13580268443,
18312303037,
18318321157,
18312196994,
13229633405,
13288011968,
13229674201,
13229674282,
13288014495,
15361203688,
13414846136,
17875113785,
18314059917,
13173088374,
13290210947,
15206801375,
13714186999,
13692189532,
13631676955,
13172068927,
15627020292,
15627020509,
17195654384,
17195654385,
17195654387,
18187550882,
18087575117,
15219120641,
15219128743,
15219128741,
13172067856,
13172068053,
13172067917,
13172067857
))limit 10';
//echo $sql;exit;
$orderlist=DB::select($sql);
foreach($orderlist as $kk=>$vv)
{
	$orderlist[$kk]->bid=json_decode($vv->bid,TRUE);
}

print_r($orderlist);exit;
		    //$orderlist=$orderlist->orderBy('tab_member_addmoney_record.id','desc')->select('tab_member_addmoney_record.*')->paginate(50);
			//print_r(count($orderlist));exit;
				   foreach($orderlist as $key=>$val)
				   {
				   	$orderlist[$key]->scookies=json_decode($val->scookies,TRUE);
					$orderlist[$key]->bid=json_decode($val->bid,TRUE);
					//抵扣红包
					//echo $key;
					//echo $orderlist[$key]->scookies['red_id'];
					
					if($orderlist[$key]->scookies['red_id']!=0)
					{
						
						$redinfo=red::where('tab_member_red.id',$orderlist[$key]->scookies['red_id'])
						->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
						->select('money')->first();
						$orderlist[$key]->redbao=$redinfo['money'];
					}
					else
					{
						$orderlist[$key]->redbao=0;
					}
					
					//抵扣快乐豆
					if(isset($orderlist[$key]->scookies['klbean']) && $orderlist[$key]->scookies['klbean']==1)
					{
						$id='%'.$orderlist[$key]->id.'%';
						$kldinfo=Memberaccount::where('content','like',$id)->where('type',9)
						         ->sum('money');
						
						$orderlist[$key]->kld=$kldinfo;
						
					}
					else
					{
						$orderlist[$key]->kld=0;
					}
					
					//echo $orderlist[$key]->kld;exit;
					
					//订单信息
					$dindan=Order::wherein('id',$orderlist[$key]->bid)->get();
					
					$orderlist[$key]->dindan=$dindan;
					//print_r($orderlist[$key]);exit;
					//把没有抵扣的订单去掉
//					if($orderlist[$key]->redbao==0 && $orderlist[$key]->kld==0)
//					{
//						unset($orderlist[$key]);
//					}
					
				   	//print_r(json_decode($val->scookies,TRUE));
				   	//print_r($orderlist);exit;
				   }
//print_r($orderlist);exit;
			$data['url']='11111';
		   	$data['orderlist']=$orderlist;
			//print_r($orderlist);exit;
			//exit;
			//print_r($data);exit;	
		    return view('backend.order.ordernewindex',$data);
	}


//导表：
	public function daoBiaonew()
	{
		//print_r($_GET);exit;
		$array=array('商品名称','商品期数','结果','本次参与','注册用户','昵称','订单号','开奖时间','商品价格','下单时间','总金额','红包','块乐豆','实际消费','收货地址','联系方式','收货人','账号异常');
		
		$name='含抵扣订单宝马表';
		$where='';
		$contab='';
		
		//$sql='select `tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.g_id,`tab_member`.`mobile`,`tab_member`.`nickname` ,`tab_bid_record`.buycount,`tab_bid_record`.fetchno,`tab_bid_record`.addressid,   FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time from `tab_bid_record` 
		//inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` '.$where.' order by `tab_bid_record`.`id` desc limit '.$offset.',50';
		
		$goods="'".'%"g_id":808,%'."'";
			//echo $goods;
		
			$sql='SELECT * FROM `tab_member_addmoney_record` where status=1 and scookies like ' .$goods. ' and NOT EXISTS (SELECT usr_id FROM `tab_member` where tab_member.usr_id = tab_member_addmoney_record.usr_id and mobile in (18087575118,
18087575115,
18087575125,
18087575113,
18087575112,
15016573338,
13577544587,
15887504919,
18469141204,
15087509685,
13710481227,
13710480521,
13538751984,
13538753420,
13710481245,
13538753146,
13710480948,
18565297386,
18565266250,
18565295525,
18565295336,
18023567763,
15089455791,
15089455790,
15219121462,
15219121471,
15219121490,
13694246799,
18125565332,
18125566992,
18127631832,
18265911375,
15206801375,
15192992375,
15192912375,
15589014194,
15563683941,
15562916548,
13287178194,
15589015165,
13021575142,
13021570624,
13713745887,
13823647313,
13534243845,
13534243712,
13554849740,
13534236872,
13923846886,
13602565958,
13631572054,
13530663672,
13288572705,
13288572548,
13288572551,
13288572913,
13288572591,
13288572560,
13169271606,
13169271713,
13169271446,
13169271265,
18312443892,
13751676976,
15219632987,
18312358154,
18312190024,
15218641380,
13580268443,
18312303037,
18318321157,
18312196994,
13229633405,
13288011968,
13229674201,
13229674282,
13288014495,
15361203688,
13414846136,
17875113785,
18314059917,
13173088374,
13290210947,
15206801375,
13714186999,
13692189532,
13631676955,
13172068927,
15627020292,
15627020509,
17195654384,
17195654385,
17195654387,
18187550882,
18087575117,
15219120641,
15219128743,
15219128741,
13172067856,
13172068053,
13172067917,
13172067857
))';
		//echo $sql;exit;
		$result=DB::select($sql);
		
	    $res=array();
		$result=$this->object_array($result);
		foreach($result as $kk=>$vv)
		{
			$result[$kk]['bid']=json_decode($vv['bid'],TRUE);
			if(count($result[$kk]['bid'])>1)
			{
				unset($result[$kk]);
			}
		}
		
		//print_r($result);exit;
		foreach($result as $key=>$val)
		{
			//$result[$key]['bid']=json_decode($val['bid'],TRUE);
			$result[$key]['scookies']=json_decode($val['scookies'],TRUE);
			//红包
			if($result[$key]['scookies']['red_id']>0)
			{
				//echo $result[$key]['scookies']['red_id'];exit;
				$redinfo=red::where('tab_member_red.id',$result[$key]['scookies']['red_id'])
						->join('tab_redbao','tab_member_red.red_code','=','tab_redbao.id')
						->select('money')->first();
						$result[$key]['redbao']=$redinfo['money'];
				//print_r($redinfo['money']);exit;
			}
			else
			{
				$result[$key]['redbao']=0;
			}
			//块乐豆
			if(isset($result[$key]['scookies']['klbean']) && $result[$key]['scookies']['klbean']==1)
			{
				
				$id='%'.$result[$key]['id'].'%';
						$kldinfo=Memberaccount::where('content','like',$id)->where('type',9)
						         ->sum('money');
						$result[$key]['klbean']=$kldinfo;
				
			}
			else
			{
				$result[$key]['klbean']=0;
			}
			
			//订单信息
			$length=count($result[$key]['bid']);
			
			//echo $length;
			
			$bidstr='';
			if($length>1)
			{
				foreach($result[$key]['bid'] as $k=>$v)
				{
					if($k==$length-1)
					{
						$bidstr=$bidstr.$v;
					}
					else
					{
						$bidstr=$bidstr.$v.',';
					}
					
				}
				unset($result[$key]);
			
			}
			else
			{
				$bidstr=$result[$key]['bid'][0];
			}
			//echo $bidstr;exit;
			$sql2="select `g_name`,`g_periods`,`fetchno`, `buycount`, `mobile`, `nickname`,`is_unusual`, `code`, `kaijiang_time`, `ykg_goods`.`money`,`addressjson`, `kaijiang_time` from `tab_bid_record` inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` inner join `ykg_goods` on `ykg_goods`.`id` = `tab_bid_record`.`g_id` where `tab_bid_record`.`id` in (".$bidstr.")";
			/*
			$info=Order::wherein('tab_bid_record.id',$result[$key]['bid'])
			  ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
			  ->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
			  ->select('g_name','mobile','nickname','code','kaijiang_time','ykg_goods.money')
			  ->get();*/
			$info=DB::select($sql2);  
			$result[$key]['info']=$this->object_array($info);
			
			
		}
		//print_r($result);exit;
		$res=array();
		//重组数组
		foreach($result as $kk=>$val)
		{
			if(1)
			{
				foreach($val['info'] as $rkey=>$row)
				{
					//echo $rkey;
					$val['info'][$rkey]['xiadantime']=date('Y-m-d H:i:s',$result[$kk]['time']);//下单时间
					if(!empty($row['kaijiang_time']))
					{
						$val['info'][$rkey]['kaijiang_time']=date('Y-m-d H:i:s',$row['kaijiang_time']/1000);//开奖时间
					}
					
					if($rkey==0)
					{
						$val['info'][$rkey]['amount']=$result[$kk]['amount'];//总额
						$val['info'][$rkey]['redbao']=$result[$kk]['redbao'];
						$val['info'][$rkey]['klbean']=$result[$kk]['klbean'];
						$val['info'][$rkey]['shijimoney']=$result[$kk]['amount']-$val['info'][$rkey]['redbao']-$val['info'][$rkey]['klbean']/100;//实际交易金融
						//print_r($val['info']);exit;
						
					}else
					{
						$val['info'][$rkey]['amount']=0;//总额
						$val['info'][$rkey]['redbao']=0;
						$val['info'][$rkey]['klbean']=0;
						$val['info'][$rkey]['shijimoney']=0;
						
					}
					
					if(empty($row['addressjson']))
					{
						$val['info'][$rkey]['address']='';
						$val['info'][$rkey]['addressmobile']='';
						$val['info'][$rkey]['addressreceiver']='';
					}
					else
					{
						$address=json_decode($row['addressjson'],TRUE);
						$val['info'][$rkey]['address']=$address['province'].$address['city'].$address['country'].$address['area'];
						$val['info'][$rkey]['addressmobile']=$address['mobile'];
						$val['info'][$rkey]['addressreceiver']=$address['receiver'];
					}
					
					if($row['is_unusual']==0)
					{
						$val['info'][$rkey]['usersign']='正常';
					}else
					{
						$val['info'][$rkey]['usersign']='封号';
					}
					
					if($row['fetchno']>0)
					{
						$val['info'][$rkey]['fetchno']='中奖';
					}else
					{
						$val['info'][$rkey]['fetchno']='';
					}
					
					unset($val['info'][$rkey]['addressjson']);
					unset($val['info'][$rkey]['is_unusual']);
					array_push($res,$val['info'][$rkey]);
				}
			}
		}
		
		//print_r($res);exit;
		
		//print_r($result);exit;
		array_unshift($res,$array);
		$time=date('Y-m-d',time());
	    //print_r($result);exit;
        Excel::create($time.$name,function($excel) use ($res){
        $excel->sheet('score', function($sheet) use ($res){
        $sheet->rows($res);
        });
        })->export('xls');
	}

	
}