<?php
namespace App\Models;

use App\Models\Relations\HasManyGoodsTrait;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    use HasManyGoodsTrait;
    public   $table  =  'tab_shopping_cart';  //购物车表
    public   $timestamps = false;
    
    /**
     * 获取用户购物车列表
     * @return array
     */
    public function getAllCart(){
        $list = $this->join('ykg_goods', 'tab_shopping_cart.g_id', '=', 'ykg_goods.id')
                     ->join('tab_object', 'tab_shopping_cart.g_id', '=', 'tab_object.g_id')
                     ->where('tab_shopping_cart.usr_id', session('user.id'))
                     ->where('tab_object.is_lottery', 0)
                     ->get(['ykg_goods.*', 'tab_shopping_cart.id as cart_id','tab_shopping_cart.bid_cnt','tab_object.id as o_id', 'tab_object.total_person',
                            'tab_object.participate_person','tab_object.periods as cur_periods','tab_object.minimum', 'tab_shopping_cart.id as shop_id'])
                     ->toArray();
        //重组数组
        $list_new = array();
        foreach ($list as $key => $row){
            $list_new[$row['id']] = $row;
            if($row['bid_cnt'] > ($row['total_person'] - $row['participate_person'])){
                $list_new[$row['id']]['bid_cnt'] = $row['total_person'] - $row['participate_person'];
                $info = $this->find($row['shop_id']);
                $info->bid_cnt = $list_new[$row['id']]['bid_cnt'];
                $info->save();
            }
        }
        
        return $list_new;
    }
}