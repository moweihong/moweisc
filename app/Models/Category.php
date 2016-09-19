<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    public   $table  =  'ykg_category';  //分类表
    public   $timestamps = false;
    protected $primaryKey = 'cateid';

}