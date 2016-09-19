@extends('backend.master')

@section('content')
<div class="header">
 <h1 class="page-title">红包管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/redbao/getList">红包列表</a> <span class="divider">/</span></li>
            <li class="active">编辑红包</li>
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
    <form id="tab" method="post" action="/backend/redbao/delUpdateRedBao">
    	<label>红包名称：</label>
        <input type="text" name='name' class="input-xlarge" value="{{ $redbao->name}}">
        <label>红包面值：</label>
        <!--<select id="category" name="money">           
        <option value="5">5元</option>
        <option value="10">10元</option>
        <option value="20">20元</option>
        <option value="50">50元</option>
        <option value="100">100元</option>
        <option value="200">200元</option>
        <option value="500">500元</option>      		
        </select>-->
        <input type="text" name='money' class="input-xlarge" value="{{ $redbao->money}}" />
        <input type="hidden" name='id' class="input-xlarge" value="{{ $redbao->id}}" />
        <label>发行量</label>
        <input type="text" name='total_num' class="input-xlarge" value="{{ $redbao->total_num}}" />
        <label>最低消费金额</label>
        <input type="text" name='xiaxian' class="input-xlarge" value="{{ $redbao->xiaxian}}" />
        <label>使用有效期</label>
        <input id="datetimepicker7" type="text" name='start_time' class="input-xlarge" value="{{date('Y/m/d h:i:s',$redbao->start_time) }}" />---
        <input id="datetimepicker8" type="text" name='end_time' class="input-xlarge" value="{{date('Y/m/d h:i:s',$redbao->end_time) }}">
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    	<label></label>
    	
    	<input type="submit" value="确认修改">
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

</script>
@endsection
