@extends('backend.master')

@section('content')
<div class="header">
 <h1 class="page-title">红包赠送</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/redbao/getList">红包管理</a> <span class="divider">/</span></li>
            <li class="active">红包赠送</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
   <div class="btn-toolbar">
   <!-- <button class="btn btn-primary"><i class="icon-save"></i> Save</button>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="tab" method="post" action="">
	
        <input type="radio" name='type' checked id='type-regtime' class="input-xlarge"><b>按注册时间赠送</b>&nbsp;&nbsp;
        <input type="radio" name='type' id='type-tel' class="input-xlarge"><b>按手机号码赠送</b>
		<br/><br/>
		<div id='regtime'>
			<label>请选择起始时间:</label>
			<input id="datetimepicker7" type="text" name='start_time' class="input-xlarge" />---<input id="datetimepicker8" type="text" name='end_time' class="input-xlarge">
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		</div>
		<div id='telarea' style='display:none'>
			<label>请输入手机号码，一行一个:</label>
			<textarea name="tellist" cols="3" rows="3" style="margin: 0px 0px 8.99306px; width: 562px; height: 166px;"></textarea>
		</div>
		
        <label>选择红包类型：</label>
        <select id="category" name="bounstype">
			<?php if(!empty($bounsList)){
				  foreach($bounsList as $b){  ?>
			<option value="{{$b->id}}">{{$b->name}}</option>   
			<?php }} ?>
        </select>
 
    	<br/><br/>
    	<input type="submit" value="提交">
    </form>
      </div>
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
var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:'11:00'
		});
	}else
		this.setOptions({
			minTime:'8:00'
		});
};
$('#datetimepicker7').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$('#datetimepicker8').datetimepicker({
	onGenerate:function( ct ){
		$(this).find('.xdsoft_date')
			.toggleClass('xdsoft_disabled');
	},
	minDate:'-1970/01/2',
	maxDate:'+1970/01/2',
	timepicker:false
});

$('#type-tel').click(function(){
	$('#regtime').hide();
	$('#telarea').show();
});
$('#type-regtime').click(function(){
	$('#telarea').hide();
	$('#regtime').show();
});

</script>
@endsection
