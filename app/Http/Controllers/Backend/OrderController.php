<?php
namespace App\Http\Controllers\Backend;
use App\Models\Order;
use App\Models\Address;
use Request,Validator;
use App\Http\Controllers\BaseController;
use Excel;
use DB;
use App\Models\Goods;
use App\Models\InviteGoods;
use App\Models\Member;
use App\Models\Merchants;


class OrderController extends BaseController
{
    /*
     * 显示所有订单
     */
    public function index(Request $request) {
    	
        $order = new Order();
		$url['page']=isset($_GET['page'])?$_GET['page']:1;
		//发货15天后自动确认
	   // Order::where('status','4')->where('shiptime')->update(['status'=>5,'shiptime'=>time()]);
		$supplierList=merchants::where('is_delete',0)->get(); 
		DB::update('update tab_bid_record set status="5",shiptime="'.time().'" where status = 4 and `shiptime`+3600*24*15 < "'.time().'"');
	
        if ($request::isMethod('post')){
            if($request::has('orderid'))
            {
                //根据订单查询
                $list = Order::where('code',$request::input('orderid'))->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
                ->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','fetchno','bid_time','kaijiang_time','affirm_time','shiptime','money','status','is_virtual','usr_id','supplier')
                ->paginate(50);
				//print_r($list);exit;
                $url=http_build_query($url);
				foreach($list as $key=>$v)
				{
					$sign=member::where('usr_id',$v->usr_id)->select('is_unusual')->first();
					if($sign['is_unusual']==0){$list[$key]['sign']='正常';}else{$list[$key]['sign']='封号';}
					$money=Goods::where('id',$v->g_id)->select('money')->first();
					
			
				}
				
                return view('backend.order.indexnew',array('list'=>$list,'url'=>$url,'num'=>1,'summoney'=>$money['money'],'supplierList'=>$supplierList));
            } else {
                //根据选择状态查询
                //var_dump($_POST);exit;
				$request::session()->forget('order');
				if($_POST['end_time']){@session(['order.endtime'    => $_POST['end_time']]);$order_endtime=strtotime($_POST['end_time'])*1000;$url['end_time']=$order_endtime;}
				if($_POST['start_time']){@session(['order.starttime'    => $_POST['start_time']]);$order_starttime=strtotime($_POST['start_time'])*1000;$url['start_time']=$order_starttime;}
				if($_POST['is_virtual']!=-1){@session(['order.virtual'    => $_POST['is_virtual']]);$url['is_virtual']=$_POST['is_virtual'];}
				if($_POST['timetype']!=-1){@session(['order.timetype'    => $_POST['timetype']]);$url['timetype']=$_POST['timetype'];}
				if($_POST['zhongjiang']!=-1){@session(['order.zhongjiang'    => $_POST['zhongjiang']]);}
                if($_POST['supplier']!='0'){echo 111;@session(['order.supplier'    => $_POST['supplier']]);$url['supplier']=$_POST['supplier'];}
				//print_r($_POST);exit;
				if($_POST['phone'])
				{
					@session(['order.phone'    => $_POST['phone']]);
					$usridarr=member::where('mobile',$_POST['phone'])->select('usr_id')->first();
					$usrid=$usridarr['usr_id'];
					if(empty($usrid))
					{
						 return view('backend.order.indexnew',array('list'=>'','url'=>'','num'=>0,'summoney'=>'','supplierList'=>$supplierList));
					}
				}
                //echo $order_endtime;exit;
				//echo $order_starttime;
				
			
                $status = $request::input('status');
                if ($status != -1)
                {
                	 if($_POST['status']){@session(['order.status'    => $_POST['status']]);$url['status']=$status;}
                    if($status == 2){
                        //2待确认状态
                        $list = Order::where('status',$status)->whereNotNull('fetchno')->whereNull('addressjson')->where('fetchno','>',0);
                    	
						
					}else {
                        $list = Order::where('status',$status);  
                    }
					if($_POST['timetype']=='0')
					{
						!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
						!empty($order_endtime)&& $list=$list->where('bid_time','<',$order_endtime);
					}
					elseif($_POST['timetype']==1)
					{
						!empty($order_starttime)&& $list=$list->where('shiptime','>',$order_starttime/1000);
						!empty($order_endtime)&& $list=$list->where('shiptime','<',$order_endtime/1000);
					}
					else
					{
						!empty($order_starttime)&& $list=$list->where('affirm_time','>',$order_starttime/1000);
						!empty($order_endtime)&& $list=$list->where('affirm_time','<',$order_endtime/1000);
					} 
					               
                   	!empty($_POST['supplier'])&& $list=$list->where('supplier',$_POST['supplier']);
					isset($usrid)&& $list=$list->where('usr_id',$usrid);
					if($_POST['is_virtual']!=-1){$list=$list->where('is_virtual',$_POST['is_virtual']);}
					if($_POST['zhongjiang']==0)
					{
						$list=$list->where('fetchno','>',0);
					}elseif($_POST['zhongjiang']==1)
					{
						$list=$list->whereNull('fetchno');
					}
					
					$listinfo=$list->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc')
					->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','pay_type','fetchno','bid_time','kaijiang_time','affirm_time','shiptime','money','status','is_virtual','usr_id','supplier')
					->paginate(50);
					
					
					$num=$listinfo->total();//总条数
					$summoney=$list->sum('ykg_goods.money');					//金额
					
					
					foreach($list as $key=>$v)
					{
						$sign=member::where('usr_id',$v->usr_id)->select('is_unusual')->first();
						if($sign['is_unusual']==0){$list[$key]['sign']='正常';}else{$list[$key]['sign']='封号';}
						
					}
                    $url=http_build_query($url);
					//echo count($list);
					//print_r($listinfo);exit;
                    return view('backend.order.indexnew',array('list'=>$listinfo,'url'=>$url,'num'=>$num,'summoney'=>$summoney,'supplierList'=>$supplierList));
                }
				else
				{
					//echo  $order_starttime;
					$list =$order;
					if($_POST['timetype']=='0')
					{
						!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
						!empty($order_endtime)&& $list=$list->where('bid_time','<',$order_endtime);
					}
					elseif($_POST['timetype']==1)
					{
						!empty($order_starttime)&& $list=$list->where('shiptime','>',$order_starttime/1000);
						!empty($order_endtime)&& $list=$list->where('shiptime','<',$order_endtime/1000);
					}
					else
					{
						!empty($order_starttime)&& $list=$list->where('affirm_time','>',$order_starttime/1000);
						!empty($order_endtime)&& $list=$list->where('affirm_time','<',$order_endtime/1000);
					} 
					isset($usrid)&& $list=$list->where('usr_id',$usrid); 
					!empty($_POST['supplier'])&& $list=$list->where('supplier',$_POST['supplier']);    
					if($_POST['is_virtual']!=-1){$list=$list->where('is_virtual',$_POST['is_virtual']);}
					if($_POST['zhongjiang']==0)
					{
						$list=$list->where('fetchno','>',0);
					}elseif($_POST['zhongjiang']==1)
					{
						$list=$list->whereNull('fetchno');
					}
					$list=$list->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc');
					$summoney=$list->sum('ykg_goods.money');
					$listinfo=$list->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','fetchno','bid_time','kaijiang_time','shiptime','affirm_time','money','status','is_virtual','usr_id','supplier')
					->paginate(50);
					//金额
					//print_r($listinfo);exit; 
					
				}
            }
        }
		elseif(session('order.status') || session('order.starttime') || session('order.endtime') || session('order.virtual')=='0' || session('order.virtual')==1 || session('order.supplier') || session('order.phone') || session('order.zhongjiang'))
		{
			
			$status=session('order.status');
			$virtual=session('order.virtual');
			$phone=session('order.phone');
			$zhongjiang=session('order.zhongjiang');
			//echo session('order.supplier');exit;
			$endtime=session('order.endtime');
			$starttime=session('order.starttime');
			$order_starttime=strtotime($starttime)*1000;
			$order_endtime=strtotime($endtime)*1000;
			$list = $order;
			$supplier=session('order.supplier');
			if(isset($status))
			{
				$url['status']=$status;
				if(session('order.status')==2){$list=$list->where('status',session('order.status'))->whereNotNull('fetchno')->where('fetchno','>',0)->where('addressid','=',0);}
				else{$list=$list->where('status',session('order.status'));}
			}
			if(isset($phone))
			{
				$usridarr=member::where('mobile',$phone)->select('usr_id')->first();
				$usrid=$usridarr['usr_id'];
				$list=$list->where('usr_id',$usrid);
			}
			if(isset($zhongjiang))
			{
				if($zhongjiang==0)
				{
					$list=$list->where('fetchno','>',0);
				}
				elseif($zhongjiang==1)
				{
					$list=$list->whereNull('fetchno');
				}
				
			}
					
			$url['end_time']=$order_endtime;
			$url['start_time']=$order_starttime;
			$url['is_virtual']=$virtual;
			if(session('order.timetype')=='0')
					{
						!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
						!empty($order_endtime)&& $list=$list->where('bid_time','<',$order_endtime);
						$url['timetype']=session('order.timetype');
					}
					elseif(session('order.timetype')==1)
					{
						!empty($order_starttime)&& $list=$list->where('shiptime','>',$order_starttime/1000);
						!empty($order_endtime)&& $list=$list->where('shiptime','<',$order_endtime/1000);
						$url['timetype']=session('order.timetype');
					}
					else
					{
						!empty($order_starttime)&& $list=$list->where('affirm_time','>',$order_starttime/1000);
						!empty($order_endtime)&& $list=$list->where('affirm_time','<',$order_endtime/1000);
						$url['timetype']=session('order.timetype');
					}      
			//!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
			//!empty($order_endtime)  &&   $list=$list->where('bid_time','<',$order_endtime);
			!empty($supplier)&& $list=$list->where('supplier',$supplier);    
			if($virtual=='0' || $virtual==1){$list=$list->where('is_virtual',$virtual);}
			$list=$list->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc');
			//金额
			$summoney=$list->sum('ykg_goods.money');
			$listinfo=$list->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','fetchno','bid_time','kaijiang_time','shiptime','affirm_time','money','status','is_virtual','usr_id','supplier')
			->paginate(50);
			
			
			
		}
		else
		{
			//echo  1;exit;
			//echo session('order.virtual');
			 $listinfo = Order::orderBy('bid_time','desc')->where('fetchno','>',0)->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc')
			        ->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','fetchno','bid_time','kaijiang_time','shiptime','money','affirm_time','status','is_virtual','usr_id','supplier')
			        ->paginate(50);
					
			//金额
			$summoney=Order::orderBy('bid_time','desc')->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
			->sum('ykg_goods.money');
					
		}
        $url=http_build_query($url);
		$num=$listinfo->total();
		foreach($listinfo as $key=>$v)
		{
			$sign=member::where('usr_id',$v->usr_id)->select('is_unusual')->first();
			if($sign['is_unusual']==0){$listinfo[$key]['sign']='正常';}else{$listinfo[$key]['sign']='封号';}
			
		}
	
        return view('backend.order.indexnew',array('list'=>$listinfo,'url'=>$url,'num'=>$num,'summoney'=>$summoney,'supplierList'=>$supplierList));
    }

