<?php
/**
 * Created by liuchen.
 * User: liuchen
 * Date: 2016/6/28 0028
 * Time: 11:46
 */

namespace App\Http\Controllers\Foreground\Service;

use App\Http\Controllers\ForeController;
use App\Mspecs\M3Result;
use App\Models\Member;
use App\Models\Userpoint;
use App\Models\Redbao;
use DB;

class RotaryController extends ForeController {
	public function __construct()
	{
		$this->jsonMspecs = new M3Result();
		$this->memberModel = new Member();

		$this->price = 10;  //每次抽奖消耗块乐豆
	}

	/**
	 * 消费块乐豆抽奖
	 * @return string
	 */
	public function run(){
		$result = false;
		//使用块乐豆抽奖
		$member = $this->memberModel->where('usr_id', session('user.id'))->first();
		if($member->kl_bean >= $this->price){
			$result = DB::update('update tab_member set kl_bean = kl_bean - '.$this->price.' where kl_bean >= '.$this->price.' and usr_id = '.session('user.id'));
		}

		if($result){
			//保存块乐豆消费记录
			$userpoint = new Userpoint();
			$userpoint->usr_id = session('user.id');
			$userpoint->type = 6;
			$userpoint->pay = '天天免费抽奖消耗';
			$userpoint->content = '天天免费抽奖消耗'.$this->price.'块乐豆';
			$userpoint->money = $this->price;
			$userpoint->time = time();
			$userpoint->save();

			$this->main(0); //开始抽奖

			return $this->jsonMspecs->toJson();
		}else{
			$member = $this->memberModel->where('usr_id', session('user.id'))->first();
			$this->jsonMspecs->status = -1;
			$this->jsonMspecs->message = '您的块乐豆不足';
			$this->jsonMspecs->data = $member->kl_bean;

			return $this->jsonMspecs->toJson();
		}
	}

	/**
	 * 消耗免费次数抽奖
	 * @return string
	 */
	public function runFree(){
		$result = false;
		//使用免费次数抽奖
		$rotary_member = DB::table('tab_rotary_member')->where('usr_id', session('user.id'))->first();
		$is_new = $rotary_member->is_new == 1 ? true : false;
		//$today_free_times = DB::table('tab_rotary_log')->where('usr_id', session('user.id'))->where('is_free', 1)->where('time', '>=', strtotime(date('Y-m-d 00:00:00')))->count();//当天使用过的免费次数
		//if($today_free_times <= 0 && (intval($rotary_member->invite_last/3) > 0 || $rotary_member->is_new == 1)){
		if(intval($rotary_member->invite_last/3) > 0 || $is_new == true){
			if($is_new == true){  //新用户第一次抽奖
				$affected = DB::update("update tab_rotary_member set is_new = 0 where usr_id = " . session('user.id') . " and is_new = 1");
				$result = $affected ? true : false;
			}
			//使用免费次数
			if($result == false){
				$is_new = false;
				$affected = DB::update("update tab_rotary_member set invite_last = invite_last - 3 where usr_id = " . session('user.id') . " and invite_last >= 3");
				$result = $affected ? true : false;
			}

			if($result == true){
				//使用免费次数成功，开始抽奖
				$this->main(1, $is_new);

				//新用户首次参与抽奖，且满足注册渠道要求，上级推荐人邀请人数量加1
				if($is_new == true && $rotary_member->is_freeday == 1){
					$base_url  =  config('global.api.base_url');
					$api_url   =  config('global.api.getRecommend');
					$res = $this->api($base_url,$api_url,array('usr_id' => session('user.id'), 'platform_source' => 3),'GET');
					if($res['code'] == 0){
						$res['resultText'] = json_decode($res['resultText'], true);
						if(isset($res['resultText']['recommend_id']) && !empty($res['resultText']['recommend_id'])){
							$recommend_id = $res['resultText']['recommend_id'];
							//更新推荐人邀请人数
							$affected = DB::update("update tab_rotary_member set invite_total = invite_total + 1, invite_last = invite_last + 1 where usr_id = " . $recommend_id);
							if($affected){
								//插入推荐记录
								DB::insert("insert into tab_rotary_invite_log (usr_id, recommend_id, time) values (" . session('user.id') . ", " . $recommend_id . ", " . time() . ")");
							}
						}
					}
				}

				return $this->jsonMspecs->toJson();
			}
		}

		if($result == false){
			//不满足免费使用条件，使用块乐豆抽奖
			return $this->run();
		}
	}

