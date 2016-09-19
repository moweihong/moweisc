 $(function(){
   	    $.post("/user/security/getUserByjava", {},
	       function(data){
		       data=eval( '('+data+')');
		      
		       if(data.code!=0)
		       {
			     //alert('用户信息不存在');
		       }
		       else
		       {
		       	
		       	 $("#hideMobile").html(data.resultText.user_phone);
		       	 $("#updateHideMobile").html(data.resultText.user_phone);
		       	 $("#bindEmailHideMobile").html(data.resultText.user_phone);
		       	 
		       	 
		       	 $("#username").val(data.resultText.user_name);
		       	 
		       	 if(typeof(data.resultText.user_email) != "undefined")
		       	 {
		       	 
		       	 	$("#emailval").html(data.resultText.user_email);
		       	   // $("#emailval").prev().html('已设置');
		       	    $("#emailval").prev().html('已设置');
					$("#emailval").prev().addClass('c_save_state_other');
		       	    $("#emailval").next().children().html('修改');
		       	    $("#emailStatus").html('立即修改');
		       	    $("#updateMobileHideEmail").html(data.resultText.user_email);
		       	    
		       	    var level=$('#level').html();
		       
		       	    if(level=='完善')
		       	    {
		       	    	$('#rankWith').css('width','264px');
		       	    	$('#rank').text('高');
		       	    	
		       	    }
		       	    else
		       	    {
		       	    	$('#rankWith').css('width','183px');
		       	    	$('#rank').text('中');
		       	    }
	
		       	    
		       	 }
		       	 else
		       	 {
		       	 	$('#rankWith').css('width','122px');
		       	 	$('#rank').text('中');
		       	 }
		       	
		       	 
		       	
			    }
	       
	       })
 	      
	//修改昵称
        $('#updateName').click(function(){
		    $('#userName2').show();
		       
        })
		    
		$('.nameOk').click(function(){  
		   //var nickname=$(this).prev().val();
		   var nickname=$('#nickname').val();
		   var sex=$('#sexselect option:selected').text();
		   var birthday=$('#birthday').val();
		   var now_address=$('#now_address').val();
		   var home_address=$('#home_address').val();
		   var salary=$('#salary').val();
		  
		   if(nickname=='')
		   {
		   	 alert('昵称不能为空');
		   	 return false;
		   }
		    var myreg = /^(19|20)\d{2}-(1[0-2]|0?[1-9])-(0?[1-9]|[1-2][0-9]|3[0-1])$/; 
			if(!myreg.test(birthday))
			{ 
			    alert('生日格式不对哦！如：1993-08-08'); 
			    return false; 
			} 
		   if(isNaN(salary)){
				alert('月收入必须是数字！');
		   	    return false;
		   }
//		   if(now_address=='')
//		   {
//		   	 alert('请写下现在居住的地址咯');
//		   	 return false;
//		   }
//		   if(home_address=='')
//		   {
//		   	 alert('请写下家乡的地址咯');
//		   	 return false;
//		   }
		    
//		   headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
		   $.post("/user/security/updateNickname", 
		   { 'sex': sex,'nickname':nickname,'birthday':birthday,'now_address':now_address,'home_address':home_address,'salary':salary},
	       function(data){
	       	 data=eval( "(" + data + ")" );
	       	 if(data.code==0)
	       	 {
	       	 	layer.msg(data.message);
	       	 	$('#updateName').parent().prev().html(nickname);
				$('#updateName').parent().prev().prev().html('完善');
			    $('#userName2').hide();
	       	 }
	       	 else
	       	 {
	       	 	layer.msg(data.message);
	       	 	return false;
	       	 }
		     
	       
	       })
			
	    })
	   //修改密码流程
		$('#updatePassword0').click(function(){//修改
		  $('.c_appearPw').show();
		});
		$('#updatePassword').click(function(){//修改密码
		    var uid=$("#uid").val();
		    var oldpass=$("#passwordOld").val();
			var newpass=$("#newpassword").val();
			var repass=$("#repassword").val();
			var username=$("#username").val();
			if(oldpass=='' || newpass=='' || repass=='' || newpass.length<6 || repass.length<6)
			{
				layer.msg('密码不能为空以及不小于6位');
				return false;
			}
			
			if(newpass.length>16 || repass.length>16)
			{
				layer.msg('密码不能为空以及不大于16位');
				return false;
			}
			
			if(newpass!=repass)
			{
				layer.msg('确认密码不一致');
				//alert('确认密码不一致');
				return false;
			}
			$.post("/user/security/updatePassWord", { 'oldpass': oldpass,'newpass':newpass,'repass':repass,'username':username,'uid':uid},
	        function(data){
	       	 data=eval( "(" + data + ")" );
		     //alert(data.code);
		     if(data.code!=0)
		     {
		     	
		     	layer.msg(data.resultText);
		     	return false;
		     }
		     else
		     {
		     	$('.c_appearPw').hide();
		     	$('#changePasswordSuccess').show();
		     }
	       
	       })
			
		   
		})
		$('.c_rechange_a').click(function(){//确定
			
		   $('#changePasswordSuccess').hide();
		});
		
	 
	 //邮箱绑定流程
		$('#bangding').click(function(){//绑定
		  $('.email_one').show();
		});
		//获取邮箱绑定验证码发送手机的
		$("#getEmailCodePhone").click(function(){
	    	var phone=$("#bindEmailHideMobile").html();
	    	
	    	$.post("/user/security/getSmsCode",{'phone':phone,'type':2},function(data){
	    		data=eval( '('+data+')');
	    		if(data.code!=0)
		   	   	{
		   	   	  layer.msg(data.resultText);
		   	   	}
	    		
	    	})
	    	
	    })
		//获取邮箱绑定验证码发送邮箱的
		$("#getEmailCode").click(function(){
	    	var phone=$("#bindMail").val();
	    	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    	if (!filter.test(phone))
			{
				layer.msg('您的电子邮件格式不正确');
				return false;
			}
	    	$.post("/user/security/getSmsCode",{'phone':phone,'type':3},function(data){
	    		//alert(data);updateMobileOldVerifyCode
	    		console.log(data);
	    	})
	    	
	    })
		$('.c_emails_step1').click(function(){//下一步
		   //验证短信验证码正确进入下步
	   	   var code=$('#bindEmailMobileValidCode').val();
	   	   if(code=='')
	   	   {
	   	   	   alert('验证码不能为空');
	   	   	   return false;
	   	   }
	   	   $.post("/user/security/submitSmsCode",{'code':code,'type':2},function(data){
	   	   	  data=eval( '('+data+')');
	   	   	
	   	   	  if(data.code!=0)
	   	   	  {
	   	   	  	alert(data.message);
	   	   	  }
	   	   	  else
	   	   	  {
			   $('.email_one').hide();
			   $('.email_two').show();
			  }
	   	   	})
		})
		
		$('.c_emails_step2').click(function(){//邮箱获取验证码的下一步
		   
		   var code=$('#bindEValidCode').val();
	   	   if(code=='')
	   	   {
	   	   	   alert('验证码不能为空');
	   	   	   return false;
	   	   }
	   	   $.post("/user/security/submitSmsCode",{'code':code,'type':3},function(data){
	   	   	  data=eval( '('+data+')');
	   	   	
	   	   	  if(data.code!=0)
	   	   	  {
	   	   	  	alert(data.message);
	   	   	  }
	   	   	  else
	   	   	  {
	   	   	  	 //验证码正确开始修改绑定邮箱
	   	   	  	   var email=$("#bindMail").val();
	   	   	  	   var uid=$("#uid").val();
	   	   	  	   $.post('/user/security/updateUserEmail',{'email':email},function(result){
	   	   	  	   	   result=eval( '('+result+')');
	   	   	  	   	   //alert(result);
	   	   	  	   	   if(result.code!=0)
	   	   	  	   	   {
	   	   	  	   	   		layer.msg('修改失败');
	   	   	  	   	   		return false;
	   	   	  	   	   }
	   	   	  	   	   else
	   	   	  	   	   {
	   	   	  	   	   	    var email=$("#bindMail").val();
	   	   	  	   	   		$("#emailval").text(email);
	   	   	  	   	   		$("#emailval").prev().html('已设置');
							$("#emailval").prev().addClass('c_save_state_other');
	   	   	  	   	   		$('.email_two').hide();
		                    $('#bindEmialSuccess').show();
	   	   	  	   	   }
	   	   	  	   })
	   	   	  	  
			  }
	   	   	  
	   	   	  
	   	   	})
		  
		})
		$('.bindEmailSuccessTip').click(function(){//确定
		   $('#bindEmialSuccess').hide();
		});
	//修改手机号流程 
	   $('#updateIphone').click(function(){//修改  
	      $('.updateIphoneAll').show();
	   });
	   $('.c_find_way_phone').click(function(){//手机号码立即修改 进入验证手机号
	      $('.updateIphoneAll').hide();
		  $('.c_phone_one').show();
	   })
	   //获取短信验证码旧手机
	    $("#updateMobileOldVerifyCode").click(function(){
	    	var phone=$("#updateHideMobile").html();
	    	$.post("/user/security/getSmsCode",{'phone':phone,'type':1},function(data){
	    		//alert(data);updateMobileOldVerifyCode
	    		data=eval( '('+data+')');
	    		if(data.code!=0)
		   	   	{
		   	   	  layer.msg(data.resultText);
		   	   	}
	    	})
	    	
	    })
	   $('#emailStatus').click(function(){//绑定邮箱修改 进入验证手机号
	   	  var val=$("#emailStatus").html();
	   	  if(val=='未绑定')
	   	  {
	   	  	alert('请先去绑定邮箱');
	   	  	return false;
	   	  }
		  $('.updateIphoneAll').hide();
		  $('.Iemail_one').show();
	   })
	   
	   //获取邮箱验证码emailCode
	   $("#emailCode").click(function(){
	    	var phone=$("#updateMobileHideEmail").html();
	    	$.post("/user/security/getSmsCode",{'phone':phone,'type':4},function(data){
	    		//alert(data);updateMobileOldVerifyCode
	    	})
	    	
	    })
	   $('.c_mail_step2').click(function(){//绑定邮箱下一步 进入到输入新手机号
	   	  
		  $('.c_rechange_password').hide();
		  $('#updMobileNewMobileVerify').show();
	   })
	   $('.c_iphone_next').click(function(){//验证手机号  下一步  进入到输入新手机号
	   	   //验证短信验证码正确进入下步
	   	   var code=$('#updMobileoldMvalidCode').val();
	   	   if(code=='')
	   	   {
	   	   	   alert('验证码不能为空');
	   	   	   return false;
	   	   }
	   	  
	   	   $.post("/user/security/submitSmsCode",{'code':code,'type':1},function(data){
	   	   	  data=eval( '('+data+')');
	   	   	
	   	   	  if(data.code!=0)
	   	   	  {
	   	   	  	alert(data.message);
	   	   	  }
	   	   	  else
	   	   	  {
	   	   	  	 $('.c_phone_one').hide();
				 $('.Iemail_one').hide();
				 $('#updMobileNewMobileVerify').show();
	   	   	  }
	   	   })
		  
	   })
	   
	   //新手机获取验证码
	    $(".updMobileGetNewMobileCode").click(function(){
	    	//alert(1);
	    	var phone=$("#newMobile").val();
	    	$.post("/user/security/getSmsCodeNewPhone",{'phone':phone},function(data){
	    		//alert(data);updateMobileOldVerifyCode
	    	})
	    	
	    })
	    
	   $('.Iemail_next1').click(function(){//邮箱验证手机号 
	   	   //验证邮箱发送的验证码是否正确
	   	   code=$("#updMobileoldEvalidCode").val();
	   	   if(code=="")
	   	   {
	   	   	 alert('验证码不可为空');
	   	   	 return false;
	   	   }
	   	   $.post("/user/security/submitSmsCode",{'code':code,'type':4},function(data){
	   	   	  data=eval( '('+data+')');
	   	   	
	   	   	  if(data.code!=0)
	   	   	  {
	   	   	  	alert(data.message);
	   	   	  }
	   	   	  else
	   	   	  {
	   	   	  	   $('.Iemail_one').hide();
				   $('.c_phone_one').hide();
			       $('#updMobileNewMobileVerify').show();
	   	   	  }
	   	   })
	   	   
		  
	   })
	   $('.c_iphone_next2').click(function(){//输入新手机号
	   	   //验证码正确否进入下一步
	   	   var code=$("#newMvalidCode").val();
	   	   
	   	   $.post("/user/security/submitSmsCodeNewPhone",{'code':code},function(data){
	   	   	  data=eval( '('+data+')');
	   	   	
	   	   	  if(data.code!=0)
	   	   	  {
	   	   	  	   alert(data.message);
	   	   	  }
	   	   	  else
	   	   	  {
	   	   	  	   //验证码正确开始修改绑定手机
	   	   	  	   var phone=$("#newMobile").val();
	   	   	  	   var uid=$("#uid").val();
	   	   	  	   $.post('/user/security/updateUserPhone',{'phone':phone,'uid':uid},function(result){
	   	   	  	   	   result=eval( '('+result+')');
	   	   	  	   	   //alert(result);
	   	   	  	   	   if(result.code!=0)
	   	   	  	   	   {
	   	   	  	   	   		layer.msg('修改失败');
	   	   	  	   	   		return false;
	   	   	  	   	   }
	   	   	  	   	   else
	   	   	  	   	   {
	   	   	  	   	   		$("#hideMobile").html(phone);
	   	   	  	   	   		$('#updMobileNewMobileVerify').hide();
			                $('#updMobileSuccess').show();
	   	   	  	   	   }
	   	   	  	   })
	   	   	  	
			       
			  }
	   	   	})
	   })
	   $('.c_rechange_a').click(function(){//确定
		$('#updMobileSuccess').hide();
	   });
  //js2
   })
 
