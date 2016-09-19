<?php $__env->startSection('content'); ?>
<script type="text/javascript">
var editurl=Array();
editurl['editurl']="<?php echo e(asset('backend/ueditor')); ?>/";
editurl['imageupurl']="<?php echo e(asset('backend/ueditor/upimage')); ?>/";
editurl['imageManager']="<?php echo e(asset('backend/ueditor/imagemanager')); ?>/";
editurl['webswf']="<?php echo e(asset('backend/uploadify/uploadify.swf')); ?>";

</script>

<link rel="stylesheet" href="<?php echo e(asset('backend/calendar/calendar-blue.css')); ?>" type="text/css"> 
<script type="text/javascript" src="<?php echo e(asset('backend/calendar/js/jquery-ui-1.8.17.custom.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('backend/calendar/js/jquery-ui-timepicker-addon.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('backend/calendar/js/jquery-ui-timepicker-zh-CN.js')); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo e(asset('backend/calendar/calendar.js')); ?>"></script>

<link rel="stylesheet" href="<?php echo e(asset('backend/uploadify/uploadify.css')); ?>" type="text/css"> 
<script src="<?php echo e(asset('backend/uploadify/jquery.uploadify.min.js')); ?>" type="text/javascript"></script>

<link type="text/css" href="<?php echo e(asset('backend/calendar/css/jquery-ui-1.8.17.custom.css')); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo e(asset('backend/calendar/css/jquery-ui-timepicker-addon.css')); ?>" rel="stylesheet" />


<script src="<?php echo e(asset('backend/ueditor/ueditor.all.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('backend/ueditor/ueditor.config.js')); ?>" type="text/javascript"></script>
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
    <form method="post" action="/backend/shop/dealUpShop">
    	<table width="100%"  cellspacing="0" cellpadding="0">
		<tr><td>
			
    	所属分类：<select id="category" name="cateid">           
                   <option value="-1">≡ 请选栏目 ≡</option>
                   <?php foreach($cateList as $v){?> 
                   	<option <?php if($shoplist->cateid==$v['cateid']){?> selected="selected" <?php }?> value="<?php echo $v['cateid'];?>"><?php echo $v['html'].$v['name'];?></option>  
               		<?php }?>
               </select><br />
        </td></tr>
        <!--<tr><td>
                      所属品牌：<select id="brand" name="brand">
                   <?php if(empty($brandlist)){?>
                   <option value="-1">≡ 请选择品牌 ≡</option>
                   <?php }else{?>
                   <option value="<?php echo e($brandlist['id']); ?>"><?php echo e($brandlist['name']); ?></option>
                   	<?php }?>
			   </select><br />
	    </td></tr>-->
	    <tr><td>
	            商品标题：<textarea name="title" style="margin: 0px; width: 639px; height: 103px;" id='shoptitle'><?php echo $shoplist->title; ?></textarea>
	    </td></tr>
	     <tr><td>       	    
    	 副&nbsp标&nbsp题&nbsp：<input type="text" value="<?php echo e($shoplist->title2); ?>" name="title2"><br>
    	 </td></tr>
    	 <!--<tr><td>	
    	 关&nbsp键&nbsp字&nbsp：<input type="text" value="<?php echo e($shoplist->keywords); ?>" name="keywords"><br>
    	</td></tr>
    	<tr><td>
    	商品描述：
    	<textarea name="description" class="wid400"  style="height: 141px; margin: 0px 0px 8.99306px; width: 715px;"><?php echo e($shoplist->description); ?></textarea> 
    	<!--<span>还能输入<b id="textdescription">250</b>个字符</span>
    	<br />
    	</td></tr>-->
    	<tr><td>
    	商品总价：<input style="width: 36px" size="6" type="text" name='money' value="<?php echo e($shoplist->money); ?>">&nbsp元<br />
    	</td></tr>
    	
    	<tr><td>
    	最大期数：<input style="width: 36px" size="6" type="text" name='maxqishu' value="<?php echo e($shoplist->maxqishu); ?>">&nbsp期<br />
    	</td></tr>
    	<tr><td>
    	seo关键字：<input style="width: 360px" size="255" type="text" name='seo_keyword' value="<?php echo e($shoplist->seo_keyword); ?>"><br />
    	</td></tr>
    	<tr><td>
    	seo标题：<input style="width: 360px" size="255" type="text" name='seo_title' value="<?php echo e($shoplist->seo_title); ?>" ><br />
    	</td></tr>
    	<tr><td>
    	seo描述：<input style="width: 360px" size="255" type="text" name='seo_descript' value="<?php echo e($shoplist->seo_descript); ?>" ><br />
    	</td></tr>
    	<tr style="margin-top: 50px;">
    		<td>
    		<h3>缩略图：</h3>
    	<img src="<?php echo e($shoplist->thumb); ?>" style="border:1px solid #eee; padding:1px; width:50px; height:50px;" id="thumpshow">
              
         </td></tr>
        
         <tr style="margin-top: 50px;"><td><h3>图片详情：</h3></td></tr>
		 
		 <?php if(!empty($shoplist->picarr)){foreach($shoplist->picarr as $v){?>
                    	<tr>
			<td >           
			  <img src="<?php echo e($v); ?>" style="border:1px solid #eee; padding:1px; width:300px; height:300px;" id="thumpshow">
            </td>           
		</tr> 
                    <?php }}?>            
		 <tr><td>&nbsp;</td></tr>
		 <tr>
        	<td><h3>商品内容详情：</h3>
				<script name="content" id="myeditor" type="text/plain">
				<?php echo $shoplist->content; ?>

			   </script>
            	<style>
				.content_attr {
					border: 1px solid #CCC;
					padding: 5px 8px;
					background: #FFC;
					margin-top: 6px;
					width:915px;
				}
				</style>
                <div class="content_attr">
                <label><input name="sub_text_des" type="checkbox"  value="off" checked>是否截取内容</label>
                <input type="text" name="sub_text_len" class="input-text" value="250" size="3">字符至内容摘要<label>         
            	</div>
            </td>        
		</tr>       
		<!--<tr>
        	<td align="left" style="width:120px">商品属性：
            
			 <input <?php if($shoplist->pos==1){ ?> checked="TRUE" <?php }?> name="goods_key[pos]" value="1" type="checkbox" />&nbsp;推荐&nbsp;&nbsp;
			 <input <?php if($shoplist->renqi==1){ ?> checked="TRUE" <?php }?> name="goods_key[renqi]" value="1" type="checkbox" />&nbsp;人气&nbsp;&nbsp; 
			 
            </td>          
        </tr> -->
   
    	</table>
    <form>
	
	<br/>
	<p>PC推广链接：<a target="_blank" href="http://www.ts1kg.com/prod/<?php echo e($shoplist->id); ?>">http://www.ts1kg.com/prod/<?php echo e($shoplist->id); ?></a></p>
	<p>H5推广链接：<a target="_blank" href="http://m.ts1kg.com/prod_m/<?php echo e($shoplist->id); ?>">http://m.ts1kg.com/prod_m/<?php echo e($shoplist->id); ?></a></p>
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
  
  //删除图片
  $(".delpic").click(function(){
  	
  	var pic=$(this).data('val');
  	$(this).parent().remove();
  	//alert(pic);
	$.post("/backend/shop/delShopPic", { 'pic': pic },
       function(data){
       if(data>0)
       {
 	
       }
       else
       {
   
       }
  	
     })
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
 
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>