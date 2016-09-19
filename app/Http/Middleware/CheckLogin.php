<?php

namespace App\Http\Middleware;

use Closure;
use App\Mspecs\M3Result;
class CheckLogin
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
                header('Location:/login');
                exit();
            }
        }

        //否则跳转
        return $next($request);

    }
}
