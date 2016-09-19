<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="Generator" content="">
    <meta name="Author" content="">
    <meta name="keywords" content="特速一块购">
    <meta name="description" content="特速一元购。">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE = edge">
    <title>@yield('title') 特速一块购</title>
    {{--全局css--}}
   {{-- <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">--}}
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/comm.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/footer_header.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/goods.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/index.css"/>
	<link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/ttmf_m_for_menu.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/ttmf_m.css">
    <script type="text/javascript" src="{{ $h5_prefix }}js/jquery191.min.js"></script>
    <script type="text/javascript" src="{{ $url_prefix }}js/iscroll.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        //csrf_token验证
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
 
    </script>
	<script type="text/javascript" src="{{ $url_prefix }}js/index.js"></script>
	<script type="text/javascript" src="{{ $url_prefix }}js/user_history.js"></script>
	{{--全局js--}}
    {{--<script src="/js/jquery-1.11.2.min.js"></script>--}}
    {{--<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>--}}
    {{--公共脚本--}}
    <script type="text/javascript" src="{{ $url_prefix }}js/common.js"></script>
    <script type="text/javascript" src="{{ $url_prefix }}js/layer/layer.js"></script>
    {{--私有css--}}
    @yield('my_usercss')
    @yield('my_css')
    <style>
        body{-webkit-overflow-scrolling: touch; }
    </style>
</head>
<body>
	@yield('myt_js')
	{!! csrf_field() !!}
	
    {{--模板内容--}}
    <div class="content">
        @yield('content')
    </div>
    @yield('my_js')
      <nav class="mui-bar mui-bar-tab" id="menu">
         <a class="mui-tab-item"  data-url="/index_m">
            <span class="mui-icon iconfont icon-home"></span>
            <span class="mui-tab-label">首页</span>
         </a>
         <a class="mui-tab-item"  data-url="/category_m">
             <span class="mui-icon iconfont icon-chanpinfenlei01"></span>
            <span class="mui-tab-label">全部商品</span>
         </a>
         <a class="mui-tab-item mui-active"  data-url="/find_m">
            <span class="mui-icon iconfont icon-youxi"><!--<span class="mui-badge">9</span>--></span>
            <span class="mui-tab-label">发现</span>
         </a>
         <a class="mui-tab-item" data-url="/mycart_m">
            <span class="mui-icon iconfont icon-gouwuche"><span class="mui-badge" id="cartI">{{$total_count}}</span></span>
            <span class="mui-tab-label">购物车</span>
         </a>
          <a class="mui-tab-item"  data-url="@if(session('user.id')>0)/user_m/usercenter2 @else /usercenter @endif">
            <span class="mui-icon iconfont icon-iconfuzhi"></span>
            <span class="mui-tab-label">我</span>
         </a>
          <div class="circle-div"><b class="circle-b"></b></div>
      </nav>
</body>

<script>
$("a").click(function(){
	window.location.href=$(this).attr("data-url");
});

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
                    if(confirm('您的账号已下线或在别的地方登陆,是否重新登录?')){
						window.location.href = '/login_m';
                    }else{
                    	window.location.href = '/index_m';
                    }
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
		link: "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}&is_freeday=1", // 分享链接
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
		link: "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}&is_freeday=1", // 分享链接
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
	
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?cc4d5f60a15bfff8ca10bf514eb87d02";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</html>
