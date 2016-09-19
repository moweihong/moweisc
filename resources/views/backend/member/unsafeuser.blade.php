@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member/unsafeuse">异常用户管理</a> <span class="divider">/</span></li>
            <li class="active">会员列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
        @if($username != '')        
        <div>
            <span>邀请总人数：{{$inviteNums}}<input value="{{$username}}" placeholder="输入手机号码" maxlength="11" name="mark_unsafe" type="hidden"></span>
            @if($inviteNums > 0)
            <button id="mark_unsafe" style="color: red;">全部标记异常</button>
            @endif
        </div><br>
        @endif
<div class="well">
    <div>
        <span>手机号：<input value="{{$username}}" placeholder="输入手机号码" maxlength="11" name="username" type="text"></span>
        <button id="searchName" >搜索好友</button>
        
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
          <th>快乐币</th>
          <th>用户经验</th>
          <th>用户级别</th>
          <th>用户类型</th>
          <th >操作</th>
        </tr>
      </thead>
      <tbody>
        @if($list!=NULL)
      	@foreach ($list as $row)
            <tr @if($row['is_unusual'] == -1) style="background-color:red;" @endif>
            	<td>{{ $row['usr_id'] }}</td>
                <td>
                    {{$row['nickname']}}
                </td>
            	<td>{{ $row['mobile'] }}</td>
            	<td>{{ $row['money'] }}</td>
            	<td>{{ $row['commission'] }}</td>
            	<td>{{ $row['kl_bean'] }}</td>
            	<td>{{ $row['kl_money'] }}</td>
            	<td>{{ $row['exps'] }}</td>
            	<td>
                     @if($row['usr_level']==1)
                        <font color="red">渠道用户</font>
                     @else
                     普通用户
                     @endif
                </td>
                @if($row['is_unusual'] == -1)
                   <td>异常用户</td>
                @elseif($row['is_unusual'] > 0)
                <td style="color: red;">已封号</td>
                @elseif($row['is_unusual'] == 0)
                    <td>正常用户</td>
                @endif
            	<td>
            		@if($row['is_unusual']==0)
                        <input type="button" value="封号" data-id="{{$row['id']}}" data-type="1" class="fenghao">
                        <input type="button" value="标记异常" data-id="{{$row['id']}}" data-type="-1" class="fenghao" style="color: red;">
            		@elseif($row['is_unusual']==-1)
                        <input type="button" value="封号" data-id="{{$row['id']}}" data-type="1" class="fenghao">
                        <input type="button" value="取消异常" data-id="{{$row['id']}}" data-type="0" class="fenghao">
                    @else
                        <input type="button" value="解封" data-id="{{$row['id']}}" data-type="0" class="fenghao">
            		@endif
            	</td>
            </tr>
        @endforeach 
        @endif
      </tbody>
    </table>
</div>
       
</div>
</div>
<script>

$("#searchName").click(function(){
    var mobile = $("input[name='username']").val();
    if(!isphone(mobile)){
        layer.msg('请输入真确的手机号码');
        return false;
    }
    location.href = '/backend/member/unsafeuse/'+mobile;
})
$("#mark_unsafe").click(function(){
    var mobile = $("input[name='mark_unsafe']").val();
    if(!isphone(mobile)){
        return false;
    }
	$.ajax({
        'url': "{{url('/backend/member/unsafeuse/markunsafe')}}",
        'dataType': 'json',
        'type': 'POST',
        'data':{'mobile':mobile,'_token':"{{ csrf_token() }}"},
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
	 /*判断输入是否为合法的手机号码*/
     function isphone(inputString)
     {
          var partten = /^1[3,4,5,8]\d{9}$/;
          var fl=false;
          if(!partten.test(inputString)){
			  return false;
          }else{
			  return true;
		  }
     }
</script>
@endsection