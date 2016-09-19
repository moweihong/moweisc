<!DOCTYPE html>
<html>
<head>
<title><?php echo getValue("title")?>登录一块购H5流量统计工具</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta charset="utf8">
<link rel="icon" href="/upload/10001/config/favicon.ico" mce_href="/upload/10001/config/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" type="image/x-icon" href="/upload/10001/config/favicon.ico" />
<link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.js"></script>
<script src="template/main.js"></script>
<style>
	.input-group{ width:25%;margin:0 auto}
 
</style>
</head>
<body>

<div class="container-fluid">
<div class="row-fluid">
<br />
<form method="POST" action="index.php?mod=log" class="bs-example bs-example-form" role="form">
<fieldset> 
<center><legend>登 录</legend></center>
<div class="input-group">
<span class="input-group-addon">用户名</span>
<input type="text" class="form-control" id="admin" name="admin">
</div>
<br />
<div class="input-group">
<span class="input-group-addon">密&nbsp;&nbsp;&nbsp;&nbsp;码</span>
<input type="password" class="form-control" id="pass" name="pass">
</div>
<br />
<div style="text-align:center;">
<div class="btn-group" id="bt">
<button type="submit" class="btn btn-success">登录</button>
<button type="reset" class="btn btn-info">重填</button>
</div>
</div>
</fieldset>
</form>
<br />