<!DOCTYPE HTML>
<html>
	<head>
		<title>打印的表格</title>
	</head>
	<style media="print" type="text/css">
        .Noprint
        {
            display: none;
        }
        .PageNext
        {
            page-break-after: always;
        }
        
       
    </style>
    <style type="text/css">
    	 .printContent
        {
        	
        	margin-bottom: 80px;
        }
    </style>
	 <script src="{{ asset('backend/lib/jquery-1.7.2.min.js') }}" type="text/javascript"></script>
	<script>
	$(function(){
        $("#btnPrint").click(function(){ $("#printContent").printArea(); });
});
	
	
	function isOk(){
	if(confirm('是否开始打印?')){
		
        $('#print1').hide();
       
		window.print();
		$('#print1').show();
	}else{
		$('#print1').show();
		return false;
	}
	}
	

	var hkey_key;
	var hkey_root="HKEY_CURRENT_USER";
	var hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup\\";
	//设置网页打印的页眉页脚为空
	function pagesetup_null()
	{   
	    var RegWsh = new ActiveXObject("WScript.Shell");
	    hkey_key="header";
	    RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
	    hkey_key="footer";
	    RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
	}
	//设置网页打印的页眉页脚为默认值
	function pagesetup_default()
	{
		  try{
		    var RegWsh = new ActiveXObject("WScript.Shell");
		    hkey_key="header";
		    RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"&w&b页码，&p/&P");
		    hkey_key="footer";
		    RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"&u&b&d");
		  }catch(e){}
	}
</script>
	<body>
<?php foreach($data as $v){?>
<table class="printContent" style="width: 99%; border-collapse: collapse;" border="1" >
  <tbody><tr>
    <td colspan="6" style="text-align: center;">深圳市木有关系网络科技有限公司</td>
  </tr>

  <tr>
    <td colspan="6" align="center">

    	@if($sign==1)
    	代收代付订单
    	@else
    	促销费用订单
    	@endif 

    </td>
  </tr><tr style="">
    <td colspan="1">用户：<?php echo $v->mobile;?></td>
    <td colspan="2">日期：<?php echo date('Y-m-d H:i:s',floor($v->kaijiang_time/1000));?></td>
    <td colspan="3">订单号：<?php echo $v->code;?></td>
  </tr>
  <tr>
    <td>编号</td>
    <td>商品名称</td>
    <td>规格</td>
    <td>单位</td>
    <td>数量</td>
    <td>金额</td>
  </tr>
   <tr style="height: 120px">
    <td rowspan="4">1</td>
    <td rowspan="4"><?php echo $v->title2;?></td>
    <td rowspan="4"> &nbsp;</td>
    <td rowspan="4">元</td>
    <td rowspan="4">1</td>
    <td rowspan="4"><?php echo $v->money;?></td>
  </tr>
  <tr>
    
  </tr>
  <tr>  
  </tr>
  <tr>

  </tr>
  <tr>
    <td colspan="2">合计：<?php echo $v->money;?>元</td>
    <td colspan="4">大写金额：<?php echo $v->numtormb;?></td>
  </tr>
  <tr>
    <td colspan="1">制单人:郑晓凤</td>
    <td colspan="3" style="padding-left:70px ;">部门主管：郑佳涛</td>
    <td colspan="2">仓管：彭家宜</td>
  </tr>
</tbody></table>

<!--<table style="width: 99%; border-collapse: collapse;" border="1" class="printContent">
  <tbody><tr>
    <td colspan="6" style="text-align: center;">深圳市木有关系网络科技有限公司</td>
  </tr>

  <tr>
    <td colspan="6" align="center">

    	@if($sign==1)
    	代收代付订单
    	@else
    	促销费用订单
    	@endif 

    </td>
  </tr><tr style="">
    <td colspan="1">用户：<?php echo $v->mobile;?></td>
    <td colspan="2">日期：<?php echo date('Y-m-d H:i:s',floor($v->kaijiang_time/1000));?></td>
    <td colspan="3">订单号：<?php echo $v->code;?></td>
  </tr>
  <tr>
    <td>编号</td>
    <td>商品名称</td>
    <td>规格</td>
    <td>单位</td>
    <td>数量</td>
    <td>金额</td>
  </tr>
   <tr style="height: 120px">
    <td rowspan="4">1</td>
    <td rowspan="4"><?php echo $v->title2;?></td>
    <td rowspan="4"> &nbsp;</td>
    <td rowspan="4">元</td>
    <td rowspan="4">1</td>
    <td rowspan="4"><?php echo $v->money;?></td>
  </tr>
  <tr>
    
  </tr>
  <tr>  
  </tr>
  <tr>

  </tr>
  <tr>
    <td colspan="2">合计：<?php echo $v->money;?>元</td>
    <td colspan="4">大写金额：</td>
  </tr>
  <tr>
    <td colspan="1">制单人:郑晓凤</td>
    <td colspan="3" style="padding-left:70px ;">部门主管：</td>
    <td colspan="2">仓管：</td>
  </tr>
</tbody></table>

<table style="width: 99%; border-collapse: collapse; margin-bottom: 40px;" border="1" >
  <tbody><tr>
    <td colspan="6" style="text-align: center;">深圳市木有关系网络科技有限公司</td>
  </tr>

  <tr>
    <td colspan="6" align="center">

    	@if($sign==1)
    	代收代付订单
    	@else
    	促销费用订单
    	@endif 

    </td>
  </tr><tr style="">
    <td colspan="1">用户：<?php echo $v->mobile;?></td>
    <td colspan="2">日期：<?php echo date('Y-m-d H:i:s',floor($v->kaijiang_time/1000));?></td>
    <td colspan="3">订单号：<?php echo $v->code;?></td>
  </tr>
  <tr>
    <td>编号</td>
    <td>商品名称</td>
    <td>规格</td>
    <td>单位</td>
    <td>数量</td>
    <td>金额</td>
  </tr>
   <tr style="height: 120px">
    <td rowspan="4">1</td>
    <td rowspan="4"><?php echo $v->title2;?></td>
    <td rowspan="4"> &nbsp;</td>
    <td rowspan="4">元</td>
    <td rowspan="4">1</td>
    <td rowspan="4"><?php echo $v->money;?></td>
  </tr>
  <tr>
    
  </tr>
  <tr>  
  </tr>
  <tr>

  </tr>
  <tr>
    <td colspan="2">合计：<?php echo $v->money;?>元</td>
    <td colspan="4">大写金额：</td>
  </tr>
  <tr>
    <td colspan="1">制单人:郑晓凤</td>
    <td colspan="3" style="padding-left:70px ;">部门主管：</td>
    <td colspan="2">仓管：</td>
  </tr>
</tbody></table>-->
<?php }?>
<input onclick="isOk()" id='print1' type="button" value="打印" />
<!--<input id='btnPrint' type="button" value="打印2" />-->

              
</body>
</html>