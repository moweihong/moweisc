<div class="sidebar-nav">
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>控制台</a>
    <ul id="dashboard-menu" class="nav nav-list collapse">
        <li id='nav-home'><a href="{{ $url_prefix }}/home">首页</a></li>
        <li id='nav-admin'><a href="{{ $url_prefix }}/admin">管理员列表</a></li>
        <!--<li ><a href="user.html">Sample Item</a></li>
        <li ><a href="media.html">Media</a></li>
        <li ><a href="calendar.html">Calendar</a></li>-->
        
    </ul>

    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>界面管理</a>
    <ul id="accounts-menu" class="nav nav-list collapse ">
        <li id='nav-dht'><a href="{{ $url_prefix }}/navigation">导航条管理</a></li>
        <li id='nav-lbt'><a href="{{ $url_prefix }}/rotation">轮播图管理</a></li>
       <!-- <li ><a href="reset-password.html">Reset Password</a></li>-->
    </ul>
    <a href="#oder-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>订单管理<i class="icon-chevron-up"></i></a>
    <ul id="oder-menu" class="nav nav-list collapse">  	
        <li id='nav-order'><a href="{{url('/backend/order')}}">订单列表</a></li>
        <li id='nav-getprize'><a href="{{url('/backend/order/getprize')}}">活动订单</a></li> 
        <li id='nav-ordernew'><a href="{{url('/backend/order/ordernew')}}">抵扣订单</a></li>
    </ul>
    <a href="#member-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>会员管理<i class="icon-chevron-up"></i></a>
    <ul id="member-menu" class="nav nav-list collapse">
        <li id='nav-user'><a href="{{url('/backend/member')}}">会员列表</a></li>
        <li id='nav-user'><a href="{{url('/backend/member/loginRecord')}}">会员登录信息列表</a></li>
        <li id='nav-unsafe'><a href="{{url('/backend/member/unsafeuse')}}">异常用户管理</a></li>
        <li id='nav-shaidan'><a href="{{url('/backend/member/showorder')}}">晒单列表</a></li>
        <li id='nav-friendlink' ><a href="{{url('/backend/member/friendlink')}}">友情链接</a></li>
    </ul>

    <a href="#error-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>天天免费<i class="icon-chevron-up"></i></a>
    <ul id="error-menu" class="nav nav-list collapse">
        <li id='nav-lottery'><a href="{{ $url_prefix }}/lottery">抽奖记录</a></li>
        <li id='nav-rotary'><a href="{{ $url_prefix }}/rotary">大转盘奖品配置</a></li>
    </ul>
    <a href="#article-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>文章管理<i class="icon-chevron-up"></i></a>
    <ul id="article-menu" class="nav nav-list collapse">
        <li id='nav-article'><a href="/backend/article">文章分类</a></li>
        <li id='nav-showarticles'><a href="/backend/article/showarticles">文章列表</a></li>
    </ul>
    
    <a href="#shop-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>商品管理 <i class="icon-chevron-up"></i></a>
    <ul id="shop-menu" class="nav nav-list collapse">
        <li id='nav-shop'><a href="{{ $url_prefix }}/shop">商品列表</a></li>
        <li id='nav-shop'><a href="{{ $url_prefix }}/shop/merchants">商户列表</a></li>
        <li id='nav-activityList'><a href="{{ $url_prefix }}/shop/activityList">活动商品列表</a></li>
        <li id='nav-category'><a href="{{ $url_prefix }}/shop/category">商品分类</a></li>
        <li id='nav-addBrand'><a href="{{ $url_prefix }}/shop/addBrand">添加品牌</a></li>
    </ul>
    
    <a href="#redbao-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>红包管理 <i class="icon-chevron-up"></i></a>
    <ul id="redbao-menu" class="nav nav-list collapse">
        <li id='nav-redbaoList'><a href="{{ $url_prefix }}/redbao/getList">红包列表</a></li>
        <li id='nav-redbaoGift'><a href="{{ $url_prefix }}/redbao/gift">红包赠送</a></li>
       
    </ul>
    <a href="#bank-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>佣金提现 <i class="icon-chevron-up"></i></a>
    <ul id="bank-menu" class="nav nav-list collapse">
        <li id='nav-bank'><a href="{{ $url_prefix }}/bank">佣金提现</a></li>
       
    </ul>
    <a href="#caiwu-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>财务对账 <i class="icon-chevron-up"></i></a>
    <ul id="caiwu-menu" class="nav nav-list collapse">
        <li id='nav-financeChage'><a href="{{ $url_prefix }}/finance/chage">充值列表</a></li>
        <li id='nav-financeBuy'><a href="{{ $url_prefix }}/finance/buy">消费列表</a></li>
        <li id='nav-financeLottery'><a href="{{ $url_prefix }}/finance/lottery">中奖列表</a></li>
        <li id='nav-financeLottery'><a href="{{ $url_prefix }}/finance/tongji">数据统计</a></li>
        <li id='nav-financeLottery'><a href="{{ $url_prefix }}/finance/redBadBuyShop">抵扣汇总</a></li>
        <li id='nav-financeLottery'><a href="{{ $url_prefix }}/finance/bigWheelIfno">幸运转盘红包明细</a></li>
       
    </ul>
    <a href="#huafei-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>话费充值 <i class="icon-chevron-up"></i></a>
    <ul id="huafei-menu" class="nav nav-list collapse">
        <li id='nav-financeChage'><a href="{{ $url_prefix }}/huafei/recharge">充值列表</a></li>
    </ul>
	
	<a href="#promote-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>推广渠道管理 <i class="icon-chevron-up"></i></a>
    <ul id="promote-menu" class="nav nav-list collapse">
        <li id='nav-promote'><a href="{{ $url_prefix }}/promote">充值卡查询</a></li>
        <li id='nav-promote'><a href="{{ $url_prefix }}/promote/bangka">新式绑卡法</a></li>
        <li id='nav-userIndex'><a href="{{ $url_prefix }}/promote/userIndex">推广人管理</a></li>
        <li id='nav-userIndex'><a href="{{ $url_prefix }}/promote/getOfflineInfo">线下体验卡数据查询</a></li>
    </ul>
	<a href="#message-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>系统消息<i class="icon-chevron-up"></i></a>
    <ul id="message-menu" class="nav nav-list collapse">
        <li id='nav-promote'><a href="{{ $url_prefix }}/sys/msg">消息列表</a></li>
        <li id='nav-userIndex'><a href="{{ $url_prefix }}/sym/msgedit">发送消息</a></li>
    </ul>
    
	<?PHP IF($admin['id']==1){  ?>
	<a href="#legal-menu" class="nav-header" data-toggle="collapse"><i class="icon-legal"></i>管理员操作</a>
    <ul id="legal-menu" class="nav nav-list collapse">
        <li ><a href="{{$url_prefix}}/manager/creatH5ProHtml?sid=&eid=">批量生成H5商品详情静态HTML</a></li>
    </ul>
	<?PHP } ?>
