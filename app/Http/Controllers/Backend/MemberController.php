<?php
/* m1 add by tangzhe 2016-08-03 获取各渠道注册人数接口
   m2 add by tangzhe 2016-08-04 生成友情链接硬盘数组式缓存
   m3 add by tangzhe 2016-08-08 获取渠道注册人按时间检索

*/
namespace App\Http\Controllers\Backend;
use App\Models\Member;
use App\Models\AddMoneyRecord;
use App\Models\Loginlog;
use App\Models\ShowOrder;
use App\Models\Goods;
use App\Models\Userpoint;
use App\Models\Link;
use App\Models\Cash;
use App\Models\WithdrawCash;
use App\Models\Commission;
use Request,Validator;
use DB;
use App\Http\Controllers\BaseController;
use Excel;
use App\Http\Controllers\Backend\Common\pageclass;

class MemberController extends BaseController
{
    /*
     * 显示所有的用户
     */
    public function index($username=''){
       // $username = $this->getParam('username', ''); 搜索错误bug修改
        $member = new Member();
        if($username != ''){
            $list = Member::where('mobile','like','%'.$username.'%')->orderBy('id','desc')->paginate(50);
            
        }else{
            $list = $member->getAll();
        }
		foreach($list as $key=>$val)
		{
			$money=AddMoneyRecord::
				where('tab_member_addmoney_record.usr_id',$val->usr_id)
			    ->where('tab_member_addmoney_record.money','<>','0')
		        ->wherein('tab_member_addmoney_record.status',[1,4,5])
				->sum('money');
			
			$list[$key]->buymoney=$money;
		}
		
		//m1 
		$url     = 'unify_interface/user/getLogincntList.do';
		$regList = $this->javaUrl($url,array('platform_source'=>'3'));
		$res     = json_decode($regList,TRUE);
		$res     = json_decode($res['resultText'],TRUE);
        return view('backend.member.index', array('list' => $list,'reg'=>$res,'username'=>$username,'url'=>''));
    }
	
	//m3
	public function muchPhoneSearch(Request $request)
	{
		$url['page']=isset($_GET['page'])?$_GET['page']:1;
		if ($request::isMethod('post'))
		{
			//echo 1111;exit;
			//print_r($_POST);exit;
			$request::session()->forget('member');
			if($_POST['phones']){@session(['member.phones'    => $_POST['phones']]);}
			if($_POST['start_time']){@session(['member.starttime'    => $_POST['start_time']]);}
			if($_POST['end_time']){@session(['member.endtime'    => $_POST['end_time']]);}
		}
		
		if(session('member.phones'))
		{
			$phonearr=explode(',', session('member.phones'));
			//print_r($phonearr);
			$list=Member::wherein('mobile',$phonearr)->orderBy('id','desc')->paginate(50);
			$url['phones']=session('member.phones');
		}
		elseif(session('member.starttime'))
		{
			$end_time=strtotime(session('member.endtime'));
			$start_time=strtotime(session('member.starttime'));
			$list=Member::where('reg_time','>=',$start_time)->where('reg_time','<',$end_time)->orderBy('id','desc')->paginate(50);
			$url['starttime']=$start_time;
			$url['end_time']=$end_time;
		}
		else
		{
			$list = Member::orderBy('id','desc')->paginate(50);
		}
		foreach($list as $key=>$val)
		{
			$money=AddMoneyRecord::
				where('tab_member_addmoney_record.usr_id',$val->usr_id)
			    ->where('tab_member_addmoney_record.money','<>','0')
		        ->wherein('tab_member_addmoney_record.status',[1,4,5])
				->sum('money');
			
			$list[$key]->buymoney=$money;
		}
		$url=http_build_query($url);	
		//m3
		$url2     = 'unify_interface/user/getLogincntList.do';
		$where   = array('platform_source'=>'3');
		if(session('member.starttime')) $where['reg_time_begin'] = str_replace(' ','%20',session('member.starttime'));
		if(session('member.endtime'))   $where['reg_time_end']   = str_replace(' ','%20',session('member.endtime')); 
		$regList = $this->javaUrl($url2,$where);
		$res     = json_decode($regList,TRUE);
		$res     = json_decode($res['resultText'],TRUE);
		return view('backend.member.index', array('list' => $list,'reg'=>$res,'url'=>$url,'username'=>''));
	}
    /*
     * 异常用户管理  16.6.20 by byl
     */
    public function unsafeUser($username=''){
        $inviteNums = 0;
        $list = NULL;
        if($username != ''){
            $member = Member::where('mobile','=',$username)->first();
            if($member){
                $url='unify_interface/user/getUsrLowerlist.do';
                $result=$this->javaUrl($url,['usr_id'=>$member->usr_id]);
                $resultText=json_decode($result,TRUE);
                if ($resultText['code'] == 0){
                    $users = json_decode($resultText['resultText'],TRUE);
                    $inviteNums = count($users);
                    foreach ($users as $key=>$val){
                        $user = Member::find($val['usr_id']);
                        $list[$key]['id'] = $user->id;
                        $list[$key]['usr_id'] = $user->usr_id;
                        $list[$key]['mobile'] = $user->mobile;
                        $list[$key]['nickname'] = $user->nickname;
                        $list[$key]['money'] = $user->money;
                        $list[$key]['commission'] = $user->commission;
                        $list[$key]['kl_bean'] = $user->kl_bean;
                        $list[$key]['kl_money'] = $user->kl_money;
                        $list[$key]['usr_level'] = $user->usr_level;
                        $list[$key]['exps'] = $user->exps;
                        $list[$key]['is_unusual'] = $user->is_unusual;
                    }
                }
            }
        }
        return view('backend.member.unsafeuser',[ 'list'=>$list,'username'=>$username,'inviteNums'=>$inviteNums]);
    }
    
