<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redbao extends Model
{
    
   
	protected $pageCount=10;//页数
    protected $table = 'tab_redbao';//红包表
    Public $timestamps = false;
    
    public function getList(){
        $list = $this->where('is_delete','0')->paginate($this->pageCount);        
        return $list;
    }

	
	
	
	
}
