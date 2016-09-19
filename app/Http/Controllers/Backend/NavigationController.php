<?php

namespace App\Http\Controllers\Backend;

use App\Models\Navigation;
use App\Mspecs\M3Result;
use App\Http\Controllers\BaseController;

class NavigationController extends BaseController {
    
    public $type = array(1 => '头部导航', 2 => '底部导航');
    public $status = array(0 => '隐藏', 1 => '显示');
    
    public function __construct(){
        parent::__construct();
        $this->model = new Navigation();
        $this->jsonMspecs = new M3Result();
    }
    
    public function index(){
        $list = $this->model->getAll();
        
        foreach ($list as &$val){
            $val->type = $this->type[$val->type];
            $val->status = $this->status[$val->status];
        }
        
        return view('backend.interface.navigation_index', array('list' => $list));
    }
    
    public function create(){
        return view('backend.interface.navigation_add');
    }
    
    public function store(){
        $this->model->name    =  $this->getParam('name');
        $this->model->url     =  $this->getParam('url');
        $this->model->sort    =  $this->getParam('sort');
        $this->model->type    =  $this->getParam('type');
        $this->model->status  =  $this->getParam('status');
    
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
        
        return view('backend.interface.navigation_edit', array('info' => $info));
    }
    
    public function update($id){
        $navigation = $this->model->find($id);
        $navigation->name    =  $this->getParam('name');
        $navigation->url     =  $this->getParam('url');
        $navigation->sort    =  $this->getParam('sort');
        $navigation->type    =  $this->getParam('type');
        $navigation->status  =  $this->getParam('status');
        
        if($navigation->save()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '修改成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '修改失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    public function destroy($id){
        $navigation = $this->model->find($id);
        
        if($navigation->delete()){
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = '删除成功';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '删除失败';
        }
        
        return $this->jsonMspecs->toJson();
    }
}