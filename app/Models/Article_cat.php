<?php

namespace App\Models;

use App\Models\Relations\HasManyArticleTrait;
use Illuminate\Database\Eloquent\Model;

class Article_cat extends Model
{
    use HasManyArticleTrait;
    public   $table  =  'article_cat';  
    protected $primaryKey = 'cat_id';
    Public $timestamps = false;
    public function getAll(){
        $article_cat = $this->paginate(10);
        
        return $article_cat;
    }
	
	//获取文章分类
	public function getArticleCat()
	{
		$res=$this->select('cat_id','cat_name')
		->where('show_in_nav','0')
		->where('cat_type','4')
		->orderby('sort_order')
		->get();
		foreach($res as $k=>$v)
		{
			$res[$k]['articlelsit']=$this->getArticle($v->cat_id);
		}
		//$res=$this->object_array($res);
		//print_r($res);
		return $res;
	}
	
	//获取文章分类下的文章
	public function getArticle($cat_id)
	{
		$this->table='article';
		$res=$this->select('article_id','title','content')
		->where('cat_id',$cat_id)
		->get();
		return $res;
	}
    /*
     * 关联文章分类表
     */
    public function articleCats() {
        return $this->hasMany('App\Models\Article','cat_id','cat_id');
    }
	
	
}
