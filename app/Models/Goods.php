<?php


namespace App\Models;

use App\Models\Relations\HasOneObjectsTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\HasManyObjectsTrait;

class Goods extends Model
{
    use HasManyObjectsTrait;//hasManyObjects关系
    use HasOneObjectsTrait;//hasOneObjects关系
    public $table = 'ykg_goods';  //商品表
    
    
    //获取全站最便宜的n个商品
    public function getCheapShop()
	{
		$where['isdeleted']=0;
		$where['is_lottery']=0;
		$res =$this
	   ->where($where)
	   ->join('tab_object','tab_object.g_id','=','ykg_goods.id')
       ->select($this->table.'.*','tab_object.total_person','tab_object.participate_person','periods','tab_object.id as bid')
	   ->orderBy('money','asc')
	   ->take(4)
       ->get();
	   return $res;
	}
    //关联商品分类表
    public function goodsCat() {
        return $this->hasOne('App\Models\Category','cateid','cateid');
    }


}
