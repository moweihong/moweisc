<?php
namespace App\Http\Controllers\Foreground\View;

use App\Facades\ActivityRepositoryFacade;
use App\Facades\IndexRepositoryFacade;
use App\Facades\ProductRepositoryFacade;
use App\Http\Controllers\ForeController;
use App\Models\Article;

class ActivityController extends ForeController {
    public function index(){
        //带入参数
        //获取所有分类
        $category=IndexRepositoryFacade::findCategory();
        foreach ($category as $key=>$val){
            //选取前五种分类循环获取相关分类下的10个商品
            $category[$key]['goods']=ProductRepositoryFacade::findLimitProductByCatid($val['cateid'],10);
        }
        foreach ($category as $key=>$val){
            if(empty($category[$key]['goods']))
            {
                unset($category[$key]);
            }
        }
        foreach ($category as $key=>$val){
            if(count($category)>5){
                unset($category[$key]);//分类超过五条，进行删除
            }
        }
        $category=array_values($category);//重建键名
        $category[count($category)]=$category[count($category)-1];
        $category[count($category)-1]['goods']=ProductRepositoryFacade::findAllProductNoPaginate(10,'hots');
        $category[count($category)-1]['name']='更多';
        $category[count($category)-1]['info']='更多';
        $category[count($category)-1]['cateid']='0';
        $data['category']=$category;
        if(!empty(session('user.id'))){
        $nickname=!empty(session("user.user_name"))?session("user.user_name"):session("user.phone");
        }else{
            $nickname='';
        }
        $member['uid']=session('user.id');
        $people=sprintf("%07d",ActivityRepositoryFacade::getAllSendCouont());//参与人数
        //获取带图片的文章
        $picArticles = Article::where(['tag'=>'p','article_type'=>5])->orderBy('created_at','desc')->limit(4)->get();
        //获取头条文章
        $hotArticles = Article::where(['tag'=>'t','article_type'=>5])->orderBy('created_at','desc')->limit(2)->get();
        return view('foreground.activity',array('data'=>$data,'nickname'=>$nickname,'member'=>$member,'people'=>$people,'picArticles'=>$picArticles,'hotArticles'=>$hotArticles));
    }
    
    /**
     * 新闻详情页
     */
    public function newsDetail($id){
        $article = Article::where(['article_id'=>$id,'article_type'=>5])->first();
        $articles = Article::where('article_type',5)->orderBy('created_at','desc')->limit(10)->get();

	    //seo配置
	    $seo_index = config('seo.index_m');
	    $seo['web_title'] = $article->title ? $article->title : $seo_index['web_title'];
	    $seo['web_keyword'] = $article->keywords ? $article->keywords : $seo_index['web_keyword'];
	    $seo['web_description'] = $article->description ? $article->description : $seo_index['web_description'];

        return view('foreground.article',['article'=>$article,'articles'=>$articles, 'seo' => $seo]);
    }
    /**
     * 新闻列表页
     */
    public function newsList(){
      //  $article = Article::where(['article_id'=>$id,'article_type'=>5])->first();
        $articles = Article::where('article_type',5)->orderBy('created_at','desc')->paginate(10);
        return view('foreground.articlelist',['articles'=>$articles]);
    }
}