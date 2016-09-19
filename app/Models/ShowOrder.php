<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowOrder extends Model
{
    
   
	protected $pageCount=20;//页数
	protected $tableShoplist='ykg_goods';//商品表
	protected $tableShowAdmire='tab_show_admire';//点赞表
    protected $table = 'tab_show';//晒单表
    Public $timestamps = false;
    
    public function getAll(){
        $showOrder = $this->orderBy('id','desc')->paginate(50);        
        return $showOrder;
    }

	
	//前台晒单列表
	public function getSdInfo($pagesize = 8)
	{
		
		$res =$this
	//   ->where($this->tableShoplist.'.isdeleted','0') 解决商品下架 晒单出错问题
	   ->where($this->table.'.is_show','1')
	   ->join($this->tableShoplist,$this->tableShoplist.'.id','=',$this->table.'.sd_gid')
	   ->join('tab_member','sd_uid','=','tab_member.usr_id')
	   ->orderBy($this->table.'.sortid','desc')
	   ->orderBy($this->table.'.id','desc')
       ->select($this->table.'.*',$this->tableShoplist.'.title','tab_member.user_photo', 'tab_member.nickname')
       
       ->paginate($pagesize);
	   //print_r($res);exit;
	
	   return $res;
	}
	
	//前台晒单列表(移动端)
	public function getSdInfoMobile($page, $pagesize, $type = 'new')
	{
	    $pagesize = (int)$pagesize ? $pagesize : 10;
	    $skip = $page * $pagesize;
	    
	    $order = '';
	    if($type == 'new'){
	        $order['name'] = 'tab_show.sd_time';
	        $order['type'] = 'desc';
	    }elseif($type == 'hot'){
	        $order['name'] = 'tab_show.sd_admire';
	        $order['type'] = 'desc';
	    }
	    
	    $res =$this
	    ->join($this->tableShoplist,$this->tableShoplist.'.id','=',$this->table.'.sd_gid')
	    ->join('tab_member','sd_uid','=','tab_member.usr_id')
	//    ->where($this->tableShoplist.'.isdeleted','0') 解决商品下架 晒单出错问题
	    ->where($this->table.'.is_show','1');
	    
		if($type == 'hot')
		{
			 $res=$res->orderBy('sortid','desc');
		}
	    $res=$res->orderBy($order['name'], $order['type'])
	    ->skip($skip)
	    ->take($pagesize)
	    ->get([$this->table.'.*',$this->tableShoplist.'.title','tab_member.user_photo', 'tab_member.nickname']);
	    //print_r($res);exit;
	
	    return $res;
	}
	//前台晒单单个商品的列表(移动端)
	public function getGoodShow($page, $pagesize, $type = 'new',$gid)
	{
	    $pagesize = (int)$pagesize ? $pagesize : 10;
	    $skip = $page * $pagesize;
	    
	    $order = '';
	    if($type == 'new'){
	        $order['name'] = 'tab_show.sd_time';
	        $order['type'] = 'desc';
	    }elseif($type == 'hot'){
	        $order['name'] = 'tab_show.sd_admire';
	        $order['type'] = 'desc';
	    }
	    
	    $res =$this
	    ->join($this->tableShoplist,$this->tableShoplist.'.id','=',$this->table.'.sd_gid')
	    ->join('tab_member','sd_uid','=','tab_member.usr_id')
	   ->where($this->tableShoplist.'.isdeleted','0')
	    ->where($this->table.'.is_show','1')
	    ->where($this->table.'.sd_gid',$gid);
		if($type == 'hot')
		{
			 $res=$res->orderBy('sortid','desc');
		}
	    $res=$res->orderBy($order['name'], $order['type'])
	    ->skip($skip)
	    ->take($pagesize)
	    ->get([$this->table.'.*',$this->tableShoplist.'.title','tab_member.user_photo', 'tab_member.nickname']);
	   // print_r($res);exit;
	    return $res;
	}
	
	public function getInfoById($id){
	    return $this
	    ->join($this->tableShoplist,$this->tableShoplist.'.id','=',$this->table.'.sd_gid')
	    ->join('tab_member','sd_uid','=','tab_member.usr_id')
	 //    ->where($this->tableShoplist.'.isdeleted','0') 解决商品下架 晒单出错问题
	    ->where($this->table.'.is_show','1')
	    ->where($this->table.'.id', $id)
	    ->first([$this->table.'.*',$this->tableShoplist.'.title',$this->tableShoplist.'.title2','tab_member.user_photo', 'tab_member.nickname']);
	}
	
	//用户中心我的晒单
	public function getMyShow($uid)
	{
		//$data['is_show']=1;
		$data['sd_uid']=$uid;
		$res=$this->where($data)
		->select('sd_title','sd_thumbs','sd_content','sd_time','id','sd_uid','is_show','kl_bean','refused_cause','sd_gid','o_id')
		->paginate($this->pageCount);
		   
		return $res;
	}
	
	//用户中心我的晒单
	public function gethisShow($uid)
	{
		$data['is_show']=1;
		$data['sd_uid']=$uid;
		$res=$this->where($data)
		->select('sd_title','sd_thumbs','sd_content','sd_time','id','sd_uid','is_show','kl_bean','refused_cause','sd_gid','o_id')
		->paginate($this->pageCount);
		   
		return $res;
	}
	//发表点赞，妒忌，恨
	public function pushComment()
	{
		$type=$_POST['type'];
		$data['ad_id']=$_POST['id'];
		$data['ad_uid']=session('user.id');
		//$data['ad_uid']=rand(1000,2000);
		$data['ad_time']=time();
		$data['type']=$type;
		$this->table=$this->tableShowAdmire;
		$where['ad_uid']=$data['ad_uid'];
		$where['type']=$type;
		$where['ad_id']=$data['ad_id'];
		//$res=$this->select('id')->where('ad_uid',$data['ad_uid'])->where('type',$type)->where('ad_id',$data['ad_id'])->first();
		$res=$this->select('id')->where($where)->first();
		if($res)
		{
			$result['message']='已经点赞过了';
			$result['data']='-1';
		}
		else
		{
			$id = $this->insertGetId($data);
			if($id>0)
			{
				$res=$this->upSdRecord($data['ad_id'],$type);
				
				$result['message']='成功';
			    $result['data']='0';
			}
			else
			{
				$result['message']='点赞失败';
			    $result['data']='-2';
			}
		}
		
		return $result;
	}
	
	//晒单表更新点赞记录
	protected function upSdRecord($id,$type)
	{
		$this->table = 'tab_show';
		$res=$this->select('sd_hate','sd_admire','sd_jeal')->where('id',$id)->first();
		if($type==1)
		{
			$num=$res['sd_admire']+1;  
			$data['sd_admire']=$num;
		}
		elseif($type==2)
		{
			$num=$res['sd_jeal']+1;
			$data['sd_jeal']=$num;
		}else
		{
			$num=$res['sd_hate']+1;
			$data['sd_hate']=$num;
		}
		@$aid=$this->where('id', $id) ->update($data);
		return $aid;
		
	}
	
	protected function upSdRecordnew($id,$type)
	{
		$this->table = 'tab_show';
		if($type==1)
		{
			$str=' sd_admire=sd_admire+1';
			//$data['sd_admire']='sd_admire+1';
		}
		elseif($type==2)
		{
			$str=' sd_jeal=sd_jeal+1';
			//$data['sd_jeal']='sd_jeal+1';
		}else
		{
			$str='sd_hate=sd_hate+1';
			//$data['sd_hate']='sd_hate+1';
		}
		$sql='update '.$this->table.$str.' where id='.$id;
		$res=$this->update($sql);
		return $res;
		
	}

    //保存晒单
    public function saveShowInfo($arr)
	{
		$data['sd_uid']=session('user.id');
		$data['sd_gid']=$arr['sd_gid'];
		$data['sd_periods']=$arr['sd_periods'];
		$data['sd_title']=$arr['sd_title'];
		$data['sd_content']=$arr['sd_content'];
		$data['sd_thumbs']=$arr['pic'][0];
		$data['sd_photolist']=serialize($arr['pic']);
		$data['sd_time']=time();
		$data['pic_num']=count($arr['pic']);
		$data['o_id']=$arr['o_id'];
		$id = $this->insertGetId($data);
		return $id;
	}
    //关联goods表
    public function relateGood() {
        return $this->hasOne('App\Models\Goods','id','sd_gid');
    }
    //关联object表
    public function object() {
        return $this->hasOne('App\Models\Object','id','o_id');
    }

}
