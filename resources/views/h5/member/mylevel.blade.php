@extends('foreground.mobilehead')
@section('title', '我的等级')
@section('my_css')
 <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css?v={{config('global.version')}}">
   <style>
   html{
   	font-size: 100px;
   }
   p{
	font-size: .11rem;
	color: #999999;
}
   .level_top{
   	    padding-top: 15px;
   }
.level_top div{
	display: inline-block;	
	vertical-align: middle;
}
.my_photo{
    width: 29.3%;
    height: 100%;
    text-align: center;
}
.my_photo img{
	width: 80%;
}
h1{
	font-size: .14rem;
	color: #999999;
	line-height: 40px;
	display: inline-block;
    vertical-align: middle;
}
.level_detail{
	    width: 68%;
}
.level_detail p:first-child,h2,th{
	font-size: .15rem;
    color: #333333;
    font-family: pingfang;
    font-weight: initial;
}
.level_detail em{
	 color: #1078FF;
	 font-family: pingfang;
	 font-style: normal;
}
.process_bar{
    width: 90%;
    height: 6px;
    background: #F29C9F;
    display: inline-block;
    border-radius: 5px;
    position: relative;
}
.process_occup{
    width: 50%;
    height: 5px;
    background: #E63955;
    display: inline-block;
    max-width: 100%;
    position: absolute;
    border-radius: 5px;
    top: 0.5px;
}
.level_top,.level_specify{
	   	background: #FFFFFF;
	   	margin-bottom: 5px;
}
.level_specify{
	   	padding: 5%;
}
.level_detail p{
	line-height: 12px;
}
.specify_item{
	margin-bottom: 13px;
	padding-top:10px;
	border-top: 2px solid #F4F4F4;
}
.circle-red{
    border-radius: 50%;
    width: 8px;
    height: 8px;
    background: #E63955;
    display: inline-block;
    border-radius: 50%;
    margin-right: 10px;
}
.level_desc{
	    border-top: 2px solid #F4F4F4;
}
table{
	 width: 100%;
}
td{
	width: 30%;
	text-align: center;
	font-size: .15rem;
	color: #0072ff;
}
td img{
	width: 25px;
	vertical-align: middle;
}
.td-center{
	width: 40%;
}
tr{
	line-height: 30px;
}

   </style>
@endsection

@section('content')
   <div class="mui-content" >  
	<div class="level_top">
		<div class="my_photo"><img src="{{ $member->user_photo }}" /></div>
		<div class="level_detail">
			<p>{{$member->nickname}}</p>
			<p>等级:<em>{{$level['name']}}</em></p>
			<p>经验值：<span>{{intval($total)}}</span>/{{$level['interval']}}</p>
			<p><i class="process_bar" ><i class="process_occup" style="width:{{$level['rate']}}"></i></i></p>
		</div>
	</div>
	<div class="level_specify">
	<div style="margin-top:-15px;"><span class="circle-red"></span><h1>等级说明</h1></div>
	<div class="specify_item">
		<h2>如何获得经验？</h2>
		<p>使用特速一块购每支付1元可获得100经验值，经验值用来提示您的等级。</p>
	</div>

	<div class="specify_item">
		<h2>等级有什么用？</h2>
		<p>等级不仅是您在夺宝地位的体现，也是后续获得等级特权的条件。赶紧参与夺宝吧！</p>
	</div>
	</div>
	<div class="level_specify">
	<div><span class="circle-red"></span><h1>等级一览</h1></div>
	<div class="level_desc">
		<table>
			<thead>
				<tr><th>等级名称</th><th>所需经验值</th><th>等级图标</th></tr>
			</thead>
			<tbody>
				<tr><td>土豪</td><td class="td-center">0-2000</td><td><img src="{{ $h5_prefix }}/images/touxiang.png"/></td></tr>
				<tr><td>铁豪</td><td class="td-center">2000-9999</td><td><img src="{{ $h5_prefix }}/images/touxiang.png"/></td></tr>
				<tr><td>铜豪</td><td class="td-center">10000-29999</td><td><img src="{{ $h5_prefix }}/images/touxiang.png"/></td></tr>
				<tr><td>银豪</td><td class="td-center">30000-59999</td><td><img src="{{ $h5_prefix }}/images/touxiang.png"/></td></tr>
				<tr><td>金豪</td><td class="td-center">60000-99999</td><td><img src="{{ $h5_prefix }}/images/touxiang.png"/></td></tr>
				<tr><td>砖豪</td><td class="td-center">100000以上</td><td><img src="{{ $h5_prefix }}/images/touxiang.png"/></td></tr>
			</tbody>
		</table>
	</div>
	</div>
   </div>
@endsection

@section('my_js')
   <script>
	
   </script>
@endsection



 


