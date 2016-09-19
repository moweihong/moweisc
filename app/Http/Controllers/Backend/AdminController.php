<?php

namespace App\Http\Controllers\Backend;

use App\Models\Admin;
use App\Mspecs\M3Result;
use App\Http\Controllers\BaseController;

class AdminController extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->model = new Admin();
        $this->jsonMspecs = new M3Result();
        
        //管理员权限控制
        if($this->user->id != 1){
            echo '无权限！';
            die();
        }
    }
    
    public function index(){
        $list = $this->model->getAll();

        return view('backend.admin.index', array('list' => $list));
    }
    
    public function create(){
        return view('backend.admin.add');
    }
    
    public function store(){
        if($this->getParam('password') != $this->getParam('password_confirm')){
            $this->jsonMspecs->status = -2;
            $this->jsonMspecs->message = '两次输入密码不一致';
            return $this->jsonMspecs->toJson();
        }
        $this->model->name = $this->getParam('name');
        $this->model->email = $this->getParam('email');
        $this->model->password = bcrypt($this->getParam('password'));
        
        if($this->model->save()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '添加成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '添加失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    public function edit($id){
        $info = $this->model->getInfoById($id);
        
        return view('backend.admin.edit', array('info' => $info));
    }
    
    public function update($id){
        $user = $this->model->find($id);
        $user->name = $this->getParam('name');
        
        if($user->save()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '修改成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '修改失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    public function destroy($id){
        $user = $this->model->find($id);
        
        if($user->delete()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '删除成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '删除失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
}
