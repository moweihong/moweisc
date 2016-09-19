<?php
namespace App\Http\Controllers\Backend;
use App\Models\Member;
use App\Models\KlbeanCharge;
use App\Models\KlbeanUser;
use Request,Validator;
use App\Http\Controllers\BaseController;
use App\Models\AddMoneyRecord;
use DB;

class PromoteController extends BaseController
{
    //充值卡状态列表
    public function index()
    {
        $promotelist=KlbeanCharge::where('recommend_id','>',0)->orderBy('card_num','desc')->paginate(30);
		$data['promotelist']=$promotelist;
		//print_r($promotelist);exit;
		return view('backend.promote.promotelist',$data);
    }
	
	//充值卡查询
	public function search()
    {
    	
		$cardnum=explode(',', $_POST['cardnum']);
		$promotelist=KlbeanCharge::wherein('card_num',$cardnum)->orderBy('id','desc')->paginate(100);
		//print_r($promotelist);exit;
		$data['promotelist']=$promotelist;
//      $sql='select * from  tab_klbean_charge  where card_num in ('.$_POST['cardnum'].')';	
//		$promotelist=DB::select($sql);
//		$data['promotelist']=$promotelist;
		//print_r($promotelist);exit;
		return view('backend.promote.promotelist',$data);
    }
	
	//推广员列表
	public function userIndex()
    {
        $promotelist=KlbeanUser::paginate(20);
		foreach($promotelist as $key=>$v)
		{
			//$tolnum=KlbeanCharge::where('recommend_id',$v->usr_id)->count();//总共
			$tiemoutnum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',2)->count();//过期
			$usenum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',1)->count();//使用
			$nousenum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',0)->count();//可用
			$dongjienum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',3)->count();//冻结
			$promotelist[$key]['timeoutnum']=$tiemoutnum;
			$promotelist[$key]['usenum']=$usenum;
			$promotelist[$key]['nousenum']=$nousenum;
			$promotelist[$key]['dongjienum']=$dongjienum;
		}
		$data['userlist']=$promotelist;
		
		//print_r($promotelist);exit;
		return view('backend.promote.promoteuser',$data);
    }
	
	//推广员查询
	public function searchUser($mobile)
    {
       // $mobile='select * from  tab_klbean_user  where mobile like "%'.$mobile.'%"';
		$promotelist=KlbeanUser::where('mobile','like','%'.$mobile.'%')->paginate(10);	
		//$promotelist=DB::select($sql);
		//print_r($promotelist);exit;
		foreach($promotelist as $key=>$v)
		{
			//$tolnum=KlbeanCharge::where('recommend_id',$v->usr_id)->count();//总共
			$tiemoutnum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',2)->count();//过期
			$usenum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',1)->count();//使用
			$nousenum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',0)->count();//可用
			$dongjienum=KlbeanCharge::where('recommend_id',$v->usr_id)->where('status',3)->count();//冻结
			$promotelist[$key]['timeoutnum']=$tiemoutnum;
			$promotelist[$key]['usenum']=$usenum;
			$promotelist[$key]['nousenum']=$nousenum;
			$promotelist[$key]['dongjienum']=$dongjienum;
		}
		$data['userlist']=$promotelist;
		return view('backend.promote.promoteuser',$data);

    }
	
	//添加卡数
	public function addUserCardNum()
	{
		$cardnum=$_GET['cardnum'];
		$usrid=$_GET['usrid'];
		$tolnum=KlbeanCharge::where('recommend_id','')->where('status','<>',2)->count();
		//echo $tolnum;exit;
		if($cardnum>$tolnum)
		{
			$data['status']='-1';
			$data['msg']='库存不足了';
		}
		else
		{
			$sql='update tab_klbean_charge set recommend_id='.$usrid.' where id in( SELECT t.id from (select * from tab_klbean_charge where recommend_id =" " limit '.$cardnum.') as t )';
			$affected=DB::update($sql);
			if($affected!=0)
			{
				$data['status']='0';
				$data['msg']='操作成功';
			}
			else
			{
				$data['status']='-2';
				$data['msg']='操作失败';
			}
		}
		echo json_encode($data);
	}
	
