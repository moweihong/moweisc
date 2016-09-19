<?php
namespace App\Http\Controllers\Backend;
use App\Models\Object_del;
use DB;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Backend\Common\tree;
use App\Http\Controllers\Backend\Common\FunController;
use App\Models\Activitygoods;
use Request,Validator;
set_time_limit(0);

class ImportController extends BaseController{
    public function index(){
        $data = DB::table('ykg_goods')->where('isdeleted', 0)->get();
        foreach ($data as $row){
            $object['g_id']=$row->id;
            $object['total_person']=$row->money;
            $object['minimum']=1;
            $object['periods']=1;
            $object['begin_time']=time();
            $oid = DB::table('tab_object')->insertGetId($object);
            if($oid>0)
            {
                //添加云购码
                $crr['o_id']=$oid;
                $code=$this->createCode($row->money);
            
                foreach($code as $v)
                {
                    $crr['code_num']=count(json_decode($v));
                    $crr['bid_codes']=$v;
                    $cid = DB::table('tab_tmp_bid_code')->insertGetId($crr);
                    
                }
                 
            }
        }
    }
    
    /*******生成云购码*********
     * totalprize:商品总价
     * $prize：单价
     */
    public function createCode($totalprize,$prize=1)
    {
        $num=$totalprize/$prize;
        $arr=array();
        $start=99997001;
        $end=100000000;
        //echo $num;
        if($num>3000)
        {
            for($num;$num>=0;$num=$num-3000)
            {
                if($num<=3000)
                {
                    //echo $num;
                    $endincrease=$num;
                    $num=0;
                    	
                }
                else
                {
                    $endincrease=3000;
                }
                $start=$start+3000;
                $end=$end+$endincrease;
                $codes=range($start,$end);
                foreach($codes as $k=>$v)
                {
                    $codes[$k]=(string)$v;
                }
                shuffle($codes);
                $arr[]=json_encode($codes);
    
            }
        }
        else
        {
            $start=$start+3000;
            $end=$end+$num;
            $codes=range($start,$end);
            foreach($codes as $k=>$v)
            {
                $codes[$k]=(string)$v;
            }
            shuffle($codes);
            $arr[]=json_encode($codes);
        }
        return $arr;
         
    }
}