<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta meta name="format-detection" content="telephone=no,email=no,adress=no" />
    <meta name="keywords" content="特速一块购">
    <meta name="description" content="特速一元购。">
    <title>@yield('title')</title>
    {{--全局css--}}
    <style>
        #search-div{width:80%;display:inline-block;text-align:center;height:30px;background:#E8E8E8;border-radius:5px;margin-top:7px;position:relative}
        #search-div img{position:absolute;width:.14rem;top:8px;left:8px}
        #search-div input{background:#E8E8E8;border:none;height:30px;padding-left:30px}
        .hide{display:none}
    </style>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/mui.css?v={{config('global.version')}}" />
    <script  type="text/javascript" src="{{ $h5_prefix }}js/jquery191.min.js"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}js/mui.js?v={{config('global.version')}}"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}layer_mobie/layer.js"></script>
   <script type="text/javascript" src="{{ $h5_prefix }}js/common.js?v={{config('global.version')}}"></script>
    <script type="text/javascript">
        //csrf_token验证
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script type="text/javascript" src="{{ $h5_prefix }}js/my_cart.js?v={{config('global.version')}}"></script>
   <script type="text/javascript" >
    $(function(){
    if($("#search-div img").css("display")==='none'){
    $(" #search-div input").css({"padding-left":"5px"});
    }
    });
   </script>

    {{--私有css--}}
    @yield('my_css')
</head>
<body>
	
    {{--模板头文件--}}
    <header class="mui-bar mui-bar-nav">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
        <form method="get" action="/search_m_result" id="mysearch">
        <div class="search-div" id="search-div">
            <img src="{{ $h5_prefix }}images/search_ioc.png" class="@yield('search_ioc_switch')"/>
            <input type="text" name="key" value="{{ $searchval }}" placeholder="@yield('textDesc')"/>
        </div>
        <div id="rightTopAction" class='mui-titleR'><a href='javascript:;'>@yield('rightTopAction') </a></div>
        </form>
    </header>

    {{--模板内容--}}
    @yield('content')

    @yield('my_js')

    <script type="text/javascript">
        $(function(){
            $('#rightTopAction').click(function(){
                if($('input[name="key"]').val()){
                    $('#mysearch').submit();
                }else{
					myalert('请输入搜索的商品名称');
                }
            });
        });
    </script>

<script>
/*
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?cc4d5f60a15bfff8ca10bf514eb87d02";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();*/
</script>

</body>
</html>

