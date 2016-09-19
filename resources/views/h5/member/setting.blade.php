@extends('foreground.mobilehead')
@section('title', '设置')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	label{color:#686868;font-size:0.16rem;letter-spacing:0.03rem;}
    .mui-table-view{margin-bottom: 0.08rem}
   </style>
@endsection

@section('content')
   <div class="mui-content" >
        <ul class="mui-table-view">
            <li class="mui-table-view-cell">
               <a class="mui-navigate-right" href="/user_m/userinfo">个人信息</a>
            </li>
        </ul>
        <ul class="mui-table-view">
            <li class="mui-table-view-cell">
               <a class="mui-navigate-right" href="/user_m/security">账户安全</a>
            </li>
        </ul>
        <ul class="mui-table-view">
           <li class="mui-table-view-cell">
               <a class="mui-navigate-right" href="/user_m/help_m">帮助中心</a>
           </li>
           <li class="mui-table-view-cell">
                <a class="mui-navigate-right" href="/advise_m">意见反馈</a>
           </li>
        </ul>
        <ul class="mui-table-view">
           <li class="mui-table-view-cell">
               <a class="mui-navigate-right" href="tel:400-6626-985">客服电话</a>
           </li>
        </ul>
        <ul class="mui-table-view">
           <li class="mui-table-view-cell">
               <a class="mui-navigate-right" href="/aboutus_m">关于我们</a>
           </li>
           <li class="mui-table-view-cell">
               <a class="mui-navigate-right" href="/agreement_m">服务协议</a>
           </li>
        </ul>


		

         <div class="button-common"><button type="button" class="mui-btn mui-btn-danger mui-btn-block">退出登录</button></div>

   </div>
@endsection

@section('my_js')
   <script>
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
    $(".mui-btn").click(function(){
        layer.open({
           content: '确认退出登录？',
           btn: ['确认', '取消'],
           shadeClose: false,
           yes: function(){
               location.href='/destory_login_m';
           }, no: function(){
              layer.open({content: '您取消了！', time: 1});
           }
        });
    });

   </script>
@endsection



 


