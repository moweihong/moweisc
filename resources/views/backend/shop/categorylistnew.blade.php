@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">商品管理</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.html">商品</a> <span class="divider">/</span></li>
            <li class="active">栏目管理</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary"><i class="icon-plus"></i>添加栏目</button>
    <button class="btn">Import</button>
    <button class="btn">Export</button>
  <div class="btn-group">
  </div>
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