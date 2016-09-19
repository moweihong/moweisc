<?php

/**
 * 后台管理员模型
 * @author lchecho
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public   $table  =  'users';  //users表
    
    /**
     * 获取所有管理员信息
     * @return object $users
     */
    public function getAll(){
        $users = $this->paginate(1);  //分页
        
//         $lists = array();
//         $users = $this->chunk(10, function($users) use (&$lists) {
//             foreach ($users as $key => $user){
//                 $lists[$key]['name'] = $user->name;
//                 $lists[$key]['email'] = $user->email;
//                 $lists[$key]['created_at'] = $user->created_at;
//                 $lists[$key]['updated_at'] = $user->updated_at;
//             }
        
//             return false;
//         });

        return $users;
    }
    
    /**
     * 根据id获取管理员信息
     * @return object $user
     */
    public function getInfoById(){
        $user = $this->where('id', 1)->first();
        
        return $user;
    }
    
    /**
     * 获取单个指定字段的所有记录
     * @param string $key
     * @return array $list
     */
    public function getColumns($key){
        $list = $this->lists('name');
        
        return $list;
    }
}
