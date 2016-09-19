<?php


namespace App\Models;

use App\Models\Relations\BelongsToGoodsTrait;
use App\Models\Relations\HasManyOrdersTrait;
use App\Models\Relations\HasManyShowTrait;
use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    use BelongsToGoodsTrait,HasManyOrdersTrait,HasManyShowTrait;
    public   $table  =  'tab_object';  //商品表
    
    //关联商品表
    public function goods() {
        return $this->hasOne('App\Models\Goods','id','g_id');
    } 

}
