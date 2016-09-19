@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">Users</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/article">文章管理</a> <span class="divider">/</span></li>
            <li class="active">文章列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button id="addArticle">添加文章</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>文章标题</th>
          <th>标签</th>
          <th>文章类型</th>
          <th style="display: none;">是否显示</th>
          <th>创建时间</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->article_id }}</td>
            	<td>{{ $row->title }}</td>       	
            	<td>
                    <?php 
                        switch ($row->tag) {
                            case 'p': echo '图片'; break;
                            case 'j': echo '推荐'; break;
                            case 'h': echo '热门'; break;
                            case 't': echo '头条'; break;
                            default:
                                echo '无';
                                break;
                        }
                    ?>                    
                </td>       	
            	<td>{{ $row->articleCat->cat_name }}</td>       	
                <td style="display: none;">
                    @if($row->is_open==0)
                       {{'否 '}}
                     @else
                        {{'是 '}}
                     @endif
                </td>
                <td>{{ $row->created_at }}</td>
            	<td>
                    <a href="{{url('/backend/article/editarticle',['id'=>$row->article_id]) }}" title="编辑文章"><i class="icon-pencil"></i></a>                    
                    <a href="javascript:void(0);" class="delete" onclick="delArticle({{$row->article_id}})"  title="删除文章"><i class="icon-remove"></i></a>
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
<script type="text/javascript">
    $("#addArticle").click(function(){
        location.href = 'addarticle';
    });
    function delArticle(id){
    layer.confirm('确定删除此文章?', {icon: 3, title:'提示'}, function(index){
      //do something
        layer.close(index);
        $.ajax({
                'url': "{{url('/backend/article/delarticle')}}",
                'dataType': 'json',
                'type': 'POST',
                'data':{'article_id':id,'_token':"{{ csrf_token() }}"},
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
    });
    }
</script>

@endsection