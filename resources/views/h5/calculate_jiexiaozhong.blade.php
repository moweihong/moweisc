@extends('foreground.mobilehead')
@section('title', '计算详情')
@section('my_css')
<link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/calculate.css">
@endsection

@section('content')
  <div class="mui-content">
  <div class="title-item">
  	<span>购买时间</span><span>时间因子</span><span>会员昵称</span>
  </div>
  	<div class="content-item">
  		<table>
  			@foreach($info as $v)
  			<tr><td><p>{{date('Y-m-d H:i:s',($v->bid_time/1000))}}.{{substr($v['bid_time'], -3)}}</p></td><td class="num-red">{{substr(date('YmdHis',($v->bid_time/1000)),-6)}}{{substr($v['bid_time'], -3)}}</td><td>{{$v['nickname']}}</td></tr>
  			@endforeach
  		</table>
  	</div>
  <div class="rule-desc">
  	<div class="rule-top">
  		<ul><li><i><span>幸运号码</span></i></li><li>=</li>
  			<li>
  			<div class="rule-gs">
  			<p>按100排列取值之和</p>
  			<p class="line"></p>
  			<p>参与总需人次</p>
  		</div></li>
  		<li>+</li>
  		<li>10000001</li>
  		</ul>
  	</div>
  	<div class="rule-bottom">
  		<p class="how">如何计算?</p>
  		<p>1、取该商品最后购买时间前网站所有商品的最后100条购买时间记录;</p>
  		<p>2、按时、分、秒、毫秒排列取值之和，除以该商品总参与人次后取余数;</p>
  		<p>3、余数加上10000001 即为 "幸运块乐码" ;</p>
  		<p>4、余数是指整数除法中被除数未被除尽部分,如7÷3=2......1,1就是余数。</p>
  	</div>
  </div>
  </div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 