@extends('backend.master')

@section('content')

<div class="header">
 <h1 class="page-title">推广渠道管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="#">充值卡</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    

<div class="well">
	<form method="post" action="/backend/promote/search">
		<textarea name="cardnum" style="margin: 0px; width: 1145px; height: 224px;"></textarea>
		<br />
		 <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="submit" value="查询"><span style="color: red;margin-left:20px ;">多卡号以英文的逗号','隔开</span>
	</form>
    <table class="table">
      <thead>
        <tr>
          <th style="width: 5%">全选</th>
          <th style="width: 10%">序号</th>
          <th style="width: 10%">卡号</th>
<!--          <th style="width: 15%">类型</th>-->
          <th style="width: 10%">面值</th>
          <th style="width: 10%">消费</th>
       
          <th style="width: 10%;">推广人</th>
          <th style="width: 10%;">消费账号</th>
          <th style="width: 15%;">充值时间</th>
          <th style="width: 10%;">状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      	<form id="jqsubmit" method="post" action="/backend/promote/plUpdata" >
      	@foreach ($promotelist as $row)
            <tr>
            	<td><input name="status[]" style="width: 18px" size="6" type="checkbox" value="{{ $row->id }}"></td>
            	<td>{!! $row->id !!}</td>
            	<td>{!! $row->card_num !!}</td>
            	<td>{!! $row->money !!}</td>
            	<td>
            		@if($row->status==0)
            		 未充值
            		@elseif($row->status==1)
            		已充值
            		@elseif($row->status==2)
            		过期
            		@endif
            	</td>
            	
            	<td>
            		@if($row->recommend_id)
            		{{ $row->user->mobile }}
            		@endif
            	</td>
            	
            	<td>
            		{{ $row->usr_id }}
            	</td>
            	<td>
            		@if(!empty($row->use_time))
            		{{ date('Y-m-d H:i:s',$row->use_time) }}
            		@endif
            	</td>
            	<td>
            		@if($row->status==3)
            		 冻结
            		@else
            		正常
            		@endif
            	</td>
            	<td>
					@if($row->status==3)
            		 <a href="javascript:void(0);" role="button" data-toggle="modal" class="delshop" data-type="0" data-id="{{ $row->id }}"><i >解冻</i></a>
            		@else
            		<a href="javascript:void(0);" role="button" data-toggle="modal" class="delshop" data-type="1" data-id="{{ $row->id }}"><i >冻结</i></a>
            		@endif
            		
            	</td>
            </tr>
        @endforeach
        <tr>
        <td colspan="3">
	        <input id='isdongjie' type="hidden" name="atype" value="0" >
	        <input onclick="quanxuan()" id='allselect' value="0" type="radio"><span>全选</span>
        </td>
        <td colspan="3">
        	<input id="pldongjie" value="批量冻结" type="button">
        </td>
        <td colspan="3">
        	<input id='pljiedong' value="批量解冻" type="button">
        </td>
        </tr>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        </form>
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $promotelist->render() !!}
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
  
  
  function selectAll(){
	var a = document.getElementsByTagName("input");
	if(a[0].checked){
		for(var i = 0;i<a.length;i++){
		if(a[i].type == "checkbox") a[i].checked = false;
		}
	}
	else{
		for(var i = 0;i<a.length;i++){
		if(a[i].type == "checkbox") a[i].checked = true;
		}
	}
  }
  
  function uncheckAll() {   
  var code_Values = document.getElementsByTagName("input");  
  for (i = 0; i < code_Values.length; i++) {  
  if (code_Values[i].type == "checkbox") {  
    code_Values[i].checked = false;  
  }  
  }  
}  
  
  function quanxuan(){
  	
  		var radioCheck= $('#allselect').val(); 
  
        if("1"==radioCheck){  
            $('#allselect').attr("checked",false);  
            $('#allselect').val("0"); 
            uncheckAll() 
              
        }else{   
            $('#allselect').val("1");  
            selectAll();
              
        }  
  		
  		
  		
  }
  
  $('#pldongjie').click(function(){
  	$('#isdongjie').val(1);
  	$('#jqsubmit').submit();
  })
  
   $('#pljiedong').click(function(){
  	$('#jqsubmit').submit();
  })
  
  //更新
  $(".upshop").click(function(){
  	 
  	  var id=parseInt($(this).data('id'));
  	  
  	  window.location.href="/backend/shop/upShop/"+id;
  	  
  })
  
   $(".lookshop").click(function(){
  	 
  	  var id=parseInt($(this).data('id'));
  	  
  	  window.location.href="/backend/shop/lookShop/"+id;
  	  
  })
  
  //单个操作
  $(".delshop").click(function(){
  	  var id=parseInt($(this).data('id'));
  	  var type=parseInt($(this).data('type'));
	$.get("/backend/promote/upIsJiedong", { 'id': id ,'type':type},
       function(data){
       var data=eval('('+data+')');
       if(data.status>0)
       {
     		alert(data.msg);
     		location.reload();
     		
     		
       }
       else
       {
       		alert(data.msg);
       		location.reload();
       }
       
       
    });'json'
  	  //alert(111);
  })
  
  $('.searchShop').click(function(){
  		var keyword=$(this).prev().val();
  		location.href='/backend/shop/searchShop/'+keyword;
  		//$.get('/backend/searchShop/'+keyword,{},function(){})
  })
</script>
@endsection