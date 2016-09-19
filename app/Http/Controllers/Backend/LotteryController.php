<?php

namespace App\Http\Controllers\Backend;
use App\Models\Lottery;
use App\Http\Controllers\BaseController;

class LotteryController extends BaseController
{ 
    public function __construct(){
        parent::__construct();
        $this->model = new Lottery();
    }
    
    public function index(){
        $mobile = $this->getParam('mobile');
        
        if($mobile){
            $list = $this->model->getListByPhone($mobile);
        }else{
            $list = $this->model->getAll();
        }
        
        foreach ($list as &$row){
            $row->is_awards = $row->happy_num == $row->lucky_num ? '是' : '否';
        }
        return view('backend.lottery', array('list' => $list, 'mobile' => $mobile));
    }
    
}
