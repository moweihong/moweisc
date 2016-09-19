<?php
namespace App\Http\Controllers\Backend;
use App\Models\Member;
use App\Models\Recharge;
use Request,Validator;
use App\Http\Controllers\BaseController;

class HuafeiController extends BaseController
{
    /*
     * 显示所有的用户
     */
     public function index()
    {
        $list = Recharge::orderBy('id','desc')->paginate(50);
        return view('backend.huafei.index',['list'=>$list]);
    }
}
