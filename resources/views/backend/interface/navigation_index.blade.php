@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">导航条管理</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="{{ $url_prefix }}/home">首页</a> <span class="divider">/</span></li>
            <li class="active">导航条管理</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <a class="btn btn-primary" href="{{ $url_prefix }}/navigation/create"><i class="icon-plus"></i> 添加</a>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>排序</th>
          <th>导航名称</th>
          <th>导航链接</th>
          <th>导航类型</th>
          <th>是否显示</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->sort }}</td>
            	<td>{{ $row->name }}</td>
            	<td>{{ $row->url }}</td>
            	<td>{{ $row->type }}</td>
            	<td>{{ $row->status }}</td>
            	<td>
            		<a href="{{ $url_prefix }}/navigation/{{ $row->id }}/edit"><i class="icon-pencil"></i></a>
              		<a href="javascript:void(0);" role="button" class="delete" value="{{ $row->id }}"><i class="icon-remove"></i></a>
            	</td>
            </tr>
        @endforeach
      </tbody>
    </table>
    <input type="hidden" value="" id='delete_url'/>
</div>
<div class="pagination">
    {!! $list->render() !!}
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">操作确认</h3>
    </div>
    <div class="modal-body">
        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>是否确定删除此导航？</p>
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
		$('#delete_url').val("{{ $url_prefix }}/navigation/" + id);
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
			window.location.href = "{{ $url_prefix }}/navigation";
		}
	})
}
</script>
@endsection