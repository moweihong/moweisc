@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">会员管理</a> <span class="divider">/</span></li>
            <li class="active">会员登录信息</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
	<form action="/backend/member/SerachLoginRecord" method="post">
		{!! csrf_field() !!}
		
       	登录时间：<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="{{ session('memberlogin.starttime') }}" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('memberlogin.endtime') }}" />
       	注册时间：<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='regstarttime'  value="{{ session('memberlogin.regstarttime') }}" />-
		<input class="datetimepicker7" id='end_time' type="text" name='regendtime' value="{{ session('memberlogin.regendtime') }}" />
       	<input type="text" name='num' value="{{ session('memberlogin.num') }}" placeholder="输入次数">
       	<br />
       	连续登录：<input class="datetimepicker7" placeholder="请输入起始时间" style="widht:60px" type="text" name='lianxutime'  value="{{ session('memberlogin.lianxutime') }}" />
       		   <input type="text" name='daynum' value="{{ session('memberlogin.daynum') }}" placeholder="输入天数">
       	<input type="submit" value="提交">
       	<a href="/backend/member/exportUserLogin?{{$url }}"><input type="button" value="导表"></a>	
	</form>
    <div>
        
       
    </div>
    </br>
    <table class="table">
      <thead>
        <tr>
          <th>用户id</th>
          <th>用户手机</th>
          <th>用户邮箱</th>
          <th>注册时间</th>
          <th>最后一次登录时间</th>
          <th>登录次数</th>
          <th >登录天数</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->usr_id }}</td>
            	<td>{{ $row->mobile }}</td>
            	<td>{{ $row->email }}</td>
            	<td style="color: red;">{{ date('Y-m-d H:i:s',$row->reg_time) }}</td>
            	<td style="color: burlywood;">{{ date('Y-m-d H:i:s',$row->login_time) }}</td>
            	<td>{{ $row->num }}</td>
            	<td>{{ $row->daynum }}</td>
            	
            </tr>
        @endforeach
      </tbody>
    </table>
    <div>会员数：{{ $num}}个</div>
    <div style="color: orangered;">当选择连续登录天数筛选条件时，登录次数会失效<div>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
   @if(is_callable(array($list,'render')))
    {!! $list->render() !!}
    @else
     {!! $page !!}
    @endif
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
