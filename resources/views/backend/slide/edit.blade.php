@extends('backend.master')

@section('content')
<script type="text/javascript">
var editurl=Array();
editurl['editurl']="{{ asset('backend/ueditor') }}/";
editurl['imageupurl']="{{ asset('backend/ueditor/upimage') }}/";
editurl['imageManager']="{{ asset('backend/ueditor/imagemanager') }}/";
editurl['webswf']="{{ asset('backend/uploadify/uploadify.swf') }}";

</script>

<link rel="stylesheet" href="{{ asset('backend/uploadify/uploadify.css') }}" type="text/css"> 
<script src="{{ asset('backend/uploadify/jquery.uploadify.min.js') }}" type="text/javascript"></script>

<div class="header">
            
            <h1 class="page-title">添加导航条</h1>
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
        <label>图片标题</label>
        <input  id='title' type="text" value="{{ $info->title }}{{ $info->type }}" class="input-xlarge" name="title">
        <label>图片上传</label>
        <img src="{{$info->img}}" style="border:1px solid #eee; padding:1px; width:50px; height:50px;" id="thumpshow">
        <input type="text" id="imagetext" name="img" value="{{$info->img}}" >
		<input type="button" id="file_upload" name="file_upload" class="button" value="上传图片" />
        <label>图片链接</label>
        <input type="text" id="linkurl" name="link" value="{{ $info->link }}" class="input-xlarge" > 
        <input type="hidden" id="roid" name="link" value="{{ $info->id }}" > 
         <label>类型</label>
       <select id='selecttype' name="type" >
        	<option value="1" <?php if($info->type==1){?> selected='selected' <?php } ?> >pc端</option>
        	<option value="2" <?php if($info->type==2){?> selected='selected' <?php } ?> >移动端</option>
        </select> 

    </form>
      </div>
  </div>

</div>
                    
</div>
</div>

<script>
$(function(){
 $("#doSubmit").click(function(){
  	var title=$("#title").val();
  	var img=$("#imagetext").val();
  	var linkurl=$("#linkurl").val();
  	var id= $("#roid").val();
  	var type=$('#selecttype option:selected').val();
	$.post("/backend/rotation/updateRo", { 'id': id,'title':title,'img':img,'link':linkurl,'type':type },
       function(data){
       data=eval( '('+data+')');
       if(data.status==0)
       {
     		alert("更新成功");
     		window.location.reload()
     		
     		
       }
       else
       {
       		alert("更新失败");
       }
       
    });
  	  
  })
 })
</script>

<script type="text/javascript">
  <?php $timestamp = time();?>
  $(function() {
   $('#file_upload').uploadify({
    
    //上传文件时post的的数据
    'formData'     : {
     'timestamp' : '<?php echo $timestamp;?>',
     'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
     'id'  : 1
    },
    'swf'      : editurl['webswf'],
    'uploader' : '{{$url_prefix}}/rotation/savePic',
    'onInit'   : function(index){
     //alert('队列ID:'+index.settings.queueID);
    },
    'method'   : 'post', //设置上传的方法get 和 post
    'auto'    : true, //是否自动上传 false关闭自动上传 true 选中文件后自动上传
    //'buttonClass' : 'myclass', //自定义按钮的样式
    //'buttonImage' : '按钮图片',
    'buttonText'  : '选择文件', //按钮显示的字迹
    //'fileObjName' : 'mytest'  //后台接收的时候就是$_FILES['mytest'] 
    //'checkExisting' : '/uploadify/check-exists.php', //检查文件是否已经存在 返回0或者1
    'fileSizeLimit' : '210000KB', //上传文件大小的限制
   // 'fileTypeDesc'  : '你需要一些文件',//可选择的文件的描述
    'fileTypeExts'  : '*.gif; *.jpg; *.png', //文件的允许上传的类型
    'progressData'  : 'speed', //文件的允许上传的类型
    //上传的时候发生的事件
    'onUploadStart' : function(file){
      //alert('开始上传了');       
      },
    'uploadLimit'   : 1, //设置最大上传文件的数量
    /*
    'onUploadComplete' : function(result){
        for (var i in result.post){
         alert(i+':::'+result[i]);
        }
       },
    */
    //文件上传成功的时候
    'onUploadSuccess' : function(file, data, response) {
        //alert(data);
        $('#thumpshow').attr('src',data);
        $("#imagetext").val(data);
		
     },
     //
       'onUploadError' : function(file, errorCode, errorMsg, errorString) {
     //alert(file.name + '上传失败原因:' + errorString); 
     },
     //'itemTemplate' : '追加到每个上传节点的html',
     'height'  : 20, //设置高度 button
     'width'  : 60, //设置宽度
     'onDisable' : function(){
      //alert('您禁止上传');
     },
     'onEnable'  : function(){
      //alert('您可以继续上传了');
     },
     //当文件选中的时候
     'onSelect'  : function(file){
      //alert(file.name+"已经添加到队列");
     }
   });
  });
 </script>
@endsection