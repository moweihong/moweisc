@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">轮播图管理</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="{{ $url_prefix }}/home">首页</a> <span class="divider">/</span></li>
            <li class="active">轮播图管理</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <a class="btn btn-primary" href="{{ $url_prefix }}/rotation/create"><i class="icon-plus"></i> 添加</a>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>图片标题</th>
          <th>图片预览</th>
          <th>图片链接</th>
          <th>类型</th>
          <th>顺序设置</th>
          <th>显示设置</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->id }}</td>
            	<td>{{ $row->title }}</td>
            	<td>{{ $row->img }}</td>
            	<td>{{ $row->link }}</td>
            	<!--<td><?php if($row->type==1){?> pc版 <?php }else{ ?>移动 端<?php } ?></td>-->
            	<td>@if($row->type==1)pc @else移动</td>@endif
                <td><input class="order_id" data-id="{{ $row->id }}" value="{{ $row->order_id }}" type="text" style="width: 30px"></td>
                <td>
                    @if($row->type==1)
                        <select style="width: 110px;" class="slide_show" data-id="{{ $row->id }}">
                            <option value="0" @if($row->show_type == 0) selected @endif>当前显示</option>
                            <option value="1" @if($row->show_type == 1) selected @endif>新窗口显示</option>
                        </select>
                    @endif
                </td>
            	<td>
            		<a href="{{ $url_prefix }}/rotation/editRo/{{ $row->id }}"><i class="icon-pencil"></i></a>
              		<a href="{{ $url_prefix }}/rotation/deleteRo/{{ $row->id }}" role="button" class="delete22" value="{{ $row->id }}"><i class="icon-remove"></i></a>
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
        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>是否确定删除此轮播图？</p>
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
		$('#delete_url').val("{{ $url_prefix }}/rotation/" + id);
		$('#myModal').modal(); 
	})
    $(".order_id").change(function(){
        var order_id = $(this).val();
        var id =  $(this).attr('data-id');
        $.post("{{url('/backend/rotation/setorder')}}",{'id':id,'order_id':order_id,'_token':"{{csrf_token()}}"},function(data){
            if (data.status == 1){
                layer.msg(data.msg);
            }else{
                layer.msg(data.msg);
            }
        },'json');          
    });
    $(".slide_show").change(function(){
        var select_id = $(this).val();
        var id =  $(this).attr('data-id');
        $.post("{{url('/backend/rotation/setshow')}}",{'id':id,'select_id':select_id,'_token':"{{csrf_token()}}"},function(data){
            if (data.status == 1){
                layer.msg(data.msg);
            }else{
                layer.msg(data.msg);
            }
        },'json');  
    });
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
			window.location.href = "{{ $url_prefix }}/rotation";
		}
	})
}
</script>
@endsection