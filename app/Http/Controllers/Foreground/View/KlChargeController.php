<?php
/**
 * Created by PhpStorm.
 * User: lchecho
 * Date: 2016/6/8 0008
 * Time: 20:53
 */

namespace App\Http\Controllers\Foreground\View;

use App\Http\Controllers\Controller;
use DB;

set_time_limit(0);

class KlChargeController extends Controller {
	public function index(){
		$i = 100001;
//		$sql = "insert into tab_klbean_charge (`card_num`, `card_pass`, `money`, `status`, `time`) values ";
//		for ($i;$i < 105001;$i++) {
//			$code = 'T'.str_pad($i, 10, '0', STR_PAD_LEFT);
//			$pass = $this->getNonceStr();
//			$sql .= " ('".$code."', '".$pass."', 200, 0, ".time()."),";
//		}
//
//		$sql = substr($sql,0,-1);
		//echo $sql;
		//DB::query("insert into tab_klbean_charge (`card_num`, `card_pass`, `money`, `status`, `time`) values (1,1,1,1,1)");

		for ($j = 1;$j < 501;$j++) {
			$data = array();
			for ($i;$i < 100001+$j*1000;$i++) {
				$data[$i]['card_num'] = 'T'.str_pad($i, 10, '0', STR_PAD_LEFT);
				$data[$i]['card_pass'] = $this->getNonceStr();
				$data[$i]['money'] = 200;
				$data[$i]['status'] = 0;
				$data[$i]['time'] = time();
			}
			DB::table('tab_klbean_charge1')->insert($data);
			unset($data);
		}

	}

	/**
	 * 获取指定长度的唯一字符串
	 * @return string
	 */
	public function getNonceStr($length = 8){
		$dictionary = '0123456789abcdefghjkmnpqrstuvwxyz';

		$size = strlen($dictionary);

		$str = '';
		for ($i = 0; $i < $length; $i++){
			$str .= substr($dictionary, rand(0, $size - 1), 1);
		}

		return $str;
	}

}