<?php

namespace App\Models;

use App\Models\Relations\HasManyOrdersTrait;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasManyOrdersTrait;
    protected $table ='tab_member';
	protected $primaryKey = 'usr_id';
    Public $timestamps = false;
    public function getAll() {
        return $this->orderBy('id','desc')->paginate(50);
    }
	
	//修改头像
	public function updateUserPic($userid,$rtname)
	{
		$res=$this->select('user_photo')->where('usr_id',$userid)->first();
		$filename=$_SERVER['DOCUMENT_ROOT'] .$res['user_photo'];
        if($res['user_photo'] != '/foreground/img/def.jpg'){
           @unlink($filename);
        }
		$res=$this->where('usr_id', $userid) ->update(['user_photo' => $rtname]);
		return $res;
	}
	
	//获取用户信息
	public function getUserInfo($uid)
	{
		$res=$this->select('user_photo','usr_id','nickname','sex','birthday','now_address','home_address','salary','wx_unionid','qq_openid')
		->where('usr_id',$uid)->first();
		return $res;
	}
	
	//完善用户信息
	public function updateNickname($data)
	{
		$uid=session('user.id');
		if(!$uid)
		{
			$result['message']='服务器错误';
			$result['code']=-1;
		}
		$nickname=$data['nickname'];
		
		$res=$this->select('id')->where('nickname',$nickname)->where('usr_id','<>',$uid)->first();
		if($res)
		{
			$result['message']='昵称已存在';
			$result['code']=-2;
		}
		else
		{
			$res=$this->where('usr_id', $uid) ->update($data);
			
			if($res==1 || $res==0)
			{
				$result['message']='修改成功';
				session(['user.nickname'  => $nickname]);
			    $result['code']=0;
				$result['result']=$res;
			}
			else
			{
				$result['message']='修改失败';
				$result['result']=$res;
			    $result['code']=-3;
			}
		}
		return $result;
	}
    //校验规则
    public static $rules = [
        'nickname' => 'required|max:30',       
       // 'year' => 'required|numeric',
       // 'month' => 'required|numeric',
       // 'day' => 'required|numeric',
//        'home_address' => 'required|max:30',
//        'now_address' => 'required|max:30',
          'salary' => 'required|numeric',
    ];
	
	
}
