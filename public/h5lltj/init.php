<?php
$info="";
$ifcookie=0; 
if(isset($_COOKIE["admin"]) and $_COOKIE["admin"]=="yes"){$ifcookie=1;}
if($ifcookie==0){
	if($_GET["mod"]=="log"){
		$admin=$_POST["admin"];
		$pass=$_POST["pass"];
		if(cheakPass($admin,$pass)){
			setcookie("admin",'yes');
			Header("Location:index.php");
		} else {
			$info="<script>alert('用户名或密码错误！');</script>";
		}
	}
	include("template/login.php");
} else {
	switch($_GET["mod"]){
		case "logout":
			session_destroy();
			Header("Location:index.php");
		break;
		case "setting":
			include("include/setting.php");
			mysqli_close($conn);
			exit(0);
		break;
		default:
			include("template/top.php");
			include("template/table.php");
		break;
	}
}
include("template/footer.php");
mysqli_close($conn);
?>