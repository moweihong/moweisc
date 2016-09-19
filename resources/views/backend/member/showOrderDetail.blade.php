@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">会员管理</a> <span class="divider">/</span></li>
            <li class="active">晒单详情</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div>
        <div>
            <span>商品名称：</span><span class="require-field">{{$goods->title}} (第{{$showOrder->sd_periods}}期)</span>
        </div><br>
        <div>
            <span>商品描述：</span><span class="require-field"><?php echo $goods->content;?></span>
        </div><br>
        <div>
            <label>商品图片：</label>
            <div>
                @if($goods->picarr != NULL)
                    @foreach($goods->picarr as $val)
                    <img style="width: 300px; height: 400px" src="{{$val}}">
                    @endforeach
                @endif
            </div>
        </div><br>
        <div>
            <span>晒单标题：</span><span>{{$showOrder->sd_title}}</span>
        </div><br>
        <div>
            <span>晒单内容：</span><span>{{$showOrder->sd_content}}</span>
        </div><br>
        <div>
            <label>晒单图片集：</label>
            <div>
                 @if($showOrder->sd_photolist != NULL)
                    @foreach($showOrder->sd_photolist as $val)
                    <img style="width: 300px;height: 400px" src="{{$val}}">
                    @endforeach
                @endif                
            </div>
        </div><br>
        @if($showOrder->is_show ==0)
        <input type="button" onclick="cheakIsPass({{$showOrder->id}},1)" value="审核">
        <input type="button" onclick="cheakIsPass({{$showOrder->id}},2)" value="拒绝">
        @endif
    </div>
</div>        
</div>
</div>
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
                    location.href = "{{url('/backend/member/showorder')}}";
                } else {
                    layer.msg('操作失败！');
                }
        }
        });
}
</script>