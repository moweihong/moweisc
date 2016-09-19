<?php
session_start(); 
	if(isset($_POST['login'])){
		if(trim($_POST['uname'])=='ykg2016' && trim($_POST['pwd'])=='tesu88992016' ){
			$_SESSION['mfeoi^s151_%fekfe2fg'] = 1;
		}else{
			echo "<script>alert('帐号或密码错误！');window.location='/index_maintain.php'</script>";
		}
	}elseif(isset($_POST['maintian'])){
		file_put_contents('index_maintain.switch',1);
		echo "<script>alert('开启成功！');window.location='/index_maintain.php'</script>";
	}elseif(isset($_POST['normal'])){
		file_put_contents('index_maintain.switch',0);
		echo "<script>alert('取消成功！');window.location='/index_maintain.php'</script>";
	}elseif(isset($_GET['logout'])){
		unset($_SESSION['mfeoi^s151_%fekfe2fg']);
	}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
<style>
body{background-color:#F2F2F2;}
.content {margin-top:150px;}
.content button {height:30px;color:white;font-size:18px;border:0px;padding:0px;cursor:pointer;}
.content .panel {background-color:white;width:302px;text-align:center;margin:0px auto;padding-top:20px;padding-bottom:20px;border:1px solid #ddd;border-radius: 5px;}
.content .panel .group {text-align:left;width:262px;margin: 0px auto 20px;}
.content .panel .group label {line-height: 30px;font-size: 18px;}
.content .panel .group input {display:block;width:250px;height:30px;border:1px solid #ddd;padding: 0px 0px 0px 10px;font-size:16px;}
.content .panel .group input:focus{border-left: 1px solid #CC865E;}
.content .panel .login input {background-color:#FE0100;width:260px;height:30px;color:#fff;font-size:14px;font-weight:bold;border:none;cursor:pointer}
.content .panel .login input:hover{border:1px solid #7A0D06;}
.maintian{margin-top:20%;height:50px;width:100%;text-align:center;font-size:18px}
.logout{text-decoration:none;color:#7A0D06}
.logout:hover{color:#FE0100}
 </style>
</head>
<body>
<?php
	if(!isset($_SESSION['mfeoi^s151_%fekfe2fg'])){   
?>
    <div class="content">
        <div class="panel">
			<form action='' method="post">
				<div class="group">
					<label>账号</label>
					<input name='uname' placeholder="请输入账号">
				</div>
				<div class="group">
					<label>密码</label>
					<input name='pwd' placeholder="请输入密码" type="password">
				</div>
				<div class="login">
					<input type='submit' name='login' value='登  录'> 
				</div>
			</form>
        </div>
    </div>
<?php 
	}else{ 
		$switch = file_get_contents('index_maintain.switch');
		if($switch==1){
?>
		<div class='maintian'>
			<form action='' method="post">
				<label>当前网站处于维护状态：</label>
				<input type='submit' name='normal' value='取消维护'>&nbsp;
				<a class='logout' href="?logout">退出登录</a>
			</form>
		</div>
	<?php }else{ ?>	
		<div class='maintian'>
			<form action='' method="post">
				<label>当前网站处于正常访问状态：</label>
				<input type='submit' name='maintian' value='开启维护'>&nbsp;
				<a class='logout' href="?logout">退出登录</a>
			</form>
		</div>
	<?php } ?>
	
	
<?php } ?>
</body>
</html>