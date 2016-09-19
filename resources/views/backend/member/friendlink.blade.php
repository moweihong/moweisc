@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="friendlink">友情链接</a> <span class="divider">/</span></li>
            <li class="active">友情链接</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button id="addlink">添加链接</button>
    <button id='cleanLinkCache' style="margin-left:10px">清除缓存</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>名称：</th>
          <th>链接地址：</th>
          <th>是否显示</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
            	<td>{{ $row->url }}</td>
                <td>
                    @if($row->logo == 1)
                        是
                    @else
                        否
                    @endif
                </td>
            	<td>
                    <a href="{{url('/backend/member/editfriendlink',['id'=>$row->id]) }}" title="编辑"><i class="icon-pencil"></i></a>
                    <a href="javascript:void(0);" class="delete" onclick="delLink({{$row->id}})" title="删除"><i class="icon-remove"></i></a>
            	</td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $list->render() !!}
</div>  
<script type="text/javascript">
    $("#addlink").click(function(){
        location.href = 'addfriendlink';
    });
    function delLink(id){
        $.post("{{url('/backend/member/delfriendlink')}}",{'id':id,'_token':"{{csrf_token()}}"},function(data){
            if(data==null){
                alert('服务端错误');
            }
            if (data.status == 1){
                alert(data.msg);
                location.reload();
            }
            if (data.status == 0){
                alert(data.msg);
            }
        },'json');  
    }
	
	$("#cleanLinkCache").click(function(){
		location.href = 'cleanLinkCache';
    });
	
</script>
</div>
</div>
@endsection
