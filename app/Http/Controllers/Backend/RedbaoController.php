<?php
/*
	m1 add by tangzhe 2016-08-05 红包赠送功能
*/
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\BaseController;
use App\Models\Redbao;
use Request,Validator;
use DB;

class RedbaoController extends BaseController {
	public function __construct()
	{
       parent::__construct();
       $this->model = new Redbao();
  
    }
    
    public function index(){
     
       $shop_list = DB::table($this->tableShoplist)
	   ->where($this->tableShoplist.'.isdeleted','0')
	   ->join($this->tableCategory,$this->tableShoplist.'.cateid','=',$this->tableCategory.'.cateid')
       ->select($this->tableShoplist.'.*',$this->tableCategory.'.name',$this->tableCategory.'.info')
       ->paginate($this->pageCount);
	   $data['shoplist']=$shop_list;
	   
	   return view('backend.shop.shoplist',$data);
	   
    }

	//红包列表
    public function getList()
    {
       $data['list']=$this->model->getList();
	   
	   return view('backend.redbao.redbaolist',$data);  
    }
	
	//m1 红包赠送
    public function gift()
    {
		if($_POST){ 
			//print_r($_POST);
			echo '功能待开发！';
			EXIT;
		}
		$data['bounsList'] = DB::select("SELECT `id`,`name` FROM `tab_redbao` WHERE `is_delete`=0 ");
		return view('backend.redbao.gift',$data);  
    }
	
	//保存入库
	public function saveRedBao(Request $request)
	{
		 
        $validator = Validator::make($request::all(), [
            'name' => 'required',
            'total_num' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } 
        else {
           
            $redbaomodel =$this->model;
            $redbaomodel->name = $request::input('name');
            $redbaomodel->total_num = $request::input('total_num');
            $redbaomodel->start_time = strtotime($request::input('start_time'));
			$redbaomodel->xiaxian = $request::input('xiaxian');
            $redbaomodel->end_time = strtotime($request::input('end_time'));
            $redbaomodel->money = $request::input('money');
            $redbaomodel->remain_num = $request::input('total_num');
			$redbaomodel->desc = $request::input('desc');
			$res=$redbaomodel->save();
            if($res){
            	
                return redirect('/backend/redbao/getList');
            }
        }
            
	}
	//加载添加红包页面
	public function addRedBao()
	{
		return view('backend.redbao.redbaoadd');  
	}
	
	//删除红包
	public function delRedBao()
	{
		$id=$_POST['id'];
		$redbaomodel =$this->model;
		$redbao=$redbaomodel->find($id);
		$redbao->is_delete=1;
		if($redbao->save())
		{
  			echo 1;//成功
		}
		else
		{
			echo 0;
		}
	}
	
	//加载更新红包载入页面
	public function upRedbao($id)
	{
		$redbaomodel =$this->model;
		$data['redbao']=$redbaomodel->where('id',$id)->first();
		return view('backend.redbao.redbaoupdate',$data);
	   
	}
	
	//更新红包载入页面
	public function delUpdateRedBao(Request $request)
	{
		    $redbaomodel =$this->model->find($_POST['id']);
            $redbaomodel->name = $request::input('name');
            $redbaomodel->total_num = $request::input('total_num');
			$redbaomodel->xiaxian = $request::input('xiaxian');
            $redbaomodel->start_time = strtotime($request::input('start_time'));
            $redbaomodel->end_time = strtotime($request::input('end_time'));
            $redbaomodel->money = $request::input('money');
            $redbaomodel->remain_num = $request::input('total_num');
			$redbaomodel->desc = $request::input('desc');
			$res=$redbaomodel->save();
            if($res)
            {
                return redirect('/backend/redbao/getList');
            }
			else
			{
				return redirect()->back()->withErrors('更新失败');
			}
	}
	
	//更新品牌信息
	public function dealUpCategory()
	{
		$cateid=intval($_POST['cateid']);
		$data['parentid']=intval($_POST['parentid']);
		$data['name']=htmlspecialchars($_POST['name']);
		$data['info']=htmlspecialchars($_POST['info']);
		@$aid=DB::table($this->tableCategory)->where('cateid', $cateid) ->update($data);
		if ($aid>0) {
            return redirect('/backend/shop/category')->with('status', 'update Success! 成功！ :)');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
	}
	
	
	

	
	
	

	
}