@extends('backend.master')

@section('content')
<div class="header">

    <h1 class="page-title">会员管理</h1>
</div>

<ul class="breadcrumb">
    <li><a href="friendlink">友情链接</a> <span class="divider">/</span></li>
    <li class="active" >添加链接</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">        
        <div class="well">
            <form  name="articleForm">
                <div style="color:red "  id="info_show"></div>
                <table cellspacing="1" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td>链接名称：</td>
                            <td>
                                <input type="text" value="" size="30" maxlength="60" name="name" id="name">
                                <span class="require-field">*</span>
                            </td>
                        </tr>                        
                        <tr>
                            <td>链接地址：</td>
                            <td>
                                <input type="text" maxlength="100" name="url" id="url"><span class="require-field">格式：http://www.baidu.com</span>
                            </td>
                        </tr>
                        <tr>
                            <td>顺序：</td>
                            <td>
                                <input type="text" size="15" value="50" name="type" id="type">
                            </td>
                        </tr>
                        <tr>
                            <td>是否显示:</td>
                            <td>
                                <input type="radio" checked="true" value="1" name="logo">
                                是
                                <input type="radio"  value="0" name="logo">
                                否
                            </td>
                        </tr>                        
                    </tbody>
                </table>
                <div align="center" colspan="2">
                    <input type="button" onclick="savelink()" value=" 确定 ">
                    <input class="button" type="reset" value=" 重置 ">
                </div>
            </form>
        </div>
           
    </div>
</div>

<script type="text/javascript">

    function savelink(){
        var name = $("#name").val();
        var url = $("#url").val();
        var type = $("#type").val();
        var logo = $("input:radio:checked").val();
        if (name == ''){
            $("#info_show").html('名称不能为空');
            $("#info_show").show();
            setTimeout(info_hidden,2000);
            return false;
        }
        if (url == ''){            
            $("#info_show").html('地址不能为空');
            $("#info_show").show();
            setTimeout(info_hidden,2000);
            return false;
        }
        $.post("{{url('/backend/member/savefriendlink')}}",{'name':name,'url':url,'type':type,'logo':logo,'action':'insert','_token':"{{csrf_token()}}"},function(data){
            if(data==null){
                alert('服务端错误');
            }
            if (data.status == 1){
               $("#info_show").html(data.msg);
               $("#info_show").show();
               location.href = 'friendlink';
            }
            if (data.status == 0){
               $("#info_show").html(data.msg);
               $("#info_show").show();               
               setTimeout(info_hidden,2000);
            }
        },'json')
    }
    function info_hidden(){
        $('#info_show').hide();
    }
</script>

@endsection