    /*
     * 标记所有好友为异常  16.6.20 by byl
     */
    public function markAllUnsafe()
    {
        $mobile = Request::input('mobile');
        $member = Member::where('mobile','=',$mobile)->first();
        if($member){
            $url='unify_interface/user/getUsrLowerlist.do';
            $result=$this->javaUrl($url,['usr_id'=>$member->usr_id]);
            $resultText=json_decode($result,TRUE);
            if ($resultText['code'] == 0){
                $users = json_decode($resultText['resultText'],TRUE);
                DB::beginTransaction();
                foreach ($users as $key=>$val){
                    $user = Member::find($val['usr_id']);
                    if(!empty($user) && $user->is_unusual == 0){
                        $user->is_unusual = -1;
                        if(!$user->update()){
                            DB::rollback();
                        }
                    }
                }
                DB::commit();
                $data['status'] = 1;
                $data['msg'] = '操作成功';
                return json_encode($data);
            }
        }
        $data['status'] = 0;
        $data['msg'] = '操作失败';
        return json_encode($data);
    }
    /*
     * 显示所有晒单记录
     */
    public function showOrder()
    {
        $showOrder = new ShowOrder();
        $list = $showOrder->orderby('sortid','desc')->orderby('id','desc')->paginate(30);
        return view('backend.member.showOrder',array('list'=>$list));
    }
	
	public function setShoworderSort()
	{
		$showOrder = ShowOrder::find($_POST['id']);
		$showOrder->sortid=$_POST['sortid'];
		if($showOrder->save())
		{
			$data['status']=1;
			$data['msg']='设置成功';
		}
		else
		{
			$data['status']=0;
			$data['msg']='设置失败';
		}
		echo json_encode($data);
	}
	
