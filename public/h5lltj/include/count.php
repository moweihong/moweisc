<?php
function GetIpAdd(){
	if (getenv("HTTP_CLIENT_IP")){
		$ip = getenv("HTTP_CLIENT_IP");
	}elseif(getenv("HTTP_X_FORWARDED_FOR")){
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}elseif(getenv("REMOTE_ADDR")){
		$ip = getenv("REMOTE_ADDR");
	} else {
		$ip = 0; 
	}
	return $ip; 
} 
function GetIpJson($x){  
	$ch = curl_init();
	$url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$x;
	$header = array(
		'apikey:'.getValue("apikey"),
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch , CURLOPT_URL , $url);
	$json = curl_exec($ch);
	//print_r($json);exit;
	return $json;
}
?>