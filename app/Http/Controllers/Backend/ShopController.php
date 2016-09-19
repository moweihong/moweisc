<?php
/*
M1 add by tangzhe 2016-08-01 生成硬盘静态
M2 add by tangzhe 2016-08-11 商品列表加入销售量
*/
namespace App\Http\Controllers\Backend;
use App\Models\Object_del;
use App\Models\Merchants;
use DB;
use Excel;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Backend\Common\tree;
use App\Http\Controllers\Backend\Common\FunController;
use App\Models\Activitygoods;
use App\Models\Goods;
use App\Models\Category;
use App\Models\Object;
use Request,Validator;

class ShopController extends BaseController {
    
    public function index(){
     
       $shop_list = DB::table($this->tableShoplist)
	   //->where($this->tableShoplist.'.isdeleted','0')
	   ->join($this->tableCategory,$this->tableShoplist.'.cateid','=',$this->tableCategory.'.cateid')
       ->select($this->tableShoplist.'.*',$this->tableCategory.'.name',$this->tableCategory.'.info')
	   ->orderBy($this->tableShoplist.'.id','desc')
       ->paginate($this->pageCount);
	   $data['shoplist']=$shop_list;
	   //m2
	   $gid ='';
	   foreach($shop_list as $s){
		   $gid .= $s->id.',';
	   }
	   $gid = substr($gid,0,-1);
	   $periods = DB::select("SELECT `g_id`,max(periods) cur_periods FROM `tab_object` WHERE `g_id` IN($gid) GROUP BY `g_id`  "); 
	   foreach($periods as $p){
		   foreach($data['shoplist'] as &$s){
			   if($p->g_id == $s->id){
				   $s->cur_periods = $p->cur_periods;
			   }else{
				   $s->cur_periods = 0;
			   }
		   }
	   }
	   return view('backend.shop.shoplist',$data);
	   
    }
	
	
	//搜索商品
	public function searchShop($keyword)
	{
		 $shop_list = DB::table($this->tableShoplist)
	   ->where($this->tableShoplist.'.title','like','%'.$keyword.'%')
	   ->join($this->tableCategory,$this->tableShoplist.'.cateid','=',$this->tableCategory.'.cateid')
       ->select($this->tableShoplist.'.*',$this->tableCategory.'.name',$this->tableCategory.'.info')
	   ->orderBy($this->tableShoplist.'.id','desc')
       ->paginate($this->pageCount);
	   $data['shoplist']=$shop_list;
	   //m2
	   $gid ='';
	   foreach($shop_list as $s){
		   $gid .= $s->id.',';
	   }
	   $gid = substr($gid,0,-1);
	   $periods = DB::select("SELECT `g_id`,max(periods) cur_periods FROM `tab_object` WHERE `g_id` IN($gid) GROUP BY `g_id`  "); 
	   foreach($periods as $p){
		   foreach($data['shoplist'] as &$s){
			   if($p->g_id == $s->id){
				   $s->cur_periods = $p->cur_periods;
			   }else{
				   $s->cur_periods = 0;
			   }
		   }
	   }  
	   return view('backend.shop.shoplist',$data);
	}
	
	
	//活动商品列表
	public function activityList(){
     
       $model=new Activitygoods();
	   $data['list']=$model->getList();
	   //var_dump($res);exit;
	   return view('backend.shop.activityshoplist',$data);
	   
    }
	
	//加载添加活动商品页面
	public function addActivityShop()
	{
		return view('backend.shop.activityshopinsert');
	}
	
