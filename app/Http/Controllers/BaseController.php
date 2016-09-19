<?php

/**
 * 后台控制器基类
 */

namespace App\Http\Controllers;

use Auth;
use View;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * 当前用户对象
     *
     * @var object
     */
    public $user  =  [];
    
    /**
     * 后台url前缀，用于模板
     *
     * @var object
     */
    public $url_prefix  =  '/backend'; 
	public $pageCount= '10';   
    
    
    protected $tableShoplist='ykg_goods';//商品表
    protected $tableCategory='ykg_category';//分类表
    protected $tableBrand='ykg_brand';//品牌表
    /**
     * 构造方法
     */
    public function __construct(){
        $this->user  =  Auth::user(); 
        View::share('admin', array('name' => $this->user->name, 'id' => $this->user->id));    //所有视图共享数据
        View::share('url_prefix', $this->url_prefix);    
    }
}
