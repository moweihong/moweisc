<?php
/*
 M1 modify by tangzhe 2016-06-30 增加最快揭晓
 M2 modify by tangzhe 2016-07-19 最新上架商品排序规则修改，数据获取方式+改写
*/

namespace App\Repositories;

/*
 *ProductRepository仓库
 *@return Array
 */
use App\Models\Show;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Object;
use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use App\Facades\UserRepositoryFacade;

class ProductRepository extends Repository implements ProductRepositoryInterface
{

    //根据id查找Goods表
    public function findInObject($id)
    {
        return $this->object2Array(Object::find($id));
    }

    //查找全部可用商品数量
    public function findAllGoods()
    {
        return Object::where('is_lottery', '0')->count();
    }


    //根据id查询Object表
    public function findInGoods($id)
    {
        return $this->object2Array(Goods::find($id));
    }

    //联合Goods和Object表根据id进行查询
    public function findObjectBelongsGoods($id)
    {
        return $this->object2Array(Object::with("belongsToGoods")
            ->where('id', $id)
            ->first());
    }

    //根据商品gid查询所有相关晒单
    public function findShowWithGid($gid)
    {
        return $this->object2Array(Object::with("objectHasManyShow")->where('g_id', $gid)->get());
    }

    //根据商品gid查询相关晒单，进行分页
    public function findShowWithGidPaginate($gid, $limit)
    {
        $showorder = $this->object2Array(Show::where('sd_gid', $gid)->where('is_show', 1)->orderBy('sd_time', 'desc')->paginate($limit));
        foreach ($showorder['data'] as $key => $val) {
            $userinfo = UserRepositoryFacade::findUserInfo($val['sd_uid']);
            $showorder['data'][$key]['nickname'] = !empty($userinfo['nickname']) ? $userinfo['nickname'] : config('global.default_nickname');
            $showorder['data'][$key]['user_photo'] = !empty($userinfo['user_photo']) ? $userinfo['user_photo'] : config('global.default_photo');
            $showorder['data'][$key]['sd_time'] = date('Y-m-d H:i:s', $val['sd_time']);
            $showorder['data'][$key]['sd_photolist'] = unserialize($val['sd_photolist']);
            //晒单内容限制字数显示
            $showorder['data'][$key]['title'] = str_limit($val['sd_title'], 55);
            $showorder['data'][$key]['content'] = str_limit($val['sd_content'], 150);

        }
        return $showorder;
    }

    //根据gid查询所有期数和相关的o_id
    public function findAllPeriodsByGid($gid, $limit)
    {
        return $this->object2Array(Object::where('g_id', $gid)->orderBy('periods', 'desc')->take($limit)->get(['id', 'periods']));
    }

    //通过标的id查出对应的gid
    public function findGidWithObjectId($id)
    {
        $gid = Object::where('id', $id)->get(['g_id']);
        foreach ($gid as $g) {
            return $g->g_id;
        }
    }

