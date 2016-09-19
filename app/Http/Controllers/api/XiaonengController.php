<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Response;
use DB;
 
class XiaonengController extends Controller
{	//http://2kg.muyouguanxi.com/xiaoneng?id=888
    public function getGoodsInfo(){
		$gid   = (int)$_GET['id'];
		if($gid==0){
			echo Response::json(['error'=>'ID错误']);
			exit;
		}
		$site  = addslashes($_GET['itemparam']);
		switch($site){ 
			case 'ykg':
				$sql   = "SELECT g.`id`,g.`title`,g.`thumb`,g.`money`,c.`name` FROM `ykg_goods` g LEFT JOIN `ykg_category` c ON c.`cateid`=g.`cateid` 
						  WHERE `id`=$gid  ";
				$goods = DB::select($sql);  
				if(empty($goods)){
					echo Response::json(['error'=>'ID错误']);
					exit;
				}
				$data['item']= [
							'id'=>$goods[0]->id,
							'name'=>$goods[0]->title,
							'imageurl'=>'http://'.$_SERVER['HTTP_HOST'].'/'.$goods[0]->thumb,
							'url'=>'http://'.$_SERVER['HTTP_HOST'].'/product/'.get_oid($gid),
							'currency'=>'￥',
							'siteprice'=>$goods[0]->money,
							'marketprice'=>$goods[0]->money,
							'category'=>$goods[0]->name,
							'brand'=>'无'
						];	
				$data = json_encode($data);  
				echo $data;
				break;
			case 'ccfax':
				$url = 'https://miror.ccfax.cn/Home/xiaoneng/getborrowinfo?id='.$gid;
				echo httpGet($url);
				break;
			default:
				echo Response::json(['error'=>'itemparam错误']);
		}
    }
	
 

}
