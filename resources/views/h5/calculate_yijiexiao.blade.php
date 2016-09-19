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
  		<ul><li><i><span>幸运号{{$winner[0]['fetchno']}}</span></i></li><li>=</li>
  			<li>
  			<div class="rule-gs">
  			<div class="rule-gs-in-ct">
	  			<div class="rule-gs-in">
	  				<p>{{$total_time}}</p>
	  				<p class="line"></p>
	  				<p>{{$total_person}}</p>
	  			</div>
	  			<p class="fetch_remain">(取余)</p>
  			</div>
  		</div></li>
  		<li>+</li>
  		<li>100000001</li>
  		</ul>
  	</div>
  	<div class="rule-bottom">
  		<p class="how">如何计算?</p>
  		<p>1、求和,{{$total_time}} ( 上面100条时间因子相加之和 ) ;</p>
  		<p>2、取余,{{$total_time}} ( 100条时间因子之和 ) 除以{{$total_person}} ( 本商品总需参与人数 ) ={{fmod($total_time, $total_person)}} ( 余数 ) ;</p>
  		<p>3、结果,{{fmod($total_time, $total_person)}} ( 余数 ) +100000001 = {{fmod($total_time, $total_person) + 100000001}};</p>
  	</div>
  </div>
  </div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 