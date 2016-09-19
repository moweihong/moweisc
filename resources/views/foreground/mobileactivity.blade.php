<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=320,minimum-scale=1,maximum-scale=5,user-scalable=no">
    <meta meta name="format-detection" content="telephone=no,email=no,address=no" />
    <meta name="keywords" content="特速一块购,一块购,1元购,一元购,特速一块购官网,一块购官网">
    <meta name="description" content="特速一块购是一种全新的购物方式，全场名车、手机、电脑、数码产品只需一块即可参与一块购物。特速一块购将打造最具权威的云购商城,以一块购得自己喜欢的商品!，特速一块购由深圳市特速集团注入巨资打造的新型购物平台，必将引导一轮新的消费潮流。">
    <title>@yield('title')</title>
    {{--全局css--}}
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/mui.css?v={{config('global.version')}}" />
    <script type="text/javascript" src="{{ $h5_prefix }}js/jquery191.min.js"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}js/mui.js?v={{config('global.version')}}"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}layer_mobie/layer.js"></script>
    <!--版本号添加-->
    @yield('activity_css')
</head>
<body>
<div class="ykgact-wrap" id="ykgactive-wrap">
{{--模板头文件--}}
<header class="mui-bar mui-bar-nav hide @yield('head_show')">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title"><b>@yield('title')</b> <span class="caret-white-down hide" id="menu-btn"></span></h1>
    <div id="rightTopAction" class='mui-titleR'><a href="javascript:void(0)" data-url="javascript:void(0);">@yield('rightTopAction') </a></div>
</header>
{{--模板内容--}}
@yield('content')

{{--模板底栏--}}
<!--footnav start-->
<nav class="mui-bar mui-bar-tab headnav-tab @yield('footer_switch') hide" id="menu">
    <a class="mui-tab-item @if($menu_active == 'index_m')mui-active @endif" data-url="/index_m">
        <span class="mui-icon iconfont icon-home"></span>
        <span class="mui-tab-label">首页</span>
    </a>
    <a class="mui-tab-item @if($menu_active == 'category_m')mui-active @endif" data-url="/category_m">
        <span class="mui-icon iconfont icon-chanpinfenlei01"></span>
        <span class="mui-tab-label">全部商品</span>
    </a>
    <a class="mui-tab-item @if($menu_active == 'find_m')mui-active @endif"  data-url="/find_m">
        <span class="mui-icon iconfont icon-youxi" style="font-size: 28px"><!--<span class="mui-badge">9</span>--></span>
        <span class="mui-tab-label">发现</span>
    </a>
    <a class="mui-tab-item @if($menu_active == 'mycart_m')mui-active @endif" data-url="/mycart_m">
        <span class="mui-icon iconfont icon-gouwuche"><span class="mui-badge" id="cartI">{{$total_count}}</span></span>
        <span class="mui-tab-label">购物车</span>
    </a>
    <a class="mui-tab-item @if($menu_active == 'user_m' || $menu_active == 'usercenter')mui-active @endif" data-url="@if(session('user.id')>0)/user_m/usercenter2 @else /usercenter @endif">
        <span class="mui-icon iconfont icon-iconfuzhi"></span>
        <span class="mui-tab-label">我</span>
    </a>
    <div class="circle-div"><b class="circle-b"></b></div>
</nav>
<!--footnav end-->
</div>
@yield('activity_js')
<script>
    if(navigator.appVersion.indexOf('Android') != -1){
        document.addEventListener("DOMContentLoaded",function(e){
            document.getElementById('ygwrap').style.zoom = e.target.activeElement.clientWidth/320;
        });
        document.addEventListener('touchstart',function(){},false);
    }

    //定时检测用户的登录状态
    var  st=false;
    $(function time()
    {
        if(st)return;
        checklogin();
        setTimeout(time,5000); //time是指本身,延时递归调用自己,100为间隔调用时间,单位毫秒
    });
    function checklogin(){
        var url="/synchronize";
        $.ajax({
            type:'GET',
            url:url,
            success:function(data){
                var data =eval('('+data+')');
                if(data.status == -10001){
                    st=true;
                    layer.open({
                        content: '您的账号已下线或在别的地方登陆~',
                        btn: ['重新登陆', '返回首页'],
                        shadeClose: false,
                        yes: function(){
                            window.location.href = '/login_m';
                        }, no: function(){
                            window.location.href='/index_m';
                        }
                    });
                }else if(data.status == -1){  //初始状态为未登录
                    st=true;
                }else{
                    //用户处于登录状态
                    st=false;
                }
            }

        });
    }
    $(document).ready(function(){
        //js 自定义跳转data-url
        $('[data-url]').on('click',function(){
            var self = $(this);
            if(self.attr('data-url') != ''){
                window.location.href = self.data('url');
            }
        });
    })
</script>
@if($is_weixin)
    <script>
        wx.config({
            debug: false,
            appId: '{{$jspackage["appId"]}}',
            timestamp: '{{$jspackage["timestamp"]}}',
            nonceStr: '{{$jspackage["nonceStr"]}}',
            signature: '{{$jspackage["signature"]}}',
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });

        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: '哇塞，全部都好想要！', // 分享标题
                link: "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}", // 分享链接
                imgUrl: 'http://m.ts1kg.com/foreground/img/wxshare.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    alert('感谢您的分享(^o-o^)');
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            //发送给朋友
            wx.onMenuShareAppMessage({
                title: '哇塞，全部都好想要！', // 分享标题
                desc: '亲，三生有幸与你相识，送你一份礼物表示一下，快来拿吧！', // 分享描述
                link: "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}", // 分享链接
                imgUrl: 'http://m.ts1kg.com/foreground/img/wxshare.png', // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    alert('感谢您的分享(^o-o^)');
                },
                cancel: function () {
                }
            });
        });
    </script>
@endif

</body>
</html>