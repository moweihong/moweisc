<?php
namespace App\Http\Tools\Recharge;

class RechargeMobile{ //定义了一个久久数字Api类
	private $partner; //代理商ID
	private $key; //代理商Key
	private $notify_url;//代理订单状态通知地址
	private $host = "http://api2.99dou.com:8000/Api/Service";//"http://api2.99dou.com:8000/Api/Service"; //久久数字接口地址
	private $charset = "utf-8";

	function  __construct(){
		$this->partner =  "11524";
		$this->key = "l794GfSvHTVEPYZuNqIzFsYfMhdF5aADbCQYLykTOSw6mKSnPuBLY5nNvhINJCkY";
		$this->notify_url = 'http://'.$_SERVER['SERVER_NAME'].'/jiujiu/recharge';
	}
	
	/*
	*话费充值
	*	@account			手机号	或者固话 如 075533377311
	*	@account_info		账户信息:如，类型:固话\n营运商:联通
	*	return 0 成功  1 失败  -1 未知
	*/
	function Huafei($out_trade_id, $account, $account_info, $quantity, $value, $client_ip, $expired_mini, &$msg){
		
		$parameter = array(
			"out_trade_id" => $out_trade_id,
			"account" => $account,
			"account_info" => $account_info,
			"quantity" => $quantity,
			"value" => $value,
			"client_ip" => $client_ip,
			"expired_mini" => $expired_mini,
			"notify_url" => $this->notify_url
		);		

		$xml =  $this->Post("Huafei",$parameter);
		
		if($xml == null){
			$msg = "服务器连接失败或者超时";
			return -1;
		}

		$msg = $xml->msg;

		if($xml->code =="0000" || $xml->code =="0004"){	// 0000 提交成功  0004  交易号重复
			
			if(!$this->VerifySign($xml))
			{
				$msg = "返回数据校验错误";
				return -1;
			}
			return 0;//成功
		} 
		else if ($xml->code == "-1")
        {
             return -1;
        }
		//失败
		return 1;
	}

	/*
	*流量充值
	*	@out_trade_id		代理订单号
	*	@account			手机号		
	*	@quantity			数量
	*	@size				流量大小 如  10M 20M 500M 1G 等
	*	@type				0 全国  1 省内
	*	return 0 成功  1 失败  -1 未知
	*/
	function Liuliang($out_trade_id, $account, $quantity, $size, $type, $client_ip, $expired_mini, &$msg){
		
		$parameter = array(
			"out_trade_id" => $out_trade_id,
			"account" => $account,			
			"size" => $size,
			"quantity" => $quantity,
			"type" => $type,
			"client_ip" => $client_ip,
			"expired_mini" => $expired_mini,
			"notify_url" => $this->notify_url
		);		

		$xml =  $this->Post("Liuliang",$parameter);
		
		if($xml == null){
			$msg = "服务器连接失败或者超时";
			return -1;
		}

		$msg = $xml->msg;

		if($xml->code =="0000" || $xml->code =="0004"){	// 0000 提交成功  0004  交易号重复
			
			if(!$this->VerifySign($xml))
			{
				$msg = "返回数据校验错误";
				return -1;
			}
			return 0;//成功
		} 
		else if ($xml->code == "-1")
        {
             return -1;
        }
		//失败
		return 1;
	}

	/*
	*	直充，根据商品序号进行充值 ，可充话费，固话，QB,网游
	*	@account			充值账户 话费时输入手机号，Q服务输入QQ号，网游时输入网游账户  如：1549332002
	*	@account_info		账户信息:如，类型:固话\n营运商:联通
	*	return 0 成功  1 失败  -1 未知
	*/
	function Direct($out_trade_id, $product_id, $quantity, $account, $account_info, $client_ip, $expired_mini, &$msg){
		$parameter = array(
			"out_trade_id" => $out_trade_id,
			"account" => $account,			
			"account_info" => $account_info,
			"quantity" => $quantity,
			"product_id" => $product_id,
			"client_ip" => $client_ip,
			"expired_mini" => $expired_mini,
			"notify_url" => $this->notify_url
		);
		
		$xml =  $this->Post("Direct",$parameter);
		
		if($xml == null){
			$msg = "服务器连接失败或者超时";
			return -1;
		}

		$msg = $xml->msg;

		if($xml->code =="0000" || $xml->code =="0004"){	// 0000 提交成功  0004  交易号重复
			
			if(!$this->VerifySign($xml))
			{
				$msg = "返回数据校验错误";
				return -1;
			}
			return 0;//成功
		} 
		else if ($xml->code == "-1")
        {
             return -1;
        }
		//失败
		return 1;
	}

