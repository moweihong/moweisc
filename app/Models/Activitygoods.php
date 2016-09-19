<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activitygoods extends Model
{
    
   
	protected $pageCount=10;//页数
    protected $table = 'tab_invite_goods';//活动商品表
    Public $timestamps = false;
    
    public function getList(){
        $list = $this->paginate($this->pageCount);        
        return $list;
    }

	
	
	
	
}