	public function unsetSearch(Request $request)
	{
		$request::session()->forget('order');
		
	}
    /*
     *  审查订单  确认 就进入待发货状态 /删除订单
     */
    public function cheackOrder(Request $request) {
        if ($request::isMethod('post')){
            if ('ok' == $request::input('action')){
                //确认订单
                $order = Order::find($request::input('id'));
                $order->status = 3;
                if($order->update()){
                    $data['status'] = 1;
                    $data['msg'] = '订单确认成功，进入发货阶段';
                } else {
                    $data['status'] = 0;
                    $data['msg'] = '操作失败';  
                }
                return json_encode($data);
            }else if ('del' == $request::input('action')){
                //删除订单
                $order = Order::find($request::input('id'));
                if($order->delete()){
                    $data['status'] = 1;
                    $data['msg'] = '订单删除成功';
                } else {
                    $data['status'] = 0;
                    $data['msg'] = '操作失败';
                }
                return json_encode($data);
            }
        }
    }

	public function sendGood()
	{
//		  $_POST['delivery_code']='111111';
//		  $_POST['delivery']='顺丰快递';
//		  $_POST['id']=6975;
		  $order = Order::find($_POST['id']);
		  if(!$order->addressjson)
		  {
		  	$retult['code']=-3;
			$retult['msg']='收货人手机号码缺失';
			echo json_encode($retult);exit;
		  }
		  $userinfo=json_decode($order->addressjson,TRUE);
		 //发送短信通知用户
		 $phone_number=$userinfo['mobile'];
		 $template_id='21945';
		 $param=$_POST['delivery'];
		 $res=$this->sendtplsms($phone_number,$template_id,$param);
		 //var_dump($res);
		 //$resu=json_decode($res,TRUE);
		 if($res['code']==0)
		 {
		 	 $order = Order::find($_POST['id']);
			 $order->delivery_code=$_POST['delivery_code'];
			 $order->delivery=$_POST['delivery'];
			 $order->status=4;
			 $order->shiptime=time();
			 if($order->save())
			 {
			 	$retult['code']=1;
				$retult['msg']='发货成功';
				
			 }
			 else
			 {
			 	
			 	$retult['code']=-1;
				$retult['msg']='操作失败';
			 }
		 }
		 else
		 {
		 	$retult['code']=-2;
			$retult['msg']='短信发送失败';
		 }
		
		echo json_encode($retult);
	}