    //根据brandid查出相关的所有商品进行分页
    public function findAllProductByBrandid($brandid, $pagesize, $order)
    {
        $brandid = (int)$brandid ? $brandid : 0;
        $pagesize = (int)$pagesize ? $pagesize : 20;
        $order = $order;
        switch ($order) {
            case 'default':
                //默认排序方式进行查询，按照即将揭晓方式排序
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
            case 'person':
                //按照剩余人数升序
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person-tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
                break;
            case 'hots':
                //热门商品排序
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->paginate($pagesize));
                break;
            case 'new':
                //最新发布商品排序
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.time', 'desc')
                    ->paginate($pagesize));
                break;
            case 'price_asc':
                //按照总价格升序
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'asc')
                    ->paginate($pagesize));
                break;
            case 'price_desc':
                //按照总价格降序
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'desc')
                    ->paginate($pagesize));
                break;
            default:
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.brandid', $brandid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person-tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
        }
    }

    //根据catid查出所有相关商品，并分页
    public function findAllProductByCatid($catid, $pagesize, $order)
    {
        $catid = (int)$catid ? $catid : 0;
        $pagesize = (int)$pagesize ? $pagesize : 20;
        $order = $order;
        switch ($order) {
            case 'default':
                //默认排序方式进行查询
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
            case 'person':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person-tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
                break;
            case 'hots':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->paginate($pagesize));
                break;
            case 'new': //m2
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.id', 'desc')
                    ->paginate($pagesize));
                break;
            case 'price_asc':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'asc')
                    ->paginate($pagesize));
                break;
            case 'price_desc':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'desc')
                    ->paginate($pagesize));
                break;
            default:
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
        }

    }

    //根据catid查出所有相关商品（移动端使用）
    public function findAllProductByCatidMobile($catid, $page, $pagesize, $order)
    {
        $catid = (int)$catid ? $catid : 0;
        $pagesize = (int)$pagesize ? $pagesize : 10;
        $skip = $page * $pagesize;

        switch ($order) {
            case 'default':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
                break;
            case 'fast':
                //默认排序方式进行查询
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
            case 'new':  //m2
                return DB::table('tab_object')->rightJoin('ykg_goods','tab_object.g_id','=','ykg_goods.id')
                ->where('ykg_goods.cateid', $catid)
				->where('tab_object.is_lottery', 0)
				->orderBy('ykg_goods.id','desc')
				->skip($skip)->take($pagesize)->get(['ykg_goods.*','tab_object.*']); 
                break;
            case 'price_asc':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'asc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
                break;
            case 'price_desc':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
                break;
            default:
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('ykg_goods.cateid', $catid)
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
        }

    }


    //查询全站的商品,不区分品牌和cateid
    public function findAllProduct($pagesize, $order)
    {
        $pagesize = (int)$pagesize ? $pagesize : 20;
        $order = $order;
        switch ($order) {
            case 'default':
                //默认排序方式进行查询
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
            case 'person':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person-tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
                break;
            case 'hots':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->paginate($pagesize));
                break;
            case 'new':  //M2 -pc
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.id', 'desc')
                    ->paginate($pagesize));
                break;
            case 'price_asc':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'asc')
                    ->paginate($pagesize));
                break;
            case 'price_desc':
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'desc')
                    ->paginate($pagesize));
                break;
            default:
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->paginate($pagesize));
        }
    }


    //查询全站的商品,不区分品牌和cateid（移动端使用）
    public function findAllProductMobile($page, $pagesize, $order)
    {
        $pagesize = (int)$pagesize ? $pagesize : 10;
        $skip = $page * $pagesize;

        switch ($order) {
            //默认排序方式进行查询
            case 'default':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
                break;
            case 'fast':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
            case 'new': //m2
				return DB::table('tab_object')->rightJoin('ykg_goods','tab_object.g_id','=','ykg_goods.id')
				->where('tab_object.is_lottery', 0)
				->orderBy('ykg_goods.id','desc')
				->skip($skip)->take($pagesize)->get(['ykg_goods.*','tab_object.*']); 
                break;
            case 'price_asc':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'asc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
                break;
            case 'price_desc':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get();
                break;
            default:
                return $this->object2Array(DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->skip($skip)
                    ->take($pagesize)
                    ->get());
        }
    }

    //查询全站的商品,不区分品牌和cateid,无分页
    public function findAllProductNoPaginate($pagesize, $order)
    {
        $pagesize = (int)$pagesize ? $pagesize : 20;
        $order = $order;
        switch ($order) {
            case 'default':
                //默认排序方式进行查询
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->take($pagesize)
                    ->get();
            case 'person':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person-tab_object.total_person'), 'desc')
                    ->take($pagesize)
                    ->get();
                break;
            case 'hots':
                $res= DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('tab_object.periods', 'desc')
                    ->take($pagesize)
                    ->get();
				return $res;
                break;
			case 'fast':  //M1 增加最快揭晓
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->take($pagesize)
                    ->get();
            case 'new':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.time', 'desc')
                    ->take($pagesize)
                    ->get();
                break;
            case 'price_asc':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'asc')
                    ->take($pagesize)
                    ->get();
                break;
            case 'price_desc':
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy('ykg_goods.money', 'desc')
                    ->take($pagesize)
                    ->get();
                break;
            default:
                return DB::table('ykg_goods')
                    ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
                    ->where('tab_object.is_lottery', 0)
                    ->orderBy(DB::raw('tab_object.participate_person/tab_object.total_person'), 'desc')
                    ->take($pagesize)
                    ->get();
        }
    }


    public function findLimitProductByCatid($catid, $limit, $order = 'default')
    {
        $res= DB::table('ykg_goods')
            ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
            ->where('ykg_goods.cateid',$catid)
            ->where('tab_object.is_lottery', 0)
            ->orderBy('ykg_goods.money', 'desc')
            ->take($limit)
            ->get();
//		$num= count($res);
//		$offset=$num/2;
//		$ys=$num%2;
//		if($ys==0)
//		{
//			$offset--;
//		}
//		$res2=$res;
//		$res2[0]=$res[$offset];
//		$res2[$offset]=$res[0];
		//print_r($res2);exit;
		return $res;

    }


    //根据商品id查询开奖状态
    public function findStatusProductById($id)
    {
        $status = Object::where('id', $id)->get(['is_lottery']);
        foreach ($status as $s) {
            return $s->is_lottery;
        }
    }

    //根据o_id查询商品的最新一期id
    public function findLatestGoods($o_id)
    {
        $o_id = DB::select('select id from tab_object where g_id in(select g_id from tab_object where id=?) order by periods desc limit 1', [$o_id]);
        foreach ($o_id as $key => $val) {
            return $val->id;
        }


    }

    //根据o_id获取指定o_id之前的$limit期
    public function findOidAndPeriods($o_id, $limit)
    {
        $periods = DB::select('select g_id,periods from tab_object where id=?', [$o_id]);
        $gids = array();
        foreach ($periods as $key => $val) {
            $periods = $val->periods;
            array_push($gids, $val->g_id);
        }
        $data = DB::table('tab_object')->whereIn('g_id', $gids)->where('periods', '<=', $periods + 2)
            ->orderBy('periods', 'desc')->take($limit)->get();
        return $data;
    }

    //获取最新揭晓和即将揭晓的商品
    public function findAnnouncement($limit)
    {
        $goods = Object::with('belongsToGoods')->where('is_lottery', '1')
            ->orWhere('is_lottery', '2')
            ->orderBy('lottery_time', 'desc')
            ->paginate($limit);
        $data['goods']=$this->object2Array($goods);
        $data['paginate']=$goods;
        return $data;

    }

    //获取正在揭晓的商品
    public function findComming($page, $pagesize)
    {
        $pagesize = (int)$pagesize ? $pagesize : 10;
        $skip = $page * $pagesize;
        $goods = Object::with('belongsToGoods')->where('is_lottery', '1')
            ->orderBy('lottery_time', 'desc')
            ->skip($skip)
            ->take($pagesize)
            ->get();
        return $this->object2Array($goods);

    }

    //获取已经揭晓的商品
    public function findReward($page, $pagesize, $gid)
    {
        $pagesize = (int)$pagesize ? $pagesize : 10;
        $skip = $page * $pagesize;
        $goods = Object::with('belongsToGoods')->where('is_lottery', '2')->where('g_id', $gid)
            ->orderBy('lottery_time', 'desc')
            ->skip($skip)
            ->take($pagesize)
            ->get();
        return $this->object2Array($goods);

    }
    
    //获取已经揭晓的商品（全部）
    public function findRewardAll($page, $pagesize)
    {
        $pagesize = (int)$pagesize ? $pagesize : 10;
        $skip = $page * $pagesize;
        $goods = Object::with('belongsToGoods')->where('is_lottery', '2')
        ->orderBy('lottery_time', 'desc')
        ->skip($skip)
        ->take($pagesize)
        ->get();
        return $this->object2Array($goods);
    
    }

    //获取即将揭晓的商品
    public function findUnveiling($page, $pagesize)
    {
        $pagesize = (int)$pagesize ? $pagesize : 10;
        $skip = $page * $pagesize;
        $goods = Object::with('belongsToGoods')->where('is_lottery', '0')
            ->orderBy(DB::raw('participate_person/total_person'), 'desc')
            ->skip($skip)
            ->take($pagesize)
            ->get();
        return $this->object2Array($goods);

    }

    //获取指定数量揭晓商品，按照剩余人数进行排序
    public function findOverPlusGoods($limit, $order = 'total_person-participate_person')
    {
        $goods = Object::with('belongsToGoods')->where('is_lottery', '0')
            ->orderBy(DB::raw($order), 'asc')
            ->take($limit)
            ->get();
        return $this->object2Array($goods);
    }

    //模糊搜索，根据商品名称搜索商品
    public function findGoodsWithLike($key, $limit)
    {

        $data = DB::table('ykg_goods')
            ->leftjoin('tab_object', 'ykg_goods.id', '=', 'tab_object.g_id')
            ->where('ykg_goods.title', 'like', '%' . $key . '%')
            ->where('tab_object.is_lottery', 0)
            ->orderBy('tab_object.id', 'desc')
            ->take($limit)
            ->get();
        return $data;

    }

    //查询商品是否已经开奖,返回0(可购买),1(正在开奖),2(已经开奖)
    public function findProductStatus($oid)
    {
        $n = false;
        if (!empty($oid)) {
            $p = Object::where('id', $oid)->get(['is_lottery']);
            foreach ($p as $v) {
                $n=$v->is_lottery;
            }
        }
        return $n;
    }


}
