@extends('foreground.mobilehead')
@section('title', '帮助中心')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	 
	.finance{width:100%;padding-left:0.1rem;line-height:0.6rem;height:0.6rem;}
	
	.mui-input-row{color:#666;}
	.mui-input-group .mui-input-row{height:0.6rem}
	 
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
   
	   <div class="mui-input-group"  style='margin-top:0.06rem;'>
			<?php $i=1 ?>
			@foreach ($article as $val)
            <div class="mui-input-row" >
				<div class='finance'><a href='article_m/{{$val->article_id}}'>{{$i}}、{{mb_substr($val->title,0,300)}}</a></div>			
            </div>
			<?php $i++ ?>
			@endforeach
		</div>
		
 
		 
 
   </div>
@endsection

@section('my_js')
   <script>
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
   </script>
@endsection



 


