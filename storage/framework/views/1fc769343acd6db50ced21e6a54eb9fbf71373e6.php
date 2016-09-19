<?php /*个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件*/ ?>

<?php $__env->startSection('title',''); ?>
<?php $__env->startSection('content_right'); ?>
<script src="<?php echo e($url_prefix); ?>/js/user_security.js"></script>
<script src="<?php echo e($url_prefix); ?>/js/user_history.js"></script>

<div id="member_right" class="member_right">
    			<div class="c_address_top c_save_top">
    				<input type="hidden" id='username' value="">
    				<input type="hidden" id='uid' value="-1" /> 
    				保护账户安全 
                    <b>您的安全等级：</b>    
                    <em><i id="rankWith" style="width: 246px;"></i></em>  
                    <tt id="rank" style="margin-left: 4px;"></tt>
    			</div>
                <div class="c_set_save">
					<!-- 
                    	date:2016.03.09
                    	修改个人资料 
                    -->
                    <ul class="c_set_save_box">
                        <li class="c_save_password">个人资料：</li>
                        <li class="c_save_tips">完善您的个人资料，可以领取丰厚的奖励哦。</li>
                       
                        	<?php if(empty($userinfo->nickname) || empty($userinfo->sex) ): ?>
                        	<li id='level' class="c_save_state">未完善</li>
                        	<?php else: ?>
                        	<li id='level' class="c_save_state_other c_save_state">完善</li>
                        	<?php endif; ?>
                       
                        <li class="c_save_num">
                        	<?php echo e(isset($userinfo->nickname) ? $userinfo->nickname : '--'); ?>

                        </li>
                        <li class="c_save_rechange"><a href="javascript:void(0);" id="updateName">修改</a></li>
                        <div class="c_clear"></div>
                       
                        <!--S 修改个人资料 -->
                        <div id="userName2" class="c_rechange_password c_appear " style="">
                            <div class="c_rechange_doing" style="position:relative">
                                    <label>当前昵称：</label>
                                <input id="nickname" type="text" value="<?php echo e($userinfo->nickname); ?>" maxlength="8">
                                    <label>性别：</label>
                                    <select id="sexselect" name="sex">
                                    	<option value="男" <?php if($userinfo->sex=='男'){?> selected='selected' <?php }?> >男</option>
                                    	<option value="女" <?php if($userinfo->sex=='女'){?> selected='selected' <?php }?> >女</option>
                                    </select><br/>
                          
                                    <label>生日：</label>
                                <input id="birthday" type="text" value="<?php echo e($userinfo->birthday); ?>" maxlength="20">
                                	<label>现居地：</label>
                                <input id="now_address" type="text" value="<?php echo e($userinfo->now_address); ?>" maxlength="20">
                                	<label>家乡：</label>
                                <input id="home_address" type="text" value="<?php echo e($userinfo->home_address); ?>" maxlength="20">
                                	<label>月收入：</label>
                                <input id="salary" type="text" value="<?php echo e($userinfo->salary); ?>" maxlength="8">
								 <a href="javascript:void(0);" class=" c_success_btn nameOk" style="margin-top:16px">确定</a>
                            </div>
                        </div>
                       <!--  修改成功
                        <div  class="c_rechange_password c_success">
                            <div class="c_rechange_doing">
                                <span>密码修改成功</span>
                                <a href="javascript:void(0);" class=" c_success_btn nameOk">确定</a>
                            </div>
                        </div> -->
                        <!--E 修改密码 -->                   
                    </ul>
				    <!-- 
                    	date:2016.03.09
                    	修改密码 
                    -->
                    <ul class="c_set_save_box">
                        <li class="c_save_password">登录密码：</li>
                        <li class="c_save_tips">保障账户安全，建议您定期更换密码。</li>
                        <li class="c_save_state c_save_state_other">已设置</li>
                        <li class="c_save_num">--</li>
                        <li class="c_save_rechange"><a href="javascript:void(0);" id="updatePassword0">修改</a></li>
                        <div class="c_clear"></div>
                        <!--S 修改密码 -->
                        <div class="c_rechange_password c_appear c_appearPw" style="">
                            <div class="c_rechange_doing" style="position:relative">
                                <label>当前密码：</label>
                                <input name="password" type="password" id="passwordOld" maxlength="16">
                            </div>
                            <div class="c_rechange_doing">
                                <label>设置新密码：</label>
                                <input name="password" type="password" id="newpassword" maxlength="16">
                            </div>
                            <div class="c_rechange_doing">
                                <label>确认新密码：</label>
                                <input name="password" type="password" id="repassword" maxlength="16">
                            </div>
                            <div class="c_rechange_doing">
                                <a href="javascript:void(0);" id="updatePassword" class="c_rechange_ture c_success_rechange">修改密码</a>
                            </div>
                        </div>
                        <!-- 修改成功 -->
                        <div id="changePasswordSuccess" class="c_rechange_password c_success">
                            <div class="c_rechange_doing">
                                <span>密码修改成功</span>
                                <a href="javascript:void(0);" class="c_rechange_a c_success_btn">确定</a>
                            </div>
                        </div>
                        <!--E 修改密码 -->                   
                    </ul>
                    
                    <!-- 
                    	date:2016.03.09
                    	修改手机号 
                    -->
                    <ul class="c_set_save_box">
                        <li class="c_save_password">手机号码：</li>
                        <li class="c_save_tips">保护账户与资金安全，是您在一块购重要的身份凭证。</li>
                        <li class="c_save_state c_save_state_other">已设置</li>
                        <li class="c_save_num" id="hideMobile">--</li>
                        <li class="c_save_rechange" ><a href="javascript:void(0);" id="updateIphone">修改</a></li>
                        <div class="c_clear"></div>
                        <!--S修改手机号 -->
                        <!--S选择修改方式-->
                        <div class="c_rechange_password c_appear updateIphoneAll" style="">
                            <div class="c_find_way">
                                <div>
                                    <p>通过手机号码修改</p>
                                    <div class="c_img_box">
                                        <img src="/foreground/img/save_icon1.png">
                                    </div>
                                    <a href="javascript:void(0);" class="c_find_way_phone" id=>立即修改</a>
                                </div>
                                <div>
                                    <p>通过电子邮箱修改</p>
                                    <div class="c_img_box">
                                        <img src="/foreground/img/save_icon2.png">
                                    </div>
                                    <a href="javascript:void(0);" id="emailStatus" class="c_newadd_color">未绑定</a>
                                </div>
                            </div>
                            <div class="c_clear"></div>
                        </div>
                        <!--E选择修改方式-->
                        
                        <!--S 手机修改 -->
                        <!-- 第一步 -->
                        <div class="c_rechange_password c_phone_newway_one c_phone_one">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm">1.验证原手机号码</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.输入新手机号码</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <!--<div>
                                        <label>图形验证码：</label>
                                        <input type="text" id="updateMobileImgVerifyCode" maxlength="6" value="">
                                        <span>
                                        	<img src="/member/validCode.do" class="img_click" onclick="this.src='/member/validCode.do?t=' + Math.random();" width="121" height="31">
                                        </span>
                                    </div>-->
                                    <div>
                                        <label>手机号：</label>
                                        <em id="updateHideMobile"></em>
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input type="text" maxlength="6" id="updMobileoldMvalidCode" value="">
                                        <i class="c_get_verify c_get_verify_one" id="updateMobileOldVerifyCode">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_add_next c_add_rechange c_step1_update_mobile_valide c_iphone_next">下一步</a>
                                </div>
                            </div>
                        </div>
                        <!-- 第二步 -->
                        <div id="updMobileNewMobileVerify" class="c_rechange_password c_phone_newway_two c_email_newway_two">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm c_new_sm">1.验证原手机号码</dd>
                                    </dl>
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.输入新手机号码</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <!--<div>
                                        <label>图形验证码：</label>
                                        <input type="text" id="updateMobileStep2ImgVerifyCode" value="">
                                        <span><img id="step2Img" src="/member/validCode.do" class="img_click" onclick="this.src='/member/validCode.do?t=' + Math.random();" width="121" height="31/"></span>
                                    </div>-->
                                    <div>
                                        <label>输入新手机号：</label>
                                        <input type="text" id="newMobile" maxlength="11" style="width:205px;">
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input type="text" id="newMvalidCode" maxlength="8" value="">
                                        <i class="c_get_verify c_get_verify_one updMobileGetNewMobileCode">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_next_steps c_step2 c_iphone_next2">下一步</a>
                                </div>
                            </div>
                        </div>
                        <!-- 重置成功 -->
                        <div id="updMobileSuccess" class="c_rechange_password c_phone_newway_success">
                            <div class="c_rechange_doing">
                                <span>手机号修改成功</span>
                                <a href="javascript:void(0);" class="c_rechange_a c_success_btn">确定</a>
                            </div>
                        </div>
                        <!--E 手机修改 -->
                        <!--S 邮箱修改 -->
                        <!-- 第一步 -->
                        <div class="c_rechange_password c_email_newway_one Iemail_one">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm">1.验证电子邮箱</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.输入新手机号码</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <div>
                                        <label>电子邮箱：</label><em id="updateMobileHideEmail"></em>
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input type="text" maxlength="6" id="updMobileoldEvalidCode">
                                        <i id='emailCode' class="c_get_verify c_get_verify_one c_valid1_update_mobile_email_valid_code">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_emails_next_step1 c_rechange_text c_step1_update_email_valide Iemail_next1 ">下一步</a>
                                </div>
                            </div>
                        </div>
                        <!--E 邮箱修改 -->
                        <!--E 修改手机号 -->
                    </ul>
                    
		            <!-- 
		            	date:2016.03.09
		            	绑定邮箱
		             -->        
                    <ul class="c_set_save_box" id="bindEmailView">
                        <li class="c_save_password">电子邮箱：</li>
                        <li class="c_save_tips">邮件接收账户通知，及时了解账户信息变动情况。</li>
                        <li class="c_save_state">未绑定</li>
                        <li class="c_save_num" id="emailval">--</li>
                        <li class="c_save_rechange"><a href="javascript:void(0);" id="bangding">绑定</a></li>
                        <div class="c_clear"></div>
                        <!--S 绑定邮箱 -->
                        <!-- 第一步 -->
                        <div class="c_rechange_password c_appear c_email_newway_one email_one" style="display: none;">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm">1.验证身份</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.绑定邮箱</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <div>
                                        <!--<label>图形验证码：</label>
                                        <input type="text" id="bindEmailImgCode" maxlength="6" value="">
                                        <span>
                                        <img src="/member/validCode.do?t=0.35444211843423545" class="img_click" onclick="this.src='/member/validCode.do?t=' + Math.random();" width="121" height="31/">
                                        </span>-->
                                    </div>
                                    <div>
                                        <label>手机号：</label><em id="bindEmailHideMobile"></em>
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input type="text" id="bindEmailMobileValidCode" maxlength="8" value="">
                                        <i  id="getEmailCodePhone" class="c_get_verify c_get_verify_one c_bind_email_one_mobile_valid1">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_emails_next_step1 c_bind_email_mobile_next c_emails_step1">下一步</a>
                                </div>
                            </div>
                        </div>
                        <!-- 第二步 -->
                        <div id="bindEmialStep2" class="c_rechange_password c_email_newway_two email_two">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm">1.验证身份</dd>
                                    </dl>
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.绑定邮箱</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <div>
                                        <label>电子邮箱：</label>
                                        <input type="text" id="bindMail" style="width:205px;">
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input maxlength="8" type="text" id="bindEValidCode" value="">
                                        <i id="getEmailCode" class="c_get_verify c_get_verify_one c_valid3">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_emails_next_step2 c_bind1 c_emails_step2">下一步</a>
                                </div>
                            </div>
                        </div>
                        <!-- 邮箱认证成功 -->
                        <div id="bindEmialSuccess" class="c_rechange_password c_email_newway_success ">
                            <div class="c_rechange_doing">
                                <span>邮箱认证成功</span>
                                <a href="javascript:void(0);" class="c_rechange_a c_success_btn bindEmailSuccessTip">确定</a>
                            </div>
                        </div>
                        <!--E 绑定邮箱 -->
                       </ul>
                    <ul class="c_set_save_box">
                        <li class="c_save_password">微信绑定：</li>
                        <li class="c_save_tips">绑定微信，可用微信帐号直接登录一块购。</li>
                        <?php if(empty($userinfo->wx_unionid)): ?>
                            <li class="c_save_state">未绑定</li>
                            <li class="c_save_num">--</li>
                            <li class="c_save_rechange"><a href="javascript:void(0);" id="wx_bind">绑定</a></li>
                        <?php else: ?>
                            <li class="c_save_state c_save_state_other">已绑定</li>
                            <li class="c_save_num">--</li>
                            <li class="c_save_rechange"><a href="javascript:void(0);" id="unbind">解绑</a></li>
                        <?php endif; ?>
                        <div class="c_clear"></div>
                        <div id="wx_photo" style="text-align:center; display: none;">
                        </div>

                        <!--E 修改密码 -->                   
                    </ul>
                    <ul class="c_set_save_box">
                        <li class="c_save_password">QQ号码：</li>
                        <li class="c_save_tips">绑定QQ号码，可用QQ帐号直接登录一块购。</li>
                        <?php if(empty($userinfo->qq_openid)): ?>
                            <li class="c_save_state">未绑定</li>
                            <li class="c_save_num">--</li>
                            <li class="c_save_rechange"><a href="<?php echo e($qq_login_url); ?>" >绑定</a></li>
                        <?php else: ?>
                            <li class="c_save_state c_save_state_other">已绑定</li>
                            <li class="c_save_num">--</li>
                            <li class="c_save_rechange"><a href="javascript:void(0);" id="qq_unbind">解绑</a></li>
                        <?php endif; ?>
                        <div class="c_clear"></div>
                        <div id="TencentLogin" style="text-align:center; display: none;"></div>
                        <!--E 修改密码 -->                   
                    </ul>
                     
			            <!-- 
			            	date:2016.03.09
			            	修改邮箱
			            -->       
                        <!--S 修改邮箱 -->
                        <!-- 第一步 -->
                        <ul class="c_set_save_box" id="updateEmailView" style="display: none;">	                   
		                    <li class="c_save_password">电子邮箱：</li>
	                        <li class="c_save_tips">邮件接收账户通知，及时了解账户信息变动情况。</li>
	                        <li class="c_save_state c_save_state_other">已设置</li>
	                        <li class="c_save_num" id="updateEmailHideEmailView">--</li>
	                        <li class="c_save_rechange"><a href="javascript:void(0);">修改</a></li>
	                        <div class="c_clear"></div>
                        <!-- 第二步 -->
						<div id="updateMailStep1" class="c_rechange_password c_appear c_email_newway_one" style="">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm">1.验证原电子邮箱</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.输入新电子邮箱</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <div>
                                        <label>电子邮箱：</label>
                                        <em id="updateEmailHideMail"></em>
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input type="text" id="updEmailoldEvalidCode">
                                        <i class="c_get_verify c_get_verify_one c_valid4_update_email_email_valid_code">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_emails_next_step1 c_mail_step1_update_email_validCode emails_next">下一步</a>
                                </div>
                            </div>
                        </div>
						<!-- 第三步 -->
                        <div id="updateMailStep2" class="c_rechange_password c_email_newway_two">
                            <div class="c_phone_way">
                                <div class="c_steps">
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>1</span></dd>
                                        <dd class="c_sm">1.验证原电子邮箱</dd>
                                    </dl>
                                    <dl class="c_active">
                                        <dd class="c_sz"><span>2</span></dd>
                                        <dd class="c_sm">2.输入新电子邮箱</dd>
                                    </dl>
                                    <dl>
                                        <dd class="c_sz"><span>3</span></dd>
                                        <dd class="c_sm">3.完成</dd>
                                    </dl>
                                </div>
                                <div class="c_phone_verify">
                                    <div>
                                        <label>电子邮箱：</label>
                                        <input type="text" id="newEmail" style="width:205px;">
                                    </div>
                                    <div>
                                        <label>验证码：</label>
                                        <input maxlength="6" type="text" id="newEvalidCode" value="">
                                        <i class="c_get_verify c_get_verify_one c_valid5">获取验证码</i>
                                    </div>
                                    <a href="javascript:void(0);" class="c_emails_next_step2 c_mail_step2" >下一步</a>
                                </div>
                            </div>
                        </div> 
                        <!-- 邮箱修改成功 -->
                         <div id="updateEmailSuccess" class="c_rechange_password c_email_newway_success ">
                            <div class="c_rechange_doing">
                                <span>邮箱修改成功</span>
                                <a href="javascript:void(0);" class="c_rechange_a c_success_btn">确定</a>
                            </div>
                        </div> 
                        <!--E 修改邮箱 -->
                    </ul> 
                        <!--E 登录保护
                    </ul>
                    -->
                </div>
			</div>
			<!-- E 右侧 -->
