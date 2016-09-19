@extends('foreground.mobilehead')
@section('title', '邀友记录')
@section('rightTopAction', '邀请规则')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
   <style>
	.mui-bar-nav ~ .mui-content{padding-top:0}
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	html{background-color:#fff}
	.layermbtn span:first-child {color:#e63955}
    .layermbtn span{color:#666}
   </style>
@endsection

@section('content')
	<div class="redbanner">
		<p class="yyjl">好友总数（人）</p>
        <p class="yyjl2">{{ $friendtotal }}</p>
        <p class="yyjl3" style="display:none;">昨日新增好友（人）<br/>20<br/>（我的好友900，二级好友100）</p>
	</div>
   <div class="mui-content" >  
    <div class="_tab">
		<div id='tab1' class="active"><a>我的好友</a></div>
        <div id='tab2' ><a><!--二级好友!--></a></div>
	</div>
  
            <div class="yyjl_title">
               <div class="yyjl_t1 ttt">时间</div>
               <div class="yyjl_t2 ttt">用户名</div>
               <div class="yyjl_t3 ttt">认证手机</div>
            </div>
			<div class="yyjl_co" id='b1'>
			   <ul>
<!--				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">未购买</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买</div>
				  </li>-->

			   </ul>
            </div>
			
<!--			<div class="yyjl_co" id='b2' style='display:none'>
			   <ul>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买2</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">未购买2</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买2</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买2</div>
				  </li>
				  <li>
				    <div class="yyjl_c1 ccc">2016.06.12</div>
                    <div class="yyjl_c2 ccc">138****5256</div>
                    <div class="yyjl_c3 ccc">已购买2</div>
				  </li>
			   </ul>
            </div>-->
	 
		 
	 
   </div>
@endsection

@section('my_js')
   <script>
	 $('#tab1').click(function(){ 
		$('#tab2').removeClass('active');
		$('#tab1').addClass('active');
		$('#b1').show();
		$('#b2').hide();
	 });
	  $('#tab2').click(function(){ 
        return false;
		$('#tab1').removeClass('active');
		$('#tab2').addClass('active');
		$('#b2').show();
		$('#b1').hide();
	 });
    $(document).ready(function(){
        var dropload = $('#b1').dropload({
            scrollArea : window,
            loadDownFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '/user_m/invite_ajax',
                    dataType: 'json',
                    data:{},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for(var i=0;i<list.length;i++){
                            html += '<li>'+
                                        '<div class="yyjl_c1 ccc">'+list[i]['time']+'</div>'+
                                        '<div class="yyjl_c2 ccc">'+list[i]['username']+'</div>'+
                                        '<div class="yyjl_c3 ccc">'+list[i]['phone']+'</div>'+
                                   '</li>';
                        }
                        $('#b1 ul').append(html);	                
                        me.lock();
                        me.noData()
                        // 每次数据加载完，必须重置
                        me.resetload()
                    },
                    error: function(xhr, type){
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
            }
        });
     });
	 $('#rightTopAction').click(function(){
		 mytips('<BR>邀请好友并消费最高可获得100块乐豆<BR>加3.5%现金奖励<BR><BR>');
	 });
   </script>
   
@endsection


   


