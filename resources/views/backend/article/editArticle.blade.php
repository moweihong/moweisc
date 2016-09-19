@extends('backend.master')

@section('content')
<div class="header">

    <h1 class="page-title">文章管理</h1>
</div>

<ul class="breadcrumb">
    <li><a href="/backend/article">文章管理</a> <span class="divider">/</span></li>
    <li class="active" >编辑文章</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">        
        <div class="well">
            <form  name="articleForm" action="/backend/article/storearticle" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="text" value="{{$article['article_id']}}" name="article_id" style="display: none;">
                <input type="text" value="update" name="action" style="display: none;">
                <table cellspacing="1" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td>文章标题：</td>
                            <td>
                                <input type="text" value="{{$article['title']}}"  maxlength="255" name="title">
                                <span class="require-field">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="color:red " >{{$errors->first('title')}}</td>
                        </tr>
                       <tr>
                            <td></td>
                            <td style="color:red " >{{$errors->first('title')}}</td>
                        </tr>
                        <tr>
                            <td>标签：</td>
                            <td>
                                <input type="radio" value="p" name="tag"  <?php echo $article['tag'] =='p'? 'checked':'';?>>
                                    图片
                                <input type="radio"  value="j" name="tag" <?php echo $article['tag'] =='j'? 'checked':'';?>>
                                    推荐
                                <input type="radio"  value="h" name="tag" <?php echo $article['tag'] =='h'? 'checked':'';?>>
                                    热门
                                <input type="radio"  value="t" name="tag" <?php echo $article['tag'] =='t'? 'checked':'';?>>
                                    头条
                                <br>
                                <span class="require-field">标签：发布新闻可适当选择</span>
                            </td>                     
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>图片：</td>
                            <td>
                                <input id="photo" type="file" name="photo" >
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="image">
                                @if($article['img'])
                                <img style="margin: 0 0.3em; width: 200px; height: 200px;" src="{{$article['img']}}" />
                                @endif                                
                            </td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td style="color:red " >{{$errors->first('photo')}}</td>
                        </tr>
                        <tr>
                            <td>文章分类：</td>
                            <td>
                                {!! $list !!}
                            </td>
                        </tr>
                        <tr>
                            <td>作者：</td>
                            <td>
                                <input type="text" size="15" value="{{$article['author']}}" name="author">
                            </td>
                        </tr>
                      
                        <tr style="display: none;">
                            <td>是否显示:</td>
                            <td>
                                @if($article['is_open']==1)
                                    <input type="radio"  checked="true" value="1" name="is_open">
                                    是
                                    <input type="radio"  value="0" name="is_open">
                                    否
                                @else
                                    <input type="radio" value="1" name="is_open">
                                    是
                                    <input type="radio" checked="true" value="0" name="is_open">
                                    否
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td>
                                关键字：
                            </td>
                            <td>
                                <input type="text" value="{{$article['keywords']}}" size="50" maxlength="60" name="keywords">
                                <br>
                                <span id="notice_keywords" class="notice-span" style="display:block">关键字为选填项，其目的在于方便外部搜索引擎搜索</span>
                            </td>
                        </tr>
                        <tr>
                            <td>描述</td>
                            <td>
                                <textarea rows="4" cols="60" name="description">{{$article['description']}}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <div>
                <div style="color: red;">{{$errors->first('editorValue')}}</div>
                <script id="editor" type="text/plain" style="width:1024px;height:500px;"><?php echo $article['content'];?></script>
            </div>
                <div align="left" colspan="2">
                        <input class="button" type="submit" value=" 保存 ">
                        <!--<input class="button" type="reset" value=" 重置 ">-->
                </div>
            </form>
        </div>         
    </div>
</div>
<script type="text/javascript" charset="utf-8" src="{{asset('backend/extension/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('backend/extension/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('backend/extension/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript">
var ue = UE.getEditor('editor');
$(function() { 
    $('#photo').change(function() { 
        var file = this.files[0]; 
        var r = new FileReader(); 
        r.readAsDataURL(file); 
        $(r).load(function() { 
            $('#image').html('<img style="margin: 0 0.3em; width: 200px; height: 200px;" src="' + this.result + '" />'); 
        }) ;
    }) ;
})
</script>

@endsection