@extends('backend.master')

@section('content')
<div class="header">
 <h1 class="page-title">商品管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop">商品</a> <span class="divider">/</span></li>
            <li class="active">活动商品列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="addActivityShop">
         <i class="icon-plus"></i>添加商品
    </button>
    <!--<button class="btn">Import</button>
    <button class="btn">Export</button>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
       
          <th style="width: 10%">商品id</th>
          <th style="width: 15%">商品名称</th>
          <th style="width: 15%">库存</th>
          <th style="width: 15%;">是否上架</th>
          <th>管理</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	
            	<td>{{ $row->id }}</td>
            	<td>{{ $row->title }}</td>
            	<td>{{ $row->stock }}</td>
            	@if($row->status==1)
            	<td>是</td>
            	@else
            	<td>否</td>
            	@endif
            	<td>
            		
              		<a href="javascript:void(0);" role="button" data-toggle="modal" class="upshop" data-id="{{ $row->id }}">
              			@if($row->status==1)
              			<input type="button" data-type='1' value="取消上架">
              			@else
              			<input type="button" data-type='0' value="设置上架">
              			@endif
              		</a>
            		
            	</td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $list->render() !!}
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
  $("#addActivityShop").click(function(){
  		window.location.href="/backend/shop/addActivityShop";
  })
  
  //更新
  $(".upshop").click(function(){
  	  var type=$(this).children().data('type');
  	  var id=parseInt($(this).data('id'));
  	  $.post("/backend/shop/setStatus", { 'id': id,'type':type },
       function(data){
       if(data>0)
       {
     		alert("设置成功");
     		window.location.reload();
     		
     		
       }
       else
       {
       		alert("设置失败");
       }
       
    });
  	  
  })
  
  //删除
  $(".delshop").click(function(){
  	  var id=parseInt($(this).data('id'));
  	   
	$.post("/backend/shop/delShop", { 'id': id },
       function(data){
       if(data>0)
       {
     		alert("删除成功");
     		window.location.reload()
     		
     		
       }
       else
       {
       		alert("删除失败");
       }
       
    });
  	  //alert(111);
  })
</script>
@endsection