	public function refused()
	{
		
		$showOrder = ShowOrder::find($_POST['id']);
		$showOrder->refused_cause=$_POST['refused_cause'];
		$showOrder->is_show=2;
		if($showOrder->save())
		{
			return redirect('/backend/member/showorder')->with('操作成功');
		}
		else
		{
			return redirect()->back()->withInput()->withErrors('操作失败！');
		}
		
	}
    /*
     * 审核晒单 
     * 审核通过 ：奖励规则 500块乐豆<=商品价格5%+字数*5+图片*50<=1500
     */
    public function checkShowOrder(Request $request)
    {
        if($request::isMethod('post'))
        {
            $id = $request::input('id');
            $showOrder = ShowOrder::find($id);
            $showOrder->is_show = $request::input('flag');
            $photos = unserialize($showOrder->sd_photolist);
            if($photos){
                $points =(int)ceil($showOrder->relateGood->money*5/100)+mb_strlen($showOrder->sd_content)*5+count($photos)*50;
            }else {
                $points =(int)ceil($showOrder->relateGood->money*5/100)+mb_strlen($showOrder->sd_content)*5; //无图片
            }
            if ($points>=100 && $points<=500){
                $pointTotal = $points;
            }else if($points<100){
                $pointTotal = 100;
            }else if($points > 500){
                $pointTotal = 500;
            }
            $showOrder->kl_bean = $pointTotal;
            if($showOrder->update()){
                $userpoint =new Userpoint();
                $member = Member::where('usr_id',$showOrder->sd_uid)->first();
                $member->kl_bean += $pointTotal;
                $userpoint->usr_id = $showOrder->sd_uid;
                $userpoint->type = 1;
                $userpoint->pay = '晒单赠送';
                $userpoint->content = '分享晒单赠送块乐豆'.$pointTotal;
                $userpoint->money = $pointTotal;
                $userpoint->time = time();                
                $userpoint->save();
                $member->update();
                $data['status'] = 1;
                $data['msg'] = '操作成功';
                return json_encode($data);
            }else {
                $data['status'] = 0;
                return json_encode($data);
            }
        }
    }
     /*
     * 晒单详情
     */
     public function showOrderDetail($id,$sd_gid)
     {
         $showOrder = ShowOrder::find($id);
         $showOrder->sd_photolist = unserialize($showOrder->sd_photolist);
         $goods = Goods::find($sd_gid);
         $goods->picarr = unserialize($goods->picarr); 
         return view('backend.member.showOrderDetail',array('showOrder'=>$showOrder,'goods'=>$goods));
     }
     /*
      * 友情链接
      */
     public function showFriendlink()
     {
        $link = new Link();
        $list = $link->getAll();
        return view('backend.member.friendlink',array('list'=>$list));
     }
     
     /*
      * 添加友情链接
      */
     public function addFriendlink()
     {
         return view('backend.member.addfriendlink');
     }
     /*
      * 编辑友情链接
      */
     public function editFriendlink($id)
     {
         $link = Link::find($id);
         return view('backend.member.editfriendlink',array('link'=>$link));
     }
     /*
      * 删除友情链接
      */
     public function delFriendlink(Request $requeat)
     {
         if($requeat::isMethod('post')){
             $id = $requeat::input('id');
             $link = Link::find($id);
             if($link->delete()){
                 $data['status'] = 1;
                 $data['msg'] = '删除成功';
             }else{
                 $data['status'] = 0;
                 $data['msg'] = '操作失败';                 
             }
             return json_encode($data);
         }
     }
     /*
      * 保存友情链接
      */
     public function saveFriendlink(Request $request)
     {
         if($request::isMethod('post')){
             if('insert' == $request::input('action')){
                 //新建链接
                 $validator = Validator::make($request::all(),[
                    'name'=>'required|unique:tab_link|max:100',
                    'url'=>'required|url|unique:tab_link|max:255',
                 ]);
                 if ($validator->fails()){
                     $data['status'] = 0;
                     $data['msg'] = $validator->errors()->first();                     
                     return json_encode($data);
                 }
                 $link =new Link();
                 $link->name = $request::input('name');
                 $link->url = $request::input('url');
                 $link->type = $request::input('type');
                 $link->logo = $request::input('logo');
                 if($link->save()){
                     $data['status'] = 1;
                     $data['msg'] = '添加成功';
                 }else {
                    $data['status'] = 0;
                    $data['msg'] = '保存失败';
                 }  
                 return json_encode($data);
             } else if('update' == $request::input('action')){
                 //更新链接
                 $validator = Validator::make($request::all(),[
                    'name'=>'required|max:100',
                    'url'=>'required|url|max:255',
                 ]);
                 if($validator->fails()){
                     $data['status'] = 0;
                     $data['msg'] = $validator->errors()->first();
                     return json_encode($data);                     
                 }else{
                    $id = $request::input('id');
                    $link = Link::find($id);
                    $link->name = $request::input('name');
                    $link->url = $request::input('url');
                    $link->type = $request::input('type');
                    $link->logo = $request::input('logo');
                    if ($link->update()){
                        $data['status'] = 1;
                        $data['msg'] = '保存成功';
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '保存失败';
                    }
                    return json_encode($data);
                 }
             }
         }
     }
    
