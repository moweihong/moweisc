<?php
namespace App\Http\Controllers\h5\Service;

/*
 * 商品相关控制器
 * */
use App\Facades\IndexRepositoryFacade;
use App\Facades\ProductRepositoryFacade;
use App\Facades\UserRepositoryFacade;
use App\Http\Controllers\ForeController;
use App\Mspecs\M3Result;

class ProductsController extends ForeController
{
    public function __construct()
    {
        $this->jsonMspecs = new M3Result();
    }

    //根据catid获取二级分类及该二级分类下的所有商品
    public function postData()
    {
        //获取所有商品分类
        $catid = $_REQUEST['catid'];
        //获取排序方式
        $order = $_REQUEST['order'] ? $_REQUEST['order'] : 'default';
        $pagesize = 40;
        if ((int)$catid) {
            //查找所有品牌分类
            $brand = IndexRepositoryFacade::findCategoryChild($catid);
            $data['brand'] = $brand;
        }
        //尝试获取brandid
        $brandid = $_REQUEST['brandid'];
        if ((int)$brandid) {
            $data['brandidpdt'] = ProductRepositoryFacade::findAllProductByBrandid($brandid, $pagesize, $order);//根据brandid获取所有商品,包含分页
            foreach ($data['brandidpdt']['data'] as $key => $val) {
                $data['brandidpdt']['data'][$key]->rate = round($data['brandidpdt']['data'][$key]->participate_person / $data['brandidpdt']['data'][$key]->total_person, 6) * 100;
                $data['brandidpdt']['data'][$key]->surplus = $data['brandidpdt']['data'][$key]->total_person - $data['brandidpdt']['data'][$key]->participate_person;
            }
        } else {
            //如果获取不到brandid则获取catid进行显示
            if ((int)$catid) {
                $data['catpdt'] = ProductRepositoryFacade::findAllProductByCatid($catid, $pagesize, $order); //根据catid获取所有商品,包含分页
                foreach ($data['catpdt']['data'] as $key => $val) {
                    $data['catpdt']['data'][$key]->rate = round($data['catpdt']['data'][$key]->participate_person / $data['catpdt']['data'][$key]->total_person, 6) * 100;
                    $data['catpdt']['data'][$key]->surplus = $data['catpdt']['data'][$key]->total_person - $data['catpdt']['data'][$key]->participate_person;
                }
            }else{
                //如果获取不到cateid,显示默认页面
                $data['catpdt'] = ProductRepositoryFacade::findAllProduct($pagesize, $order); //根据catid获取所有商品,包含分页
                foreach ($data['catpdt']['data'] as $key => $val) {
                    $data['catpdt']['data'][$key]->rate = round($data['catpdt']['data'][$key]->participate_person / $data['catpdt']['data'][$key]->total_person, 6) * 100;
                    $data['catpdt']['data'][$key]->surplus = $data['catpdt']['data'][$key]->total_person - $data['catpdt']['data'][$key]->participate_person;
                }
            }
        }
        return $this->packageData($data);
    }

    //根据商品o_id查出所有购买记录
    public function getAllBuyRecord()
    {
        $page = $this->getParam('page');
        $o_id = $this->getParam('o_id');
        $data = UserRepositoryFacade::findBuyRecordWithIdMobile($o_id, $page);
        return $this->packageData($data);
    }

    //根据商品o_id查出所有相关的用户晒单记录
    public function getShowOrders($o_id)
    {
        //查找出商品Gid
        $gid = ProductRepositoryFacade::findGidWithObjectId($o_id);
        //通过gid查出用户的相关晒单记录，需要分页
        $showorder = ProductRepositoryFacade::findShowWithGidPaginate($gid, 5);
        return $this->packageData($showorder);
    }

    public function packageData(Array $data)
    {
        //封装数据
        if (is_array($data) && !empty($data)) {
            $this->jsonMspecs->status = '0';
            $this->jsonMspecs->message = 'success';
            $this->jsonMspecs->data = $data;
        } else {
            $this->jsonMspecs->status = '100001';
            $this->jsonMspecs->message = 'fail';
            $this->jsonMspecs->data = array();
        }
        return $this->jsonMspecs->toJson();
    }
}