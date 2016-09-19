<?php
namespace App\Http\Controllers\h5\View;
use App\Models\ShowOrder;
use App\Http\Controllers\ForeController;
use App\Models\Bid_record;
use Request,DB;
use Carbon\Carbon;

class ShareController extends ForeController {
    public function index(Request $request){
    	if(session('user.id'))
		{
			$data['userid']=session('user.id');
		}
		else
		{
			$data['userid']=-1;
		}
		
		//获取页数
		$page = $this->getParam('page', 0);
		//获取type
		$type = $this->getParam('type', 'new');
		//获取商品gid 
        $gid = $this->getParam('gid');
        if($gid){
            //某个商品的晒单详情
            $sdlist = array();
            if($request::ajax()){
                $model=new ShowOrder();
                $res=$model->getGoodShow($page, 10, $type,$gid);
                $sdlist=$res;
                $timenow = time();
                foreach($sdlist as &$row){
                    $row->sd_photolist = unserialize($row->sd_photolist);
                    $row->sd_time = $this->showTime($timenow,$row->sd_time);
                }

                return response()->json(array('sdlist' => $sdlist, 'page' => $page, 'type' => $type));
            }
        }else{
            $sdlist = array();
            if($request::ajax()){
                $model=new ShowOrder();
                $res=$model->getSdInfoMobile($page, 10, $type);
                $sdlist=$res;
                $timenow = time();
                foreach($sdlist as &$row){
                    $row->sd_photolist = unserialize($row->sd_photolist);
                    $row->sd_time = $this->showTime($timenow,$row->sd_time);

                }

                return response()->json(array('sdlist' => $sdlist, 'page' => $page, 'type' => $type));
            }
        }

		
        return view('h5.share_m',array('sdlist' => $sdlist, 'page' => $page, 'type' => $type,'userid'=>$data['userid']));
    }
    
    //晒单时间判断
    public function showTime($timenow,$showtime)
    {
        $todayTime = strtotime(Carbon::today());
        $yesTime = strtotime(Carbon::yesterday());
        $num = $timenow-$showtime;
    
        if($num<60){
            $str = '刚刚';
        }else if($num < 3600){
            //大于一分钟 
            $days=$num/60;
            $str = (int)$days.'分钟前';
        }else if($num <18000){
            //大于1小时小于5小时
           $days = $num/3600;
           $str = (int)$days.'小时前';
        }else if($showtime>=$todayTime){
            //大于5小时小于一天
            $days = date('H:i', $showtime);
            $str = '今天'.$days;
        }else if($showtime<$todayTime&&$showtime>=$yesTime){
            //昨天
            $days = date('H:i', $showtime);
            $str = '昨天'.$days;
        }else{
            //大于两天
            $str = date('Y-m-d H:i:s', $showtime);
        }
        return $str;
    }


    //晒单点赞
	public function pushComment()
	{
		$model=new ShowOrder();
		$res=$model->pushComment($_POST);
		$status = $res['data'];
		return response()->json(array('status' => $status, 'message' => $res['message']));
	}
	
	//晒单详情
	public function sharedetail($id)
	{
	    if($id){            
            if(session('user.id'))
            {
                $data['userid']=session('user.id');
                //该用户是否点赞了
                $res = DB::table('tab_show_admire')->where(['ad_id'=>$id,'type'=>1,'ad_uid'=>$data['userid']])->first();
                if($res){
                    $zanflag = true;
                }else{
                    $zanflag = false;
                }
            }
            else
            {
                $data['userid']=-1;
                $zanflag = false;
            }
	        $model = new ShowOrder();
	        $info = $model->getInfoById($id);
	        if(!empty($info)){
	            $info->sd_photolist = unserialize($info->sd_photolist);
	            $info->sd_time = date('Y-m-d', $info->sd_time);

		        //seo配置
		        $seo_index = config('seo.index');
		        $seo['web_title'] = $info->sd_title ? $info->sd_title : $seo_index['web_title'];
		        $seo['web_keyword'] = $info->sd_title ? $info->sd_title : $seo_index['web_keyword'];
		        $seo['web_description'] = $info->sd_content ? $info->sd_content : $seo_index['web_description'];

	            return view('h5.sharedetail', array('info' => $info,'userid'=>$data['userid'],'zanflag'=>$zanflag,'seo' => $seo));
	        }else{
	            return view('errors.h5_403');
	        }
	    }else{
	        return view('errors.h5_403');
	    }
	}
	
	//晒单广场按钮
	public function sharePlus(){
	    if(session('user.id')){
	       $bid_model = new Bid_record();
	       $bid_count = $bid_model->where('usr_id', session('user.id'))->where('pay_type', '<>' ,'invite')->where('fetchno','<>','0')->count();
	       if($bid_count > 0){
    	       $noshow_list = $bid_model->getUserNoShow_m(session('user.id'));
    	       if(count($noshow_list) > 0){
    	           return response()->json(array('status'=>1, 'message'=>'/user_m/prize'));
    	       }else{
    	           return response()->json(array('status'=>2, 'message'=>'/user_m/show'));
    	       }
	       }else{
	           return response()->json(array('status'=>-2, 'message'=>'亲，晒单需要中奖后，才能晒单哦！'));
	       }
	    }else{
	        return response()->json(array('status'=>-1, 'message'=>'未登录'));
	    }
	}
}