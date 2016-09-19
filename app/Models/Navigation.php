<?php

/**
 * 导航条管理模型
 * @author lchecho
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model {
    
    public   $table  =  'ykg_navigation';  
    public   $timestamps = false;
    
    /**
     * 获取所有导航条列表
     */
    public function getAll(){
        $navigations = $this->paginate(10);
        
        return $navigations;
    }
    
    /**
     * 根据id获取导航信息
     * @return object $user
     */
    public function getInfoById($id){
        $navigation = $this->where('id', $id)->first();
    
        return $navigation;
    }
}