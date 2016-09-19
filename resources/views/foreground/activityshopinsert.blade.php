@extends('backend.master')

@section('content')
<script type="text/javascript">
var editurl=Array();
editurl['editurl']="{{ asset('backend/ueditor') }}/";
editurl['imageupurl']="{{ asset('backend/ueditor/upimage') }}/";
editurl['imageManager']="{{ asset('backend/ueditor/imagemanager') }}/";
editurl['webswf']="{{ asset('backend/uploadify/uploadify.swf') }}";

</script>

<link rel="stylesheet" href="{{ asset('backend/calendar/calendar-blue.css') }}" type="text/css"> 
<script type="text/javascript" src="{{ asset('backend/calendar/js/jquery-ui-1.8.17.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/calendar/js/jquery-ui-timepicker-addon.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/calendar/js/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('backend/calendar/calendar.js') }}"></script>

<link rel="stylesheet" href="{{ asset('backend/uploadify/uploadify.css') }}" type="text/css"> 
<script src="{{ asset('backend/uploadify/jquery.uploadify.min.js') }}" type="text/javascript"></script>

<link type="text/css" href="{{ asset('backend/calendar/css/jquery-ui-1.8.17.custom.css') }}" rel="stylesheet" />
<link type="text/css" href="{{ asset('backend/calendar/css/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" />


<script src="{{ asset('backend/ueditor/ueditor.all.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/ueditor/ueditor.config.js') }}" type="text/javascript"></script>
<div class="header">
            
            <h1 class="page-title">商品管理</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/backend/shop">商品</a> <span class="divider">/</span></li>
            <li class="active">添加商品</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="well">
    <form method="post" action="/backend/shop/saveActivityShop">
    	<table width="100%"  cellspacing="0" cellpadding="0">
	    <tr><td>
	            商品名称:<input type="text" name="title"><br> 
	    </td></tr>
	     <tr><td>       	    
    	
    	<!--<span>还能输入<b id="textdescription">250</b>个字符</span>-->
    	<br />
    	</td></tr>
    	<tr><td>
    	邀请人数:<input style="width: 36px" size="6" type="text" name='invite_need'>&nbsp个<br />
    	</td></tr>
    	
    	<tr><td>
    	库&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp存:<input style="width: 36px" size="6" type="text" name='stock'>&nbsp件<br />
    	</td></tr>
    	<tr>
    		<td>
    		缩略图：
    	<img src="/photo/goods.jpg" style="border:1px solid #eee; padding:1px; width:50px; height:50px;" id="thumpshow">
           
           	<input type="text" id="imagetext" name="img" value="photo/goods.jpg" >
        
           
			<input type="button" id="file_upload" name="file_upload" class="button" value="上传图片"/>
           
         </td></tr>
    	<tr><td><input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"></td></tr>
    	
    	<tr><td><input type="submit" value="添加商品"></td></tr>
    	</table>
    <form>
</div>

<div class="pagination">
  
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
<script>
  $("#addshop").click(function(){
  	
  		window.location.href="/backend/shop/addShop";
  })
  
  //栏目选中触发品牌选择
  $("#category").change(function(){
  	  var cateid=$("#category option:selected").val();
  	  $.post("/backend/shop/getBrandid", { 'cateid': cateid },
       function(result){
       	   html='';
       	   
          var result=eval(result);
				     
	     $.each(result,function(index,item)
	     {
	     	
	     	//html+='<li>'+item.phone+'</li>';
	     	html+='<option value="'+item.id+ '" >'+item.name+ '</option> ';
	     });
         
          $("#brand").html(html);
       
  
     })
  	 
  })
</script>
<script type="text/javascript">
    //实例化编辑器
    var ue = UE.getEditor('myeditor');

    ue.addListener('ready',function(){
        this.focus()
    });
    function getContent() {
        var arr = [];
        arr.push( "使用editor.getContent()方法可以获得编辑器的内容" );
        arr.push( "内容为：" );
        arr.push(  UE.getEditor('myeditor').getContent() );
        alert( arr.join( "\n" ) );
    }
    function hasContent() {
        var arr = [];
        arr.push( "使用editor.hasContents()方法判断编辑器里是否有内容" );
        arr.push( "判断结果为：" );
        arr.push(  UE.getEditor('myeditor').hasContents() );
        alert( arr.join( "\n" ) );
    }
	
	var info=new Array();
    function gbcount(message,maxlen,id){
		
		if(!info[id]){
			info[id]=document.getElementById(id);
		}			
        var lenE = message.value.length;
        var lenC = 0;
        var enter = message.value.match(/\r/g);
        var CJK = message.value.match(/[^\x00-\xff]/g);//计算中文
        if (CJK != null) lenC += CJK.length;
        if (enter != null) lenC -= enter.length;		
		var lenZ=lenE+lenC;		
		if(lenZ > maxlen){
			info[id].innerHTML=''+0+'';
			return false;
		}
		info[id].innerHTML=''+(maxlen-lenZ)+'';
    }
	
function set_title_color(color) {
	$('#title2').css('color',color);
	$('#title_style_color').val(color);
}
function set_title_bold(){
	if($('#title_style_bold').val()=='bold'){
		$('#title_style_bold').val('');	
		$('#title2').css('font-weight','');
	}else{
		$('#title2').css('font-weight','bold');
		$('#title_style_bold').val('bold');
	}
}


$(function () {
        $(".ui_timepicker").datetimepicker({
            //showOn: "button",
            //buttonImage: "./css/images/icon_calendar.gif",
            //buttonImageOnly: true,
            showSecond: true,
            timeFormat: 'hh:mm:ss',
            stepHour: 1,
            stepMinute: 1,
            stepSecond: 1
        })
      })
//API JS
//window.parent.api_off_on_open('open');  
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
    'uploader' : '/backend/shop/savePic',
    'onInit'   : function(index){
     //alert('队列ID:'+index.settings.queueID);
    },
    'method'   : 'post', //设置上传的方法get 和 post
    'auto'    : true, //是否自动上传 false关闭自动上传 true 选中文件后自动上传
    //'buttonClass' : 'myclass', //自定义按钮的样式
    //'buttonImage' : '按钮图片',
    'buttonText'  : '选择', //按钮显示的字迹
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
     'height'  : 30, //设置高度 button
     'width'  : 30, //设置宽度
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
 <script type="text/javascript">
  <?php $timestamp = time();?>
  $(function() {
   $('#file_uploadmax').uploadify({
    
    //上传文件时post的的数据
    'formData'     : {
     'timestamp' : '<?php echo $timestamp;?>',
     'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
     'id'  : 1
    },
    'swf'      : editurl['webswf'],
    'uploader' : '/backend/shop/savePic',
    'onInit'   : function(index){
     //alert('队列ID:'+index.settings.queueID);
    },
    'method'   : 'post', //设置上传的方法get 和 post
    'auto'    : true, //是否自动上传 false关闭自动上传 true 选中文件后自动上传
    //'buttonClass' : 'myclass', //自定义按钮的样式
    //'buttonImage' : '按钮图片',
    'buttonText'  : '选择', //按钮显示的字迹
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
    'uploadLimit'   : 10, //设置最大上传文件的数量
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
		$("#showfile").append("<input type='text' name=pic[] value='"+data+"'>");

     },
     //
       'onUploadError' : function(file, errorCode, errorMsg, errorString) {
         //alert(file.name + '上传失败原因:' + errorString); 
     },
     //'itemTemplate' : '追加到每个上传节点的html',
     'height'  : 30, //设置高度 button
     'width'  : 30, //设置宽度
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