    /*
     * 查看订单
     */
    public function orderLook($id) {
        $order = Order::find($id);
		if(empty($order['addressjson']))
		{
		   
	        if($order->relateAddress)
	        {
	            
	            $data['receiver'] = $order->relateAddress->receiver;
	            $data['country'] = $order->relateAddress->country;
	            $data['province'] = $order->relateAddress->province;
	            $data['city'] = $order->relateAddress->city;
	            $data['area'] = $order->relateAddress->area;
	            $data['mobile'] = $order->relateAddress->mobile;
				$data['notice'] = $order->relateAddress->notice;
				$order->addressjson=json_encode($data);
				$order->update();
			}
			$order->addressjson=(object)array();
			$order->addressjson->province='';
			$order->addressjson->receiver='';
			$order->addressjson->country='';
			$order->addressjson->city='';
			$order->addressjson->area='';
			$order->addressjson->notice='';
			$order->addressjson->mobile='';	
        }
		else
		{
			$order->addressjson=json_decode($order['addressjson']);
			if(!isset($order->addressjson->notice))
			{	
				$order->addressjson->notice='';
			}
			if(strpos($order->addressjson->province, '\\') == false)
			{
				
				$order->addressjson->province=str_replace('u','\u',$order->addressjson->province);
				$order->addressjson->receiver=str_replace('u','\u',$order->addressjson->receiver);
				$order->addressjson->country=str_replace('u','\u',$order->addressjson->country);
				$order->addressjson->city=str_replace('u','\u',$order->addressjson->city);
				$order->addressjson->area=str_replace('u','\u',$order->addressjson->area);
				
				$arr["province"] = json_decode('{"province":"'.$order->addressjson->province.'"}', true);
				$arr["city"] = json_decode('{"city":"'.$order->addressjson->city.'"}', true);
				$arr["country"] = json_decode('{"country":"'.$order->addressjson->country.'"}', true);
				$arr["area"] = json_decode('{"area":"'.$order->addressjson->area.'"}', true);
				$arr["receiver"] = json_decode('{"receiver":"'.$order->addressjson->receiver.'"}', true);
				
				$order->addressjson->province=$arr["province"]["province"];
				$order->addressjson->receiver=$arr["receiver"]["receiver"];
				$order->addressjson->country=$arr["country"]["country"];
				$order->addressjson->city=$arr["city"]["city"];
				$order->addressjson->area=$arr["area"]["area"];
			}
		}
		
		//print_r($order->goods);exit;
        return view('backend.order.orderDetailnew',array('order'=>$order));
    }
    
	
	//订单打印
	public function orderdayin($id)
	{
		$info=Order::where('tab_bid_record.id','=',$id)
			  ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
			  ->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
			  ->select('ykg_goods.title2','mobile','nickname','code','kaijiang_time','ykg_goods.money')
			  ->first();
		$info->mobile=$this->trimall($info->mobile);
		$info->numtormb=$this->num_to_rmb($info->money);
		//print_r($this->num_to_rmb($info->money));exit;
		$data['data']=$info;
		$data['sign']=1;	 
		$data['type']=1;	 
		return view('backend.order.orderdayin',$data);
		
	}
	
