<?php include("include/top.php");?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo getValue("title")?>一块购H5流量统计</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta charset="utf8">
<link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
<link href="./static/css/datedropper.css" rel="stylesheet">
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.js"></script>
<script src="./static/js/datedropper.min.js"></script>
<script src="./static/js/main.js"></script>
</head>
<body>

<div class="container-fluid">
<div class="row-fluid">
<br />
<div class="col-sm-12 col-lg-4">
<div class="panel panel-success">
<div class="panel-heading">
<h3 class="panel-title">基本统计信息</h3>
</div>
<div class="panel-body">
<table class="table table-hover">
<tbody>
<tr><td>月均PV</td><td><?php echo getmonthpv(date("Y"),date("n"));?></td></tr>
<tr><td>月均UV</td><td><?php echo getmonthuv(date("Y"),date("n"));?></td></tr>
<tr><td>日均PV</td><td><?php echo getdaypv(date("Y"),date("n"),date("j"));?></td></tr>
<tr><td>日均UV</td><td><?php echo getdayuv(date("Y"),date("n"),date("j"));?></td></tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-4">
<?php include("template/pie.php");?>
</div>
<div class="col-sm-12 col-lg-4">
<div class="well well-sm" style="text-align:center;">
本系统从<?php echo getValue("date");?>开始运行。<a href="index.php?mod=logout" style="text-decoration:none;">【退出登录】</a><br />
<!--
<a href="index.php" style="text-decoration:none;">首页</a>&nbsp;|&nbsp;
<a data-toggle="modal" data-target="#myModal" style="text-decoration:none;">设置</a>&nbsp;|&nbsp;
<a title="使用说明" data-container="body" data-toggle="popover" data-placement="bottom" data-content="在需要统计的网页中引用count.js即可实现自动统计。" style="text-decoration:none;">帮助</a>&nbsp;|&nbsp;
<a href="index.php?mod=logout" style="text-decoration:none;">注销</a>-->

</div>
<form action="index.php" method="GET" role="form">
<div class="input-group">
<span class="input-group-addon">查询日期</span>
<input type="text" class="form-control" id="date" name="date" style="background-color:#fff;">
<span class="input-group-btn"><button class="btn btn-default" type="submit">查询</button></span>
</div>
</form>
</div>
</div>
</div>