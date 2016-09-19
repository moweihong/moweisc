<?php
namespace App\Http\Controllers\Backend;

use App\Models\Slide;
use App\Mspecs\M3Result;
use App\Http\Controllers\BaseController;

class RotationController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->model = new Slide();
        $this->jsonMspecs = new M3Result();
    }
    
    public function index(){
        $list = $this->model->paginate(10);
        
        return view('backend.slide.index', array('list' => $list));
    }
    
    public function create(){
        return view('backend.slide.add');
    }
    
    public function store(){
        $this->model->title =  $this->getParam('title');
        $this->model->img   =  $this->getParam('img');
        $this->model->link  =  $this->getParam('link');
        $this->model->type  =  $this->getParam('type');
        
        if($this->model->save()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '添加成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '添加失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    public function editRo($id){
        $info = $this->model->find($id);
        if(empty($info)){
            return redirect('backend/rotation');
        }
        
        return view('backend.slide.edit', array('info' => $info));
    }
    
    public function updateRo(){
    	
       
		$info = $this->model->find($_POST['id']);
        $info->title =  $_POST['title'];
        $info->img   =  $_POST['img'];
        $info->link  =  $_POST['link'];
        $info->type  =  $_POST['type'];
		
        
        if($info->save()){
            $data['status'] = 0;
            $data['message'] = '修改成功';
        }else{
        	$data['status'] =-1;
            $data['message'] = '修改失败';
            
        }
        
        return json_encode($data);
    }
    
    public function deleteRo($id){
        $slide = $this->model->find($id);
        
        if($slide->delete()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '删除成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '删除失败';
        }
        
        //return $this->jsonMspecs->toJson();
        if ($this->jsonMspecs->status==0) {
            return redirect('/backend/rotation')->with('status', '删除 成功！ :)');
        } else {
            return redirect()->back()->withInput()->withErrors('删除失败！');
        }
    }
    
    //保存图片到服务器
    public function savePic()
    {
    
        $targetFolder = '/backend/upload/slide'; // Relative to the root
        $verifyToken = md5('unique_salt' . $_POST['timestamp']);
        if (!empty($_FILES) && $_POST['token'] == $verifyToken)
        {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $rand=rand(1,100);
            $filename=$rand.time().".jpg";
            $targetFile = rtrim($targetPath,'/') . '/' .$filename;
    
            $fileTypes = array('jpg','jpeg','gif','png',); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $rtname=$targetFolder.'/'.$filename;
            if (in_array($fileParts['extension'],$fileTypes))
            {
                move_uploaded_file($tempFile,$targetFile);
    
                echo  $rtname;
            } else
            {
                echo 'Invalid file type.';
            }
        }
    }
    /*
     *设置轮播图顺序 16.6.26 by byl
     */
    public function setOrder()
    {
        $id = $this->getParam('id');
        $order_id = $this->getParam('order_id');
        $slide = Slide::find($id);
        if($slide){
            $slide->order_id = $order_id;
            if($slide->update()){
                $data['status'] = 1;
                $data['msg'] = '设置成功';   
            }
        }else{
            $data['status'] = 0;
            $data['msg'] = '设置失败';
        }
        return json_encode($data);
     }
    /*
     *设置显示方式 16.6.26 by byl
     * 默认0:当前页面打开  1:新窗口打开
     */
    public function setShow()
    {
        $id = $this->getParam('id');
        $select_id = $this->getParam('select_id');
        $slide = Slide::find($id);
        if($slide){
            $slide->show_type = $select_id;
            if($slide->update()){
                $data['status'] = 1;
                $data['msg'] = '设置成功';   
            }
        }else{
            $data['status'] = 0;
            $data['msg'] = '设置失败';
        }
        return json_encode($data);
    }
}