	//新式绑卡
	public function bangka()
	{
		return view('backend.promote.bangka');
	}
	
	
	//推广员新增
	public function addUser()
    {
    	$mobile=$_GET['mobile'];
    	$userinfo=Member::where('mobile',$mobile)->select('usr_id')->first();
		if(!$userinfo)
		{
			$data['status']='-1';
			$data['msg']='账号不存在';
		
		}
		else
		{
	        $data['usr_id']=$userinfo['usr_id'];
			$data['mobile']=$mobile;
			$data['time']=time();
			$id = DB::table('tab_klbean_user')->insert($data);
			if ($id>0){
	            $data['status']='0';
				$data['msg']='操作成功';
	        } else {
	            $data['status']='-2';
				$data['msg']='操作失败';
	        }
	
		}
		echo json_encode($data);
    }
	
	//批量操作
	public function plUpdata()
	{
		
		$pid='';
		if(isset($_POST['status']))
		{
			$num=count($_POST['status'])-1;
			foreach($_POST['status'] as $key=>$v)
			{
				
				if($key==$num)
				{
					$pid=$pid.$v;
				}
				else
				{
					$pid=$pid.$v.',';
				}
				
			}
			//解冻
			if($_POST['atype']==0)
			{
				$sql='update tab_klbean_charge set status=0 where status not in (1,2) and id in('.$pid.')';	
			}
			else//冻结
			{
				$sql='update tab_klbean_charge set status=3 where status not in (1,2) and id in('.$pid.')';
			}
			$affected=DB::update($sql);
			return redirect('/backend/promote');
		}
		else
		{
			echo '数据出错,请重新提交！';exit;
		}
		
	
	}
	
	//单个操作
	public function upIsJiedong()
	{
		//冻结
		$type=$_GET['type'];
		$id=$_GET['id'];
		if($type==1)
		{
			$sql='update tab_klbean_charge set status=3 where status not in (1,2) and id='.$id;	
		}
		else
		{
			$sql='update tab_klbean_charge set status=0 where status not in (1,2) and id='.$id;	
		}
		$affected=DB::update($sql);
		if($affected==1)
		{
			$data['status']='0';
			$data['msg']='操作成功';
		}
		else
		{
			$data['status']='-1';
			$data['msg']='操作失败';
		}
		echo json_encode($data);
	}
	
	
	//单个操作
	public function testUser()
	{
		$mobile=$_GET['mobile'];
		$userinfo=Member::where('mobile',$mobile)->select('usr_id')->first();
		if(!$userinfo)
		{
			$data['status']='-1';
			$data['msg']='账号未注册';
		
		}
		else
		{
			$usertuiguang=KlbeanUser::where('mobile',$mobile)->select('usr_id')->first();
			if($usertuiguang)
			{
				$data['status']='-1';
				$data['msg']='账号已存在';
			
			}
			else
			{
				$data['status']='0';
				$data['msg']='可以注册';
			}
		}
		//print_r($data);exit;
		echo json_encode($data);
	}
	
	//线下推荐人数查询
	 public function  getOfflineInfo($mobile=''){
	 	
	 	if(!empty($mobile))
	 	{
	 		//echo $mobile;
	 		$recommend_id=Member::where('mobile',$mobile)->select('usr_id')->first();
	 		//$promotelist=KlbeanCharge::where('status',1)->where('tab_member.mobile',$mobile)->join('tab_member','tab_member.usr_id','=','tab_klbean_charge.recommend_id')->paginate(30);
			$promotelist=KlbeanCharge::where('status',1)->where('recommend_id',$recommend_id['usr_id'])->paginate(100);
			$usernum=KlbeanCharge::where('status',1)->where('recommend_id',$recommend_id['usr_id'])->count();
			
			foreach($promotelist as $key=>$v)
			{
				//print_r($v);
				$invite_uid=$v->usersec->usr_id;//邀请用户的uid
				//查询此用户的消费情况
				$promotelist[$key]->xfmoney=AddMoneyRecord::where('bid','<>','')->where('usr_id',$invite_uid)->sum('amount');
				
				
			}
			//print_r($promotelist);exit;
		
			$data['list']=$promotelist;
			$data['usernum']=$usernum;
			
	 	}else
	 	{
	 		$data['list']=array();
			$data['usernum']=0;
	 	}
       	//print_r($data);
        return view('backend.promote.promoteuserinfo',$data);
    }

