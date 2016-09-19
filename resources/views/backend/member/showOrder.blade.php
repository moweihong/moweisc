@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">会员管理</a> <span class="divider">/</span></li>
            <li class="active">晒单列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th width="10%">用户id</th>
          <th width="10%">晒单缩略图</th>
          <th width="10%">晒单标题</th>
          <th width="20%">晒单内容</th>
          <th ></th>          
          <th width="10%">晒单时间</th>
          <th width="20%">排序id</th>
          <th >操作</th>
        </tr>
      </thead>
      <tbody>
      	
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->sd_uid }}</td>
                <td><img width="100" height="100" src="{{ $row->sd_thumbs }}"></td>
            	<td>{{ str_limit($row->sd_title,150) }}</td>
            	<td>{{ str_limit($row->sd_content,400)}}</td>
                <td><a href="{{url('/backend/member/showorderdetail/'.$row->id.'/'.$row->sd_gid)}}">详情...</a></td>
            	<td>{{ date('Y-m-d H:i:s',$row->sd_time)}}</td>
            	<td><input type="text" value="{{ $row->sortid }}" /><input type="button" data-id='{{$row->id}}' value="设置" class="setsort"></td>
                <td >
                    @if($row->is_show == 0)
                        <input type="button" onclick="cheakIsPass({{$row->id}},1)" value="通过审核">
                        <input type="button" data-id="{{$row->id}}" class='refused' value="拒绝通过">
                    @elseif($row->is_show == 1)
                        已通过审核
                    @else
                        审核未通过
                    @endif
            	</td>
            	
            </tr>
            
        @endforeach
      </tbody>
    </table>
</div>

<div id='kuangkuang' style="width:900px; height:220px;position: fixed; padding: 30px; box-shadow: 3px 3px 3px #666;left:50%;top:50%; margin-top:-140px; margin-left:-480px;background:white;display: none;">
	<form action="/backend/member/refused" method="post">
	          拒绝原因：<textarea name="refused_cause" style="margin-top:15px; width: 100%; height: 164px;" rows="4" cols="8"></textarea><br />
	          <input type="hidden" value="{{ csrf_token() }}" name="_token" />
	          <input type="hidden" value="" name="id" id='shaidanid' />
	          <span style="display:block;margin-left:50%">
	          <div style="margin-top: 10px;"><input type="submit" value="提交"><input style="margin-left:10px" type="button" id='quxiao' value="取消"></div>
	          </span>
	</form>
</div>

<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $list->render() !!}
</div>             
</div>
</div>
<script>
	$('.refused').click(function(){
		
	 	var id=$(this).data('id');
	 	
	 	var ht=$(this).offset().top-400;
	 	$("#shaidanid").val(id);
	 	//$("#kuangkuang").css('top',ht)
	 	$("#kuangkuang").show();
    })
    $('#quxiao').click(function(){
    	$("#kuangkuang").hide();
    })
    
    $('.setsort').click(function(){
    	var id=$(this).data('id');
    	var sortid=$(this).prev().val();
    	$.ajax({
        'url': "{{url('/backend/member/setShoworderSort')}}",
        'dataType': 'json',
        'type': 'POST',
        'data':{'id':id,'sortid':sortid,'_token':"{{ csrf_token() }}"},
        'success': function(data){
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
                } else {
                    layer.msg('操作失败！');
                }
        }
        });
    	
	})
</script>
@endsection
<script type="text/javascript">
function cheakIsPass(id,flag){
        $.ajax({
        'url': "{{url('/backend/member/checkshoworder')}}",
        'dataType': 'json',
        'type': 'POST',
        'data':{'id':id,'flag':flag,'_token':"{{ csrf_token() }}"},
        'success': function(data){
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
                } else {
                    layer.msg('操作失败！');
                }
        }
        });
}


</script>