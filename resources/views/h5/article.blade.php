@extends('foreground.mobilehead')
@section('title', $article->title)
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{$h5_prefix }}css/common.css">
   <style>
		.contain{width:90%;margin:0.6rem auto;min-height:6.5rem;
				-webkit-box-shadow:0 0 10px #666;
				-moz-box-shadow:0 0 10px #666;
				 box-shadow:0 0 10px #333;
		}
		.logo{text-align:center;}
		.logo img{margin-top:1.1rem}
		.qr{text-align:center;}
		.qr img{margin-top:0.32rem}
		.gut{padding-top:0.2rem;margin:0 auto;padding-bottom:0.6rem}
		.gut_p{width:76%;margin:0 auto;}
		.gut_p p{color:#333; }
	 
   </style>
@endsection

@section('content')
   <div class="mt60 contain">
		<div class='gut'>
			<div class='gut_p'>
				 <?php echo $article->content;?>
			 </div>
		</div>
   </div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 