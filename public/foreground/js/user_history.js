$(function(){
	//用户头像赋值
	 $.post("/user/security/getUserPhoto", {},
	       function(data){
		       data=eval( '('+data+')');
		       
		       if(data.user_photo!='')
		       {
		       		 $('#alterFace').attr('src',data.user_photo);
		       }
		       
		       
	})
	
	$(".b_record_title li").click(function(){
	   var index=$(this).index(".b_record_title li");  //获取选中元素的索引
	   $(this).addClass("b_record_this").siblings().removeClass("b_record_this");//为选中元素的增加样式
	   $("table").eq(index+1).show().siblings('table').hide();//将对应模块的内容显示出来其他隐藏掉
	   $('.pageStr').eq(index).show().siblings('.pageStr').hide();
	 //第二版夺宝记录时间查询切换  $('.b_record_list>div').eq(index).show().siblings('.b_record_list>div').hide();
   });
   //安全中心里面的验证码倒计时  
   //修改手机号码验证原手机号码短信验证倒计时
   		 var wait= 59;
		 var yzm = $("#updateMobileOldVerifyCode");
     function time() {
             if (wait == 0) {
                yzm.addClass("c_get_verify_one");
				yzm.attr('id','updateMobileOldVerifyCode')
				yzm.removeClass("c_get_verify2");
                yzm.html("获取验证码");
                wait = 59;
				$("#updateMobileOldVerifyCode").one("click",function(){
			 time();
				 })
              } else {
				yzm.attr('id','')
                yzm.removeClass("c_get_verify_one" );
				yzm.addClass("c_get_verify2");
                yzm.html(wait + "秒后重新发送");
                wait--;
                setTimeout(function() {
                time(yzm)
                },
           1000)
                }
            };
   	   $("#updateMobileOldVerifyCode").one("click",function(){
			 time();
	   })
//修改手机号码输入新手机号码短信验证倒计时			用的是类名不是ID
	     var wait2= 59;
	   	 var yzm2 = $(".updMobileGetNewMobileCode");
     function time2() {
             if (wait2 == 0) {
                yzm2.addClass("updMobileGetNewMobileCode c_get_verify_one");
				//yzm2.attr('id','updMobileGetNewMobileCode')
				yzm2.removeClass("c_get_verify2");
                yzm2.html("获取验证码");
                wait2 = 59;
		$(".updMobileGetNewMobileCode").one("click",function(){
			 time2();
				 })
              } else {
				//yzm2.attr('id','')
                yzm2.removeClass("updMobileGetNewMobileCode c_get_verify_one" );
				yzm2.addClass("c_get_verify2");
                yzm2.html(wait2 + "秒后重新发送");
                wait2--;
                setTimeout(function() {
                time2(yzm2)
                },
           1000)
                }
            };
   	   $(".updMobileGetNewMobileCode").one("click",function(){
			 time2();
	   })
//修改手机号码验证电子邮箱邮箱验证倒计时
	    var wait3= 59;
		var yzm3 = $("#emailCode");
      function time3() {
             if (wait3 == 0) {
                yzm3.addClass("c_get_verify_one");
				yzm3.attr('id','emailCode')
				yzm3.removeClass("c_get_verify2");
                yzm3.html("获取验证码");
                wait3 = 59;
				$("#emailCode").one("click",function(){
			 time3();
				 })
              } else {
				yzm3.attr('id','')
                yzm3.removeClass("c_get_verify_one" );
				yzm3.addClass("c_get_verify2");
                yzm3.html(wait3 + "秒后重新发送");
                wait3--;
                setTimeout(function() {
                time3(yzm3)
                },
           1000)
                }
            };
   	   $("#emailCode").one("click",function(){
			 time3();
	   })
//电子邮箱修改邮箱验证身份获取验证码
		var wait4= 59;
		var yzm4 = $("#getEmailCodePhone");
      function time4() {
             if (wait4 == 0) {
                yzm4.addClass("c_get_verify_one");
				yzm4.attr('id','getEmailCodePhone')
				yzm4.removeClass("c_get_verify2");
                yzm4.html("获取验证码");
                wait4 = 59;
				$("#getEmailCodePhone").one("click",function(){
			 time4();
				 })
              } else {
				yzm4.attr('id','')
                yzm4.removeClass("c_get_verify_one" );
				yzm4.addClass("c_get_verify2");
                yzm4.html(wait4 + "秒后重新发送");
                wait4--;
                setTimeout(function() {
                time4(yzm4)
                },
           1000)
                }
            };
   	   $("#getEmailCodePhone").one("click",function(){
			 time4();
	   })
//电子邮箱绑定	邮箱验证身份获取验证码
		var wait5= 59;
		var yzm5 = $("#getEmailCode");
      function time5() {
             if (wait5 == 0) {
                yzm5.addClass("c_get_verify_one");
				yzm5.attr('id','getEmailCode')
				yzm5.removeClass("c_get_verify2");
                yzm5.html("获取验证码");
                wait5 = 59;
				$("#getEmailCode").one("click",function(){
			 time5();
				 })
              } else {
				yzm5.attr('id','')
                yzm5.removeClass("c_get_verify_one" );
				yzm5.addClass("c_get_verify2");
                yzm5.html(wait5 + "秒后重新发送");
                wait5--;
                setTimeout(function() {
                time5(yzm5)
                },
           1000)
                }
            };
   	   $("#getEmailCode").one("click",function(){
			 time5();
	   });

   //未晒单里面的一件分享弹窗
   $('.wsd_yjsd').click(function(){
        var sd_gid=$(this).attr("data-sd_gid");
        var qishu=$(this).attr("data-sd_periods");
        var bid=$(this).attr("data-bid");
        var oid=$(this).attr("data-oid");
        $("#shopids").val(sd_gid);
        $("#qishus").val(qishu);
        $("#brecordids").val(bid);
        $("#o_ids").val(oid);
        $("#showid").val('');
        $(".wsd_submit").val('晒单');
        $(".wsd_contentTitle").val('');
        $(".wsd_content").val('');
        $("#showpic").html('');
		$('.uploadify-button-text:eq(1)').addClass('uploadify-button-text2');
   		$(this).parent().parent().find('td:lt(2)').clone().prependTo('#appendShow');
		$('.wsd_popup').show();
   });
   $('.wsd_close').click(function(){
	    $('.wsd_close').next().find('td:lt(2)').remove();//移除掉所加的数据
		$('.wsd_popup').hide();
   })
//夺宝记录的查看所有云购码
   $('.viewAll2').click(function(){
       $('.member_right').hide();
	   $('.member_right2').show();
   });
//查看所有云购码返回夺宝记录
   $('.details_back').click(function(){
       $('.member_right2').hide();
	   $('.member_right').show();
   });
//中奖记录里面一键晒单的鼠标移入移出功能
   $('.b_part_title~tr').hover(function(){
       $(this).find('.viewAll').show();
   },function(){
	   $(this).find('.viewAll').hide();
	}); 
//会员中心-常见问题选项卡切换
    $(".u_questit .u_quet_a").click(function(){
       var j = $(this).attr("data-divshow");
       $(".u_quesmain .uque_tab").eq(j).show().siblings(".uque_tab").hide();
       $(this).addClass("u_quet_acurr").siblings(".u_quet_a").removeClass("u_quet_acurr");
    });

//首页帮助中心-选项卡切换
    $(".fnes-quetit .fquetit-a").click(function(){
        var k = $(this).attr("data-queshow");
        $(".fnes-qustxt .fuque_tab").eq(k).show().siblings(".fuque_tab").hide();
        $(this).addClass("fquetit-aon").siblings(".fquetit-a").removeClass("fquetit-aon");
    });

//首页帮助中心-点击弹出，再点击收回
     $(".uqb_box .uqb_btit").click(function(){
        $(this).siblings(".uqb_btxt").slideToggle(300);
        $(this).find(".uqb_bico").toggleClass("uqb_bico_down");
         return false;
    });
})



