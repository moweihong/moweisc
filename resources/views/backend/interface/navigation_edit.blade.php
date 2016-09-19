@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">编辑导航条</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="{{ $url_prefix }}/navigation">首页</a> <span class="divider">/</span></li>
            <li class="active">导航条管理</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="doSubmit"><i class="icon-save"></i> 保存</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="tab">
    	{!! csrf_field() !!}
        <label>导航名称</label>
        <input type="text" value="{{ $info->name }}" class="input-xlarge" name="name">
        <label>导航url</label>
        <input type="text" value="{{ $info->url }}" class="input-xlarge" name="url">
        <label>排序</label>
        <input type="text" name="sort" value="{{ $info->sort }}" class="input-xlarge">
        <label>导航类别</label>
        <select name="type" id="type" class="input-xlarge">
          <option value="1" @if($info->type == 1) selected="selected" @endif>头部导航</option>
          <option value="2" @if($info->type == 2) selected="selected" @endif>底部导航</option>
    	</select>
        <label>是否显示</label>
        <select name="status" id="status" class="input-xlarge">
          <option value="1" @if($info->status == 1) selected="selected" @endif>显示</option>
          <option value="0" @if($info->status == 0) selected="selected" @endif>隐藏</option>
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
		url : "{{ $url_prefix }}/navigation/{{ $info->id }}",
		type : 'PUT',
		dataType : 'json',
		data : data,
		success : function(res){
			alert(res.message);
			if(res.status == 0){
				window.location.href = "{{ $url_prefix }}/navigation/{{ $info->id }}/edit";
			}
		}
	})
})
</script>
@endsection