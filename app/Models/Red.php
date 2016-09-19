<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Red extends Model {
    public   $table  =  'tab_member_red';  //用户红包表
    public   $timestamps = false;
    
    /**
     * 获取用户可用的红包列表
     * @return array
     */
    public function getRedList(){
        $red = $this->leftjoin('tab_redbao', 'tab_redbao.id', '=', 'tab_member_red.red_code')
                    ->where('tab_member_red.usr_id', session('user.id'))
                    ->where('tab_member_red.end_time', '>', time())
                    ->where('tab_member_red.status', 0)
	                ->orderby('tab_redbao.money', 'desc')
                    ->get(['tab_member_red.*', 'tab_redbao.money', 'tab_redbao.xiaxian', 'tab_redbao.name'])->toArray();
        //重组数组
        $red_new = array();
        foreach ($red as $key => $row){
            $red_new[$row['id']] = $row;
        }
        
        return $red_new;
    }
    /*
     *关联红包配置表
     */
    public function redbao(){
        return $this->hasOne('App\Models\Redbao','id','red_code');
    }
}