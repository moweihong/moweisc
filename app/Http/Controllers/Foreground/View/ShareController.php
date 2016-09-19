<?php
namespace App\Http\Controllers\Foreground\View;
use App\Models\ShowOrder;
use App\Http\Controllers\ForeController;
use DB;

class ShareController extends ForeController {
    public function index(){
    	if(session('user.id'))
		{
			$data['userid']=session('user.id');
		}
		else
		{
			$data['userid']=-1;
		}
		$model=new ShowOrder();
		$res=$model->getSdInfo();
		$data['totalnum']=ShowOrder::where('is_show',1)
		->join('ykg_goods','ykg_goods.id','=','tab_show.sd_gid')
	   	->join('tab_member','sd_uid','=','tab_member.usr_id')
		->count();
		$data['sdlist']=$res;
        return view('foreground.share',$data);
    }
	
	//晒单点赞
	public function pushComment()
	{
		$model=new ShowOrder();
		$res=$model->pushComment($_POST);
		echo json_encode($res);
	}
	
	//具体某个晒单
	public function sharedetail($id)
	{
		$model=new ShowOrder();
		$show=$model->where('tab_show.id',$id)
		->join('ykg_goods','ykg_goods.id','=','tab_show.sd_gid')
	    ->join('tab_member','sd_uid','=','tab_member.usr_id')
		->join('tab_object','o_id','=','tab_object.id')
		->select('tab_show.*','ykg_goods.title','tab_member.user_photo', 'tab_member.nickname','tab_object.lottery_time')
		->first();
		$show->sd_photolist=unserialize($show->sd_photolist);
		$data['show']=$show;  
		//获奖者信息
		$owner = DB::table('tab_bid_record')->where('o_id',$data['show']->o_id)->where('g_id',$data['show']->sd_gid)->where('usr_id',$data['show']->sd_uid)->first();
		$data['buycount'] = $owner->buycount;
		$data['fetchno']  = $owner->fetchno;
		//本商品当前期
		$periods = DB::table('tab_object')->where('g_id',$data['show']->sd_gid)->orderBy('periods','DESC')->first();
		$data['periods'] = $periods->id;

		//seo配置
		$seo_index = config('seo.index');
		$seo['web_title'] = $show->sd_title ? $show->sd_title : $seo_index['web_title'];
		$seo['web_keyword'] = $show->sd_title ? $show->sd_title : $seo_index['web_keyword'];
		$seo['web_description'] = $show->sd_content ? $show->sd_content : $seo_index['web_description'];
		$data['seo'] = $seo;
		 
		return view('foreground.sharedetail',$data);
	}
}