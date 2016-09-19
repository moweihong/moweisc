@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">会员管理</a> <span class="divider">/</span></li>
            <li class="active">会员列表</li>
        </ul>
		
		<div style='margin:0 auto;width:96%;text-align:center;'>
			<b>注册来源：</b>
			<?php  
			if(!empty($reg)){ 
			foreach($reg['Logincntlist'] as $r){  ?>
				{{$r['equipment']}}:{{$r['logincnt']}}人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }} ?>
		</div>
		
    <div class="container-fluid">
        <div class="row-fluid">
<div class="well">
	<form action="/backend/member/muchPhoneSearch" method="post">
		{!! csrf_field() !!}
		 <textarea name="phones" style="margin: 0px; width: 1088px; height: 174px;">{{session('member.phones')}}</textarea>
       	 <p style="color: red;">多个手机号用英文的逗号","隔开</p>
       	 <input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="{{ session('member.starttime') }}" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('member.endtime') }}" />
       	 <input type="submit" value="提交">
       	 	
	</form>
    <div>
        <span>单个手机号：<input value="{{$username}}" placeholder="输入手机号码" name="username" type="text"></span>
        <button id="searchName" >搜索</button>
        <a href="/backend/member/exportUser?{{$url }}"><input type="button" value="导表"></a>
    </div>
    </br>
    <table class="table">
      <thead>
        <tr>
          <th>用户id</th>
          <th>用户名</th>
          <th>电话</th>
          <th>用户余额</th>
          <th>佣金</th>
          <th>块乐豆</th>
          <th>注册时间</th>
          <th>用户经验</th>
          <th>用户级别</th>
          <th >渠道审核</th>
          <th >消费金额</th>
          <th >操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr @if($row->is_unusual == -1) style="background-color:red;" @endif>
            	<td>{{ $row->usr_id }}</td>
                <td>
                <?php
                    if($username==''){
                        echo $row->nickname;
                    }else{
                        echo str_replace($username,'<font color="red">'.$username.'</font>',$row->nickname);
                    }
                ?>
                </td>
            	<td>{{ $row->mobile }}</td>
            	<td>{{ $row->money }}</td>
            	<td>{{ $row->commission }}</td>
            	<td>{{ $row->kl_bean }}</td>
            	<td>{{ date('Y-m-d H:i:s',$row->reg_time) }}</td>
            	<td>{{ $row->exps }}</td>
            	<td>
                     @if($row->usr_level==1)
                        <font color="red">渠道用户</font>
                     @else
                     普通用户
                     @endif
                </td>
                <td>
                    @if($row->usr_level == 2)
                    <a href="javascript:void(0);" onclick="checkPass({{$row->usr_id}})">审核</a>
<!--                    <a href="javascript:void(0);">拒绝</a>-->
                    @endif
            	</td>
            	<td>{{ $row->buymoney }}</td>
            	<td>
            		@if($row->is_unusual==0 || $row->is_unusual==-1)
            		<input type="button" value="封号" data-id="{{$row->id}}" data-type="1" class="fenghao">
            		@else
            		<input type="button" value="解封" data-id="{{$row->id}}" data-type="0" class="fenghao">
            		@endif
            	</td>
            	
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $list->render() !!}
</div>          
</div>
</div>
<script>

$("#searchName").click(function(){
    var name = $("input[name='username']").val();
    location.href = '/backend/member/'+name;
})

$(".fenghao").click(function(){
	var id=$(this).data('id');
	var type=$(this).data('type');
	$.ajax({
        'url': "{{url('/backend/member/setFengHao')}}",
        'dataType': 'json',
        'type': 'POST',
        'data':{'id':id,'type':type,'_token':"{{ csrf_token() }}"},
        'success': function(data){
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
                } else {
                    layer.msg(data.msg);
                }
        }
        });
})

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
$('.datetimepicker7').datetimepicker();
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
<script type="text/javascript">
function checkPass(id)
{
    layer.confirm('是否确认升级为渠道用户？', {icon: 3, title:'提示'}, function(index){
        $.ajax({
        'url': "{{url('/backend/member/uplevel')}}",
        'dataType': 'json',
        'type': 'POST',
        'data':{'id':id,'_token':"{{ csrf_token() }}"},
        'success': function(data){
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
                } else {
                    layer.msg(data.msg);
                }
        }
        });
    });
}


</script>
