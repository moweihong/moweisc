<?php
namespace App\Http\Controllers\Foreground\Service;
use App\Models\Member;
use DB;
use App\Models\Object;
use App\Http\Controllers\ForeController;

class UploadifyController extends ForeController {
	
	
   //重传用户头像
	public function up()
	{  
       
 
        /*$session_name = session_name();
        if(isset($_POST[$session_name])){
            session_id($_POST[$session_name]);
            session_start();
        }*/
		//$uid
		$uid=session('user.id');//用户sessionid;
		if(!$uid)
		{
			$uid=$_POST['uid'];
		}
		//$uid=1889;
		$targetFolder = '/backend/upload/userimg'; // Relative to the root
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) 
		{
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$rand=rand(1,100);
			$filename=$rand.time().".jpg";
			$targetFile = rtrim($targetPath,'/') . '/' .$filename;
		
			$fileTypes = array('jpg','jpeg','gif','png',); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$rtname=$targetFolder.'/'.$filename;
			if (in_array($fileParts['extension'],$fileTypes)) 
			{
				move_uploaded_file($tempFile,$targetFile);
				$Member=new Member();
				$Member->updateUserPic($uid,$rtname);
				session(['user.photo'     => $rtname]);
				echo  $rtname;
			} else 
			{
				echo 'Invalid file type.';
			}
	     }
	}
	
	
	
	//晒单图片上传
	public function saveShowPic()
	{
		$targetFolder = '/backend/upload/showpic'; // Relative to the root
		
		if (!empty($_FILES)) 
		{
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$rand=rand(1,100);
			$filename=$rand.time().".jpg";
			$targetFile = rtrim($targetPath,'/') . '/' .$filename;
		
			$fileTypes = array('jpg','jpeg','gif','png',); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$rtname=$targetFolder.'/'.$filename;
			if (in_array($fileParts['extension'],$fileTypes)) 
			{
				move_uploaded_file($tempFile,$targetFile);
				echo  $rtname;
			} else 
			{
				echo 'Invalid file type.';
			}
	     }
	
	}
	
	//晒单图片旋转处理
	function xuanZhuanPic(){
        
        $filename=$_SERVER['DOCUMENT_ROOT'].$_POST['imgsrc'];
		$degrees=-90;
		 //读取图片
        $data = @getimagesize($filename);
		 if($data==false)return false;
 
		  switch ($data[2]) {
		   case 1:
			$source = imagecreatefromgif($filename);break;
		   case 2:
			$source = imagecreatefromjpeg($filename);break;
		   case 3:
			$source = imagecreatefrompng($filename);break;
		  } 
        //使用imagerotate()函数按指定的角度旋转
        $rotate = imagerotate($source, $degrees, 0);
        //旋转后的图片保存
        imagejpeg($rotate,$filename);
    }
	
	//晒单图片上传换成百度上传插件
	public function saveShowPicWeb()
	{
		$targetFolder = '/backend/upload/showpic'; // Relative to the root
		
		if (!empty($_FILES)) 
		{
			$tempFile = $_FILES['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$rand=rand(1,100);
			$filename=$rand.time().".jpg";
			$targetFile = rtrim($targetPath,'/') . '/' .$filename;
		
			$fileTypes = array('jpg','jpeg','gif','png',); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$rtname=$targetFolder.'/'.$filename;
			if (in_array($fileParts['extension'],$fileTypes)) 
			{
				move_uploaded_file($tempFile,$targetFile);
				echo  $rtname;
			} else 
			{
				echo 'Invalid file type.';
			}
	     }
	
	}
}