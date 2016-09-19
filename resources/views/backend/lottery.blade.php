@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">所有抽奖记录</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.html">首页</a> <span class="divider">/</span></li>
            <li class="active">天天免费</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
<form action="{{$url_prefix}}/lottery" method="get">
	<input type="text" name="mobile" value="{{$mobile}}" style="margin-right:10px;" placeholder="请输入手机号"/>
    <input class="btn btn-primary" type="submit" value="查询">
  <div class="btn-group">
  </div>
  </form>
</div>

<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>用户手机</th>
          <th>块乐码</th>
          <th>幸运码</th>
          <th>是否中奖</th>
          <th>抽奖时间</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $key => $row)
            <tr>
            	<td>{{$row->id}}</td>
            	<td>{{$row->user_phone}}</td>
            	<td>{{$row->happy_num}}</td>
            	<td>{{$row->lucky_num}}</td>
            	<td>{{$row->is_awards}}</td>
            	<td>{{date("Y-m-d H:i:s",$row->time)}}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
   @if(is_object($list) && count($list))
    {!! $list->render() !!}
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
<script>
$(function(){
	$('.delete').click(function(){
		var id = $(this).attr('value');
		$.ajax({
			'url': "{{ $url_prefix }}/admin/" + id,
			'dataType': 'json',
			'type': 'DELETE',
			'data': {'_token':"{{ csrf_token() }}"},
			'success': function(data){
				alert(data);
			}
		})
	})
})
</script>
@endsection