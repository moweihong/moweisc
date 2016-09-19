<?php
/**
 * Created by liuchen.
 * User: liuchen
 * Date: 2016/6/27 0027
 * Time: 15:31
 */

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Rotary extends Model
{
	public   $table  =  'tab_rotary_prize';  //users表
	Public $timestamps = false;

	/**
	 * 获取所有奖品配置
	 * @return object $users
	 */
	public function getAll(){
		$prize = $this->where('status', 1)->paginate(20);  //每页显示几条
		return $prize;
	}

}

