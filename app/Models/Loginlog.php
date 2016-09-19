<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loginlog extends Model {
    public   $table  =  'tab_login_log';  //用户登录记录表
    public  $timestamps=false;
}