@extends('backend.master')
@section('content')
<div class="header">

    <h1 class="page-title">系统消息</h1>
</div>

<ul class="breadcrumb">
    <li><a href="/sym/msgedit">发送消息</a> <span class="divider">/</span></li>
    <li class="active" >消息编辑</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">        
        <div class="well">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
        <form id="msgform" enctype="multipart/form-data" onsubmit="return check()">
            {!! csrf_field() !!}
            <span>发送对象：</span>
            <select id="msg_type" name="msg_type">           
                       <option value="0">全部用户</option>
                       <option value="1">指定用户</option>
            </select><br /><br />
            <div id="sendMobile" style="display: none;">
             <label>发送人的手机号：<font color="red">(手机号之间用英文逗号","隔开,且最后一个号码末尾不能添加逗号,例如格式：15012345671,15012345672,15012345673)</font></label>
             <textarea name="mobile" id="mobile"  rows="6" class="input-xlarge" style="width: 60%"></textarea><br/>
             <input type="file" id="file" value=""  onchange="handleFiles(this.files)" style="display: none;"/>
             <input type="button"  value="TXT导入" onclick="$('#file').click();"/>
             <input type="file" id="file1" name="file1" value=""  onchange="importXLS(this.files)" style="display: none;"/>
             <input type="button"  value="EXCEL导入" onclick="$('#file1').click();"/>
             <input type="button"  value="全部清除" onclick="$('#mobile').val('');"/>
            </div><br/>
            
            <span>标题：</span>
            <input type="text" name='title' id="title" class="input-xlarge" style="width: 50%" value=""><br/><br/>
            
            <label>发送内容：<font color="red">(内容不要超过200个汉字！)</font></label>
            <textarea name="content" id="content"  rows="6" style="width: 60%" ></textarea><br/><br/>
            <span>送达时间：</span>
<!--            <div class="input-append date">            
            <input  class="datetimepicker" id="send_time" style="widht:200px" type="text" name="send_time" maxlength="11" value="" /><span class="add-on"><i class="icon-remove"></i></span>
            </div>-->
            <div class="input-append date form_datetime" data-date="{{date('Y-m-d H:i')}}">
                <input id="send_time" name="send_time" size="16" type="text" value="" readonly>
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
            <span style="color: red;">(*若为空表示立即发送)</span><br/><br/>

            <input type="submit" value="提交">
        </form>
          </div>
      </div>
        </div>          
    </div>
</div>
<script src="{{ asset('backend/lib/ajaxfileupload.js') }}" type="text/javascript"></script>
<script>
    $(".form_datetime").datetimepicker({
        autoclose: true,
        todayBtn: true,
        startDate: "2016-7-6 00:00",
        minuteStep: 1
    });
    $(".icon-remove").click(function(){
        $("#send_time").val('');
    })
    $("#send_time").change(function(){
        var send_time = $("#send_time").val();
        if(send_time != ''){
            var time_now = new Date().getTime();
            var timemsg = new Date(send_time).getTime();
            if(timemsg < time_now){
                layer.msg('发送时间不能小于当前时间！');
                $("#send_time").val('');
            }
        }
    });
	function check()
	{
        var msg_type = $("#msg_type").val();
        var mobile = $("#mobile").val();
        var title = $("#title").val();
        var content = $("#content").val();
        var send_time = $("#send_time").val();

        if(msg_type == 1){
            if(mobile == '' || mobile == null){
                layer.msg('发送手机号不能为空！');
                return false;
            }
        }
        if(title == '' || content == ''){
            layer.msg('标题或内容不能为空！');
            return false;
        }
        var send_time = $("#send_time").val();
        if(send_time != '' || send_time != null){
            var time_now = new Date().getTime();
            var timemsg = new Date(send_time).getTime();
            if(timemsg < time_now){
                layer.msg('发送时间不能小于当前时间！');
                return false;
            }
        }
        $.post("{{url('/backend/sym/msgedit')}}",{'msg_type':msg_type,'mobile':mobile,'title':title,'content':content,'send_time':send_time,'_token':"{{csrf_token()}}"},function(data){
            if (data.status == 0){
                layer.alert(data.msg);
            }else{
                layer.alert(data.msg);
            }
        },'json');
        return false;        
	}

    $("#msg_type").change(function(){
        var value = $(this).val();
        if(value == 1){
           $("#sendMobile").show();
        }else{
            $("#sendMobile").hide();
        }
    });
    
    function handleFiles(files) {
        if (files.length) {
            var file = files[0];
            var reader = new FileReader();
            if (/text\/\w+/.test(file.type)) {
                reader.onload = function() {
                    $("#mobile").val(this.result.replace(/\s+/g,""));
                    layer.msg('导入成功！');
                }
                reader.readAsText(file);
                $("#file").val('');
            }else{
                layer.msg('格式错误，不是.txt格式');
            }
        }
    }
    function importXLS(files)
    { 
        if (files.length) {
            var file =files[0];
            if (/excel/.test(file.type)) {
                $.ajaxFileUpload({  
                    url : "/backend/sym/excelImport",
                    secureuri : false,
                    fileElementId : 'file1',
                    dataType : 'json',
                    success : function(data) {
                        if(data.status == 0){
                            $("#mobile").val(data.msg.replace(/\s+/g,""));
                            $("#file1").val('');
                            layer.msg('导入成功！');
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                });
            }else{
                layer.msg('格式错误，不是.xls格式');
            }            
        }
    }
    
    
 </script>
@endsection