	//活动订单打印
	public function orderdayinp($id)
	{
		$info=Order::where('tab_bid_record.id','=',$id)
			  ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
			  ->join('tab_invite_goods','tab_invite_goods.id','=','tab_bid_record.g_id')
			  ->select('ykg_goods.title2','mobile','nickname','code','bid_time as kaijiang_time','invite_money as money')
			  ->first();
		$info->mobile=$this->trimall($info->mobile);
		$info->numtormb=$this->num_to_rmb($info->money);
		$data['data']=$info;
		$data['sign']=0;	 
		$data['type']=0;	 
		return view('backend.order.orderdayin',$data);
		
	}
    
	//设置批量打印的id
	public function setDayinId(request $request)
	{
		$request::session()->forget('dayinsession');
		if($_POST['id'])
		{
			@session(['dayinsession.id'    => $_POST['id']]);
		}
		//print_r($_POST['id']);
	}
	
	//批量打印
	public function orderdayinpl()
	{
		
		$info=Order::wherein('tab_bid_record.id',session('dayinsession.id'))
			  ->join('tab_member','tab_member.usr_id','=','tab_bid_record.usr_id')
			  ->join('ykg_goods','ykg_goods.id','=','tab_bid_record.g_id')
			  ->select('ykg_goods.title2','mobile','nickname','code','kaijiang_time','ykg_goods.money')
			  ->get();
		foreach($info as $key=>$val)
		{
			$info[$key]['numtormb']=$this->num_to_rmb($val['money']);
		}
		$data['data']=$info;
		
		//print_r($info);exit;
		$data['sign']=1;	 
		$data['type']=1;	 
		return view('backend.order.orderdayinpl',$data);
		
	}