	/*
	*	查询充值结果
	*	return 0 查询成功 （根据success_qty,fail_qty判断订单状态）  1 充值中 2 没有记录  -1 未知
	*/
	function Query($out_trade_id , &$success_qty, &$fail_qty, &$msg){
		$parameter = array(
			"out_trade_id" => $out_trade_id		
		);
		
		$xml =  $this->Post("Query",$parameter);
		
		if($xml == null){
			$msg = "服务器连接失败或者超时";
			return -1;
		}

		$msg = $xml->msg;

		if($xml->code =="0000"){	// 0000 查询成功  
			
			if(!$this->VerifySign($xml)){
				$msg = "返回数据校验错误";
				return -1;
			}
			if($xml->status == "success" || $xml->status == "fail"){
				$success_qty = $xml->success_qty;
				$fail_qty = $xml->fail_qty;
				return 0;
			}
			else{
				$msg = $xml->status;
				return 1;
			}
			return 0;//成功
		} 
		else if ($xml->code == "0012"){
           if(!$this->VerifySign($xml))
			{
				$msg = "返回数据校验错误";
				return -1;
			}
            return 2;
        }
		//失败
		return -1;
	}

	function VerifyNotify($array,&$out_trade_id, &$success_qty, &$fail_qty, &$msg){

		$newSign = $this->Build_mysign($array, $this->key);
		//print_r ($newSign);
		$sign = $array["_sign"];
		//签名验证
		if(strcasecmp($newSign ,$sign)==0){ //验证成功
			$out_trade_id = $array["out_trade_id"];				 

			if ($array["status"] == "success" || $array["status"] == "fail")
			{
				$success_qty = $array["success_qty"];
				$fail_qty = $array["fail_qty"];
				return 0;
			}
			$msg = "未知状态:" . $array["status"];
		}
		else{
			$msg = "校验失败:" ;	
		}

		return -1;			
	}

	private function Post($method,$array){

			$array["partner"] = $this->partner;
            $array["method"] = $method;
            $array["sign_type"] = "md5";
			
			if(!isset($array["client_ip"]) || $array["client_ip"] == ""){
				$array["client_ip"] = $_SERVER["REMOTE_ADDR"];
			}

			$array["_sign"] = $this->Build_mysign($array,$this->key);

			$query = $this->Create_linkstring($array);

			$url = $this->host;			

            if (strpos($url,"?") == false)
                $url .= "?_charset=" . $this->charset;
            else
                $url .= "&_charset=" . $this->charset;
						
            return $this->getHttpResponsePOST($url, $query);
	}

	private function getHttpResponsePOST($url, $para) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_HEADER, 0 );

		curl_setopt($ch, CURLOPT_POSTFIELDS , $para);// post传输数据

		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);//不直接输出，返回到变量

		$curl_result = curl_exec($ch);
		
		$xml = simplexml_load_string($curl_result);

		return $xml;
	}

	private function Build_mysign($array, $key){
		ksort($array);
		reset($array);			
		$arg  = "";
		while (list ($name, $val) = each ($array)) {
			if(strpos($name, "_") === 0)
				continue;			
			if(is_array($val))
				$val =join(',',$val);
			if($val=="")
				continue;
			$arg.=$name."=". $val ."&";
		}
		$arg = substr($arg,0,count($arg)-2);	
		//print_r($arg.$key);
		return md5($arg.$key);
	}
	private function Create_linkstring($array){
		$arg  = "";
		while (list ($key, $val) = each ($array)) {
			$arg.=$key."=". urlencode($val) ."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		return $arg;
	}

	private function VerifySign($xml){		
		$array = json_encode($xml);
		$array = json_decode($array, true);
		$sign = $xml->_sign;
		$newSign = $this->Build_mysign($array, $this->key);
		
		if (trim($sign) != "" && strcasecmp($sign,$newSign)==0 ){
             return true;
		}
        return false;
    }
}
?>