@extends('foreground.mobilehead')
@section('title', '我的红包')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	html{background-color:#EFEFF4}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
    <div class="_tab">
		<div id='tab1' class="active"><a>可使用</a></div>
		<div id='tab2'><a>已使用/过期</a></div>
	</div>
  
            <div class="bouns" id='b1'>
               <div class='bounsL'>￥<span class='bouns_limit'>6</span></div>
               <div class='bounsR'>
				   <div class='bouns_title'>红包抵用券</div>
				   <div class='bouns_desc'>红包描述文案文案文案</div>
			   </div>
			   <div style='clear:both;padding-top:0.05rem'>
				<p style='float:left'>还有XX天过期</p>
				<p style='float:right'>有效期至：2016-05-02</p>
			   </div>
            </div>
			
			<div class="bouns" id='b2' style='display:none'>
               <div class='bounsL'>￥<span class='bouns_limit'>8</span></div>
               <div class='bounsR'>
				   <div class='bouns_title'>红包抵用券</div>
				   <div class='bouns_desc'>红包描述文案文案文案</div>
			   </div>
			   <div style='clear:both;padding-top:0.05rem'>
				<p style='float:left'>还有XX天过期</p>
				<p style='float:right'>有效期至：2016-05-02</p>
			   </div>
            </div>


	   <!--null start-->
	   <div class="cart-null">
		   <img src="{{ $h5_prefix }}images/cart-null.png" />
		   <a href="#" class="cart-nulllinks">去 逛 逛</a>
	   </div>
	   <!--null end-->
	   <!--猜你喜欢 start-->
	   <div class="faxbox sdshare-box">
		   <h2 class="faxboxh2 announce-boxtit">
			   <a href="#">
				   <span class="boxtit-h2">猜你喜欢</span>
			   </a>
		   </h2>

		   <div class="guess-pro mui-clearfix">
			   <div class="guess-probox">
				   <a href="#">
					   <div class="gue-proimg"><img src="{{ $h5_prefix }}images/product.jpg" /></div>
					   <span class="gue-protxt">Apple iPhone6s 16G 颜色随机</span>
					   <div class="gue-progress"><div class="gue-progress-div" style="width: 80%;"></div></div>
				   </a>
			   </div>
			   <div class="guess-probox">
				   <a href="#">
					   <div class="gue-proimg"><img src="{{ $h5_prefix }}images/product.jpg" /></div>
					   <span class="gue-protxt">Apple iPhone6s 16G 颜色随机</span>
					   <div class="gue-progress"><div class="gue-progress-div" style="width: 80%;"></div></div>
				   </a>
			   </div>
			   <div class="guess-probox">
				   <a href="#">
					   <div class="gue-proimg"><img src="{{ $h5_prefix }}images/product.jpg" /></div>
					   <span class="gue-protxt">Apple iPhone6s 16G 颜色随机</span>
					   <div class="gue-progress"><div class="gue-progress-div" style="width: 80%;"></div></div>
				   </a>
			   </div>
		   </div>

	   </div>
	   <!--猜你喜欢 start-->
		 
	 
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
		$('#tab1').removeClass('active');
		$('#tab2').addClass('active');
		$('#b2').show();
		$('#b1').hide();
	 });
   </script>
@endsection



 


