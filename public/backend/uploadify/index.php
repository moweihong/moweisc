<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="uploadify.css">
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
   <!--
	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php'
			});
		});
	</script>
	-->
	<script>
	
	$(function() {
   $('#file_upload').uploadify({
    	<?php $timestamp = time();?>
    //�ϴ��ļ�ʱpost�ĵ�����
    'formData'     : {
     'timestamp' : '<?php echo $timestamp;?>',
     'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
     'id'  : 1
    },
    'swf'      : '/uploadify.swf',
    'uploader' : 'uploadify.php',
    'onInit'   : function(index){
     alert('����ID:'+index.settings.queueID);
    },
    'method'   : 'post', //�����ϴ��ķ���get �� post
    //'auto'    : false, //�Ƿ��Զ��ϴ� false�ر��Զ��ϴ� true ѡ���ļ����Զ��ϴ�
    //'buttonClass' : 'myclass', //�Զ��尴ť����ʽ
    //'buttonImage' : '��ťͼƬ',
    'buttonText'  : 'ѡ���ļ�', //��ť��ʾ���ּ�
    //'fileObjName' : 'mytest'  //��̨���յ�ʱ�����$_FILES['mytest'] 
    //'checkExisting' : '/uploadify/check-exists.php', //����ļ��Ƿ��Ѿ����� ����0����1
    'fileSizeLimit' : '10000KB', //�ϴ��ļ���С������
    'fileTypeDesc'  : '����ҪһЩ�ļ�',//��ѡ����ļ�������
    'fileTypeExts'  : '*.gif; *.jpg; *.png', //�ļ��������ϴ�������
    
    //�ϴ���ʱ�������¼�
    'onUploadStart' : function(file){
      alert('��ʼ�ϴ���');       },
    'uploadLimit'   : 5, //��������ϴ��ļ�������
    /*
    'onUploadComplete' : function(result){
        for (var i in result.post){
         alert(i+':::'+result[i]);
        }
       },
    */
    //�ļ��ϴ��ɹ���ʱ��
    'onUploadSuccess' : function(file, data, response) {
     alert(data);
     },
     //
       'onUploadError' : function(file, errorCode, errorMsg, errorString) {
     alert(file.name + '�ϴ�ʧ��ԭ��:' + errorString); 
     },
     'itemTemplate' : '׷�ӵ�ÿ���ϴ��ڵ��html',
     'height'  : 30, //���ø߶� button
     'width'  : 30, //���ÿ��
     'onDisable' : function(){
      alert('����ֹ�ϴ�');
     },
     'onEnable'  : function(){
      alert('�����Լ����ϴ���');
     },
     //���ļ�ѡ�е�ʱ��
     'onSelect'  : function(file){
      alert(file.name+"�Ѿ���ӵ�����");
     }
   });
  });

	</script>
</body>
</html>