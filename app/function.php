<?php
/** 获取当前时间戳，精确到毫秒 */
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

/** 格式化时间戳，精确到毫秒，x代表毫秒 */
function microtime_format($tag,$time)
{
   $usec=substr($time,0,10);
   $sec=substr($time,9,3);
   $date = date($tag,$usec);
   return str_replace('x', $sec, $date);
}
	
function httpGet($url) {  
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);  
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}
