<?php


namespace App\Models;

use App\Models\Relations\BelongsToGoodsTrait;
use App\Models\Relations\HasManyOrdersTrait;
use App\Models\Relations\HasManyShowTrait;
use Illuminate\Database\Eloquent\Model;

class Object_del extends Model
{
    use BelongsToGoodsTrait,HasManyOrdersTrait,HasManyShowTrait;
    public   $table  =  'tab_object_del';  //商品表
    public   $timestamps=false;
    


}
