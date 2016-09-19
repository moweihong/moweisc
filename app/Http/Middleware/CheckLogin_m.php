<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use App\Mspecs\M3Result;
class CheckLogin_m
{
    /**
     * 登陆验证中间件
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断用户登陆信息是否存在session中
        $member = $request->session()->get('user.id');
        if (empty($member)) {
            //如果用户未登录，跳转到登陆页面
            if ($request->ajax()) {
                //ajax请求
                //返回json格式
                //Mspecs
                $mspecs = new M3Result();
                $mspecs->status = -1;
                $mspecs->message = '未登陆';
                echo $mspecs->toJson();
                exit();
            } else {
                //直接跳转到登陆页面
	            if(strpos($_SERVER['REQUEST_URI'], 'cz') !== false){
		            header('Location:/login_m?url_prefix=cz');
	            }else{
		            //header('Location:/login_m');
                    //微信公众号  用户未登录时 点击户中心的链接 记住此链接 登陆之后跳转这个链接  16.6.26 by byl
		            header('Location:/login_m?url='.urlencode($_SERVER['REQUEST_URI']));
	            }
                exit();
            }
        }

        //否则跳转
        return $next($request);

    }
}