<!--
    <a href="help.html" class="nav-header" ><i class="icon-question-sign"></i>Help</a>
    <a href="faq.html" class="nav-header" ><i class="icon-comment"></i>Faq</a>-->
</div>

<script>
	$(function () {
		var _pathname = window.location.pathname;
		//alert(_pathname.substring(0,16));
		if(_pathname=='/backend/home' || _pathname=='/backend/admin'){   //控制台
			$('#dashboard-menu').addClass('in');
				if(_pathname.substr(-4)=='home') $('#nav-home').addClass('active');
				if(_pathname.substr(-5)=='admin') $('#nav-admin').addClass('active');
		}else if(_pathname=='/backend/navigation' || _pathname=='/backend/rotation'){ //界面管理
			$('#accounts-menu').addClass('in');
				if(_pathname.substr(-8)=='rotation') $('#nav-dht').addClass('active');
				if(_pathname.substr(-10)=='navigation') $('#nav-lbt').addClass('active');
		}else if(_pathname.substring(0,14)=='/backend/order'){ //订单管理         
			$('#oder-menu').addClass('in');
				if(_pathname.substr(-5)=='order') $('#nav-order').addClass('active');
				if(_pathname.substr(-8)=='getprize') $('#nav-getprize').addClass('active');
		}else if(_pathname.substring(0,15)=='/backend/member'){ //会员管理
			$('#member-menu').addClass('in');
				if(_pathname.substr(-6)=='member') $('#nav-user').addClass('active');
				if(_pathname.substr(-9)=='showorder') $('#nav-shaidan').addClass('active');
				if(_pathname.substr(-10)=='friendlink') $('#nav-friendlink').addClass('active');
		}else if(_pathname=='/backend/lottery'){ //天天免费
			$('#error-menu').addClass('in');
				if(_pathname.substr(-7)=='lottery') $('#nav-lottery').addClass('active');
		}else if(_pathname.substring(0,16)=='/backend/article'){ //文章管理
			$('#article-menu').addClass('in');
				if(_pathname.substr(-7)=='article') $('#nav-article').addClass('active');
				if(_pathname.substr(-12)=='showarticles') $('#nav-showarticles').addClass('active');
		}else if(_pathname.substring(0,13)=='/backend/shop'){ //商品管理
			$('#shop-menu').addClass('in');
				if(_pathname.substr(-4)=='shop') $('#nav-shop').addClass('active');
				if(_pathname.substr(-12)=='activityList') $('#nav-activityList').addClass('active');
				if(_pathname.substr(-8)=='category') $('#nav-category').addClass('active');
				if(_pathname.substr(-8)=='addBrand') $('#nav-addBrand').addClass('active');
		}else if(_pathname.substring(0,15)=='/backend/redbao'){ //红包管理
			$('#redbao-menu').addClass('in');
			if(_pathname.substr(-14)=='redbao/getList') $('#nav-redbaoList').addClass('active');
			if(_pathname.substr(-14)=='redbao/getGift') $('#nav-redbaoGift').addClass('active');
		}else if(_pathname=='/backend/bank'){ //佣金提现
			$('#bank-menu').addClass('in');
				if(_pathname.substr(-4)=='bank') $('#nav-bank').addClass('active');
		}else if(_pathname.substring(0,16)=='/backend/finance'){ //财务对账
			$('#caiwu-menu').addClass('in');
				if(_pathname.substr(-13)=='finance/chage') $('#nav-financeChage').addClass('active');
				if(_pathname.substr(-11)=='finance/buy') $('#nav-financeBuy').addClass('active');
				if(_pathname.substr(-15)=='finance/lottery') $('#nav-financeLottery').addClass('active');
		}else if(_pathname.substring(0,16)=='/backend/promote'){ //推广管理
			$('#promote-menu').addClass('in');
				if(_pathname.substr(-7)=='promote') $('#nav-promote').addClass('active');
				if(_pathname.substr(-17)=='promote/userIndex') $('#nav-userIndex').addClass('active');
		}else if(_pathname.substring(0,15)=='/backend/rotary'){
            $('#error-menu').addClass('in');
            if(_pathname.substr(-6)=='rotary') $('#nav-rotary').addClass('active');
        }
		
	});
</script>