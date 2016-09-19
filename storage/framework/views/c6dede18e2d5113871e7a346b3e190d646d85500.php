<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>一块购后台管理系统</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="<?php echo e(asset('backend/lib/bootstrap/css/bootstrap.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('backend/lib/bootstrap/css/page.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('backend/stylesheets/theme.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('backend/lib/font-awesome/css/font-awesome.css')); ?>" />
		<link rel="stylesheet" href="<?php echo e(asset('backend/lib/time/bootstrap-datetimepicker.min.css')); ?>" />
    <script src="<?php echo e(asset('backend/lib/jquery-1.7.2.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(asset('backend/lib/time/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo e(asset('foreground/js/layer/layer.js')); ?>"></script>
    <!-- Demo page code -->

    <style type="text/css">
    		table{
    			table-layout: fixed;
    			
    		}
    		table td
    		{
    			word-wrap: break-word;
    		}
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
        
				.uploadify-button {
			    background-color: #505050;
			    background-image: linear-gradient(bottom, #505050 0%, #707070 100%);
			    background-image: -o-linear-gradient(bottom, #505050 0%, #707070 100%);
			    background-image: -moz-linear-gradient(bottom, #505050 0%, #707070 100%);
			    background-image: -webkit-linear-gradient(bottom, #505050 0%, #707070 100%);
			    background-image: -ms-linear-gradient(bottom, #505050 0%, #707070 100%);
			    background-image: -webkit-gradient(
			 linear,
			 left bottom,
			 left top,
			 color-stop(0, #505050),
			 color-stop(1, #707070)
			 );
			    background-position: center top;
			    background-repeat: no-repeat;
			    -webkit-border-radius: 30px;
			    -moz-border-radius: 30px;
			    border-radius: 30px;
			    border: 2px solid #808080;
			    color: #FFF;
			    font: bold 12px Arial, Helvetica, sans-serif;
			    text-align: center;
			    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
			    width: 100%;
			}


    </style>
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="lib/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <?php echo $__env->yieldContent('my_css'); ?>
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
	<?php echo $__env->make('backend.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->make('backend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    

	<div class="content" style="min-height:913px;">
    	<?php echo $__env->yieldContent('content'); ?>
	</div>


    <script src="<?php echo e(asset('backend/lib/bootstrap/js/bootstrap.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
   
   <h5 style="text-align: center;">温馨提示：建议用谷歌浏览器，更加好的体验哟!!!</h5>
  </body>
</html>
 

