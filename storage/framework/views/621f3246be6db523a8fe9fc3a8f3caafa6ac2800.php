<?php /*个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件*/ ?>

<?php $__env->startSection('title','收货地址'); ?>
<?php $__env->startSection('my_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/users_question.css">
    <style type="text/css">
    /*.info select{ border:1px #993300 solid; background:#FFFFFF;}
	.info{ margin:5px; text-align:center;}
	.info #show{ color:#3399FF; }*/
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_right'); ?>
    <div id="member_right" class="member_right">
        <!--address start-->
        <div class="my-address">
            <div class="c_address_top"><span></span>已保存<?php echo e(count($address)); ?>条地址</div>
            <!--列表 start-->
            <div class="c_address clearfix">
            <?php foreach($address as $row): ?>
                <div class="c_address_detail c_new_address_detail">
                    <p class="c_p_bg"></p>
                    <div class="c_address_operation">
                    	<?php if($row->default){?>
                        <div class="c_address_default"><i></i>默认地址</div>
                        <?php }?>
                        <div class="c_address_all_operation updateAddress" data-id='<?php echo e($row->id); ?>' 
                        	 data-province='<?php echo e($row->province); ?>' data-city='<?php echo e($row->city); ?>' data-country='<?php echo e($row->country); ?>'
                        	 data-area='<?php echo e($row->area); ?>' data-receiver='<?php echo e($row->receiver); ?>' data-mobile='<?php echo e($row->mobile); ?>'
                        data-qqnum='<?php echo e($row->notice); ?>'>
                            <i   title="编辑" class="c_set_edit " style="cursor: pointer"></i>
                        </div >
                        <div  >
                        	 <i  data-id='<?php echo e($row->id); ?>' title="删除" class="c_set_esc deleteAddress" style="cursor: pointer"></i>
                        </div>
                    </div>
                    <div class="c_user_address"><p class="c_user_message">收 货 人 ：<?php echo e($row->receiver); ?></p>
						  <p class="">收货号码：<?php echo e($row->mobile); ?></p>
                    	  <p title="">收货地区：<?php echo e($row->province); ?>   <?php echo e($row->city); ?>  <?php echo e($row->country); ?></p>
                    	  <p title="">收货地址：<?php echo e($row->area); ?></p>
                    	  <p title="">备注：<?php echo e($row->notice); ?></p>
                    </div>
                    <span></span>
                    <?php if($orderid != null): ?>
                    <div class="c_packet_name" title="选择为发货地址">
                        <a href="javascript::void(0);" onclick="saveOrderAddr(<?php echo e($row->id); ?>,<?php echo e($orderid); ?>)">使用</a>
                    </div> 
                    <?php endif; ?>
                </div>
             <?php endforeach; ?>  
                
                
                
                <div class="c_add_address c_new_address_detail"><a href="javascript:void(0);" class="c_add_address_btn pop_open"><i></i>增加新地址</a></div>
            </div>
            
            
            <!--列表 end-->
        </div>
        <!--address end-->
    </div>
    <!-- E 右侧 -->
    <!--新增地址 start-->
    <div class="popup">
        <div class="popup_main popup_address">
            <h3>收货地址<em class="c_em_close pop_close"></em></h3>
            <div class="c_address">
                <div class="c_form_con">
                    <label>收货人姓名：</label>
                    <div class="c_form_right">
                        <input class="c_khname" type="text" placeholder="请输入真实姓名" maxlength="20">
                        <p class="c_error">请输入真实姓名</p>
                    </div>
                    <div class="c_clear"></div>
                </div>

                <div class="c_form_con">
                    <label>收货人地区：</label>
                    <ul class="c_form_right">
                        <div class="info">
                        <div class="add_select">
							<select id="s_province" name="s_province"></select>  
						    <select id="s_city" name="s_city" ></select>  
						    <select id="s_county" name="s_county"></select>
						    <script type="text/javascript">_init_area();</script>
						</div>
						<div id="show"></div>
						<div class="info">
                    </ul>
                    <div class="c_clear"></div>
                </div>
                <div class="c_form_con">
                    <label>收货人地址：</label>
                    <div class="c_form_right"><div class="c_address_infor" id="addStr" style="display: none;">广东省  深圳市  罗湖区</div>
                        <input class="c_details_address" type="text" placeholder="请输入正确收货人地址" maxlength="50">
                        <p class="c_error">请输入正确收货人地址</p>
                    </div>
                    <div class="c_clear"></div>
                </div>
                <div class="c_form_con">
                    <label>收货人手机：</label>
                    <div class="c_form_right">
                        <input class="c_details_contact mobilenum" type="text" placeholder="请输入收货人手机号" maxlength="11">
                        <p class="c_error" id="errorMobileMsg">请输入收货人手机号</p>
                        <span style="color:#555;font-size:14px;margin-left:20px;">（注：此手机号可作为话费卡充值号码）</span>
                    </div>
                    <div class="c_clear"></div>
                </div>
                 <div class="c_form_con">
                    <label>备注：</label>
                    <div class="c_form_right">
                        <input class="c_details_contact qqnum"  type="text" placeholder="" maxlength="11">
                        <p class="c_error" id="errorMobileMsg"></p>
                        <span style="color:#555;font-size:14px;margin-left:225px;">（列：充值qq的号码为123456）</span>
                    </div>
                    <div class="c_clear"></div>
                </div>
                <div class="c_form_con" id="isdefaultDiv" style="display: block;">
                    <div class="c_new_form_right">
                        <input type="checkbox" id="isdefault">
                        <input type="hidden" value="0" id='addressid'>
                        <input type="hidden" value="<?php echo e($userid); ?>" id='userid'>
                        <i>设为默认地址</i>
                    </div>
                </div>
                <div class="c_form_con">
                    <button class="c_save" id="saveAddress">保存</button><button class="c_save_other pop_close">取消</button>
                </div>
            </div>
        </div>
        <div class="popupbg"></div>
    </div>
    <!--新增地址 end-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('myt_js'); ?>
	<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/area.js"></script>
	<script type="text/javascript">
		var Gid  = document.getElementById ;
		var showArea = function(){
			Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" + 	
			Gid('s_city').value + " - 县/区" + 
			Gid('s_county').value + "</h3>"
								};
		//Gid('s_county').setAttribute('onchange','showArea()');
</script>

    <script>
        $(function(){
            //获取窗口高度
            var h = document.body.clientHeight;
            $(".popup").height(h);
            //打开弹出窗
            $(".pop_open").click(function(){
                $(".popup").fadeIn(300);
                $(".popup_address").slideDown(400);
            })
            //关闭弹出窗
            $(".popup .pop_close").click(function(){
                $(this).parents(".popup_address").slideUp(300);
                $(this).parents(".popup").fadeOut(400);
                $("#addressid").val(0);
            })
            //发送获取验证码倒计时
            var wait= 59;
            var yzmobj = $(".c_veri_code");
            $(".c_veri_code").click(function(){
                time();
            });
            function time() {
                if (wait == 0) {
                    yzmobj.removeAttr("disabled");
                    yzmobj.html("发送短信获取验证码");
                    wait = 59;
                } else {
                    yzmobj.attr("disabled","disabled");
                    yzmobj.html(wait + "秒后重新发送短信");
                    wait--;
                    setTimeout(function() {
                                time(yzmobj)
                            },
                            1000)
                }
            }
        
        //删除收货地址   
        $(".deleteAddress").click(function(){
        	if(confirm("确定要删除吗")){
        	var id=$(this).data('id');
	    	var userid=$('#userid').val();
	    	$.ajax({
		        type : 'post',
		        url : '/user/deleteAddress',
		        data : {
		                id : id,
		             userid: userid,
		            _token : "<?php echo e(csrf_token()); ?>",
		        },
		        dataType : 'json',
		        success : function(data) {
		            if(data.code<1){
		                layer.msg(data.msg);
		            }
		            else{
		                layer.msg(data.msg);
		                window.location.reload();
		               
		            }
		        }
			});
        	}else{
        		return false;
        	}
	    	
	    	
        })  
       
        
        //修改
        $(".updateAddress").click(function(){
        		
                $(".popup").fadeIn(300);
                $(".popup_address").slideDown(400);
                var id=$(this).data('id');
	  		    var receiver=$(this).data('receiver');
	  		    var mobile=$(this).data('mobile');
	  		    var area=$(this).data('area'); 
	  		    var province=$(this).data('province');
	  		    var city=$(this).data('city');
	  		    var country=$(this).data('country');
	  		    var qqnum=$(this).data('qqnum');
	  		    $("#addressid").val(id);
	  		    $('.c_khname').val(receiver);
	  		    $('.mobilenum').val(mobile);
	  		    $('.c_details_address').val(area);
	  		    $('.qqnum').val(qqnum);
	  		    
//	  		    $('#s_province').prepend("<option selected='selected' value='"+province+"'>"+province+"</option>");
//	  		    $('#s_city').prepend("<option selected='selected' value='"+city+"'>"+city+"</option>");
//	  		    $('#s_county').prepend("<option selected='selected' value='"+country+"'>"+country+"</option>");
	  		    //选中省
	  		    var selectP=document.getElementById("s_province");
	  		    for(var i=0;i<selectP.options.length;i++)
	  		    {
	  		    	
	  		    	if(selectP.options[i].innerHTML==province)
	  		    	{
	  		    		selectP.options[i].selected=true;
	  		    	    break;
	  		    	}
	  		    }
                change(1);
	  		    //选中市
	  		    var selectCY=document.getElementById("s_city");
	  		    for(var i=0;i<selectCY.options.length;i++)
	  		    {
	  		    	
	  		    	if(selectCY.options[i].innerHTML==city)
	  		    	{
	  		    		selectCY.options[i].selected=true;
	  		    	    break;
	  		    	}
	  		    }
                change(2);
	  		    //选中街道，镇
	  		    var selectCU=document.getElementById("s_county");
	  		    for(var i=0;i<selectCU.options.length;i++)
	  		    {
	  		    	
	  		    	if(selectCU.options[i].innerHTML==country)
	  		    	{
	  		    		selectCU.options[i].selected=true;
	  		    	    break;
	  		    	}
	  		    }
//				$('#s_city').prepend("<option selected='selected' value='"+city+"'>"+city+"</option>");
//	  		    $('#s_county').prepend("<option selected='selected' value='"+country+"'>"+country+"</option>");
	  		    
	  		     var receiver=$('.c_khname').val();
	  		     var mobile=$('.mobilenum').val();
	  		     var area=$('.c_details_address').val(); 
	  		     var province=$('#s_province').find("option:selected").val();
	  		     var city=$('#s_city').find("option:selected").val();
	  		     var country=$('#s_county').find("option:selected").val();
  		     
	  		     if($('#isdefault').is(':checked'))
	  		     {
	  		     	var is_default=1;
	  		     }
	  		     else
	  		     {
	  		     	var is_defautl=0;
	  		     }
//	  		     alert(1);
//			     $.post("/user/address/submit", 
//			        { 'id': id,'receiver':receiver,'mobile':mobile,'province':province,'city':city,'country':country,'is_default':is_default,'area':area,'usr_id':userid },
//			       
//			        function(data){
//			        alert(1);
//			        data=eval( "(" + data + ")" );
//			        if(data.result>0)
//			        {
//			        	window.location.reload();
//			        }
//			        else
//			        {
//			        	alert(data.message]);
//			        }
			     		
			  //  });
	  		    
	  		    
        })
       
        //提交
        $("#saveAddress").click(function(){
        	 var id=$("#addressid").val();
        	 var userid=$('#userid').val();
  		     var receiver=$('.c_khname').val();
  		     var mobile=$('.mobilenum').val();
  		     var qqnum=$('.qqnum').val();
  		     var area=$('.c_details_address').val(); 
  		     var province=$('#s_province').find("option:selected").val();
  		     var city=$('#s_city').find("option:selected").val();
  		     var country=$('#s_county').find("option:selected").val();
			 if(province=='省份'){
				alert('请选择省份'); 
				return false;
			 }
			 if(city=='城市'){
				alert('请选择城市');
				return false;
			 }
//			 if(country=='区/县'){
//				 alert('请选择区/县');
//				 return false;
//			 }
			 
  		     if($('#isdefault').is(':checked'))
  		     {
  		     	var is_default=1;
  		     }
  		     else
  		     {
  		     	var is_defautl=0;
  		     }
  		     if(receiver==''){alert('收货人不能为空');return false;}
  		     var myreg = /^1[34578][0-9]{9}$/;
			 if(!myreg.test(mobile))
			 { 
			    alert('请输入有效的手机号码！'); 
			    return false; 
			 } 
  		     if(area==''){alert('收货地址不能为空');return false;}
		     $.post("/user/address/submit", 
		        { 'id': id,'receiver':receiver,'mobile':mobile,'province':province,'city':city,'country':country,'is_default':is_default,'area':area,'usr_id':userid,'notice':qqnum },
		       
		        function(data){
		        data=eval( "(" + data + ")" );
		        if(data.result>0)
		        {
		        	window.location.reload();
		        }
		        else
		        {
		        	alert(data.message);
		        }
		     		
		    });
        })
        
       
        
    })
    
	function saveOrderAddr(id,o_id){
        $.ajax({
        type : 'post',
        url : '/user/orderAddress',
        data : {
            id : id,
            o_id : o_id,
            _token : "<?php echo e(csrf_token()); ?>",
        },
        dataType : 'json',
        success : function(data) {
            if(data == null){
                layer.msg('服务端错误！');
            }
            if(data.status == 1){
                layer.msg(data.msg);
                if(data.type == 1){
                    location.href = '/user/prize';
                }else {
                    location.href = '/user/inviteprize';
                }                
            }else {
                layer.msg(data.msg);
            }
        }
		});
    }			  
    
   
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('foreground.user_center', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>