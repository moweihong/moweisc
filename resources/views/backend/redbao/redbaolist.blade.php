@extends('backend.master')

@section('content')
<div class="header">
 <h1 class="page-title">红包管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop">红包</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="addredbao">
         <i class="icon-plus"></i>添加红包
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
          <th style="width: 5%">红包id</th>
          <th style="width: 10%">红包名称</th>
          <th style="width: 10%">红包个数</th>
          <th style="width: 10%;">剩余个数</th>
          <th style="width: 10%;">红包面值</th>
          <th style="width: 10%;">消费金额</th>
          <th style="width: 18%;">开始时间</th>
          <th style="width: 18%;">失效日期</th>
          <th>管理</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
       
            	<td>{{ $row->id }}</td>
            	<td>{{ $row->name }}</td>
            	<td>{{ $row->total_num }}</td>
            	<td>{{ $row->remain_num }}</td>
            	<td>{{ $row->money }}</td>
            	<td>{{ $row->xiaxian }}</td>
            	<td>{{ date('Y-m-d h:i:s',$row->start_time) }}</td>
            	<td>{{ date('Y-m-d h:i:s',$row->end_time) }}</td>
            	<td>	
              		<a href="javascript:void(0);" role="button" data-toggle="modal" class="upshop" data-id="{{ $row->id }}"><i >编辑</i></a>
            		<a href="javascript:void(0);" role="button" data-toggle="modal" class="delshop" data-id="{{ $row->id }}"><i >删除</i></a>
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
  $("#addredbao").click(function(){
  		window.location.href="/backend/redbao/addRedbao";
  })
  
  //更新
  $(".upshop").click(function(){
  	 
  	  var id=parseInt($(this).data('id'));
  	  
  	  window.location.href="/backend/redbao/upRedbao/"+id;
  	  
  })
  
  //删除
  $(".delshop").click(function(){
  	  var id=parseInt($(this).data('id'));
	$.post("/backend/redbao/delRedBao", { 'id': id },
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