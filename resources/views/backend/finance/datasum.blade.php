@extends('backend.master')

@section('content')

<script type="text/javascript" src="{{ $url_prefix }}js/laydate/laydate.js"></script>
<div class="header">
 <h1 class="page-title">数据统计</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="">统计</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <!--<button class="btn">Import</button>
    <button class="btn">Export</button>-->
  <div class="btn-group">
  </div>
</div>
<form method="post" action="/backend/finance/tongji" onsubmit="return check()">
<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="{{ session('lottery.starttime') }}" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('lottery.endtime') }}" /><input type="submit" id="submitbtn" value="搜索">
<input type="hidden" value="{{ csrf_token() }}" name="_token" />
</form>
<div class="well">
	
    <table class="table">
      <thead>
        <tr>
          <th style="width: 30%">统计项目</th>
          <th style="width: 15%">数值</th>
        </tr>
      </thead>
      <tbody>
      
      		<tr><td>注册总数</td><td>{{ $rgnum }}</td></tr>
      		<tr><td>新增注册总数</td><td>{{ $xzrgnum }}(没有选择时间就是总注册人数了)</td></tr>
      		<tr><td>新增注册消费人数</td><td>{{ $xzxfnum }}(没有选择时间就是总消费人数了)</td></tr>
      		<tr><td>消费用户数</td><td>{{ $xfunum }}</td></tr>
      		<tr><td>网站销售额</td><td>{{ $xftsum }}</td></tr>
      		
      		
			<tr><td>幸运转盘每日参与人数</td><td>{{ $peopleofbigwheeleveryday }}</td></tr>
			<tr><td>幸运转盘每日参与次数</td><td>{{ $numofbigwheeleveryday }}</td></tr>
			<tr><td>幸运转盘参与二次人数</td><td>{{ $pepoleofbigwheeleverydayagain }}</td></tr>
			<tr><td>幸运转盘老用户每日参与人数</td><td>{{ $oldpepoleofbigwheeleveryday }}</td></tr>
			<tr><td>幸运转盘老用户每日参与次数</td><td>{{ $oldpepolenumofbigwheeleveryday }}</td></tr>
			<tr><td>每日新增注册用户幸运转盘参与人数</td><td>{{ $newpepoleofbigwheeleveryday }}</td></tr>
			<tr><td>每日新增注册用户幸运转盘二次参与人数</td><td>{{ $newpepoleofbigwheeleverydayagain }}</td></tr>
      		
      		<tr><td>总消费块乐豆</td><td>{{ $klxfnum }}</td></tr>
      		<tr><td>活动发现参与用户数</td><td>{{ $atfnum }}</td></tr>
      		<tr><td>发送短信数</td><td>{{ $smsnum }}</td></tr>
      		<tr><td>用户充值数量(人数)</td><td>{{ $czunum }}</td></tr>
      		<tr><td>用户总充值金额</td><td>{{ $zcmsum }}</td></tr>
      		<tr><td>用户账户总余额</td><td>{{ $symsum }}</td></tr>
      		<tr><td>邀请总佣金</td><td>{{ $yjsum }}</td></tr>
      		<tr><td>每日新增佣金</td><td>{{ $everydayincyongjing }}</td></tr>
      		<tr><td>3日登陆用户数</td><td>{{ $srunum }}</td></tr>
      		<tr><td>7日登陆用户数</td><td>{{ $qrunum }}</td></tr>
			<tr><td>15日登陆用户数</td><td>{{ $swrunum }}</td></tr>
            <tr><td>30日登陆用户数</td><td>{{ $ssrunum }}</td></tr>
  
      </tbody>
     
    </table>

     <!--<h3>总共充值金额：{{ 11111111 }}元</h3>-->
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal">Delete</button>
    </div>
</div>              
</div>
</div>
<script src="{{ asset('backend/lib/finance/finance.js') }}" type="text/javascript"></script>
@endsection