	/**
	 * 抽奖主程序
	 *
	 * @param $is_free     1为使用免费次数 0为使用块乐豆
	 * @param 是否为新用户|bool $is_new 是否为新用户
	 */
	public function main($is_free, $is_new = false){
		//计算开奖结果
		$prize_id = 0;
		if($is_new == true){
			//新用户首次抽奖，奖品固定为5元红包
			$prize_id = 5;
		}else{
			$list = DB::table('tab_rotary_prize')->where('weight', '>', 0)->get();
			$prize_arr = array();
			foreach ($list as $item) {
				$prize_arr[$item->id] = $item->weight;
			}
			asort($prize_arr);
			$prize_id = $this->getPrizeId($prize_arr);
		}

		//插入抽奖记录
//		$insertId = DB::insert("insert into tab_rotary_log (usr_id, is_free, prize_id, status, time) values (" . session('user.id') . ", " . $is_free . ", " . $prize_id . ", 0, " . time() . ")");
		$insertId = DB::table('tab_rotary_log')->insertGetId(['usr_id' => session('user.id'), 'is_free' => $is_free, 'prize_id' => $prize_id, 'status' => 0, 'time' => time()]);

		//新用户首次参与抽奖，上级推荐人邀请人数量加1
		if($insertId){
			$member = $this->memberModel->where('usr_id', session('user.id'))->first();
			$rotary_member = DB::table('tab_rotary_member')->where('usr_id', session('user.id'))->first();

			$return = array();
			$return['invite_total'] = $rotary_member->invite_total;
			$return['last_free_times'] = intval($rotary_member->invite_last/3);
			$return['total_free_times'] = intval($rotary_member->invite_total/3) + 1; //免费次数需要加上注册赠送的1次
			$return['total_last_times'] = $return['last_free_times'] + intval($member->kl_bean/$this->price);
			$return['log'] = $insertId;
			$return['prize_id'] = $prize_id;
			$return['kl_bean'] = $member->kl_bean;
			$return['flag'] = $member->kl_bean >= $this->price ? 2 : 0;

			$this->jsonMspecs->status = 0;
			$this->jsonMspecs->message = 'ok';
			$this->jsonMspecs->data = $return;
		}else{
			$this->jsonMspecs->status = -2;
			$this->jsonMspecs->message = '服务器异常';
		}
	}

	/**
	 * 更新中奖状态
	 */
	public function updateStatus(){
		$log = $this->getParam('log', 0);
		if($log){
			$affected = DB::table('tab_rotary_log')->where('usr_id', session('user.id'))->where('id', $log)->where('status', 0)->update(['status' => 1]);
			if($affected){
				//发送奖品
				$info = DB::table('tab_rotary_log')->where('usr_id', session('user.id'))->where('id', $log)->first();
				$this->sendPrize($info->prize_id);

				$this->jsonMspecs->status = 0;
				$this->jsonMspecs->message = 'ok';
				return $this->jsonMspecs->toJson();
			}
		}

		$this->jsonMspecs->status = -3;
		$this->jsonMspecs->message = '非法请求';
		return $this->jsonMspecs->toJson();

	}

	/**
	 * 发送奖品
	 * @param $prize_id
	 */
	private function sendPrize($prize_id){
		$prize = DB::table('tab_rotary_prize')->where('id', $prize_id)->first();
		//红包类奖品发送
		if($prize->red_pid){
			$red = Redbao::where('pid', $prize->red_pid)->get();  //获取父id下所有的红包
			$start_time = time();
			$end_time = $start_time + intval(config('global.red_expired_days')) * 86400;
			foreach ($red as $item) {
				DB::insert("insert into tab_member_red (usr_id, red_code, start_time, end_time, status) values (" . session('user.id') . ", " . $item->id . ", " . $start_time . ", " . $end_time . ", 0)");
			}
		}
		//实物类奖品发送
		if($prize->act_gid){

		}
	}

	/**
	 * 抽奖的概率算法，函数执行完后必须会得到一个中奖id
	 * @param array $proArr    Example:array(1=>5, 2=>10),键名0表示奖品id,键值表示chance中奖权重
	 * @param int $noprize  不中奖概率，越大中奖概率越小，现设置为1，一定中奖
	 * @return string|int <string, int>
	 */
	function getPrizeId($proArr, $noprize = 1){
		$rand = mt_rand(1,$noprize);
		if($rand > 1){
			return 'noprize';
		}
		$result = '';
		//概率数组的总概率精度
		$proSum = array_sum($proArr);
		//概率数组循环
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset ($proArr);
		return $result;
	}
}