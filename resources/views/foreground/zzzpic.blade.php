<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>
<link rel="stylesheet" href="{{ asset('backend/uploadify/uploadify.css') }}" type="text/css"> 
<script src="{{ asset('backend/uploadify/jquery.uploadify.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('backend/lib/jquery-1.8.1.min.js') }}"></script>
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<h1>Uploadify Demo</h1>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form>

	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php',
				'buttonText'  : '选择文件222'，
			
				
		
			});
			
			
		});
	</script>
</body>
</html>