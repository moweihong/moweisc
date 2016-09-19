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
    <button  id='addcategory' class="btn btn-primary"><i class="icon-plus" ></i>添加栏目</button>
    <!--<button class="btn"></button>
    <button class="btn"></button>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th width="100px">排序</th>
          <th>栏目id</th>
          <th>栏目名称</th>
          <th>是否返佣</th>
          <th style="width: 260px;">操作管理</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($categorylist as $row)
            <tr>
            	<td><input style="width: 18px" size="6" type="text" value="{{ $row->sort_order }}"></td>
            	<td>{{ $row->cateid }}</td>
            	<td>{{ $row->name }}</td>
            	@if($row->is_rebate==1)
            	<td>是</td>
            	@else
            	<td>否</td>
            	@endif
            	<td>
            		<a href="{{ $url_prefix }}/shop/addCategory/{{ $row->cateid }}"><i>添加子栏目</i></a>
              		<a href="javascript:void(0);" role="button" data-id="{{ $row->cateid }}" class="upcate" value="{{ $row->cateid }}"><i>修改</i></a>
            		<!--<a href="javascript:void(0);" role="button" data-id="{{ $row->cateid }}" class="delcate" value="{{ $row->cateid }}"><i>删除</i></a>-->
            	</td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $categorylist->render() !!}
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
 $("#addcategory").click(function(){
  		window.location.href="/backend/shop/addCategory/0";
  })
  
   //更新
  $(".upcate").click(function(){
  	 
  	  var id=parseInt($(this).data('id'));
  	
	  window.location.href="/backend/shop/upCategory/"+id;
  	  
  })
  
   //删除
  $(".delcate").click(function(){
  	  var id=parseInt($(this).data('id'));
  	 
	 $.post("/backend/shop/delCategory", { 'id': id },
       function(data){
       if(data>0)
       {
     		alert("删除成功");
     		
       }
    });
     $(this).parent().parent().remove();
  	  
  })
</script>
@endsection