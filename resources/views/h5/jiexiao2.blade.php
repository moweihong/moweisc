@extends('foreground.mobilehead')
@section('title', '正在揭晓')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   	<style>
   		.jjjx-listbox {
	    margin-bottom: 0.86em;
	    padding: 0.14rem;
	    background: #fff;
	    position: relative;
	    overflow: hidden;
	}
	.jjjx-bq {
    background: #999999;    
}
.jjjx-bimg {
    width: 28%;
    float: left;
}
.jjjx-btxt a{
font-size: .14rem;	
}
.jjjx-desc{
	display: inline-block;
	font-family: "微软雅黑";
 	width: 73%;
	line-height: 12px;
}
.jjjx-detail img{
	width: 50px;
}
.jjjx-right{
	width: 70%;
    float: left;
    margin-left: 2%;
}
h2 a{
    font-weight: normal;
    font-size: .14rem;
    font-family: "pingfang";
    text-overflow: ellipsis;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    display: -webkit-box;
}
html{
	font-size: 100px;
}
.jjjx-desc p{
	word-break: break-all;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    font-size: .12rem;
}
.jjjx-img {
	position: relative;
	display: inline-block;
    overflow: hidden;	
}
.jjjx-detail b{
	background: #e63955;
    width: 52px;
    height: 20px;
    line-height: 20px;
    top: 0px;
    left: -15px;
    font-size: 0.12rem;
    transform: rotate(-45deg) scale(0.6);
}
.jjjx-img p{
	text-align: center;
	color: #0072ff;
	font-size: .11rem;
}
   	</style>
@endsection

@section('content')
   <div class="mui-content">
   <div class="jjjx-listbox mui-clearfix">
         <b class="jjjx-bq">即将揭晓</b>
         <div class="jjjx-bimg"><a href="/product_m/455"><img src="/backend/upload/shopimg/751462434131.jpg" width="108" height="124"></a></div>
         <div class="jjjx-right">
            <h2><a href="#">小米 红米Note 增强版4G手机  双卡双待</a></h2>
            <div class="jjjx-detail">
            	 <div class="jjjx-img">
	            	 <b class="jjjx-bq">获得者</b>
	            	<img src="{{ $h5_prefix }}/images/touxiang.png" />
	            	<p>0072ff</p>
            	</div>
            	<div class="jjjx-desc">
            			<p>手机号：17811223344</p>
            			<p>本期参与：10人次 </p>
            			<p>幸运众筹码：0072159252 </p>
            			<p>用户地址：中国广东深圳  </p>
            	</div>
            </div>    
         </div>
        
      </div>
   </div>

@endsection

@section('my_js')
   <script>

   </script>
@endsection
