@extends('backend.master')

@section('content')

<div class="header">
 <h1 class="page-title">推广渠道管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="#">推广人</a> <span class="divider">/</span></li>
            <li class="active">充值卡绑定</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    
    
  <div class="btn-group">
  </div>
</div>
<div class="well">
	<div>
		<input id='startnum' type="text"  placeholder="输入起始卡号"  class="btn">---
	    <input id='endnum' type="text"  placeholder="输入结束卡号"  class="btn">
	    <button id='searchNum' class="btn searchUser">查询</button>
	</div>
    <div id="showcard" style="background: olive; display: none;"  >
    <div style="margin-top: 20px; margin-left: 100px;">
    	<span><b>未绑定：</b><dd style="color: burlywood;margin-left: 50px;" id='nobind'>3000&nbsp;张</dd></span>
    	<span><b>已绑定：</b><dd style="color: burlywood;margin-left: 50px;" id='isbind'>3000&nbsp;张</dd></span>
    	<span><b>已冻结：</b><dd style="color: burlywood;margin-left: 50px;" id='freeze'>3000&nbsp;张</dd></span>
    	<span><b>已过期：</b><dd style="color: burlywood;margin-left: 50px;" id='overdue'>3000&nbsp;张</dd></span>
    	<span><b>已充值：</b><dd style="color: burlywood;margin-left: 50px;" id='charge'>3000&nbsp;张</dd></span>
    	
    	<button id='nobindsubmit' style="margin-left: 100px;" class="btn searchUser">解绑</button>
    </div>
    </div>

    <div id="actcard" style="margin-top: 20px;display: none;" >
    	<input id='usrphone' style="margin-left: 70px;" type="text"  placeholder="输入推广人手机"  class="btn"><br />
	            绑定卡数：<input id='upcardnum' type="text"  placeholder="输入结束卡数"  class="btn"><br />
	    <button id='submitBind' style="margin-left: 200px;" class="btn searchUser">确定</button>
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
  $("#showaddusr").click(function(){
  		$('#divone').show();
  })
  
  $("#hideaddusr").click(function(){
  		$('#divone').hide();
  })
  
   $(".showcardnum").click(function(){
   		var uid=$(this).data('uid');
   		$('#uploaduid').val(uid);
  		$('#divtwo').show();
  })
  
  $("#hideaddcardnum").click(function(){
  		$('#divtwo').hide();
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
  
   $('#searchNum').click(function(){
  		var startnum=$('#startnum').val();
  		var endnum=$('#endnum').val();
  		
 
  		$.post('/backend/promote/searchNum',{'startnum':startnum,'endnum':endnum,'_token':"{{csrf_token()}}"},function(data)
  		{
  			var data=eval('('+data+')');
  			if(data.code>0)
  			{
  				$('#showcard').show();
	  			$('#actcard').show();
		  		$('#nobind').html(data.data.nobind+'&nbsp;张');
		  		$('#isbind').html(data.data.isbind+'&nbsp;张');
		  		$('#freeze').html(data.data.freeze+'&nbsp;张');
		  		$('#overdue').html(data.data.overdue+'&nbsp;张');
		  		$('#charge').html(data.data.charge+'&nbsp;张');
  			}else
  			{
  				alert(data.result);
  			}
  			
  		})
  })
  
  
  $('#nobindsubmit').click(function(){
  		var startnum=$('#startnum').val();
  		var endnum=$('#endnum').val();
  		$.post('/backend/promote/noBindRecommendid',{'startnum':startnum,'endnum':endnum,'_token':"{{csrf_token()}}"},function(data)
  		{
  			var data=eval('('+data+')');
  			alert(data.result);	
  		})
  })
  
   $('#submitBind').click(function(){
  		var startnum=$('#startnum').val();
  		var endnum=$('#endnum').val();
  		var usrphone=$('#usrphone').val();
  		var upcarnum=$('#upcardnum').val();
  		$.post('/backend/promote/submitBind',{'usrphone':usrphone,'upcardnum':upcarnum,'startnum':startnum,'endnum':endnum,'_token':"{{csrf_token()}}"},function(data)
  		{
  			var data=eval('('+data+')');
  			if(data.code>0)
  			{
  				alert(data.result);
  				window.location.href="/backend/promote";
  			}else
  			{
  				alert(data.result);
  			}
  		})
  })
  
  

</script>
@endsection