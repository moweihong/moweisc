@extends('foreground.mobilehead')
@section('title', '我的佣金')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
   <style>
	.mui-bar-nav ~ .mui-content{padding-top:0;background-color:#fff}
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	html{background-color:#fff}
	.layermbtn span:first-child {color:#e63955}
    .layermbtn span{color:#666}
	.yyjl2{font-size:0.5rem}
	.redbanner{height:1.8rem}
   </style>
@endsection

@section('content')
	<div class="redbanner">
		<p class="yyjl">总佣金（元）</p>
		<p class="yyjl2">{{$commission}}</p>
		<p class="yyjl3">昨日佣金（元）<br/>{{$yesCommission}}<br/></p>
	</div>
   <div class="mui-content" >  
    <div class="_tab">
		<div id='tab1' class="active"><a>佣金明细</a></div>
		<div id='tab2'><a>提现记录</a></div>
	</div>
		<div id='b1'>
            <!--ajax异步加载-->
<!--            <div class="yjmx">
               <div class='yjmx_time'>2016.04.12 14:00:00</div>
			   <p class='yjmx_title'>获得佣金<span>100</span></p>
			   <p class='yjmx_title'>佣金类型<span>1级好友消费返利</span></p>
			   <div class="gmsp">
					<div class="gmsp1">购买商品</div>
					<div class="gmsp2">小米 红米Note 增强版 4G手机 双卡双待 颜色随机 【包邮】</div>
			   </div>
            </div>		 -->
		 </div>
		 
		  <div id='b2' style='display:none'>
		     <div class="yyjl_title">
               <div class="yjtx1 ttt">账户信息</div>  
               <div class="yjtx2 ttt">提现</div>
               <div class="yjtx3 ttt">审核</div>
               <div class="yjtx4 ttt">时间</div>
             </div>
			<div class="yyjl_co">
			   <ul>
<!--				  <li class="mui-clearfix">
				    <div class="txjl1 ccc">银行卡</div>
                    <div class="txjl2 ccc">+180</div>
                    <div class="txjl3 ccc">已通过</div>
                    <div class="txjl4 ccc">2016-04-11<BR>06:00:00</div>
				  </li>
				  <li class="mui-clearfix">
				    <div class="txjl1 ccc">银行卡</div>
                    <div class="txjl2 ccc">+180</div>
                    <div class="txjl3 ccc">已通过</div>
                    <div class="txjl4 ccc">2016-04-11<BR>06:00:00</div>
				  </li>
				  <li class="mui-clearfix">
				    <div class="txjl1 ccc">银行卡</div>
                    <div class="txjl2 ccc">+180</div>
                    <div class="txjl3 ccc">已通过</div>
                    <div class="txjl4 ccc">2016-04-11<BR>06:00:00</div>
				  </li>
				  <li class="mui-clearfix">
				    <div class="txjl1 ccc">银行卡</div>
                    <div class="txjl2 ccc">+180</div>
                    <div class="txjl3 ccc">已通过</div>
                    <div class="txjl4 ccc">2016-04-11<BR>06:00:00</div>
				  </li>-->
			   </ul>                
            </div>
		  </div>
   </div>
   <div class="foot_mer"></div>
   <footer class='yj_foot'>
		<div class='yj_foot_contain'>
            <div class="yj_foot1">充值到余额</div>
			<div class="yj_foot2" >申请提现</div>
		</div>
   </footer>
   <div style='clear:both;width:100%;background:#fff;height:0.8rem;position:fixed;bottom:0;'></div>
@endsection

@section('my_js')
   <script>
   var commission =  {{$commission}};
   var type = 0;//佣金 0;佣金明细 1;提现记录
    var page = 0;
    var loadOver = false; //避免用户点击过快或网络慢，出现加载出错
    var tab1page = 0;//佣金明细的下一页
    var tab2page = 0;//提现记录的下一页
    var tab1LoadEnd = false;//佣金明细是否加载
    var tab2LoadEnd = false;//提现记录是否加载
    var dropload = {};
    $(document).ready(function(){
        dropload = $('.mui-content').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            if(type == 0){
                page = tab1page;
            }else if(type == 1){
                page = tab2page;
            }
            loadOver = false;
            $.ajax({
                type: 'GET',
                url: '/user_m/mycommission',
                dataType: 'json',
                data:{page:page,type:type},
                success: function(data){
                    var list = data.data;
                    var html = '';
                    if(data.type == 0){
                        for(var i=0;i<list.length;i++){
                            html += '<div class="yjmx">'+
                                        "<div class='yjmx_time'>"+list[i]['time']+"</div>"+
                                        "<p class='yjmx_title'>获得佣金<span>"+list[i]['commission']+"</span></p>"+
                                        "<p class='yjmx_title'>佣金类型<span>"+list[i]['source']+"</span></p>"+
                                        '<div class="gmsp">'+
                                            '<div class="gmsp1">来自好友</div>'+
                                            "<div class='gmsp2'>"+list[i]['friend']+"</div>"+
                                        '</div>'+
                                    '</div>';
                        }
                    }else{
                        for(var i=0;i<list.length;i++){
                            html += '<li class="mui-clearfix">'+
                                        "<div class='txjl1 ccc'>"+list[i]['bank']+"</div>"+
                                        "<div class='txjl2 ccc'>+"+list[i]['money']+"</div>"+
                                        "<div class='txjl3 ccc'>"+list[i]['cashtype']+"</div>"+
                                        "<div class='txjl4 ccc'>"+list[i]['timeday']+"<BR>"+list[i]['timeh']+"</div>"+
                                    '</li>';
                        }
                    }                  
                    if(list.length==0){
                        //暂无数据
                        if(data.type == 0){
                            tab1LoadEnd = true;
                        }else if (data.type == 1){
                            tab2LoadEnd = true;
                        }
                        me.lock();
                        me.noData()
                    }else{
                        if(data.type == 0){
                            $('#b1').append(html);	                
                            tab1page = data.current_page+1;
                        }else if(data.type == 1){
                            $('ul').append(html);
                            tab2page = data.current_page+1;
                        }
                    }
                    loadOver = true;
                    // 每次数据加载完，必须重置
                    me.resetload()
                },
                error: function(xhr, type){
                   // alert('服务器错误!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });
    });
	 $('#tab1').click(function(){ 
        type = 0;
		$('#tab2').removeClass('active');
		$('#tab1').addClass('active');
		$('#b1').show();
		$('#b2').hide();
        if(!loadOver){
            return false;
        }
        if(!tab1LoadEnd){
            //数据没有加载完  解锁 继续加载
            dropload.unlock();
            dropload.noData(false);
        }else{
            dropload.lock();
            dropload.noData();
        }
        dropload.resetload();
	 });
	  $('#tab2').click(function(){
        type = 1;
		$('#tab1').removeClass('active');
		$('#tab2').addClass('active');
		$('#b2').show();
		$('#b1').hide();
        if(!loadOver){
            return false;
        }
        if(!tab2LoadEnd){
            //数据没有加载完  解锁 继续加载
            dropload.unlock();
            dropload.noData(false);
        }else{
            dropload.lock();
            dropload.noData();
        }
        dropload.resetload();
	 });
//	 $('#rightTopAction').click(function(){
//		 mytips('<BR>邀请一个好友，可奖励50块乐豆，<BR>可获得好友消费6+1提成哦<BR><BR>');
//	 });
    $(".yj_foot2").click(function(){
        if(commission>=100){
           location.href='/user_m/commitobank';
        } else{
            myalert('尊敬的用户您好！<BR>佣金满100，才可以提现哦！');
        }
    });
    $(".yj_foot1").click(function(){
        if(commission>0){
           location.href='/user_m/tomoney';
        } else{
            myalert('您还没有佣金不能充值！');
        }
    });
   </script>
   
@endsection



 


