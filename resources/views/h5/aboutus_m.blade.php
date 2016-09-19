@extends('foreground.mobilehead')
@section('title', '关于我们')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{$h5_prefix }}css/common.css">
   <style>

	    html{font-size: 100px;}
    	body{font-family: "微软雅黑";}
    	.ts_introduce{font-size:.13rem;line-height: 18px;color: #313131;padding: 5%;background: white;}
    	.coperation_partner_title{font-size: .16rem;line-height: 32px;color: white;width:100%;height: 30px; 
		 background: #e63955; margin: 0 auto;padding-left:0.15rem;border-top-left-radius:5px;border-top-right-radius:5px;}
    	.coperation_partner{padding-left: 5%;}
    	.inner_ct{width: 95%;padding-bottom: 10px;}
    	.coperation_partner_imgs{background: white;padding:10px 0;text-align:center;border:1px solid #ddd;
								 border-bottom-left-radius:5px;border-bottom-right-radius:5px;border-top:none}
    	.coperation_partner_imgs img{width:96%;}
    	.ts_company{width: 90%;background: white;margin: 0 auto;}
    	.ts_company img{width: 100%;}
    	.img_left,.img_right {width: 49%;;display: inline-block; vertical-align: top;    text-align: center;}
    	.coperation_partner .img_left img{width: 90%;}
    	.coperation_partner .img_right img{width: 80%;}
		.abs{text-align:center;border:1px solid #ddd;
		    padding:10px 0 10px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;border-top:none
		}
		.abs img{width:96%;}
   </style>
@endsection

@section('content')
   <div class="ts_introduce" style='margin-top:50px'>
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		   特速集团总部位于深圳，是经国家经贸部、海关总署批准的国际化集团公司。集团旗下拥有香港特速、深圳特速、东莞特速、特速国际、木有关系网络、特速软件研发、链金所金融、
		   全木行电商、等数十家全资子公司，在深圳、东莞、腾冲等国际港口拥有仓储基地数十万平方，业务涉及金融、电商、仓储、物流等众多领域，业务覆盖全球数十个国家。
	</div>
	

		<div class="ts_company">
			<img src="{{$h5_prefix}}images/ts_company.png"/>
		</div>

	<div class="ts_introduce">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		         特速一块购是由特速集团旗下木有关系网络科技有限公司投入巨资打造的一家新型电商平台，先后与央视网、腾讯、百度等企业达成合作伙伴关系，并接入了腾讯天御安全防护系统，
				 为平台的稳定，用户的账户、交易、资金安全保驾护航。
	</div>
	
	<div class="coperation_partner">
		<div class="inner_ct">
			<div class="coperation_partner_title">合作伙伴</div>
			<div class="coperation_partner_imgs">
				<img src="{{$h5_prefix }}images/hzicon.jpg"/>
			</div>
			
		</div>
	</div>
	
	<div class="coperation_partner">
		<div class="inner_ct">
			<div class="coperation_partner_title">公司荣誉</div>
			<div class="abs">
				<img src="{{$h5_prefix}}images/abs.png" alt="">
			</div>
			
		</div>
	</div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 