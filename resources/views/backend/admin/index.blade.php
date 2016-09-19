@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">管理员列表</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="{{ $url_prefix }}/home">首页</a> <span class="divider">/</span></li>
            <li class="active">管理员列表</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <a class="btn btn-primary" href="{{ $url_prefix }}/admin/create"><i class="icon-plus"></i> 新增</a>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>用户昵称</th>
          <th>登陆邮箱</th>
          <th>创建时间</th>
          <th>最后登陆时间</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->id }}</td>
            	<td>{{ $row->name }}</td>
            	<td>{{ $row->email }}</td>
            	<td>{{ $row->created_at }}</td>
            	<td>{{ $row->updated_at }}</td>
            	<td>
            		<a href="{{ $url_prefix }}/admin/{{ $row->id }}/edit"><i class="icon-pencil"></i></a>
              		<a href="javascript::void(0);" role="button" class="delete" value="{{ $row->id }}"><i class="icon-remove"></i></a>
            	</td>
            </tr>
        @endforeach
      </tbody>
    </table>
    <input type="hidden" value="" id='delete_url'/>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $list->render() !!}
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">操作确认</h3>
    </div>
    <div class="modal-body">
        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>是否确定删除此用户？</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
        <button class="btn btn-danger" onclick="postDelete()">删除</button>
    </div>
</div>              
</div>
</div>
<script>
$(function(){
	$('.delete').click(function(){
		var id = $(this).attr('value');
		$('#delete_url').val("{{ $url_prefix }}/admin/" + id);
		$('#myModal').modal(); 
	})
})

function postDelete(){
	var url = $('#delete_url').val();
	$.ajax({
		url: url,
		dataType: 'json',
		type: 'DELETE',
		data: {'_token':"{{ csrf_token() }}"},
		success: function(data){
			$('#myModal').modal('hide'); 
			window.location.href = "{{ $url_prefix }}/admin";
		}
	})
}
</script>
@endsection