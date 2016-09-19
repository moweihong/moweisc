<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta meta name="format-detection" content="telephone=no,email=no,address=no" />
    <meta name="keywords" content="{{$seo['web_keyword']}}">
    <meta name="description" content="{{$seo['web_description']}}">
    <title>@yield('title') {{$seo['web_title']}}</title>
    @yield('canonical')
    {{--全局css--}}
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/mui.css?v={{config('global.version')}}" />
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/dropload.css?v={{config('global.version')}}" />
    <script type="text/javascript" src="{{ $h5_prefix }}js/jquery191.min.js"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}js/mui.js?v={{config('global.version')}}"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}layer_mobie/layer.js"></script>
    <script type="text/javascript" src="/h5lltj/count.js?v={{config('global.version')}}"></script>
    <script type="text/javascript">
        //csrf_token验证
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
   <!--版本号添加-->
   <script type="text/javascript" src="{{ $h5_prefix }}js/common.js?v={{config('global.version')}}"></script>
   <script type="text/javascript" src="{{ $h5_prefix }}js/dropload.min.js"></script>
   <script type="text/javascript" src="{{ $h5_prefix }}js/my_cart.js?v={{config('global.version')}}"></script>
   <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
   <script type="text/javascript" src="{{ $h5_prefix }}js/lazyload.min.js"></script>

    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?7bc9a7ba14b930a92b7faa123527b406";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

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
    <input type="hidden" id="sys_cur_time" value="{{date('Y/m/d H:i:s')}}"/>
    {{--模板内容--}}
    @yield('content')
    
    {{--模板底栏--}}
    <!--footnav start-->


      <nav class="mui-bar mui-bar-tab @yield('footer_switch') hide" id="menu">

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
            <span class="mui-icon iconfont icon-gouwuche"><span class="mui-badge @if($total_count <= 0) hide @endif" id="cartI">{{$total_count}}</span></span>
            <span class="mui-tab-label">购物车</span>
         </a>
          <a class="mui-tab-item @if($menu_active == 'user_m' || $menu_active == 'usercenter')mui-active @endif" data-url="@if(session('user.id')>0)/user_m/usercenter2 @else /usercenter @endif">
            <span class="mui-icon iconfont icon-iconfuzhi"></span>
            <span class="mui-tab-label">我</span>
         </a>
          <div class="circle-div"><b class="circle-b"></b></div>
      </nav>
   <!--footnav end-->
    @yield('my_js')
    <script>
        //懒加载插件
        echo.init();
        /*$(window).load(function(){
            $(".layermbox").fadeOut(300)
        })*/
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
});//end ready function
	</script>
	@endif
	
</body>
</html>

