<?php if(!is_mobile_request()){ ?>
<!DOCTYPE>
<html>
<head>
<meta charset="UTF-8">
<meta name="keywords" content="特速一块购,一元购,一元云购,一元夺宝">
<meta name="description" content="特速一块购是由深圳特速集团巨资打造出的一元云购,一元夺宝权威购物平台,建立消费者值得信赖的一元购众筹商城，带您领略全新的互联网购物模式">
<meta http-equiv="X-UA-Compatible" content="IE = edge">  
<title>404页面 特速一块购官网 </title>
<style>
body{font-size:12px; font-family:微软雅黑, PMingLiU, Verdana, Arial, Helvetica, sans-serif;color:#363636;background:white url(../images/bpbg.jpg) center top no-repeat;}
html, body, div, span, h1, h2, h3, h4, h5, h6, em, img, strong, sub, sup, tt,dd, dl, dt, form, label, table, caption, tbody, tfoot, thead, tr, th, td,ul,li,p,a{ margin: 0; padding: 0;  }
*{margin: 0px; padding: 0px;}
input,select,textarea{ vertical-align:middle;}
img{ border:0;}
ul,li{ list-style-type:none;}
a:link,a:visited{text-decoration:none;}
a:hover{color:#ED0909;}
.clearfix:after {clear: both;content: ' ';display: block;font-size: 0;line-height: 0;visibility: hidden;width: 0;height: 0;}
.clearfix{zoom:1}

.ts404{width:1210px; height:444px; margin: 160px auto 0px;}
.ts404 .ts404-zp{width:550px; height:444px; float: left; display: inline; background: url(foreground/img/page/404.png) no-repeat;}
.ts404 .ts404-index{width:650px; height:444px; float: right; display: inline; background: url(foreground/img/page/404.png) no-repeat; background-position:-550px 0px ;}
.ts404-zp a,.ts404-index a{width:100%; height: 100%; display: block;}
</style>

</head>


<body>
<div class="ts404 clearfix">
	<div class="ts404-zp"><a href="http://www.ts1kg.com/freeday"></a></div>
	<div class="ts404-index"><a href="http://www.ts1kg.com/"></a></div>
</div>
 
</body>
</html>


<?php }else{  ?>
 <!DOCTYPE>
<html>
<head>
<meta charset="UTF-8">
<meta name="keywords" content="特速一块购,一元购,一元云购,一元夺宝">
<meta name="description" content="特速一块购是由深圳特速集团巨资打造出的一元云购,一元夺宝权威购物平台,建立消费者值得信赖的一元购众筹商城，带您领略全新的互联网购物模式">
<meta name="viewport" content="width=320,minimum-scale=1,maximum-scale=5,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>404页面 特速一块购官网 </title>
<style>
body{font-size:12px;font-family:"microsoft yahei",PMingLiU,Verdana,Arial,Helvetica,sans-serif;color:#fff}
a,body,caption,dd,div,dl,dt,em,form,h1,h2,h3,h4,h5,h6,html,img,label,li,p,span,strong,sub,sup,table,tbody,td,tfoot,th,thead,tr,tt,ul{margin:0;padding:0}
*{margin:0;padding:0}
input,select,textarea{vertical-align:middle}
img{border:0}
li,ul{list-style-type:none}
a{color:#fff}
a:link,a:visited{text-decoration:none}
a:hover{color:#fff}
.clearfix:after{clear:both;content:' ';display:block;font-size:0;line-height:0;visibility:hidden;width:0;height:0}
.clearfix{zoom:1}
.ts404{width:320px;margin:0 auto;padding-top:3rem}
.ts404 .ts404-img{width:260px;height:281px;margin:0 auto 0;background:url(H5/images/page/404.jpg) no-repeat;background-size:260px 281px}
.ts404 .play-des{color:#39434d;font-size:15px;margin-top:1.2rem;text-align:center}
.ts404 .ts404-but{margin-top:1rem;text-align:center}
.ts404-but a{width:7rem;height:2rem;line-height:2rem;display:inline-block;margin:0 0.8rem;border-radius:5px;-webkit-border-radius:5px;background:#e63955}
</style>

</head>
<body>
<!--404 start-->
<div class="ts404 clearfix" id="ykgerror">
	<div class="ts404-img"></div>
	<p class="play-des">您可以去这里玩</p>
	<div class="ts404-but"><a href="http://m.ts1kg.com/">返回首页</a><a href="http://m.ts1kg.com/freeday_m">免费抽奖</a></div>
</div>
<!--404 end-->
<script>
if(navigator.appVersion.indexOf('Android') != -1){
	document.addEventListener("DOMContentLoaded",function(e){
		document.getElementById('ykgerror').style.zoom = e.target.activeElement.clientWidth/320;
	});
}
</script>
</body>
</html>

 
<?php } ?>







<?php  
	/**
	 * 判断是否移动设备访问 
	 * return boolean 
	 */
	function is_mobile_request(){ 
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			return true;
		} 
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		{ 
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		} 
		// 脑残法，判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			$clientkeywords = array ('nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
				); 
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				return true;
			} 
		} 
		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{ 
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
			{
				return true;
			} 
		} 
		return false;
	}
