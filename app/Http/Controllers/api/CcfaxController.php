<?php
/**
 * Created by liuchen.
 * User: liuchen
 * Date: 2016/8/9 0009
 * Time: 14:44
 */

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Userpoint;
use Response;
use Log;
use DB;

class CcfaxController extends Controller {

	//签名唯一key md5('tesu8899')
	const KEY = '0c355fd6ad99f5605813d4e7859fac77';

	//注册成功并首次投资
	public $_regFirstInvest = 500;

	//投资超过10000奖励，每10000奖励100
	public $_investAward = 100;

	/**
	 * 活动赠送用户块乐豆接口
	 */
	public function addBean(){
		$code       =  $this->getParam('code', '' );  //唯一编码
		$usr_id     =  $this->getParam('usr_id', 0);  //用户usr_id
		$sign       =  $this->getParam('sign', '');  //签名
		$type       =  $this->getParam('type', 0);   //活动类型 (0：注册投资赠送500  1：投资达到条件奖励块乐豆)
		$timestamp  =  $this->getParam('timestamp', 0);  //时间戳

		//是否重复请求
		$record = DB::select("select * from act_ccfax_klbean where code='".$code."' limit 1");
		if(empty($record)) {
			Log::info('ccfax klbean api success:code-'.$code.',usr_id-'.$usr_id.',sign-'.$sign.',type-'.$type.',timestamp-'.$timestamp);
			//第一次回调插入记录
			$log_id = DB::table('act_ccfax_klbean')->insertGetId(
				['code' => $code, 'usr_id' => $usr_id, 'type' => 0, 'status' => 0, 'time' => $timestamp]
			);

			//签名验证
			$str = 'code='.$code.'&usr_id='.$usr_id.'&type='.$type.'&timestamp='.$timestamp.'&key='.self::KEY;
			$param_sign = strtoupper(md5($str));
			if($param_sign != $sign){
				echo json_encode(array('status' => -3, 'msg' => 'sign failed'));
				die();
			}

			//查询用户记录
			$info = Member::where('usr_id', $usr_id)->first();
			if(empty($info)){
				$base_url  =  config('global.api.base_url');
				$getUsrinf = config('global.api.getUsrinf');
				$result = $this->api($base_url,$getUsrinf,array('usr_id'=>$usr_id),'GET');
				Log::info('ccfax klbean api java:'.json_encode($result));
				if($result['code'] == 0){
					$user_info = json_decode($result['resultText'], true);
					//其他平台未登录用户，插入记录
					$member = new Member();
					$login_time = time();

					$member->usr_id = $usr_id;
					$member->nickname = substr_replace($user_info['user_phone'], '****', 3, 4);
					$member->is_firstbuy = 1;
					$member->mobile = $user_info['user_phone'];
					$member->user_name = $user_info['user_name'];
					//$member->reg_ip = $user_info['reg_ip'];
					$member->user_photo = config('global.default_photo');
					$member->login_time = $login_time;
					$member->reg_time = $user_info['reg_time'];
					$member->platform_source = $user_info['platform_source'];
					$member->save();
				}else{
					echo json_encode(array('status' => -2, 'msg' => 'can not find user'));
					die();
				}

			}

			$addBean = $this->getAddBean($type);
			//更新用户块乐豆
			$up_result = DB::update('update tab_member set kl_bean = kl_bean + '.$addBean.' where usr_id = :id', [':id' => $usr_id]);

			$msg = '用户'.$usr_id.'在链金所投资赠送'.$addBean.'块乐豆，记录id：'.$log_id;
			$msg .= $up_result ? '，赠送成功' : '，赠送失败';

			$userpoint_first = new Userpoint();
			$userpoint_first->usr_id = $usr_id;
			$userpoint_first->type = 10;
			$userpoint_first->pay = '链金所投资赠送';
			$userpoint_first->content = $msg;
			$userpoint_first->money = $addBean;
			$userpoint_first->time = time();
			$userpoint_first->save();

			//更新状态
			$status = $up_result ? 1 : 2;
			DB::table('act_ccfax_klbean')->where('id', $log_id)->update(['status' => $status]);

			$return['status'] = $up_result ? 0 : -4;
			$return['msg'] = $up_result ? 'ok' : 'system error';
			echo json_encode($return);
			die();
		}else{
			Log::info('ccfax klbean api repeat request:code-'.$code.',usr_id-'.$usr_id.',sign-'.$sign.',type-'.$type.',timestamp-'.$timestamp);
			echo json_encode(array('status' => -1, 'msg' => 'repeat request'));
			die();
		}
	}

	/**
	 * 获取赠送块乐豆数量
	 * @param $type
	 */
	public function getAddBean($type){
		$addBean = 0;
		switch($type){
			case 0 :
				$addBean = $this->_regFirstInvest;
				break;
			case 1 :
				$addBean = $this->_investAward;
				break;
			default :
				$addBean = 0;
				break;
		}

		return $addBean;
	}

	/**
	 * 获取用户块乐豆接口
	 */
	public function getUserBean(){
		$usr_id = $this->getParam('usr_id', 0);

		$info = Member::where('usr_id', $usr_id)->first(['kl_bean']);
		if(!empty($info)){
			echo json_encode(array('status' => 0, 'msg' => 'ok', 'data' => array('usr_id' => $usr_id, 'bean' => $info->kl_bean)));
			die();
		}else{
			echo json_encode(array('status' => -1, 'msg' => 'can not find user'));
			die();
		}
	}

	/*
	 * 调用api方法封装
	 * @param string $base_url 路径
	 * @param string $api_url  调用路径
	 * @param string $data 数组
	 * @param string $method post/get
	 * @return array
	 */
	public function api($base_url,$api_url,$data,$method){

		$client = new \GuzzleHttp\Client(['base_uri' => $base_url]);

		$query = http_build_query($data);

		$res = $client->request($method, $api_url, ['query' => $query]);

		return json_decode($res->getBody(), true);
	}
}