<?php /*个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件*/ ?>

<?php $__env->startSection('title','我的晒单'); ?>
<?php $__env->startSection('content_right'); ?>
    <div id="member_right" class="member_right b_record_box">
		<div class="wsd_popup" style="display:none">
			<em class="wsd_close"></em>
			  <div class="wsd_popup2">
			  <table id="wsdTable">
								<tbody>
								    <tr id='appendShow'>
									  <!--<td><a href="javascript:gotoGoods(327,725)"><img src="/backend/upload/shopimg/251457604788.jpg" alt=""></a></td>
									  <td id="div_0"><div class="wsd_goods_name">
									     <span><a href="javascript:gotoGoods(327,725)">(第2期) iPhone6&nbsp;Plus</a></span>
										 <b class="wsd_all_require">价值：6988.00</b><b class="wsd_all_require">幸运块乐码：123</b><b class="wsd_all_require">揭晓时间:1953-07-17 11:50:57</b>
									  </div></td>-->
									  <!--<td class="sd_color"><span class="wsd_score">已接晓</span></td>-->
									  <!--<td><a href="javascript:gotoGoods(327,725)" class="wsd_yjsd" style="color:red">查看详情</a></td>-->
									</tr>						
							  </tbody>
			  </table>
			   <form method="post" action="/user/saveShowInfo" onsubmit="return check()" style="    margin-top: 30px;">
				<div class="wsd_contentLeft">
					      
						标题：<input type="text" name='sd_title' class="wsd_contentTitle"><br>
						<!--<span style="color:red "><?php echo e($errors->first('sd_title')); ?></span>-->
						内容：<textarea class="wsd_content" name='sd_content' ></textarea>
						<!--<span style="color:red "><?php echo e($errors->first('sd_content')); ?></span>-->
						<input type="hidden" id="shopids" name="sd_gid"> 
						<input type="hidden" id="brecordids" name="bid">
						<input type="hidden" id="qishus" name="sd_periods">
						<input type="hidden" id="o_ids" name="o_id">
						<input type="hidden" id="showid" name="showid">
				</div>
				<div class="wsd_contentRight">
				   <span class="wsd_rightpicture">晒单：</span>
                   <br/>
				   <div id='showpic'>
				  </div>
				   	<span class="wsd_rightImg wsd_rightSc" alt="1">
				   		<input type="button" value="上传" id="uploadshowpic">
				   		<!--<a href="javascript:$('#uploadshowpic').uploadify('upload','*')">
				   			上传文件
				   		</a>-->
				   	</span>
				   	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				</div>
				<div style="text-align: center;"><span class="wsd_error" style="">晒单图片不少于3张</span><input type="submit" value="晒单" class="wsd_submit" ></div>
                </form>
			  </div>
			  
			  
		</div>
        <!-- S 我的晒单模块标题 -->
        <ul class="b_record_title expose_b_record_title">
            <li class=""><a href="javascript:;">已晒单</a></li>
            <li class="b_record_this"><a href="javascript:;">未晒单</a></li>
        </ul>
        <!-- E 我的晒单模块标题 -->
            <!-- S 已晒单 -->
           <table id="sdTable" style="display:none">
								<tbody>
									<tr class="sd_part_title">
									  <th class="sd_th1">图片</th>
									  <th class="sd_th2">晒单信息</th>
									  <th class="sd_th3">晒单状态</th>
									  <th class="sd_th3">奖励</th>
									  <th class="sd_th4">操作</th>
									</tr>
									<?php foreach($myshow as $row): ?>
									<tr>
									  <td><a href="javascript:void(0)"><img src="<?php echo e($row->sd_thumbs); ?>" alt=""></a></td>
									  <td id="div_0"><div class="sd_goods_name">
									     <span><a href="javascript:void(0)"><?php echo e(str_limit($row->sd_title,22)); ?></a></span>
										 <span><?php echo e(date('Y-m-d H:i:s',$row->sd_time)); ?></span><b class="sd_all_require"><?php echo e(str_limit($row->sd_content,30)); ?></b>
									  </div></td>
									  <td class="sd_color">
									  	<?php if($row->is_show==1): ?>
									  	<span class="sd_pass">审核通过</span>
									  	<?php elseif($row->is_show==0): ?>
									  	<span class="sd_during">审核中</span>
									  	<?php else: ?>
									  	<span class="sd_pass">拒绝通过</span>
									  	<span class="sd_reward" style='color: red;'><?php echo e($row->refused_cause); ?></span>
									  	<?php endif; ?>
									  </td>
									  
									  
									  <td class="sd_color">
									  	<?php if($row->is_show==1): ?>
									  	<span class="sd_reward"><?php echo e($row->kl_bean); ?></span>
									  	<?php else: ?>
									  		<span class="sd_reward">0</span>
									  	<?php endif; ?>
									  </td>
									  
									  
                                      <td>
                                          <?php if($row->is_show == 2): ?>
                                          <!--<a href="javascript:;" class="wsd_yjsd"  style="color:red">重新编辑</a>-->
                                          <a id="wanshanAddress" href="javascript:void(0)" onclick="editShow(<?php echo e($row->id); ?>)">重新编辑</a>
                                          <?php else: ?>
                                          <a href="javascript:void(0)" onclick="showDetail(<?php echo e($row->id); ?>)" class="viewAll2">查看详情</a>
                                          <?php endif; ?>
                                      </td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
			<div id="pageStr" class="pageStr" style="margin: 64px auto;display:none;">
             <?php echo $myshow->render(); ?>

            </div>
            <!-- E 已晒单 -->
            <!-- S 未晒单 -->
           <table id="wsdTable" >
								<tbody>
									<tr class="wsd_part_title">
									  <th class="wsd_th1">图片</th>
									  <th class="wsd_th2">商品列表</th>
									  <th class="wsd_th3">订单号</th>
									  <th class="wsd_th4">操作</th>
									</tr>
									<?php foreach($noshow as $v): ?>
									<tr>
									  <td><a href="javascript:gotoGoods(327,725)"><img src="<?php echo e($v->thumb); ?>" alt=""></a></td>
									  <td id="div_0">
									  	<div class="wsd_goods_name">
										     <span><a href="javascript:gotoGoods(327,725)">(第<?php echo e($v->g_periods); ?>期) <?php echo e($v->g_name); ?></a></span>
											 <b class="wsd_all_require">价值：<?php echo e($v->money); ?></b>
											 <b class="wsd_all_require">幸运块乐码：<?php echo e($v->fetchno); ?></b>
											 <b class="wsd_all_require">揭晓时间:<?php echo e(date('Y-m-d H:i:s',(int)($v->kaijiang_time/1000))); ?></b>
									     </div>
									  </td>
									  <td class="sd_color"><span class="wsd_score"><?php echo e($v->code); ?></span></td>
									  <td><a href="javascript:;" class="wsd_yjsd" style="color:red" data-sd_gid="<?php echo e($v->g_id); ?>" data-bid="<?php echo e($v->id); ?>" data-sd_periods="<?php echo e($v->g_periods); ?>" data-oid="<?php echo e($v->o_id); ?>">一键晒单</a></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
                <!-- S 分页 -->
                <!--<center id="unSunSingleListPageStr" class="pageStr" style="display: block;"></center>-->
                <div id="pageStr" class="pageStr" style="margin: 64px auto; display:none">
                <?php echo $noshow->render(); ?>

                </div>
                <!-- E 分页 -->
            </div>