	//m2
	public function cleanLinkCache(){
		$sql  = 'SELECT `name`,`url` FROM `tab_link` where `logo`=1 ORDER BY `type` desc ';
		$res  = DB::select($sql);
		$html = '<div class="w1190">';
		$html.= 	'<div class="indexfriendlink">';
		$html.= 		'<div class="g-links">';	
							foreach($res as $r){
								$html.= '<a href="'.$r->url.'" target="_blank" title="'.$r->name.'">'.$r->name.'</a><s></s>';
							}
							$html = substr($html,0,-7);
		$html.=     	'</div>';
		$html.=     '</div>';
		$html.=	'</div>';
		file_put_contents('hd_caches/index_footer_friendlink.html',$html);
		echo "<script>window.location='friendlink'</script>";
		exit;
	}

     /*
      * 佣金提现
      */
     public function withdrawCash()
     {
        $withdrawCash = new WithdrawCash();
        $list = $withdrawCash->getAll();
        return view('backend.bank.withdrawCash',['list'=>$list]);
     }
     
     /*
      * 打款
      */
     public function checkPass(Request $request)
     {
         $withdrawCash  = WithdrawCash::find($request::input('id'));
         $withdrawCash->cashtype = 1;
         $withdrawCash->checktime = time();
         if ($withdrawCash -> update()){
//             $commission = new Commission();
//             $member = Member::find($withdrawCash->uid);
//             $commission->usr_id = $withdrawCash->uid;
//             $commission->commission = $withdrawCash->money;
//             $commission->source_usr_id = $withdrawCash->uid;
//             $commission->time = time();
//             $commission->source_type = 3;
//             $commission->is_pay = 1;
//             $member->commission -= $withdrawCash->money;
//             $commission->save();
//             $member->update();
             $data['status'] = 1;
             $data['msg'] = '打款成功';
             return json_encode($data);
         } else {
             $data['status'] = 0;
             $data['msg'] = '操作失败';
             return json_encode($data);
         }
     }
     /*
      * 拒绝打款
      */
     public function checkRefuse(Request $request)
     {
         $withdrawCash  = WithdrawCash::find($request::input('id'));
         $withdrawCash->cashtype = 2;
         if ($withdrawCash -> update()){         
             $data['status'] = 1;
             $data['msg'] = '操作成功';
             return json_encode($data);
         } else {
             $data['status'] = 0;
             $data['msg'] = '操作失败';
             return json_encode($data);
         }
     }
     /*
      * 升级为渠道用户
      */
     public function upLevel(Request $request)
     {
         if($request::has('id')){
            $result = Member::where('usr_id',$request::input('id'))->update(['usr_level'=>1]);
            if($result){
                $data['status'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['status'] = 0;
                $data['msg'] = '操作失败';
            }
         }
         return json_encode($data);
     }
	 
	 //封号与解封
	 public function setFengHao()
	 {
	 	$id=$_POST['id'];
		$type=$_POST['type'];
		 $result = Member::where('id',$id)->update(['is_unusual'=>$type]);
            if($result){
                $data['status'] = 1;
                $data['msg'] = '操作成功';
            }else{
                $data['status'] = 0;
                $data['msg'] = '操作失败';
            }
         return json_encode($data);
		
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
	

	
	//用户信息导表
	public function exportUser()
	{
	
		$array=array('用户id','用户名','电话','用户余额','佣金','块乐豆','用户经验','用户级别','账号异常','注册时间','消费金额');
		$name='用户信息表';
		$where='';
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
			$where=$where.' where mobile in ('.$phonestr.')';
		}
		//echo $where;exit;
		if(!isset($_GET['page'])){$_GET['page']=1;}
		$offset=($_GET['page']-1)*50;
		//$sql='select `tab_bid_record`.code,`tab_bid_record`.g_name,`tab_bid_record`.g_periods,`tab_bid_record`.g_id,`tab_member`.`mobile`,`tab_member`.`nickname` ,`tab_bid_record`.buycount,`tab_bid_record`.fetchno,`tab_bid_record`.addressid,   FROM_UNIXTIME((`tab_bid_record`.`bid_time`/1000),"%Y年%m月%d日%H时%i分%s秒") as time from `tab_bid_record` 
		//inner join `tab_member` on `tab_member`.`usr_id` = `tab_bid_record`.`usr_id` '.$where.' order by `tab_bid_record`.`id` desc limit '.$offset.',50';
		if(isset($_GET['phones']))
		{
			$sql='select usr_id,nickname,mobile,money,commission,kl_bean,exps,usr_level,is_unusual,FROM_UNIXTIME((`reg_time`),"%Y年%m月%d日%H时%i分%s秒") from tab_member '.$where.' order by id desc limit '.$offset.',50';
		}
		elseif(isset($_GET['starttime']))
		{
			$sql='select usr_id,nickname,mobile,money,commission,kl_bean,exps,usr_level,is_unusual,FROM_UNIXTIME((`reg_time`),"%Y年%m月%d日%H时%i分%s秒") from tab_member where reg_time>='.$_GET['starttime'].' and reg_time<'.$_GET['end_time'].'  order by id desc ';
		}else
		{
			$sql='select usr_id,nickname,mobile,money,commission,kl_bean,exps,usr_level,is_unusual,FROM_UNIXTIME((`reg_time`),"%Y年%m月%d日%H时%i分%s秒") from tab_member  order by id desc limit '.$offset.',50';
		}
		//echo $sql;exit;
		$result=DB::select($sql);
	    //print_r($result);exit;
		$result=$this->object_array($result);
		
		foreach($result as $key=>$val)
		{
			if($val['is_unusual']==0)
			{
				$result[$key]['is_unusual']='正常';
			}
			else
			{
				$result[$key]['is_unusual']='封号';
			}
			if($val['usr_level']==0)
			{
				$result[$key]['usr_level']='普通用户';
			}
			elseif($val['usr_level']==1)
			{
				$result[$key]['is_unusual']='渠道用户';
			}
			else
			{
				$result[$key]['is_unusual']='申请渠道用户';
			}
			//消费金额
		
			$money=AddMoneyRecord::
				where('tab_member_addmoney_record.usr_id',$val['usr_id'])
			    ->where('tab_member_addmoney_record.money','<>','0')
		        ->wherein('tab_member_addmoney_record.status',[1,4,5])
				->sum('money');
			
			$result[$key]['buymoney']=$money;
		
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


	//用户登录记录表
	public function loginRecord(Request $request)
	{
		$request::session()->forget('memberlogin');
		$result=Loginlog::join('tab_member','tab_member.usr_id','=','tab_login_log.usr_id')->groupBy('tab_login_log.usr_id')->select('tab_login_log.*','tab_member.mobile','tab_member.email','tab_member.reg_time','tab_member.login_time')->paginate(50);
		foreach($result as $key=>$val)
		{
			$result[$key]->num=Loginlog::where('usr_id',$val->usr_id)->count('id');//登录次数
			//登录天数
			$sql='SELECT usr_id  FROM `tab_login_log` where usr_id='.$val->usr_id." GROUP BY FROM_UNIXTIME( TIME, '%Y%m%d' )";
			$res=DB::select($sql);
			$result[$key]->daynum=count($res);	
		}
		$data['list']=$result;
		$data['url']='';
		$data['num']=$result->total();
		
		return view('backend.member.loginrecord',$data);
	}
	
	//用户登录记录筛选
	public function SerachLoginRecord(Request $request)
	{
		
		if ($request::isMethod('post'))
		{
			//echo 1111;exit;
			$request::session()->forget('memberlogin');
			if($_POST['num']){@session(['memberlogin.num'    => $_POST['num']]);}
			if($_POST['start_time']){@session(['memberlogin.starttime'    => $_POST['start_time']]);}
			if($_POST['end_time']){@session(['memberlogin.endtime'    => $_POST['end_time']]);}
			if($_POST['regstarttime']){@session(['memberlogin.regstarttime'    => $_POST['regstarttime']]);}
			if($_POST['regendtime']){@session(['memberlogin.regendtime'    => $_POST['regendtime']]);}
			if($_POST['lianxutime']){@session(['memberlogin.lianxutime'    => $_POST['lianxutime']]);}
			if($_POST['daynum']){@session(['memberlogin.daynum'    => $_POST['daynum']]);}
		}
		
		$page=isset($_GET['page'])?$_GET['page']:1;
		$limit=50;
		$offset=$limit*($page-1);
		$url=array();
		$sql='select tab_login_log.usr_id,tab_member.mobile,tab_member.email,tab_member.reg_time,num as daynum,tab_member.login_time,count(*) as num from tab_login_log inner join  tab_member on  tab_member.usr_id=tab_login_log.usr_id where 1' ;
		
		if(session('memberlogin.starttime'))
		{
			$end_time=strtotime(session('memberlogin.endtime'));
			$start_time=strtotime(session('memberlogin.starttime'));
			$sql=$sql.' and time>='.$start_time.' and time<'.$end_time;
			$url['starttime']=$start_time;
			$url['end_time']=$end_time;
		}

		if(session('memberlogin.regstarttime'))
		{
			$regendtime=strtotime(session('memberlogin.regendtime'));
			$regstarttime=strtotime(session('memberlogin.regstarttime'));
			$sql=$sql.' and reg_time>='.$regstarttime.' and reg_time<'.$regendtime;
			$url['regstarttime']=$regstarttime;
			$url['regendtime']=$regendtime;
		}
		
		if(session('memberlogin.lianxutime') && session('memberlogin.daynum'))
		{
			$lianxutime=strtotime(session('memberlogin.lianxutime'));
			$daynum=session('memberlogin.daynum');
			$lianxutimeend=$lianxutime+86400*$daynum;
			$sql=$sql.' and time>='.$lianxutime.' and time<='.$lianxutimeend.' and num>='.$daynum;
			$url['lianxutime']=$lianxutime;
			$url['daynum']=$daynum;
			
		}
		//echo session('memberlogin.num');
		$sql=$sql.' group by tab_login_log.usr_id';
		if(session('memberlogin.num'))
		{
			
			$sql =$sql.' having num>='.session('memberlogin.num');
			$url['num']=session('memberlogin.num');
		}
		$sql2=$sql.' limit '.$offset.','.$limit;
		$num=count(DB::select($sql));
		
		$result=DB::select($sql2);
		//print_r($result);exit;
    	$page=new pageclass($num,$page);
		$data['page']=$page->GetPagerContent();
		
		$url=http_build_query($url);
		$data['list']=$result;
		$data['url']=$url;
		$data['num']=$num;	
		return view('backend.member.loginrecord',$data);
	}

	public function exportUserLogin()
	{
		if(count($_GET)==1)
		{
			echo '请选择条件再导表，数目太多';exit;
		}
		$array=array('用户id','用户手机','用户邮箱','注册时间','最后一次登录时间','登录天数','登录次数');
		$name='用户信息表';
		$sql='select tab_login_log.usr_id,tab_member.mobile,tab_member.email,FROM_UNIXTIME((tab_member.`reg_time`),"%Y年%m月%d日%H时%i分%s秒"),FROM_UNIXTIME((tab_member.`login_time`),"%Y年%m月%d日%H时%i分%s秒"),num as daynum,count(*) as num from tab_login_log inner join  tab_member on  tab_member.usr_id=tab_login_log.usr_id where 1';
		
		if(isset($_GET['starttime']))
		{
			$sql=$sql.' and time>='.$_GET['starttime'].' and time<'.$_GET['end_time'];
		}
		
		if(isset($_GET['regstarttime']))
		{
			$sql=$sql.' and reg_time>='.$_GET['regstarttime'].' and reg_time<'.$_GET['regendtime'];
		}
		
		if(isset($_GET['lianxutime']) && isset($_GET['daynum']))
		{
			$lianxutime=$_GET['lianxutime'];
			$daynum=$_GET['daynum'];
			$lianxutimeend=$lianxutime+86400*$daynum;
			$sql=$sql.' and time>='.$lianxutime.' and time<='.$lianxutimeend.' and num>='.$daynum;
			
			
		}
		
		$sql=$sql.' group by tab_login_log.usr_id';
		if(isset($_GET['num']))
		{
			$sql =$sql.' having num>='.$_GET['num'];
		}
		$result=DB::select($sql);
	    //print_r($result);exit;
		$result=$this->object_array($result);
		array_unshift($result,$array);
		$time=date('Y-m-d',time());
	    //print_r($result);exit;
        Excel::create($time.$name,function($excel) use ($result){
        $excel->sheet('score', function($sheet) use ($result){
        $sheet->rows($result);
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
}
