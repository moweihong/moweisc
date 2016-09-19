<?php

/**
 * 后台.抽奖记录模型
 * @author lchecho
 *
 */

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public   $table  =  'tab_freeday_log';  //users表
    
    /**
     * 获取所有参与记录
     * @return object $users
     */
    public function getAll(){
        $users = $this->where('status', 1)->paginate(20);  //每页显示几条
        return $users;
    }
    
    /**
     * 获取指定用户的抽奖记录
     * @param string $phone
     * @return object $users
     */
    public function getListByPhone($phone){
        $users = $this->where('status', 1)->where('user_phone', $phone)->paginate(20);  //每页显示几条
        return $users;
    }
}
