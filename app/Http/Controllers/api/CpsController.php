<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Response;
use DB;
//为空的情况，这一天有消费，但没有点击，也就是老客户。
class CpsController extends Controller
{
    public function getCpsResult()
    { 
		//http://ykg.tz/freeday?salesman_usrid=2708&way=2
		//http://ykg.tz/getCpsResult?usr_id=2708&begin_date=1465962139&end_date=1466137683&page_no=&page_number=
		$usr_id		 = (int)$_GET['usr_id']; 
        $begin_date  = (int)$_GET['begin_date']; 
        $end_date 	 = (int)$_GET['end_date'];
        $page_no 	 = empty($_GET['page_no'])?1:(int)$_GET['page_no']; 
        $page_number = empty($_GET['page_number'])?10:(int)$_GET['page_number'];
		
		$data = array('code'=>0,'msg'=>'一块购分销效果列表'); //code=0为成功，-1位失败
		$data['cps_result_list'] = array(); //分销效果列表
		/*
			$data['cps_result_list']下字段：
			cps_date 统计日期，某一天
			hits     点击数
			customer_cnt 有效客户数
			invest_amount 消费总金额
			estimate_commission 预估收入
			introduce_source 引入来源，1第三方分享、2链接分享、3二维码分享
		*/
		$star = ($page_no-1)*$page_number;
		$limit = " LIMIT $star,$page_number";
		if($begin_date=='' && $end_date=='' ){  
			$where = ' ';
		}else{
			$where = ' AND time>="'.$begin_date.'" AND time<="'.$end_date.'" ';
		}
	
		//总记录数计算
		$sql  = 'SELECT count(*) hit,salesman_usrid,FROM_UNIXTIME(time,"%Y-%m-%d") thedate FROM `ykg_cps` 
		         WHERE `salesman_usrid`="'.$usr_id.'"'.$where.'AND `valid`="click" GROUP BY `thedate`'; 
		$hits = DB::select($sql);
		
		//点击数
		$sql  = 'SELECT count(*) hit,salesman_usrid,FROM_UNIXTIME(time,"%Y-%m-%d") thedate FROM `ykg_cps` 
		         WHERE `salesman_usrid`="'.$usr_id.'"'.$where.'AND `valid`="click" GROUP BY `thedate` order by `thedate` desc '.$limit; 
		$hits = DB::select($sql);
		foreach($hits as $h){
			$data['cps_result_list'][$h->thedate]['hit'] = $h->hit;
			$data['cps_result_list'][$h->thedate]['date'] = $h->thedate;
		}
		//引入来源
		$ly_page_number = $page_number*3;
		$ly_star  = ($page_no-1)*$ly_page_number;
		$ly_limit = " LIMIT $ly_star,$ly_page_number";
		$sql  = 'SELECT way,count(way) sumway,FROM_UNIXTIME(time,"%Y-%m-%d") thedate FROM `ykg_cps` 
				      WHERE `salesman_usrid`="'.$usr_id.'"'.$where.'AND `valid`="click" GROUP BY `thedate`,`way` '.$ly_limit; 
		$ref  = DB::select($sql);
	 	foreach($ref as $f){
			$data['cps_result_list'][$f->thedate]['introduce_source'] = '';
		} 
		foreach($ref as $f){
			if($f->way==1){
				$data['cps_result_list'][$f->thedate]['introduce_source'] .= '第三方分享'.$f->sumway.'次,';
			}elseif($f->way==2){
				$data['cps_result_list'][$f->thedate]['introduce_source'] .= '链接分享'.$f->sumway.'次,';
			}elseif($f->way==3){
				$data['cps_result_list'][$f->thedate]['introduce_source'] .= '二维码分享'.$f->sumway.'次';
			}
		}
		//有效客户数（注册数）
		$sql = 'SELECT count(*) customer_cnt,FROM_UNIXTIME(time,"%Y-%m-%d") thedate  FROM `ykg_cps` WHERE `salesman_usrid`="'.$usr_id.'" 
				AND `valid`<>"click"'.$where.' GROUP BY `thedate`'.$limit;
		$act = DB::select($sql);  
		foreach($act as $a){
			$data['cps_result_list'][$a->thedate]['customer_cnt'] = $a->customer_cnt;
			$data['cps_result_list'][$a->thedate]['date'] = $a->thedate;
		}
		
		//消费总金额
		$sql = 'SELECT usr_id FROM `ykg_cps`  WHERE `salesman_usrid`="'.$usr_id.'" AND `valid`<>"click" '.$where.' AND `valid`<>"click" GROUP BY usr_id '; //查询所有下线用户
		$uids= DB::select($sql);
 
		$uid = '';
		foreach($uids as $u){
			$uid .= $u->usr_id.',';
		}  
	 	$uid = substr($uid,0,-1);
		if(!$uid){ 
			$data['record_total'] = count($data['cps_result_list']); //总记录数
			$data['page_total']   = ceil($data['record_total']/$page_number); //总页数
			$data['cps_result_list'] = array_values($data['cps_result_list']); 
			return Response::json($data);
		} 
	 	$sql = 'SELECT sum(`amount`) sum_amount,FROM_UNIXTIME(time,"%Y-%m-%d") thedate FROM `tab_member_addmoney_record` 
				WHERE usr_id in('.$uid.') '.$where.' GROUP BY thedate '.$limit;
		$amount = DB::select($sql);
	 
		foreach($amount as $am){
			$data['cps_result_list'][$am->thedate]['invest_amount'] = $am->sum_amount;
			$data['cps_result_list'][$am->thedate]['date'] = $am->thedate;
		} 
		//预估收入（佣金）
		$sql = 'SELECT `commission` estimate_commission,FROM_UNIXTIME(time,"%Y-%m-%d") thedate  FROM `tab_member_commission_record` 
				WHERE usr_id in('.$uid.') '.$where.' GROUP BY thedate '.$limit;
		$commission = DB::select($sql);
 
		foreach($commission as $c){
			$data['cps_result_list'][$c->thedate]['estimate_commission'] = $c->estimate_commission;
			$data['cps_result_list'][$c->thedate]['date'] = $c->thedate;
		}
		
		//数组填充，没有数据的0填充;
		foreach($data['cps_result_list'] as &$fd){
			if(!isset($fd['customer_cnt']))
				$fd['customer_cnt'] = 0;
			if(!isset($fd['invest_amount']))
				$fd['invest_amount']= 0; 
			if(!isset($fd['estimate_commission']))
				$fd['estimate_commission']= 0; 
		} 
		//因循环往$data['cps_result_list']中添加数据导致数组记录数可能比分页每页显示的数多，需处理数组长度。
		$pop = count($data['cps_result_list']) - $page_number; 
		for($i=0;$i<$pop;$i++){
			array_pop($data['cps_result_list']);
		}
		$data['cps_result_list'] = array_values($data['cps_result_list']);
		
		$data['record_total'] = count($data['cps_result_list']); //总记录数
		$data['page_total']   = ceil($data['record_total']/$page_number); //总页数
		//print_r($data);exit;
		
        return Response::json($data);
    }
}