	//卡号区间查询8-17
	public function searchNum()
	{
		if(empty($_POST['startnum']) || empty($_POST['endnum']))
		{
			$data['code']=-1;
			$data['result']='请先填卡号';
			
		}
		else
		{
			$data['data']['overdue']=KlbeanCharge::where('card_num','>=',$_POST['startnum'])->where('card_num','<=',$_POST['endnum'])->where('status',2)->count();//过期
			$data['data']['charge']=KlbeanCharge::where('card_num','>=',$_POST['startnum'])->where('card_num','<=',$_POST['endnum'])->where('status',1)->count();//充值
			$data['data']['nobind']=KlbeanCharge::where('card_num','>=',$_POST['startnum'])->where('card_num','<=',$_POST['endnum'])->where('status',0)->whereNull('recommend_id')->count();//未绑定
			$data['data']['isbind']=KlbeanCharge::where('card_num','>=',$_POST['startnum'])->where('card_num','<=',$_POST['endnum'])->where('status',0)->whereNotNull('recommend_id')->count();//绑定
			$data['data']['freeze']=KlbeanCharge::where('card_num','>=',$_POST['startnum'])->where('card_num','<=',$_POST['endnum'])->where('status',3)->count();//冻结
			$data['code']=1;
			$data['result']='success';
		}
		echo json_encode($data);
	}

	//卡号区间批量解绑
	public function noBindRecommendid()
	{
		if(empty($_POST['startnum']) || empty($_POST['endnum']))
		{
			$data['code']=-1;
			$data['result']='请先填卡号';
			
		}
		else
		{
			$usrid='NULL';
			$sql="update tab_klbean_charge set recommend_id=".$usrid.",status=0 where card_num>='".$_POST['startnum']."' and  card_num<='".$_POST['endnum']."' and status != 1 ";
			$affected=DB::update($sql);
			if($affected!=0)
			{
				$data['code']=1;
				$data['result']='解绑成功';
			}
			else
			{
				$data['status']=-2;
				$data['result']='解绑失败';
			}
		}
		echo json_encode($data);
	}
	
	//卡号区间批量绑定
	public function submitBind()
	{
		if(empty($_POST['startnum']) || empty($_POST['endnum']) || empty($_POST['upcardnum']) || empty($_POST['usrphone']) )
		{
			$data['code']=-1;
			$data['result']='请先填绑定卡数和推荐人';
			
		}
		else
		{
			$usertuiguang=KlbeanUser::where('mobile',$_POST['usrphone'])->select('usr_id')->first();
			if($usertuiguang)
			{
				
				$usrid=$usertuiguang['usr_id'];
				$nobind=KlbeanCharge::where('card_num','>=',$_POST['startnum'])->where('card_num','<=',$_POST['endnum'])->where('status',0)->whereNull('recommend_id')->count();//未绑定
				if($_POST['upcardnum']>$nobind)
				{
					$data['code']=-2;
					$data['result']='绑定卡数不足';
					echo json_encode($data);exit;
				}
				$sql="update tab_klbean_charge set recommend_id=".$usrid." where id in( SELECT t.id from (select * from tab_klbean_charge where recommend_id is Null and card_num>='".$_POST['startnum']."' and  card_num<='".$_POST['endnum']."' and status != 1  limit ".$_POST['upcardnum'].") as t )";
				$affected=DB::update($sql);
				if($affected!=0)
				{
					$data['code']=1;
					$data['result']='绑定成功';
				}
				else
				{
					$data['status']=-3;
					$data['result']='绑定失败';
				}
			
			}
			else
			{
				$data['code']=-2;
				$data['result']='此号码还没有设置为推广人，请先添加';
			}
			
		}
		echo json_encode($data);
	}
	
	
	
	
	protected function javaUrl($url,$arr)
	{
        $url_java = config('global.api.base_url');
		
		$readUrl=$url_java.$url.'?';
		
	    foreach($arr as $k=>$v)
		{
			$readUrl=$readUrl.$k.'='.$v.'&';
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch, CURLOPT_URL, $readUrl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec($ch);
		return $output;
		
	}
	
}
