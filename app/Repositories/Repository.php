<?php
/*
	M1 add by tangzhe 2016-07-19 增加转换DB门面生成的数据
*/
namespace App\Repositories;



class Repository
{


    //对象转数组
    public  function object2Array($obj)
    {
        if (empty(($obj))) {
            return array();
        } else {
            return $obj->toArray();
        }
    }
	
	//M1
	public function DBarray($res){ //print_r($res);
		$i=0;
		foreach($res as $r){
			$res2[$i]['id']=$r->id;
			$res2[$i]['g_id']=$r->g_id;
			$res2[$i]['total_person']=$r->total_person;
			$res2[$i]['participate_person']=$r->participate_person;
			$res2[$i]['minimum']=$r->minimum;
			$res2[$i]['periods']=$r->periods;
			$res2[$i]['begin_time']=$r->begin_time;
			$res2[$i]['end_time']=$r->end_time;
			$res2[$i]['lottery_time']=$r->lottery_time;
			$res2[$i]['is_lottery']=$r->is_lottery;
			$res2[$i]['lottery_code']=$r->lottery_code;
			$res2[$i]['user_phone']=$r->user_phone;
				$res2[$i]['belongs_to_goods']['id']=$r->g_id;
				$res2[$i]['belongs_to_goods']['cateid']=$r->cateid;
				$res2[$i]['belongs_to_goods']['brandid']=$r->brandid;
				$res2[$i]['belongs_to_goods']['title']=$r->title;
				$res2[$i]['belongs_to_goods']['title2']=$r->title2;
				$res2[$i]['belongs_to_goods']['keywords']=$r->keywords;
				$res2[$i]['belongs_to_goods']['description']=$r->description;
				$res2[$i]['belongs_to_goods']['money']=$r->money;
				$res2[$i]['belongs_to_goods']['maxqishu']=$r->maxqishu;
				$res2[$i]['belongs_to_goods']['thumb']=$r->thumb;
				$res2[$i]['belongs_to_goods']['picarr']=$r->picarr;
				$res2[$i]['belongs_to_goods']['content']=$r->content;
				$res2[$i]['belongs_to_goods']['pos']=$r->pos;
				$res2[$i]['belongs_to_goods']['renqi']=$r->renqi;
				$res2[$i]['belongs_to_goods']['time']=$r->time;
				$res2[$i]['belongs_to_goods']['order']=$r->order;
				$res2[$i]['belongs_to_goods']['isdeleted']=$r->isdeleted;
				$res2[$i]['belongs_to_goods']['is_virtual']=$r->is_virtual;
				$res2[$i]['belongs_to_goods']['g_type']=$r->g_type;
				$res2[$i]['belongs_to_goods']['supplier']=$r->supplier;
				$i++;
		}
		//print_r($res2);exit;
		return $res2;
	}
	
	//对象转数组函数
	public function object_to_array($obj){
		$_arr = is_object($obj)? get_object_vars($obj) :$obj;
		foreach ($_arr as $key => $val){
		$val=(is_array($val)) || is_object($val) ? object_to_array($val) :$val;
		$arr[$key] = $val;
		}
		return $arr;
	}

}
