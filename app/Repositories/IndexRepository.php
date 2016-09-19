<?php

namespace App\Repositories;

/*
 *IndexRepository仓库
 */
use App\Models\Brand;
use App\Models\Category;
use App\Models\Member;
use App\Repositories\Interfaces\IndexRepositoryInterface;
use App\Models\Bid_record;
use App\Models\Object;
use App\Models\Show;
use App\Models\Slide;
use App\Models\Article_cat;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
class IndexRepository extends Repository implements IndexRepositoryInterface
{
    public function findLatest($limit)
    {
        //获取正在揭晓商品
        $data['latest'] = $this->object2Array(Object::with('belongsToGoods')
            ->where('is_lottery', '=', 1)
            ->orderBy('end_time', 'asc')
            ->take($limit)->get());
        foreach ($data['latest'] as $key => $val) {
            $time = strtotime($data['latest'][$key]['lottery_time']);
            $data['latest'][$key]['lottery_min'] = date('m', time() - $time);
            $data['latest'][$key]['lottery_sec'] = date('s', time() - $time);
        }
        return $data['latest'];
    }

	//获取已揭晓的商品
	public function findLatestOpen($limit)
	{ 
		$data['open'] = $this->object2Array(Object::with('belongsToGoods')
			->where('is_lottery', '=', 2)
			->orderBy('end_time', 'desc')
			->take($limit)->get());
		foreach ($data['open'] as $key => $val) {
			$bid_record = Bid_record::where('o_id', $val['id'])->where('fetchno', $val['lottery_code'])->first();
			$winner = Member::where('usr_id', $bid_record->usr_id)->first();
			$data['open'][$key]['nickname'] = $winner->nickname;
			$data['open'][$key]['usr_id']   = $bid_record->usr_id;
		}
		return $data['open'];
	}

    public function findLatestCount()
    {
        //获取已经揭晓商品数量
        return Object::where('is_lottery', '=', 2)->count();
    }

    public function findSlide($type = 1)
    {
        //轮播图片数据
        return Slide::where('type', $type)->orderBy('order_id','asc')->get();
    }

    public function findSoon($limit)
    {
        //即将揭晓数据 按照剩余人次升序
        return $this->object2Array(Object::with('belongsToGoods')
            ->where('is_lottery', '=', 0)
            ->orderBy(DB::raw('participate_person/total_person'), 'desc')
            ->skip(0)->take($limit)->get());
    }

    public function findIsBuy($limit)
    {
        //正在购买数据
        return Bid_record::where('pay_type','!=','invite')
            ->orderBy('id', 'desc')
            ->take($limit)->get();
    }

    public function findAll($order)
    {
        //全部商品数据，按照期数最多的排序 desc
        return $this->object2Array(Object::with('belongsToGoods')
            ->where('is_lottery', '=', 0)
            ->orderBy($order, 'desc')
            ->take(8)
            ->get());
    }

    public function findNew($limit)
    {
        //新品上架数据 按照goods表的time 降序
	 	$res = DB::table('tab_object')->rightJoin('ykg_goods','tab_object.g_id','=','ykg_goods.id')
		->where('tab_object.is_lottery', 0)
		->orderBy('ykg_goods.id','desc')
		->skip(0)->take($limit)->get(['ykg_goods.*','tab_object.*']); 
		$res = $this->DBarray($res);
		return $res;  
	   /*  $res = $this->object2Array(Object::with('belongsToGoods')
            ->where('is_lottery', '=', 0)
          ->orderBy('periods', 'asc')
           ->orderBy('id', 'desc')
            ->skip(0)->take($limit)->get()); 
		print_r($res);exit;
		return $res; */
    }

    public function findShow($limit)
    {
        //晒单分享数据
        return $this->object2Array(Show::where('is_show',1)->
            orderby('sortid','desc')->orderby('id','desc')->skip(0)->take($limit)->get());
    }

    public function findFooter($order)
    {
        //获取页面底部数据
        return $this->object2Array(Article_cat::with('hasManyAtricles')->where('cat_type', '=', 2)
            ->orderBy($order, 'desc')
            ->get());
    }

    public function findNavigata($order)
    {
        //获取导航条数据
        return $this->object2Array(Category::where('model', '=', 0)
            ->where('parentid', '=', '0')
            ->where('is_show', '=','0')
            ->orderBy($order, 'desc')
            ->get());
    }

    public function findCategory()
    {
        //获取所有一级分类
        return $this->object2Array(Category::where('model', '=', 0)
            ->where('parentid', '=', '0')
            ->where('is_show', '=','0')
            ->orderBy('sort_order', 'desc')
            ->get());
    }
	
	//活动发现的分类处理
	public function findCategoryactivity()
    {
        //获取所有一级分类
        $res=$this->object2Array(Category::where('model', '=', 0)
            ->where('parentid', '=', '0')
            ->where('is_show', '=','0')
            ->orderBy('sort_order', 'desc')
            ->get());
		$res2=$res;
		foreach($res as $k=>$v)
		{
			
			if($v['name']=='汽车奢品')
			{
				unset($res2[$k]);
				array_unshift($res2,$v);
			}
		}
		//print_r($res2);exit;
		return $res2;
    }

    public function findCategoryChild($cateid)
    {
        //获取二级分类

        return $this->object2Array(Brand::where('cateid',$cateid)->where('status','Y')->get());
    }

    public function findArticles($limit)
    {
        //获取limit条公告
        $data=$this->object2Array(Article::where('article_type',3)->orderBy('updated_at', 'desc')->limit(10)->get());
        foreach($data as $key=>$val){
            $data[$key]['updated_at']=date('Y-m-d',$val['updated_at']);
        }
        return $data;
    }


}
