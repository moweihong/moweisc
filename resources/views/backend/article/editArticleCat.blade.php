@extends('backend.master')

@section('content')
<div class="header">

    <h1 class="page-title">文章管理</h1>
</div>

<ul class="breadcrumb">
    <li><a href="/backend/article">文章管理</a> <span class="divider">/</span></li>
    <li class="active" >编辑分类</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">        
        <div class="well">
            <form  name="articleForm" action="/backend/article/storearticlecat" method="POST">
                {!! csrf_field() !!}
                <input type="text" value="{{$articleCat['cat_id']}}" maxlength="60" name="cat_id" style="display: none;">
                <input type="text" value="update" name="action" style="display: none;">
                <table cellspacing="1" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td>文章分类名称</td>
                            <td>
                                <input type="text" value="{{$articleCat['cat_name']}}" size="30" maxlength="60" name="cat_name">
                                <span class="require-field">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:red " >{{$errors->first('cat_name')}}</td>
                        </tr>  
                        <tr>
                            <td>上级分类</td>
                            <td>
                                <?php echo $articleCatlist;?>
                            </td>
                        </tr>
                        <tr>
                            <td>类型</td>
                            <td>
                                <select name="cat_type" id="cat_type">
                                    <option value="1" <?php echo $articleCat['cat_type']==1?'selected':'';?>>普通分类</option>
                                    <option value="2" <?php echo $articleCat['cat_type']==2?'selected':'';?>>帮助分类</option>
                                    <option value="3" <?php echo $articleCat['cat_type']==3?'selected':'';?>>首页动态公告</option>
                                    <option value="4" <?php echo $articleCat['cat_type']==4?'selected':'';?>>常见问题</option>
                                    <option value="5" <?php echo $articleCat['cat_type']==5?'selected':'';?>>新闻分类</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>排序:</td>
                            <td>
                                <input type="text" size="15" value="{{$articleCat['sort_order']}}" name="sort_order">
                            </td>
                        </tr>
                        <tr style="display: none;">
                            <td>是否显示在导航栏:</td>
                            <td>
                                @if($articleCat['show_in_nav']==1)
                                    <input type="radio" checked="true" value="1" name="show_in_nav">
                                    是
                                    <input type="radio" value="0" name="show_in_nav">
                                    否
                                @else
                                    <input type="radio" value="1" name="show_in_nav">
                                    是
                                    <input type="radio" checked="true" value="0" name="show_in_nav">
                                    否
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                关键字
                            </td>
                            <td>
                                <input type="text" value="{{$articleCat['keywords']}}" size="50" maxlength="60" name="keywords">
                                <br>
                                <span id="notice_keywords" class="notice-span" style="display:block">关键字为选填项，其目的在于方便外部搜索引擎搜索</span>
                            </td>
                        </tr>
                        <tr>
                            <td>描述</td>
                            <td>
                                <textarea rows="4" cols="60" name="cat_desc">{{$articleCat['cat_desc']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">
                                <br>
                                <input class="button" type="submit" value=" 确定 ">
                                <input class="button" type="reset" value=" 重置 ">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Delete Confirmation</h3>
            </div>
            <div class="modal-body">
                <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-danger" data-dismiss="modal">Delete</button>
            </div>
        </div>              
    </div>
</div>

@endsection