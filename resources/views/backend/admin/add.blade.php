@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">新增</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="{{ $url_prefix }}/home">首页</a> <span class="divider">/</span></li>
            <li><a href="{{ $url_prefix }}/admin">管理员列表</a> <span class="divider">/</span></li>
            <li class="active">新增</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="doSubmit"><i class="icon-save"></i> 提交</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="tab" id="form">
    	{!! csrf_field() !!}
        <label>用户昵称</label>
        <input type="text" value="" class="input-xlarge" name="name">
        <label>登陆邮箱</label>
        <input type="text" value="" class="input-xlarge" name="email">
        <label>登陆密码</label>
        <input type="password" value="" class="input-xlarge" name="password">
        <label>登陆密码确认</label>
        <input type="password" value="" class="input-xlarge" name="password_confirm">
    </select>
    </form>
      </div>
  </div>

</div>
                    
</div>
</div>
<script>
$('#doSubmit').click(function(){
	var data = $('form').serialize();
	$.ajax({
		url : "{{ $url_prefix }}/admin",
		type : 'POST',
		dataType : 'json',
		data : data,
		success : function(res){
			alert(res.message);
			if(res.status == 0){
				window.location.href = "{{ $url_prefix }}/admin";
			}
		}
	})
})
</script>
@endsection