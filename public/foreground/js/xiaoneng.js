/**
 * 小能客服系统JS
 * create by tangzhe 2016-08-12
 */
 
var page = window.location.pathname;
var userlevel = 1,
	isvip     = 0,
	erpparam  = 'abc',
	uname     = 'www.ts1kg.com',
	uid       = '2016',
	settingid = 'kf_9372_1470212593294',
	siteid    = 'kf_9372';
 	
if(page.substring(0,9)=='/category'){ 
	NTKF_PARAM = {
		siteid:siteid,		            
		settingid:settingid,	
		uid:uid,		              	    
		uname:uname,	     	    
		isvip:isvip,                          
		userlevel:userlevel,		                 
		erpparam:erpparam,                    
		ntalkerparam:{
	　　	category:"商品大全",    //分类名称，多分类可以用分号(;)分隔， 长路径父子间用冒号(:)分割
	　　	brand:""                //品牌名称，多品牌可以用分号(;)分隔
		}
	} 
}else if(page.substring(0,8)=='/product'){  
	var gid = $('.w_slip_in').attr('id');  
	NTKF_PARAM = {
		siteid:siteid,                   
		settingid:settingid,    
		uid:uid,                        
		uname:uname,             
		isvip:isvip,                          
		userlevel:userlevel,                       
		erpparam:erpparam,                    
			itemid:gid,				 	     //(必填)商品ID
			itemparam:"ykg"				     //(选填)itemparam为商品接口扩展字段，用于商品接口特殊要求集成
	}
}else if(page.substring(0,7)=='/mycart'){  
	var priceTotal = $('#priceTotal').text(); 
	var items      = $('#good_json').text();  
	var items      = '['+items.substring(0,(items.length)-2)+']';  
	NTKF_PARAM = {
		siteid:siteid,                    
		settingid:settingid,    
		uid:uid,                        
		uname:uname,           
		isvip:isvip,                           
		userlevel:userlevel,                      
		erpparam:erpparam,                      
		ntalkerparam:{                       
			cartprice:priceTotal,	         //购物车总价
	　　	items:items    					 //购物车商品列表          
		}
	} 	
}else if(page.substring(0,9)=='/user/buy'){
	NTKF_PARAM = {
		siteid:siteid,		            
		settingid:settingid,	 
		uid:uid,		                 
		uname:uname,		      
		isvip:isvip,                          
		userlevel:userlevel,		                 
		erpparam:erpparam,                       
		orderid:"Unknown",		             //订单ID
		orderprice:"Unknown"		         //订单总价
	}
}else{
	NTKF_PARAM = {
		siteid:siteid,						 //企业ID，为固定值，必填	           
		settingid:settingid,				 //接待组ID，为固定值，必填 
		uid:uid,		                     //用户ID，未登录可以为空，但不能给null，uid赋予的值在显示到小能客户端上  
		uname:uname,           			     //用户名，未登录可以为空，但不能给null，uname赋予的值显示到小能客户端上		    
		isvip:isvip,             			 //是否为vip用户，0代表非会员，1代表会员，取值显示到小能客户端上             
		userlevel:userlevel,		       	 //网站自定义会员级别，0-N，可根据选择判断，取值显示到小能客户端上     
		erpparam:erpparam        			 //erpparam为erp功能的扩展字段，可选，购买erp功能后用于erp功能集成              
	}
}
 