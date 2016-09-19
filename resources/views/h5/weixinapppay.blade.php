<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>微信支付</title>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
	<style type="text/css">
		.paymainbox {
			background: #f4f4f4;
			text-align: center;
			overflow: hidden;
			zoom: 1;
		}

		.paymainbox .loading {
			border-top: none;
			box-shadow: none;
			margin-top: 70px;
		}

		* {
			margin: 0;
			padding: 0;
		}

		body,input,textarea {
			font-size: 12px;
			font-family: arial,微软雅黑;
		}

		div,input {
			font-size: 12px;
		}

		input,textarea {
			-webkit-tap-highlight-color: rgba(0,0,0,0);
			-webkit-appearance: none;
			border: 0;
			border-radius: 0;
		}

		a {
			color: #000;
			text-decoration: none;
			outline: medium none;
		}

		a:hover {
			color: #C00;
		}

		b {
			font-weight: normal;
		}

		.z-minheight {
			min-height: 200px;
		}

		.loading {
			clear: both;
			width: 100%;
			display: block;
			background: #f4f4f4;
			height: 40px;
			line-height: 40px;
			text-align: center;
			color: #999;
			font-size: 12px;
			box-shadow: 0 1px 1px #ddd inset;
		}

		.loading b {
			background: url(data:image/gif;base64,R0lGODlhEAAQAPIAAP///wCA/8Lg/kKg/gCA/2Kw/oLA/pLI/iH/C05FVFNDQVBFMi4wAwEAAAAh/h1CdWlsdCB3aXRoIEdJRiBNb3ZpZSBHZWFyIDQuMAAh/hVNYWRlIGJ5IEFqYXhMb2FkLmluZm8AIfkECQoAAAAsAAAAABAAEAAAAzMIutz+MMpJaxNjCDoIGZwHTphmCUWxMcK6FJnBti5gxMJx0C1bGDndpgc5GAwHSmvnSAAAIfkECQoAAAAsAAAAABAAEAAAAzQIutz+TowhIBuEDLuw5opEcUJRVGAxGSBgTEVbGqh8HLV13+1hGAeAINcY4oZDGbIlJCoSACH5BAkKAAAALAAAAAAQABAAAAM2CLoyIyvKQciQzJRWLwaFYxwO9BlO8UlCYZircBzwCsyzvRzGqCsCWe0X/AGDww8yqWQan78EACH5BAkKAAAALAAAAAAQABAAAAMzCLpiJSvKMoaR7JxWX4WLpgmFIQwEMUSHYRwRqkaCsNEfA2JSXfM9HzA4LBqPyKRyOUwAACH5BAkKAAAALAAAAAAQABAAAAMyCLpyJytK52QU8BjzTIEMJnbDYFxiVJSFhLkeaFlCKc/KQBADHuk8H8MmLBqPyKRSkgAAIfkECQoAAAAsAAAAABAAEAAAAzMIuiDCkDkX43TnvNqeMBnHHOAhLkK2ncpXrKIxDAYLFHNhu7A195UBgTCwCYm7n20pSgAAIfkECQoAAAAsAAAAABAAEAAAAzIIutz+8AkR2ZxVXZoB7tpxcJVgiN1hnN00loVBRsUwFJBgm7YBDQTCQBCbMYDC1s6RAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P4wykmrZULUnCnXHggIwyCOx3EOBDEwqcqwrlAYwmEYB1bapQIgdWIYgp5bEZAAADsAAAAAAAAAAAA=);
			background-size: 12px auto;
			background-repeat: no-repeat;
			width: 12px;
			height: 12px;
			display: inline-block;
			margin-right: 5px;
			position: relative;
			top: 2px;
		}
	</style>
	</head>
<body style="background: #f4f4f4;">
    <div class="h5-1yyg-v1">
        <div id="divPayBox" class="paymainbox z-minheight">
            <div class="loading"><b></b>正在提交支付请求，请稍后…</div>
            
            <div id='buttons' style="display:none;"></div>
        </div>
        <div id="divPayJS">
		<script type="text/javascript">
    		var ua = navigator.userAgent.toLowerCase();	
    		var equip = '';
    		if (/iphone|ipad|ipod/.test(ua)) {
    			equip = 'ios';		
    		} else if (/android/.test(ua)) {
    			equip = 'android';	
    		}
		
			var is_charge = {{$is_charge}};
			//if(typeof(wechatPay) == 'function'){
			//var appId = "{{$data['appid']}}";     //公众号名称，由商户传入     
			   var partnerId = "{{$data['partnerid']}}";
	           var timeStamp = "{{$data['timestamp']}}";         //时间戳，自1970年以来的秒数     
	           var nonceStr = "{{$data['noncestr']}}"; //随机串 
	           var prepayId = "{{$data['prepayid']}}";    
	           var data_package = "{{$data['package']}}";     
	           var sign = "{{$data['sign']}}"; //微信签名 

	           if(equip == 'ios'){
					function setupWebViewJavascriptBridge(callback) {
				        if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
				        if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
				        window.WVJBCallbacks = [callback];
				        var WVJBIframe = document.createElement('iframe');
				        WVJBIframe.style.display = 'none';
				        WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
				        document.documentElement.appendChild(WVJBIframe);
				        setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0);
				    }

					setupWebViewJavascriptBridge(function(bridge) {
						var callbackButton = document.getElementById('buttons').appendChild(document.createElement('button'));
						callbackButton.innerHTML = 'ObjcCallback';
						callbackButton.onclick = function(e) {
							e.preventDefault();
							bridge.callHandler('wechatPay', {'partnerId': partnerId,'timeStamp' : timeStamp, 'nonceStr' : nonceStr, 'prepayId' : prepayId, 'package' : data_package, 'sign' : sign}, function(response) {
								//alert('success');
							})
						}

						callbackButton.click();
					})
					
// 					wechatPay(partnerId, timeStamp, nonceStr, prepayId, data_package, sign);
				}else if(equip == 'android'){
					myObj.wechatPay(partnerId, timeStamp, nonceStr, prepayId, data_package, sign);
				}
        	//}
		</script>
	</div>
    </div>
</body>
</html>