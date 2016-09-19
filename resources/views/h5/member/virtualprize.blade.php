@extends('foreground.mobilehead')
@section('title', '中奖记录')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content" style='background-color:#fff' >
<style>html,body{background-color:#fff}</style>
      <!--box start-->
      <div id="prizeContent">
          <!--ajax异步加载-->
         <div class="jjjx-listbox zjjl-listbox mui-clearfix" style='border-bottom:1px solid #ddd'>
           <div class="jjjx-bimg"><a ><img src="{{ $img }}" /></a></div>
           <div class="jjjx-btxt zjjl-btxt">
              <h2><a >（第{{$g_periods}}期）{{$g_name}}</a></h2>
              <div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">本期参与：<span class="color-de2f51">{{$buycount}}人次</span></div>
              <div class="jjjx-des-other" style="color:#666666">揭晓时间：{{$kaijiang_time}}</div>
              <div class="zj-button mui-clearfix">
                 <a data-id="68" style="background:#e63955;color:#fff;padding:4px 14px">幸运号码{{$fetchno}}</a>
              </div>
           </div>
        </div>
     
        <div class="vir1">
			<p class='virp'>您获得了一份价值{{$g_money}}元的话费，请输入手机号码</p>
			<div class='vir2'>
				<div class="vir2-1">
                    <input id='typePhone' type="text" value='' maxlength="13">
				</div>
				<div class="vir2-2">号码格式不对</div>
			</div>
			<p style="color:#8A8A8A;margin:0.12rem;text-align:center">客官~号码一旦确定就无法更改哦</p>
        </div>
		
	    <div class='btttt'>
			<div class="btttt2">确 定</div>
		</div>
    
      </div>
      <!--box end-->
	<div class='h5tips'>
		<div class="h5tips1">
		<!--<div class="h5tips-title">马上开抢<i class="h5tips-close_btn">x</i></div>-->
			<div class="h5tips2">
				<p class="h5tips2-title">提交成功~</p>
				<p class="msgcontent">到账要一点点时间哦~不要着急~<br/>注意查收短信</p>
				<div class="h5tips_confirm_btn">好哒</div>
			</div>  
		</div>
	</div>
	
	<div class='h5failtips'>
		<div class="h5tips1">
		<!--<div class="h5tips-title">马上开抢<i class="h5tips-close_btn">x</i></div>-->
			<div class="h5tips2">
				<p class="h5tips2-title">咦？提交出错啦~</p>
				<p class="msgcontent">客官，拨打客服电话400-6626-985<br/>或重新确认号码试试吧</p>
				<div class="h5tips_confirm_btn">好哒</div>
			</div>  
		</div>
	</div>
	
   </div>
@endsection

@section('my_js')
   <script>
       var o_id = {{ $id }};
		$(document).ready(function(){
			$('#typePhone').keyup(function(){
				var p = $(this).val().replace(/\ +/g,"");  
				var q = '';
				for(var i=0;i<p.length;i++){
					if(i==3 || i==7) q+=' ';
					q += p.substr(i,1);
				}
				$(this).val(q);
                $('.vir2-2').hide();
                if(p.length == 11){
                    if(!checkMobile(p)){
                        $('.vir2-2').show();
                        return false;
                    }
                }
			});
		});
		
	 /*判断输入是否为合法的手机号码*/
     function isphone(inputString)
     {
          var partten = /^1[3,4,5,8]\d{9}$/;
          var fl=false;
          if(!partten.test(inputString)){
			  return false;
          }else{
			  return true;
		  }
     }
     
    $(".btttt2").click(function(){
        var mobile = $("#typePhone").val().replace(/\ +/g,"");
        if(mobile == ''){
            $('.vir2-2').show();
            return false;
        }
        if(mobile.length != 11){
            $('.vir2-2').show();
            return false;
        }
        if(!checkMobile(mobile)){
            $('.vir2-2').show();
            return false;
        }
        $(".layer_phone").hide();
        $.post('/user_m/autorecharge',{'id':o_id,'mobile':mobile,'_token':"{{ csrf_token() }}"},function(data){
            if(data.status == 1)
            {
                succTips();
            }
            else
            {
                failTips();                
            }
        },'json');
    });
    
    function checkMobile(mobile)
    {
        var arr = ['139','138','137','136','135','134','159','158','152','151','150','157','182','183','188','187','147','130','131','132','155','156','186','185','133','153','189','180'];
        var result = $.inArray(mobile.substr(0,3), arr);
        if(result > -1){
            return true;
        }else {
            return false;
        }
    }
	//充值提示
	function succTips(){
		$(".h5tips").show();
	}
	function failTips(){
		$(".h5failtips").show();
	}
	$(".h5tips_confirm_btn").click(function(){
		$(".h5tips,.h5failtips").hide();
        location.href = '/user_m/prize';
	});
   </script>
@endsection



 