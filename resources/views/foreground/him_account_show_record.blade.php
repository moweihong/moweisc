{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.him_center')
@section('title','我的晒单')
@section('content_right')
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
						<!--<span style="color:red ">{{$errors->first('sd_title')}}</span>-->
						内容：<textarea class="wsd_content" name='sd_content' ></textarea>
						<!--<span style="color:red ">{{$errors->first('sd_content')}}</span>-->
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
        <!--<ul class="b_record_title expose_b_record_title">
            <li class="b_record_this"><a href="javascript:;">已晒单</a></li>
            <li class=""><a href="javascript:;">未晒单</a></li>
        </ul>-->
        <!-- E 我的晒单模块标题 -->
            <!-- S 已晒单 -->
           <table id="sdTable">
								<tbody>
									<tr class="sd_part_title">
									  <th class="sd_th1">奖品图片</th>
									  <th style="width: 215px;text-align: left;">奖品名称</th>
									  <th class="sd_th3">晒单时间</th>
									  <th style="width: 425px;">分享内容</th>
									  <th class="sd_th3">操作</th>
									</tr>
									@foreach($myshow as $row)
									<tr>
									  <td><a href="/sharedetail/{{$row->id }}"><img src="{{ $row->sd_thumbs }}" alt=""></a></td>
									  <td id="div_0"><div class="sd_goods_name">
									     <span><a href="/sharedetail/{{$row->id }}">{{ str_limit($row->relateGood->title,22) }}</a></span>
									  </div></td>
									  <td class="sd_color">
									  	{{ date('Y-m-d H:i:s',$row->sd_time) }}
									  </td>
									  <td>{{ str_limit($row->sd_title,30) }}</td>
                                      <td>
          
                                          <a style="color: red;" href="/sharedetail/{{$row->id }}" >查看详情</a>
                                        
                                      </td>
									</tr>
									@endforeach
								</tbody>
							</table>
			<div id="pageStr" class="pageStr" style="margin: 64px auto;">
             {!! $myshow->render() !!}
            </div>
            <!-- E 已晒单 -->
          
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
@endsection
@section('my_shaidanjs') 
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
		$("#showpic").append("<img class='wsd_rightImg' src='"+data+"' />");
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
                 _token : "{{csrf_token()}}",
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
                 _token : "{{csrf_token()}}",
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
     
     function a(obj){
     	alert($(obj).html());
     }
</script>
@endsection
