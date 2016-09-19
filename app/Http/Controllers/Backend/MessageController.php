<?php

namespace App\Http\Controllers\Backend;
use App\Models\Object_del;
use App\Models\Message;
use App\Models\Member;
use DB,Excel;;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Backend\Common\tree;
use App\Http\Controllers\Backend\Common\FunController;
use App\Models\Activitygoods;
use Request,Validator;

class MessageController extends BaseController {

    /*
     * 消息列表  16.7.5  by byl
     */
    public function index(){
        if(Request::isMethod('post')){
            $start_time = strtotime(Request::input('start_time'));
            $end_time = strtotime(Request::input('end_time'));
            $mobile = Request::input('mobile');
        }else{
            $start_time = Request::input('start_time');
            $end_time = Request::input('end_time');
            $mobile = Request::input('mobile');
        }
        if(!empty($start_time) && !empty($mobile)){
            $list = Message::whereBetween('send_time', [$start_time, $end_time])->where('mobile',$mobile)->orderBy('id','desc')->paginate(50);
            $list->appends(['start_time' => $start_time, 'end_time'=>$end_time, 'mobile' => $mobile]);
        }else if(empty($start_time) && !empty($mobile)){
            $list = Message::where('mobile',$mobile)->orderBy('id','desc')->paginate(50);
            $list->appends(['mobile' => $mobile]);
        }else if(empty($mobile) && !empty($start_time)){
            $list = Message::whereBetween('send_time', [$start_time, $end_time])->orderBy('id','desc')->paginate(50);
            $list->appends(['start_time' => $start_time,'end_time'=>$end_time]);
        }else{
            $list = Message::orderBy('id','desc')->paginate(50);
        }
             
       return view('backend.msg.index',['list'=>$list,'start_time'=>$start_time,'end_time'=>$end_time,'mobile'=>$mobile]);
    }
	
	
    /*
     * 发送消息  16.7.5  by byl
     */
	public function msgEdit()
	{
        if(Request::isMethod('post')){
            $msg_type = Request::input('msg_type');
            $formdate = Request::all();         
            $validator = Validator::make($formdate, [ 'title' => 'required|max:30','content'=>'required|max:200']);
            if ($validator->fails()) {
                return $this->msgjson(-1,$validator->errors()->first());
            }
            if($formdate['msg_type'] == 1){
                if(empty($formdate['mobile'])){
                    return $this->msgjson(-1,'接受手机号不能为空！');
                }else{
                    $mobileArr = explode(',', $formdate['mobile']);                    
                    foreach ($mobileArr as $key=>$val){
                        if(is_numeric($val) && strlen($val) == 11){
                            if($this->cheakMobile($val)){
                                $user = Member::where('mobile',$val)->first();
                                if($user){
                                    $sendMobile[$key]['usr_id'] = $user->usr_id;
                                    $sendMobile[$key]['mobile'] = $val;
                                }else{
                                    return $this->msgjson(-1,'手机号'.$val.'不存在！不能发送消息，请核实！');
                                }
                            }else{
                                return $this->msgjson(-1,'手机号'.$val.'格式错误！');
                            }
                        }else{
                            return $this->msgjson(-1,'手机号'.$val.'格式错误！');
                        }
                    }
                    DB::beginTransaction();
                    foreach ($sendMobile as $val){
                       $msg =new Message();
                       $msg->usr_id = $val['usr_id'];
                       $msg->mobile = $val['mobile'];
                       $msg->title = $formdate['title'];
                       $msg->msg = $formdate['content'];
                       $msg->msg_type = 3;
                       $msg->send_time = empty($formdate['send_time']) ? time():strtotime($formdate['send_time']);
                        if(!$msg->save()){
                            DB::rollback();
                            return $this->msgjson(-1,'到手机号'.$val['mobile'].'发送失败，所有的号码请重新发送！');
                        }
                    }
                    DB::commit();
                    return $this->msgjson(0,'发送成功！');
                }
            }else if($formdate['msg_type'] == 0){
                $msg =new Message();
                $msg->title = $formdate['title'];
                $msg->msg = $formdate['content'];
                $msg->msg_type = 0;
                $msg->send_time = empty($formdate['send_time']) ? time():strtotime($formdate['send_time']);
                if($msg->save()){
                    return $this->msgjson(0,'发送成功！');
                }else{
                    return $this->msgjson(-1,'系统消息发送失败！');
                }
            }
        }else{
            return view('backend.msg.sendmsg');
        }	   
	}

    /*
     * 检测手机号的有效性
     */
    public function cheakMobile($mobile)
    {
        $mobile_arr = ['139','138','137','136','135','134','159','158','152','151','150','157','182','183','188','187','147','130','131','132','155','156','186','185','133','153','189','180'];
        $str = substr($mobile, 0,3);
        if (in_array($str,$mobile_arr)) {
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * json 数据  
     */
    public function msgJson($status, $msg)
    {
        return json_encode(['status'=>$status, 'msg'=>$msg]);
    }
    
    public function excelImport()
    {
       $file= Request::file('file1');
        //文件扩展名
        $photoext = $file->getClientOriginalExtension();
        //生成新的文件名
        $newname = time().rand( 1 , 10000 ).'.'.$photoext;
        //新的文件目录，存在就返回原有的文件目录
        $pathStr = 'backend/upload/temp/';
        $newPath = $this->getFolder($pathStr);
        if(!$newPath){
            $data['status'] = -1;
            $data['msg'] = '保存文件时创建目录失败';
            return  json_encode($data);
        }
        $file->move($newPath,$newname);

        $filePath = 'public/'.$newPath.'/'.$newname;
        
        $data = NULL;
        Excel::load($filePath, function($reader) use(&$data){
            $dataArr = $reader->toArray();
            $str = '';
            foreach ($dataArr[0] as $val){
                $str .= $val[0].',';
            }
            $str = substr($str, 0, -1);
            $data['status'] = 0;
            $data['msg'] =$str;
        });
        unlink($newPath.'/'.$newname);
        return  json_encode($data);

    }
    
    /**
     * 按照日期自动创建存储文件夹
     * @return string
     */
    private function getFolder($pathStr)
    {        
        if ( strrchr( $pathStr , "/" ) != "/" ) {
            $pathStr .= "/";
        }
        $pathStr .= date( "Ymd" );
        if ( !file_exists( $pathStr ) ) {
            if ( !mkdir( $pathStr , 0777 , true ) ) {
                return false;
            }
        }
        return $pathStr;
    }
}