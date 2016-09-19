<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta meta name="format-detection" content="telephone=no,email=no,address=no" />
    <meta name="keywords" content="特速一块购,一块购,1元购,一元购,特速一块购官网,一块购官网">
    <meta name="description" content="特速一块购是一种全新的购物方式，全场名车、手机、电脑、数码产品只需一块即可参与一块购物。特速一块购将打造最具权威的云购商城,以一块购得自己喜欢的商品!，特速一块购由深圳市特速集团注入巨资打造的新型购物平台，必将引导一轮新的消费潮流。">
    <title>@yield('title')</title>
    {{--全局css--}}
    <style>
        #menu-btn{display:none}
        .caret-white-down,.caret-white-up{display:inline-block;width:0;height:0;vertical-align:3px;border-right:6px solid transparent;border-left:6px solid transparent;margin-left:2px}
        .caret-white-down{border-top:6px solid #fff}
        .caret-white-up{border-top:none;border-bottom:6px solid #fff}
        .footer-menu{display:none}
        html body .show{display:table}
        body .hide{display:none}
    </style>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/mui.css?v={{config('global.version')}}" />
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/dropload.css?v={{config('global.version')}}" />

    {{--私有css--}}
    @yield('my_css')
</head>
<body>
	{!! csrf_field() !!}
    {{--模板头文件--}}
    <header class="mui-bar mui-bar-nav">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
        <h1 class="mui-title"><b>@yield('title')</b> <span class="caret-white-down hide" id="menu-btn"></span></h1>
	    <div id="rightTopAction" class='mui-titleR'><a href="javascript:void(0)" data-url="javascript:void(0);">@yield('rightTopAction') </a></div>
    </header>
    
    @yield('content')
    
    {{--模板底栏--}}

</body>
</html>