<div class="member_right2" style="display:none">
    <div class="g-buyCon clrfix">
        <h3 class="gray3">
            晒单详情
            <a class="details_back" href="javascript:void(0)">返回</a>
        </h3>
        <div class="m-buy-num clrfix">
            <dl id="showdetail">
                <dd><p> 标题： </p></dd>
                <dd class="gray6"><cite>内容： </cite></dd>
                <dd>           
                </dd>
            </dl>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('my_shaidanjs'); ?> 
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/jquery.rotate.min.js"></script>
<script>
 
	  $(function() {
   $('#uploadshowpic').uploadify({
    //上传文件时post的的数据
    'formData'     : {
     'timestamp' : '132566555555',
     'token'     : 'afdsfsdfsdf',
     'laravel_session'   : 'afdsfsdfsdf',
     'id'  : 1
    },
   
    'swf'      : editurl['webswf'],
    'uploader' : '/uploadify/saveShowPic',
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
		if($('.wsd_rightImg').size() > 6){
			$('.wsd_rightSc').hide();
			$('.wsd_rightSc').css('margin-top','30px');
            $('#uploadshowpic').uploadify('cancel', 'SWFUpload_0_0');
            layer.msg('最多只能上传6张图片');
		}
      },
    'uploadLimit'   : 6, //设置最大上传文件的数量
    //文件上传成功的时候
    'onUploadSuccess' : function(file, data, response) {
		$("#showpic").append("<input type='hidden' name=pic[] value='"+data+"'>");
		$("#showpic").append("<img class='wsd_rightImg' data-id='0' onclick='xuanzhuan(this);' src='"+data+"' />");
		$("#showpic").append("<img class='deletepic' onclick='deletepic(this);' src='/foreground/img/wsd_close.png' />");
	  //图片大于三个就将距离和图片距离保持一致
	 $('.wsd_rightImg').each(function(i){
     	if(i>2&&i<6){
     		$(this).css('margin-top','30px');
     	}
     });
		if($('.wsd_rightImg').size() > 6){
			$('.wsd_rightSc').hide();
			$('.wsd_rightSc').css('margin-top','30px');
		}

     },
     
     //
       'onUploadError' : function(file, errorCode, errorMsg, errorString) {
         //alert(file.name + '上传失败原因:' + errorString);
     },
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

  function showDetail(id)
  {
    $("#showdetail").html('');  
    var index = layer.load();
    $.ajax({
            type : 'post',
            url : '/user/showdetail',
            data : {
                id : id,
                 _token : "<?php echo e(csrf_token()); ?>",
            },
            dataType : 'json',
            success : function(data) {
                layer.close(index);
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    var appendStr = "";
                    appendStr += "<dd><p> 标题："+data.sd_title+" </p></dd>";
                    appendStr += "<dd class=\"gray6\"><cite>内容： "+data.sd_content+"</cite></dd>";
                    appendStr += "<dd>";
                    for (var i = 0; i < data.sd_photolist.length; i++) {
                        appendStr += "<img style=\"width: 200px;height: 300px\" src=\""+data.sd_photolist[i]+"\">";
                    }
                    appendStr += "</dd>";
                    $("#showdetail").html(appendStr);
                }else if(data.status == 0){
                    layer.msg(data.msg);
                }
            }
    });
  }
function editShow(id)
{
    var pics ='';
    $(".wsd_popup").show();
    $("#showid").val(id);
    $(".wsd_contentTitle").val('');
    $(".wsd_content").val('');  
    $(".wsd_submit").val('提交');
    var index = layer.load();
    $.ajax({
            type : 'post',
            url : '/user/editshow',
            data : {
                id : id,
                 _token : "<?php echo e(csrf_token()); ?>",
            },
            dataType : 'json',
            success : function(data) {
                layer.close(index);
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    var appendStr = "";
                    $(".wsd_contentTitle").val(data.title);
                    $(".wsd_content").val(data.content);  
                    for (var i = 0; i < data.pics.length; i++) {
                        appendStr += "<input type=\"hidden\" value=\""+data.pics[i]+"\" name=\"pic[]\">"+
                                       "<img class=\"wsd_rightImg\" src=\""+data.pics[i]+"\">"+
                                       "<img class=\"deletepic\" src=\"/foreground/img/wsd_close.png\" onclick=\"deletepic(this);\">";
                    if(i==5)
                    {
                    	$('.wsd_rightSc').hide();
                    }
                    }
                   
                    $("#showpic").html(appendStr);
                }else if(data.status == 0){
                    layer.msg(data.msg);
                    location.reload();
                }
            }
    });
}
</script>
<script>
	function deletepic(obj)
	{
		//alert($(obj)[0].src);
		$(obj).prev().prev().remove();
		$(obj).prev().remove();
		$(obj).remove();
		$('.wsd_rightSc').show();
		var swfuploadify = window['uploadify_file_upload'];
        $("#uploadshowpic").uploadify('settings', 'uploadLimit', swfuploadify.settings.uploadLimit + 1);
		
		
	}
	
	function xuanzhuan(obj)
	{
		var num=parseInt($(obj).attr('data-id'));
		num ++; 
		$(obj).rotate(90*num); 
		$(obj).attr('data-id',num);
		imgsrc=$(obj).attr('src');
		
		 $.ajax({
            type : 'post',
            url : '/uploadify/xuanZhuanPic',
            data : {
                imgsrc : imgsrc,
                 _token : "<?php echo e(csrf_token()); ?>",
            },
            dataType : 'json',
            success : function(data)
            {
                
            }
    });
		 
		
	}
     
     function a(obj){
     	alert($(obj).html());
     }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('foreground.user_center', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>