	protected function num_to_rmb($num){
	    $c1 = "零壹贰叁肆伍陆柒捌玖";
	    $c2 = "分角元拾佰仟万拾佰仟亿";
	    //精确到分后面就不要了，所以只留两个小数位
	    $num = round($num, 2); 
	    //将数字转化为整数
	    $num = $num * 100;
	    if (strlen($num) > 10) {
	        return "金额太大，请检查";
	    } 
	    $i = 0;
	    $c = "";
	    while (1) {
	        if ($i == 0) {
	            //获取最后一位数字
	            $n = substr($num, strlen($num)-1, 1);
	        } else {
	            $n = $num % 10;
	        }
	        //每次将最后一位数字转化为中文
	        $p1 = substr($c1, 3 * $n, 3);
	        $p2 = substr($c2, 3 * $i, 3);
	        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
	            $c = $p1 . $p2 . $c;
	        } else {
	            $c = $p1 . $c;
	        }
	        $i = $i + 1;
	        //去掉数字最后一位了
	        $num = $num / 10;
	        $num = (int)$num;
	        //结束循环
	        if ($num == 0) {
	            break;
	        } 
	    }
	    $j = 0;
	    $slen = strlen($c);
	    while ($j < $slen) {
	        //utf8一个汉字相当3个字符
	        $m = substr($c, $j, 6);
	        //处理数字中很多0的情况,每次循环去掉一个汉字“零”
	        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
	            $left = substr($c, 0, $j);
	            $right = substr($c, $j + 3);
	            $c = $left . $right;
	            $j = $j-3;
	            $slen = $slen-3;
	        } 
	        $j = $j + 3;
	    } 
	    //这个是为了去掉类似23.0中最后一个“零”字
	    if (substr($c, strlen($c)-3, 3) == '零') {
	        $c = substr($c, 0, strlen($c)-3);
	    }
	    //将处理的汉字加上“整”
	    if (empty($c)) {
	        return "零元整";
	    }else{
	        return $c . "整";
	    }
	}
	
	//导表
	public function daoBiao()
	{
		
		
		//$array=array('订单号','商品名称','商品期数','商品价格','手机号码','收货人','购买总数','是否中奖','收货地址','时间');
		$array=array('订单号','商品名称','商品期数','商品价格','购买人次','账号','昵称','收货地址','下单时间','开奖时间','发货时间','地址确认时间','账号异常', '收货人','收货人手机号码','备注');
		$name='订单表第'.$_GET['page'].'页';
		if(isset($_GET['prize']))
		{
			$where='where `tab_bid_record`.`pay_type`="invite"';
		}
		else
		{
			$where='where `tab_bid_record`.`pay_type`!="invite"';
		}
		if(isset($_GET['is_virtual'])){$where=$where.' and `ykg_goods`.`is_virtual` ='.$_GET['is_virtual'];}
		
		
		if(isset($_GET['timetype']) && $_GET['timetype']=='0')
		{
			if(isset($_GET['start_time'])&&$_GET['start_time']!=0){$where=$where.' and `tab_bid_record`.`bid_time` >'.$_GET['start_time'];}
			if(isset($_GET['end_time'])&&$_GET['end_time']!=0){$where=$where.'  and `tab_bid_record`.`bid_time`<'.$_GET['end_time'];}
		}
		elseif(isset($_GET['timetype']) && $_GET['timetype']==1)
		{
			if(isset($_GET['start_time'])&&$_GET['start_time']!=0){$where=$where.' and `tab_bid_record`.`shiptime` >'.$_GET['start_time']/1000;}
			if(isset($_GET['end_time'])&&$_GET['end_time']!=0){$where=$where.'  and `tab_bid_record`.`shiptime`<'.$_GET['end_time']/1000;}
		
		} 
		else
		{
			if(isset($_GET['start_time'])&&$_GET['start_time']!=0){$where=$where.' and `tab_bid_record`.`affirm_time` >'.$_GET['start_time']/1000;}
			if(isset($_GET['end_time'])&&$_GET['end_time']!=0){$where=$where.'  and `tab_bid_record`.`affirm_time`<'.$_GET['end_time']/1000;}
		}
		
		if(isset($_GET['status'])){$where=$where.' and `tab_bid_record`.`status`="'.$_GET['status'].'"';}
		if(isset($_GET['status'])&&$_GET['status']==2){$where=$where.' and `tab_bid_record`.`fetchno`>0 and `tab_bid_record`.`fetchno` is not null and addressjson is null';}
		
		$offset=($_GET['page']-1)*50;
		//$sql='select `tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.g_id,`tab_member`.`mobile`,`tab_member`.`nickname` ,`tab_bid_record`.buycount,`tab_bid_record`.fetchno,`tab_bid_record`.addressid,   FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time from `tab_bid_record` 
		//inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` '.$where.' order by `tab_bid_record`.`id` desc limit '.$offset.',50';
		if(isset($_GET['is_virtual']))
		{
			$sql='select `tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.g_id,`tab_bid_record`.buycount,`tab_member`.`mobile`,`tab_member`.`nickname` ,`tab_bid_record`.addressjson,FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time,
			FROM_UNIXTIME((`tab_bid_record`.`kaijiang_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as kaijiang_time,FROM_UNIXTIME((`tab_bid_record`.`shiptime`),"%Y年%m月%d日%H时%i分%s秒") as shiptime,
			FROM_UNIXTIME((`tab_bid_record`.`affirm_time`),"%Y年%m月%d日%H时%i分%s秒") as affirm_time,is_unusual from `tab_bid_record` 
			inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` inner join `ykg_goods` on `ykg_goods`.`id` = `tab_bid_record`.`g_id` '.$where.' order by `tab_bid_record`.bid_time desc limit '.$offset.',50';
		}
		else
		{
			$sql='select `tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.g_id,`tab_bid_record`.buycount,`tab_member`.`mobile`,`tab_member`.`nickname` ,`tab_bid_record`.addressjson,FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time ,
			FROM_UNIXTIME((`tab_bid_record`.`kaijiang_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as kaijiang_time,FROM_UNIXTIME((`tab_bid_record`.`shiptime`),"%Y年%m月%d日%H时%i分%s秒") as shiptime,
			FROM_UNIXTIME((`tab_bid_record`.`affirm_time`),"%Y年%m月%d日%H时%i分%s秒") as affirm_time,is_unusual from `tab_bid_record` 
			inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id`  '.$where.' order by `tab_bid_record`.bid_time desc limit '.$offset.',50';
		}
		//echo $sql;exit;
		$result=DB::select($sql);
	    
		$result=$this->object_array($result);
		if(!isset($_GET['prize']))
		{
			foreach($result as $key=>$val)
			{
				
				$resg=Goods::where('id','=',$val['g_id'])->select('money')->first();
				$result[$key]['g_id']=$resg['money'];
	//			if(empty($result[$key]['fetchno']))
	//			{
	//				$result[$key]['fetchno']='未中奖';
	//			}
				if(!empty($val['addressjson']))
				{
					
					$res=json_decode($val['addressjson'],TRUE);
					$province = $city = $country = $area = $receiver = '';
					if(strpos($res['province'], '\\') == false){
						for($k=0;$k<strlen($res['province']);$k++){
							if($k%5 == 0){
								$province .= "\\";
							}
							$province .= $res['province'][$k];
						}
						for($k=0;$k<strlen($res['city']);$k++){
							if($k%5 == 0){
								$city .= "\\";
							}
							$city .= $res['city'][$k];
						}
						for($k=0;$k<strlen($res['country']);$k++){
							if($k%5 == 0){
								$country .= "\\";
							}
							$country .= $res['country'][$k];
						}
						for($k=0;$k<strlen($res['area']);$k++){
							if($res['area'][$k] =='u'){
								$area .= "\\";
							}
							$area .= $res['area'][$k];
						}
						for($k=0;$k<strlen($res['receiver']);$k++){
							if($k%5 == 0){
								$receiver .= "\\";
							}
							$receiver .= $res['receiver'][$k];
						}
						
						$arr[0] = json_decode('{"province":"'.$province.'"}', true);
						$arr[1] = json_decode('{"city":"'.$city.'"}', true);
						$arr[2] = json_decode('{"country":"'.$country.'"}', true);
						$arr[3] = json_decode('{"area":"'.$area.'"}', true);
						$arr[4] = json_decode('{"receiver":"'.$receiver.'"}', true);
						
						$province = $arr[0]['province'] ? $arr[0]['province'] : $res['province'];
						$city = $arr[1]['city'] ? $arr[1]['city'] : $res['city'];
						$country = $arr[2]['country'] ? $arr[2]['country'] : $res['country'];
						$area = $arr[3]['area'] ? $arr[3]['area'] : $res['area'];
						$receiver = $arr[4]['receiver'] ? $arr[4]['receiver'] : $res['receiver'];
					}else{
						$province = $res['province'];
						$city = $res['city'];
						$country = $res['country'];
						$area = $res['area'];
						$receiver = $res['receiver'];
					}
					if(isset($res['notice']))
					{
						$notice='备注：'.$res['notice'];
					}else
					{
						$notice='备注：';
					}
					$result[$key]['addressjson']=$province.$city.$country.$area;
					$result[$key]['receiver']=$receiver;
					$result[$key]['receivermobile']=$res['mobile'];
					$result[$key]['notice']=$notice;
					//$result[$key]['addressjson'];
					//$result[$key]['nickname']=$res['receiver'];
				}
				else
				{
					$result[$key]['nickname']='地址未填写';
					$result[$key]['addressjson']='地址未填写';
				}
				
				if($val['is_unusual']==1)
				{
					$result[$key]['is_unusual']='封号';
				}
				else
				{
					$result[$key]['is_unusual']='正常';
				}
			}
		}
		else
		{
			//echo  1;exit;
			foreach($result as $key=>$val)
			{
				
				$resg=InviteGoods::where('id','=',$val['g_id'])->select('invite_money')->first();
			
				$result[$key]['g_id']=$resg['invite_money'];
				if(!empty($val['addressjson']))
				{
					$res=json_decode($val['addressjson'],TRUE);
					$result[$key]['addressjson']=$res['province'].$res['city'].$res['country'].$res['area'];
					$result[$key]['nickname']=$res['receiver'];
					$result[$key]['mobile']=$res['mobile'];
				}
				else
				{
					$result[$key]['nickname']='地址未填写';
					$result[$key]['addressjson']='地址未填写';
				}
				
				if($val['is_unusual']==1)
				{
					$result[$key]['is_unusual']='封号';
				}
				else
				{
					$result[$key]['is_unusual']='正常';
				}
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

	//领奖的订单列表
	public function getprizeorder(Request $request) {
        $order = new Order();
		$url['page']=isset($_GET['page'])?$_GET['page']:1;
		$url['prize']=1;
        if ($request::isMethod('post')){
            if($request::has('orderid'))
            {
                //根据订单查询
                $list = Order::where('code',$request::input('orderid'))->join('tab_invite_goods','tab_invite_goods.id','=','tab_bid_record.g_id')
                ->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','pay_type','bid_time','tab_bid_record.status as status')
                ->paginate(50);
                $url=http_build_query($url);
                return view('backend.order.prizeindex',array('list'=>$list,'url'=>$url));
            } else {
                //根据选择状态查询
                //var_dump($_POST);exit;
				$request::session()->forget('order');
				if($_POST['end_time']){@session(['order.endtime'    => $_POST['end_time']]);$order_endtime=strtotime($_POST['end_time'])*1000;$url['end_time']=$order_endtime;}
				if($_POST['start_time']){@session(['order.starttime'    => $_POST['start_time']]);$order_starttime=strtotime($_POST['start_time'])*1000;$url['start_time']=$order_starttime;}
                //echo $order_endtime;
				//echo $order_starttime;
                $status = $request::input('status');
                if ($status != -1)
                {
                	 if($_POST['status']){@session(['order.status'    => $_POST['status']]);$url['status']=$status;}
                    if($status == 2){
                        //2待确认状态
                        $list = Order::where('tab_bid_record.status',$status)->where('addressid','=',0);
                    	
						
					}else {
                        $list = Order::where('tab_bid_record.status',$status);  
                    } 
					                  
                   	!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
					!empty($order_endtime)&& $list=$list->where('bid_time','<',$order_endtime);
					$list=$list->where('pay_type',"invite");
					$list=$list->join('tab_invite_goods','tab_invite_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc')
					->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','pay_type','bid_time','tab_bid_record.status as status')
					->paginate(50);
                    $url=http_build_query($url);
					
                    return view('backend.order.prizeindex',array('list'=>$list,'url'=>$url));
                }
				else
				{
					//echo  $order_starttime;
					$list =$order;
					!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
					!empty($order_endtime)&& $list=$list->where('bid_time','<',$order_endtime);
					$list=$list->where('pay_type',"invite");
					$list=$list->join('tab_invite_goods','tab_invite_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc')
					->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','pay_type','bid_time','tab_bid_record.status')
					->paginate(50);
				}
            }
        }
		elseif(session('order.status') || session('order.starttime') || session('order.endtime')  )
		{
			
			$status=session('order.status');
			$endtime=session('order.endtime');
			$starttime=session('order.starttime');
			$order_starttime=strtotime($starttime);
			$order_endtime=strtotime($endtime);
			$list = $order;
			if(isset($status))
			{
				$url['status']=$status;
				if(session('order.status')==2){$list=$list->where('tab_bid_record.status',session('order.status'))->where('addressid','=',0);}
				else{$list=$list->where('tab_bid_record.status',session('order.status'));}
			}
			$url['end_time']=$order_endtime;
			$url['start_time']=$order_starttime;
			!empty($order_starttime)&& $list=$list->where('bid_time','>',$order_starttime);
			!empty($order_endtime)  &&   $list=$list->where('bid_time','<',$order_endtime);
			$list=$list->where('pay_type',"invite");
			$list=$list->join('tab_invite_goods','tab_invite_goods.id','=','tab_bid_record.g_id')->orderBy('bid_time','desc')
			->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','pay_type','bid_time','tab_bid_record.status as status')
			->paginate(50);
			
		}
		else
		{
			
			 $list = Order::orderBy('bid_time','desc')->join('tab_invite_goods','tab_invite_goods.id','=','tab_bid_record.g_id')
			         ->where('pay_type',"invite")
			         ->select('tab_bid_record.id as id','g_name','code','g_id','g_periods','buycount','pay_type','bid_time','tab_bid_record.status as status')
			         ->paginate(50);
					// print_r($list);exit;
		}
        $url=http_build_query($url);
		
        return view('backend.order.prizeindex',array('list'=>$list,'url'=>$url));
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
	
	protected function trimall($str)//删除空格
	{
	    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
	    return str_replace($qian,$hou,$str);    
	}
	
	/*
	*订单自提
	*/
	public function takeOrder(Request $request)
	{
		$order = Order::find($request::input('id'));
		$order->status = 4;
		$order->delivery = '自提';
		 $order->shiptime=time();
		if($order->update()){
			$data['status'] = 1;
			$data['msg'] = '订单自提成功';
		} else {
			$data['status'] = 0;
			$data['msg'] = '操作失败';  
		}
		return json_encode($data);
	}
	
	/*
	*订单批量自提
	*/
	public function takeOrderpl(Request $request)
	{
		//echo json_encode($_POST);exit;
		if(!isset($_POST['id']) || empty($_POST['id']))
		{
			$data['status'] = 0;
			$data['msg'] = '操作失败';  
		}
		else
		{
			$id=$_POST['id'];
			$updata['status']=4;
			$updata['shiptime']=time();
			$updata['delivery']='自提';
			$order = DB::table('tab_bid_record')->wherein('id',$id)->where('status','3')->update($updata);
			if($order>0){
				$data['status'] = 1;
				$data['msg'] = '订单自提成功';
			} else {
				$data['status'] = 0;
				$data['msg'] = '操作失败';  
			}
		}
		
		echo  json_encode($data);
	}
    
    
}