<script src="<?php echo e(asset('foreground/js/layer/layer.js')); ?>"></script>
<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script>
    var wx_error = "<?php echo e(session('wx_error')); ?>";
    if(wx_error != null && wx_error != ''){
        layer.msg(wx_error);
    }
    
    $("#wx_bind").click(function(){
        $("#wx_photo").show();
    });
    //微信解绑
    $("#unbind").click(function(){
        layer.open({
            content: '您是否确定解绑？',
            btn: ['确认', '取消'],
            shadeClose: false,
            yes: function(){
                $.ajax({
                   type: "post",
                   url: "/user/wx_unbind",
                   dataType:'json',
                   data:{
                      state : "<?php echo e($state); ?>",
                      _token : "<?php echo e(csrf_token()); ?>"
                   },
                   success:function(data){
                      if(data.status == 1){
                          layer.msg(data.msg);
                          window.location.reload();
                      }else{
                          layer.msg(data.msg);
                      }
                   }
                }); 
            }, no: function(){
               layer.open({content: '你取消了！', time: 1});
            }
        });
    });
    //qq解绑
    $("#qq_unbind").click(function(){
        layer.open({
            content: '您是否确定解绑？',
            btn: ['确认', '取消'],
            shadeClose: false,
            yes: function(){
                $.ajax({
                   type: "post",
                   url: "/user/qq_unbind",
                   dataType:'json',
                   data:{
                      state : "<?php echo e($state); ?>",
                      _token : "<?php echo e(csrf_token()); ?>"
                   },
                   success:function(data){
                      if(data.status == 1){
                          layer.msg(data.msg);
                          window.location.reload();
                      }else{
                          layer.msg(data.msg);
                      }
                   }
                }); 
            }, no: function(){
               layer.open({content: '你取消了！', time: 1});
            }
        });
    });
    
    var obj = new WxLogin({

        id:"wx_photo", 

        appid: "<?php echo e(config('global.weixin.AppID')); ?>",

        scope: "snsapi_login", 

        redirect_uri: "<?php echo e($redirect_uri); ?>",

        state: "<?php echo e($state); ?>",

        style: "",

        href: ""
      });
      
//    function qqBind(){
//      //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
//      //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
//        var A=window.open("","qq","width=450,height=320,left=450,top=450,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
//    }
    

</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('foreground.user_center', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>