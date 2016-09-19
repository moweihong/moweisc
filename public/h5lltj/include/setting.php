<?php
$keyarray = array("admin"=>"用户名","pass"=>"密码","title"=>"标题","apikey"=>"apikey");
$key = $_GET["key"];
$value = $_GET["value"];
$newvalue = $value;
if($key == "pass"){$newvalue = md5($value);}
updateValue($key,$newvalue);
echo "已将".$keyarray[$key]."修改为".$value."！";
?>