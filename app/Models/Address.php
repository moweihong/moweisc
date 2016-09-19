<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $table = 'tab_member_address';  //用户地址表
	Public $timestamps = false;
	public $primaryKey = 'usr_id';
	
	//获取用户地址
	public function getUserAddress($usr_id)
	{
		$res=$this->where('usr_id',$usr_id)->where('is_delete',0)->get();
		return $res;
		
	}
	
	//保存地址
	public function saveAddress($data)
	{
		$data['time']=time();
		if($data['usr_id']==session('user.id'))
		{
			if($data['id']==0)
			{
				
				$id = $this->insertGetId($data);
			}
			else
			{
				
				$id=$this->where('id', $data['id']) ->update($data);
			}
			return $id;
		}
		else
		{
			return -1;
		}
		
	}



}
