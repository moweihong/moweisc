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
<form method="post" action="/backend/finance/redBadBuyShop" onsubmit="return check()">
<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="{{ session('dikou.starttime') }}" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('dikou.endtime') }}" /><input type="submit" id="submitbtn" value="搜索">
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
      
      		<tr><td>块乐豆抵扣</td><td>{{ $kldbuyshop }}</td></tr>
      		<tr><td>红包抵扣</td><td>{{ $redbaobuyshop }}</td></tr>
      		<div style="color: red;text-align: center;">
                                  注意:红包抵扣的数据太多，汇总就自己每页相加一下，块乐豆就不用了！
            </div>
      </tbody>
    
     
    </table>

     <!--<h3>总共充值金额：{{ 11111111 }}元</h3>-->
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
   @if(is_object($orderlist) && count($orderlist))
    {!! $orderlist->render() !!}
    @endif
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