	//添加活动商品页面
	public function saveActivityShop(Request $request)
	{
		$validator = Validator::make($request::all(), [
            'title' => 'required',
            'invite_need' => 'required',
            'stock' => 'required',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } 
        else {
            
            $model=new Activitygoods();
            $model->title = $request::input('title');
            $model->invite_need = $request::input('invite_need');
            $model->stock= $request::input('stock');
            $model->img = $request::input('img');
			$model->invite_money = $request::input('invite_money');
            if($model->save()){
                return redirect('/backend/shop/activityList');
            }
        }
	}
	
	//设置活动商品上下架
	public function setStatus()
	{
		$type=$_POST['type'];
		$model=new Activitygoods();
	    $res=$model->find($_POST['id']);
		if($type==1)
		{ 
		   $res->status=0;//下架	
		}
		else
		{
			 $res->status=1;//上架	
	    }
		if($res->save())
		{
  			echo 1;//成功
		}
		else
		{
			echo 0;
		}
	}
	
     public function show(){
        //
        return '参数非法！请勿手动更改访问地址。';
    }
	
	//栏目列表
    public function category(){
        //
       $tree=new tree();
       $categorylist = DB::table($this->tableCategory)->where('is_show','0')->paginate($this->pageCount);
	   $arr=array();
	   foreach($categorylist as $v)
	   {
	   	 $arr[]=$this->object_array($v);
	   }
	   $result=$tree->getTree($arr);
	  
       $data['result']=$result;
	   $data['categorylist']=$categorylist;
	   //print_r($data);exit;
	   return view('backend.shop.categorylist',$data);
	   //return view('backend.admin.index');
       
    }
	
	 //删除品牌
	public function delCategory()
	{
		$id=$_POST['id'];
		@$aid=DB::table($this->tableCategory)->where('cateid', $id) ->update(['is_show' =>'1']);
		echo $aid;
	}
	
	//更新品牌载入页面
	public function upCategory($id)
	{
		
		//商品信息
	   $categorylist=$this->categoryTree();
	   $data['cateList']=$categorylist;
       $cateinfo = DB::table($this->tableCategory)->where('cateid',$id)->get();
	   $data['cateinfo']=$cateinfo[0];
	   //print_r($data);exit;
	   return view('backend.shop.categoryupdate',$data);
	   
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
	
	
	
	//品牌列表
	public function brand()
	{
	  
       $brandlist = DB::table($this->tableBrand)->where('status','Y')->paginate($this->pageCount);
	   $data['brandlist']=$brandlist;
	   return view('backend.shop.brandlist',$data);
	}
	
	
	//添加品牌载入页面
	public function addBrand(){
        $categorylist=$this->categoryTree();
		$data['cateList']=$categorylist;
	    return view('backend.shop.brandidadd',$data);
      
    }
	
	//添加品牌入库
	public function saveBrand()
	{
		
		$data['cateid']=intval($_POST['cateid']);
		$data['name']=htmlspecialchars($_POST['name']);
		$data['order']=intval($_POST['order']);
		$id = DB::table($this->tableBrand)->insertGetId($data);
		if ($id>0) {
            return redirect('/backend/shop/brand')->with('status', 'add Success! 成功！ :)');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
		 
	    
	}

    //删除品牌
	public function delBrand()
	{
		$id=$_POST['id'];
		@$aid=DB::table($this->tableBrand)->where('id', $id) ->update(['status' =>'N']);
		echo $aid;
	}
	
	//更新品牌载入页面
	public function upBrand($id)
	{
		
		//商品信息
	   $categorylist=$this->categoryTree();
	   $data['cateList']=$categorylist;
       $brandlist = DB::table($this->tableBrand)->where('id',$id)->get();
	   $data['brandlist']=$brandlist[0];
	   //print_r($data);exit;
	   return view('backend.shop.brandupdate',$data);
	   
	}
	
	//更新品牌信息
	public function dealUpBrand()
	{
		$data['id']=intval($_POST['id']);
		$data['cateid']=intval($_POST['cateid']);
		$data['name']=htmlspecialchars($_POST['name']);
		$data['order']=intval($_POST['order']);
		@$aid=DB::table($this->tableBrand)->where('id', $id) ->update($data);
		if ($aid>0) {
            return redirect('/backend/shop/brand/'.$id)->with('status', 'update Success! 成功！ :)');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
	}
	
	
	public function addShop(){
        //
       $tree=new tree();
       $categorylist = DB::table($this->tableCategory)->get();
	   $list=merchants::where('is_delete',0)->get();
	   $data['supplierList']=$list;
	   $arr=array();
	   foreach($categorylist as $v)
	   {
	   	 $arr[]=$this->object_array($v);
	   }
	   $result=$tree->getTree($arr);
	   $data['cateList']=$result;
	   
	   //print_r($result);
       return view('backend.shop.shopinsert',$data);
        
        
    }
	
	
	public function saveShop()
	{
		//print_r(http://'.$_SERVER['HTTP_HOST']);exit;
		//print_r($_POST);exit;
		$tree=new tree();
		$data['cateid'] = intval($_POST['cateid']);
		if($data['cateid']==102)
		{
			$data['is_virtual'] =1;
		}
		else
		{
			$data['is_virtual'] =0;
		}
		if(isset($_POST['brand']))
		{
			$data['brandid'] = intval($_POST['brand']);
		}
		else
		{
			$data['brandid'] = 0;
		}
		$data['supplier'] = htmlspecialchars(trim($_POST['supplier']));
		$data['title'] = htmlspecialchars(trim($_POST['title']));
		$data['title2'] = htmlspecialchars(trim($_POST['title2']));			
		//$data['keywords'] = htmlspecialchars($_POST['keywords']);
		//$data['description'] = htmlspecialchars($_POST['description']);
		/*******seo信息*******/
		$data['seo_title'] = htmlspecialchars(trim($_POST['seo_title']));
		$data['seo_descript'] = htmlspecialchars(trim($_POST['seo_descript']));
		$data['seo_keyword'] = htmlspecialchars(trim($_POST['seo_keyword']));
		/*******seoend******/
		$data['money'] = intval($_POST['money']);
		$data['purchase_price'] = intval($_POST['purchase_price']);
		$data['shoptype'] = intval($_POST['shoptype']);
		
		$data['maxqishu'] = intval($_POST['maxqishu']);				

		$data['thumb'] = htmlspecialchars($_POST['thumb']);
		if(isset($_POST['pic'])){
			$data['picarr']  = serialize($_POST['pic']);
		}else{
			$data['picarr'] = serialize(array());
		}
		
		$data['content'] = $tree->editor_safe_replace(stripslashes($_POST['content']));	
	
		$data['pos'] = isset($_POST['goods_key']['pos']) ? 1 : 0;
		$data['renqi'] = isset($_POST['goods_key']['renqi']) ? 1 : 0;
		
		$data['time']=time();
		$data['g_type']=$_POST['g_type'];
		//保存入库 开启事务
		DB::beginTransaction();
		$id = DB::table($this->tableShoplist)->insertGetId( $data);
		
		if ($id>0)
	    {
	    	//标表
	    	$object['g_id']=$id;
			$object['total_person']=$data['money'];
			$object['minimum']=$_POST['minimum'];
			$object['periods']=1;
			$object['begin_time']=time();
			$oid = DB::table('tab_object')->insertGetId($object);
		    if($oid>0)
		    {
		    	//添加云购码
		    	$crr['o_id']=$oid;
		    	$code=$this->createCode($data['money']);
				
				foreach($code as $v)
				{
					$crr['code_num']=count(json_decode($v));
					$crr['bid_codes']=$v;
					$cid = DB::table('tab_tmp_bid_code')->insertGetId($crr);
					//$cid=FALSE;
					if(!$cid)
					{
						DB::rollback();
						return redirect()->back()->withInput()->withErrors('云购码生成失败！');
					}
				}
		    	
		    }
			else
			{
				DB::rollback();
				return redirect()->back()->withInput()->withErrors('添加失败！');//标表添加失败
			}
			DB::commit();
			//M1 生成硬盘静态
			$object_id = DB::select('select id from tab_object where g_id="'.$id.'" order by id desc limit 1 ');
			$object_id= $object_id[0]->id;
			
			$html = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/productdetail_m/'.$object_id);
			file_put_contents('html_static/h5pro/'.$id.'.html',$html);
            return redirect('/backend/shop')->with('status', 'add Success! 成功！ :)');
        }
        else
		{
			DB::rollback();
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
		 
	}
	
	 /*******生成云购码*********
	  * totalprize:商品总价
	  * $prize：单价
	  */
	 public function createCode($totalprize,$prize=1)
	 {
	 	$num=$totalprize/$prize;
		$arr=array();
		$start=99997001;
		$end=100000000;
		//echo $num;
		if($num>3000)
		{
			for($num;$num>=0;$num=$num-3000)
			{
				if($num<=3000)
				{
					//echo $num;
					$endincrease=$num;
					$num=0;
					
				}
				else
				{
					$endincrease=3000;
				}
				$start=$start+3000;
				$end=$end+$endincrease;
				$codes=range($start,$end);
				foreach($codes as $k=>$v)
				{
					$codes[$k]=(string)$v;
				}
		        shuffle($codes);
				$arr[]=json_encode($codes);

			}
		}
		else
		{
			$start=$start+3000;
			$end=$end+$num;
			$codes=range($start,$end);
			foreach($codes as $k=>$v)
			{
				$codes[$k]=(string)$v;
			}
		    shuffle($codes);
			$arr[]=json_encode($codes);
		}
	    return $arr;
	 	
	 }
	//保存图片到服务器
	public function savePic()
	{
		
		$targetFolder = '/backend/upload/shopimg'; // Relative to the root
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
				//非本地转移多一份到app的地址中去
//				if($_SERVER['SERVER_NAME']!='localhost')
//				{
//					$appFile='/data001/www/site/app.ts1kg.com/public/backend/upload/shopimg/'.$filename;
//					//$appFile='D:/phpStudy/WWW/ykg/public/backend/upload/shopimg/'.$filename;
//					@move_uploaded_file($tempFile,$appFile);
//				}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
				echo  $rtname;
			} else 
			{
				echo 'Invalid file type.';
			}
	     }
	}
	
	//删除商品
	public function delShop()
	{
		//删除商品逻辑  -------》 根据gid查询出商品最新一期期数，将maxqishu修改为当前期数即可,
		$id=$_POST['id'];

		$data=DB::table('tab_object')->where('g_id',$id)->orderBy('periods','desc')->take(1)->get();
		foreach ($data as $v){
			$pod=$v->periods;//最近的期数
			$participate_person=$v->participate_person;//已参与人数
			$oid=$v->id;//商品的oid
			$gid=$v->g_id;
			$total=$v->total_person;
			$minimum=$v->minimum;
			$begintime=$v->begin_time;
		}
		//如果已经产生购买，则不能删除，否则直接移除商品进入回收站。
		if($participate_person>0){
			//商品已经购买
		}
		else{
			//将object表中的商品进行移除
			DB::beginTransaction();
			try{
				$object_del=new Object_del();
				$del=DB::delete('delete from tab_object where id=?',[$oid]);
                $object_del->id=$oid;
				$object_del->g_id=$id;
				$object_del->total_person=$total;
				$object_del->minimum=$minimum;
				$object_del->periods=$pod;
				$object_del->begin_time=$begintime;
				$sav=$object_del->save();
				$pod=$pod-1;//期数递减一期
				if($del && $sav){
					DB::commit();
				}else{
					DB::rollback();
				}
			}
			catch (\Exception $e) {
              DB::rollBack();
			}
		}

		@$aid=DB::table($this->tableShoplist)->where('id', $id) ->update(['maxqishu' => $pod,'isdeleted'=>'1']);
		echo $aid;
	}

	//上架商品
	public function uploadShopAgain()
	{
		//print_r($_POST);exit;
		//删除商品逻辑  -------》 根据gid查询出商品最新一期期数，将maxqishu修改为当前期数即可,
		$id=$_POST['id'];

		$objectinfo=DB::table('tab_object')->where('g_id',$id)->orderBy('periods','desc')->take(1)->get();
		if(empty($objectinfo))
		{
			echo '此商品数据有误，不能重新上架，请重新添加';exit;
		}
		//print_r($objectinfo);exit;
		foreach ($objectinfo as $v){
			$pod=$v->periods;//最近的期数
			$participate_person=$v->participate_person;//已参与人数
			$total_person=$v->total_person;//总参与人数
			$oid=$v->id;//商品的oid
			$gid=$v->g_id;
			$total=$v->total_person;
			$minimum=$v->minimum;
			$begintime=$v->begin_time;
		}
		if($_POST['maxqishu']<=$pod)
		{
			echo '当期期数已经是'.$pod,'提交的最大期数不能小于当期期数';exit;
		}
		//当期已经购买完毕，可上架
		if($participate_person==$total_person){
			//更新goods表
			$tree=new tree();
			$data['cateid'] = intval($_POST['cateid']);
			if(isset($_POST['brand']))
			{
				$data['brandid'] =intval($_POST['brand']);
			}
			else
			{
				$data['brandid'] =0;
			}
			$data['title'] =htmlspecialchars(trim($_POST['title']));
			$data['title2'] = htmlspecialchars(trim($_POST['title2']));			
	//		$data['keywords'] = htmlspecialchars($_POST['keywords']);
	//		$data['description'] = htmlspecialchars($_POST['description']);
			/*******seo信息*******/
//			$data['seo_title'] = htmlspecialchars(trim($_POST['seo_title']));
//			$data['seo_descript'] = htmlspecialchars(trim($_POST['seo_descript']));
//			$data['seo_keyword'] = htmlspecialchars(trim($_POST['seo_keyword']));
			/*******seoend******/
			$data['money'] = intval($_POST['money']);
		
			$data['maxqishu'] = intval($_POST['maxqishu']);				
	
			$data['thumb'] = htmlspecialchars($_POST['thumb']);
			if(isset($_POST['pic'])){
				$data['picarr']  = serialize($_POST['pic']);
			}else{
				$data['picarr'] = serialize(array());
			}
			
			$data['content'] = $tree->editor_safe_replace(stripslashes($_POST['content']));	
		
			$data['pos'] = isset($_POST['goods_key']['pos']) ? 1 : 0;
			$data['renqi'] = isset($_POST['goods_key']['renqi']) ? 1 : 0;
			$data['isdeleted']=0;
			$data['time']=time();	
			DB::beginTransaction();
			@$aid=DB::table($this->tableShoplist)->where('id', $id) ->update($data);
			
			if ($aid>0)
		    {
		    	//标表
		    	$object['g_id']=$id;
				$object['total_person']=$data['money'];
				$object['minimum']=$minimum;//单价
				$object['periods']=$pod+1;
				$object['begin_time']=time();
				$oid = DB::table('tab_object')->insertGetId($object);
			    if($oid>0)
			    {
			    	//添加云购码
			    	$crr['o_id']=$oid;
			    	$code=$this->createCode($data['money']);
					
					foreach($code as $v)
					{
						$crr['code_num']=count(json_decode($v));
						$crr['bid_codes']=$v;
						$cid = DB::table('tab_tmp_bid_code')->insertGetId($crr);
						//$cid=FALSE;
						if(!$cid)
						{
							DB::rollback();
							echo '云购码生成失败';exit;
							//return redirect()->back()->withInput()->withErrors('云购码生成失败！');
						}
					}
			    	
			    }
				else
				{
					DB::rollback();
					echo '上架失败';exit;//标表添加失败
				}
				DB::commit();
	            return redirect('/backend/shop')->with('status', '上架 成功！ :)');
	        }
	        else
			{
				DB::rollback();
	            echo '上架失败';exit;
	        }
			
		}
		else{
			echo '下架商品最后一期还没买完，还不能上架';exit;
		}

		
	}

	//载入上架商品信息
	public function loadUoloadShopAgain($id)
	{
		//商品信息
		$shop_list = DB::table($this->tableShoplist)
	   ->where($this->tableShoplist.'.id',$id)
	   ->join($this->tableCategory,$this->tableShoplist.'.cateid','=',$this->tableCategory.'.cateid')
       ->select($this->tableShoplist.'.*',$this->tableCategory.'.name')
       ->get();
	   $shop_list[0]->picarr=unserialize($shop_list[0]->picarr);
	   $data['shoplist']=$shop_list[0];
	  // print_r( $data['shoplist']);exit;
	   //分类
	   $tree=new tree();
       $categorylist = DB::table($this->tableCategory)->get();
	   $arr=array();
	   foreach($categorylist as $v)
	   {
	   	 $arr[]=$this->object_array($v);
	   }
	   $result=$tree->getTree($arr);
	   $data['cateList']=$result;
	   $brandlist=$this->getBidCom($data['shoplist']->brandid);
	   $data['brandlist']=$brandlist;
	   
	   return view('backend.shop.shopdellist',$data);
	   
	}
	
	
	//更改商品载入页面
	public function upShop($id)
	{
		//商品信息
		$shop_list = DB::table($this->tableShoplist)
	   ->where($this->tableShoplist.'.id',$id)
	   ->join($this->tableCategory,$this->tableShoplist.'.cateid','=',$this->tableCategory.'.cateid')
       ->select($this->tableShoplist.'.*',$this->tableCategory.'.name')
       ->get();
	   $shop_list[0]->picarr=unserialize($shop_list[0]->picarr);
	   $data['shoplist']=$shop_list[0];
	  // print_r( $data['shoplist']);exit;
	   //分类
	   $tree=new tree();
       $categorylist = DB::table($this->tableCategory)->get();
	   $arr=array();
	   foreach($categorylist as $v)
	   {
	   	 $arr[]=$this->object_array($v);
	   }
	   $result=$tree->getTree($arr);
	   $data['cateList']=$result;
	   $brandlist=$this->getBidCom($data['shoplist']->brandid);
	   $data['brandlist']=$brandlist;
	   
	   return view('backend.shop.shopupdate',$data);
	   
	}
	
	
	
	//正式更改商品
	public function dealUpShop()
	{
		$tree=new tree();
		$id=intval($_POST['id']);
		$data['cateid'] = intval($_POST['cateid']);
		if(isset($_POST['brand']))
		{
			$data['brandid'] =intval($_POST['brand']);
		}
		else
		{
			$data['brandid'] =0;
		}
		$data['title'] =htmlspecialchars(trim($_POST['title']));
		$data['title2'] = htmlspecialchars(trim($_POST['title2']));	
		$data['supplier'] = htmlspecialchars(trim($_POST['supplier']));			
//		$data['keywords'] = htmlspecialchars($_POST['keywords']);
//		$data['description'] = htmlspecialchars($_POST['description']);
		/*******seo信息*******/
		$data['seo_title'] = htmlspecialchars(trim($_POST['seo_title']));
		$data['seo_descript'] = htmlspecialchars(trim($_POST['seo_descript']));
		$data['seo_keyword'] = htmlspecialchars(trim($_POST['seo_keyword']));
		/*******seoend******/
		//$data['money'] = intval($_POST['money']);
	
		$data['maxqishu'] = intval($_POST['maxqishu']);				

		$data['thumb'] = htmlspecialchars($_POST['thumb']);
		if(isset($_POST['pic'])){
			$data['picarr']  = serialize($_POST['pic']);
		}else{
			$data['picarr'] = serialize(array());
		}
//		print_r($_POST['content']);
//		echo '<br />';
		
		$data['content'] = $tree->editor_safe_replace(stripslashes($_POST['content']));	
	   // print_r($data['content']);exit;
		$data['pos'] = isset($_POST['goods_key']['pos']) ? 1 : 0;
		$data['renqi'] = isset($_POST['goods_key']['renqi']) ? 1 : 0;
		$data['time']=time();


		if(!$data['cateid']){return -1;}//请选择栏目
		if(!$data['title']){return -3;};//标题不能为空
        
        
		@$aid=DB::table($this->tableShoplist)->where('id', $id) ->update($data);
		
		
		if ($aid>0) {
			//M1 生成硬盘静态
			$object_id = DB::select('select id from tab_object where g_id="'.$id.'" order by id desc limit 1');
			$object_id= $object_id[0]->id;
			$html = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/productdetail_m/'.$object_id);
			file_put_contents('html_static/h5pro/'.$_POST['id'].'.html',$html);
            return redirect('/backend/shop/upShop/'.$id)->with('status', 'update Success! 成功！ :)');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
		 
	 }
			
			 

     //删除商品图片
     public function delShopPic()
	 {
	 	$filename=$_SERVER['DOCUMENT_ROOT'] .$_POST['pic'];
		$res=unlink($filename);
		echo $res;
	 	
	 }
	 
	 //查看商品详情
	 //更改商品载入页面
	public function lookShop($id)
	{
		//商品信息
		$shop_list = DB::table($this->tableShoplist)
	   ->where($this->tableShoplist.'.id',$id)
	   ->join($this->tableCategory,$this->tableShoplist.'.cateid','=',$this->tableCategory.'.cateid')
       ->select($this->tableShoplist.'.*',$this->tableCategory.'.name')
       ->get();
	   $shop_list[0]->picarr=unserialize($shop_list[0]->picarr);
	   $data['shoplist']=$shop_list[0];
	   //分类
	   $tree=new tree();
       $categorylist = DB::table($this->tableCategory)->get();
	   $arr=array();
	   foreach($categorylist as $v)
	   {
	   	 $arr[]=$this->object_array($v);
	   }
	   $result=$tree->getTree($arr);
	   $data['cateList']=$result;
	   $brandlist=$this->getBidCom($data['shoplist']->brandid);
	   $data['brandlist']=$brandlist;
	   return view('backend.shop.shoplook',$data);
	   
	}
	 //获取品牌
	 public function getBrandid()
	 {
	 	$cateid=intval($_POST['cateid']);
		//$cateid=2;
		$brandlist = DB::table($this->tableBrand)->where('cateid',$cateid)->select('id','name')->get();
		$brandlist=$this->object_array($brandlist);
		//print_r($brandlist);
		echo json_encode($brandlist);
	 }
	
	//添加子栏目载入页面
	public function addCategory($id)
	{
		//echo $id;exit;
		$categorylist=$this->categoryTree();
		$data['cateList']=$categorylist;
		$data['id']=$id;
	    return view('backend.shop.categoryadd',$data);
	}
	
	//添加栏目入库
	public function saveCategory()
	{
		
		$data['parentid']=intval($_POST['cateid']);
		$data['name']=htmlspecialchars($_POST['name']);
		$data['info']=htmlspecialchars($_POST['info']);
		$data['is_rebate']=intval($_POST['is_rebate']);
		$id = DB::table($this->tableCategory)->insertGetId( $data);
		if ($id>0) {
            return redirect('/backend/shop/category')->with('status', 'add Success! 成功！ :)');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
		 
	    
	}
	//获取具体品牌信息
    protected function getBidCom($bid)
    {
    	$brandlist = DB::table($this->tableBrand)->where('id',$bid)->select('id','name')->first();
		$brandlist=$this->object_array($brandlist);
		return $brandlist;
    }
	
	//对象转数组	
	protected function object_array($array) 
	{  
	    if(is_object($array)) 
	    {  
	        $array = (array)$array;  
	    } 
	     if(is_array($array)) 
	     {  
	         foreach($array as $key=>$value) 
	         {  
	             $array[$key] = $this->object_array($value);  
	             
			 }  
	     }  
	     return $array;  
	} 
	
	//分类树
	protected function categoryTree()
	{
	   $tree=new tree();
       $categorylist = DB::table($this->tableCategory)->get();
	   $arr=array();
	   foreach($categorylist as $v)
	   {
	   	 $arr[]=$this->object_array($v);
	   }
	   $result=$tree->getTree($arr);
	   return $result;
	}
	
	public function exportShop()
	{
		//echo '正在开发中。。。';exit;
		$array=array('商品id','商品名称','商品副标题','售价','采购价','供应商','所属类别','销售量');
		$name='商品信息表';
		$goodlist=Goods::select('id','title','title2','money','purchase_price','supplier','cateid')->get()->toArray();
		foreach($goodlist as $key=>$val)
		{
			$cate=Category::where('cateid',$val['cateid'])->select('name')->first();
			$goodlist[$key]['cateid']=$cate['name'];
			$xiaoshouNum=object::where('g_id',$val['id'])->select('periods')->orderBy('periods','desc')->first();
			$goodlist[$key]['xiaoshouNum']=$xiaoshouNum['periods'];
			
		}
		//print_r($goodlist);exit;
		array_unshift($goodlist,$array);
		$time=date('Y-m-d',time());
        Excel::create($time.$name,function($excel) use ($goodlist){
        $excel->sheet('score', function($sheet) use ($goodlist){
        $sheet->rows($goodlist);
        });
        })->export('xls');
	}
	
	
	
	
	/***************商户管理2016-08-12**********************/
	
	//商户列表
	public function merchants()
	{
		$list=merchants::where('is_delete',0)->paginate(50);
		$data['list']=$list;
		return view('backend.shop.merchantslist',$data);
	}
	
	//添加商户
	public function addMerchants(Request $request)
	{
		if($request::isMethod('post'))
		{
			$data['merchants']=htmlspecialchars($_POST['merchants']);
			$data['time']=time();
			$id = DB::table('tab_shop_merchants')->insertGetId($data);
			if ($id>0) {
	            return redirect('/backend/shop/merchants')->with('status', 'add Success! 成功！ :)');
	        } else {
	            return redirect()->back()->withInput()->withErrors('添加失败！');
	        }
		}
		
		return view('backend.shop.addMerchants');
	}
	
	//删除商户
	public function delMerchants()
	{
		$id=intval($_POST['id']);
		$data['is_delete']=1;
		@$aid=DB::table('tab_shop_merchants')->where('id', $id) ->update($data);
		echo $aid;
	}
	
	//编辑商户
	public function changeMerchants()
	{
		$id=intval($_POST['id']);
		$data['merchants']=$_POST['merchants'];
		@$aid=DB::table('tab_shop_merchants')->where('id', $id) ->update($data);
		if ($id>0) {
	            return redirect('/backend/shop/merchants')->with('status', 'add Success! 成功！ :)');
	        } else {
	            return redirect()->back()->withInput()->withErrors('编辑失败！');
	        }
	}
}
