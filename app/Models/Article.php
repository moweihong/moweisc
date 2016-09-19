<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'article_id';
    protected $dateFormat = 'U';
    public function getAll() {
        return $this->paginate(10);
    }	
	
     /*
     * 关联文章分类表
     */
    public function articleCat() {
        return $this->hasOne('App\Models\Article_cat','cat_id','cat_id');
    }
}