/*  $(function() {
   $('#uploadshowpic').uploadify({
    //上传文件时post的的数据
    'formData'     : {
     'timestamp' : '<?php echo $timestamp;?>',
     'token'     : 'afdsfsdfsdf',
     'id'  : 1
    },
    'swf'      : editurl['webswf'],
    'uploader' : '/user/saveShowPic',
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
    //文件上传成功的时候
    'onUploadSuccess' : function(file, data, response) {
        //alert(data);
		$("#showpic").append("<input type='hidden' name=pic[] value='"+data+"'>");
		$("#showpic").append("<img class='wsd_rightImg' src='"+data+"' />");
	  //图片大于三个就将距离和图片距离保持一致
		if($('.wsd_rightImg').size() > 3){
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
  });*/
    function check()
    {
    	var sd_title=$(".wsd_contentTitle").val();
    	var sd_content=$('.wsd_content').val();
		var sdImg=$('.wsd_rightImg').size()-1;
		
    	if(sd_title=='')
    	{
    		alert('标题不能为空');
    		return false;
    	}
    	if(sd_content=='')
    	{
    		alert('内容不能为空');
    		return false;
    	}
		if(sdImg < 3)
		{
		  alert('晒单的图片是不是少于三张了呢~');
		  return false;
		}
		if(sdImg >9)
		{
		  alert('晒单的图片是不是大于九张了呢~');
		  return false;
		}
    	
    }
