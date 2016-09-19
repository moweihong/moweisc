<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use DB;
class HomeController extends BaseController {
    
    public function index(){
        $data = $this->db('users')->paginate(1);
        return view('backend.home', array('data' => $data));
    }
    
    public function creatH5ProHtml(){
        $startid = empty($_GET['sid'])?'':(int)$_GET['sid'];
        $endid = empty($_GET['eid'])?'':(int)$_GET['eid'];
		if($startid==''||$endid==''){
			echo '请带上起始gid'; return;
		}
		$gid = DB::select('select id from ykg_goods where id between "'.$startid.'" and "'.$endid.'" and isdeleted=0');
		foreach($gid as $id){
			$object_id = DB::select('select id from tab_object where g_id="'.$id->id.'" order by id desc limit 1');
			//print_r($object_id);exit;
			$object_id= $object_id[0]->id;
			$html = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/productdetail_m/'.$object_id);
			file_put_contents('html_static/h5pro/'.$id->id.'.html',$html);
		}
		echo "it's ok!";
    }
}