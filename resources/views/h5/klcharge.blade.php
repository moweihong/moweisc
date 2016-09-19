@extends('foreground.mobilehead')
@section('title', '块乐豆充值')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
<style>
	.result_right_info,.result_error_info,.main{
		width: 80%;
		margin:44px auto;
	}
	.result_right_info,.result_error_info{
		text-align: center;
	}
	.card_no input,.c_password input{
	  font-size: .12rem;		  
	  margin: 5px 0;
	  height: 40px;
	}
	.c_validate div input:first-child{
        font-size: .12rem;
		width: 55%;
		height: 40px;
        margin: 5px 0;
	}
	.c_validate div img{
		width: 39.4%;
		height: 40px;
        margin: 5px 0;
		float: right;
		background: #999999;
		 
	}
	.c_confirm input,.c_confirm_btn{
 		 width: 100%;
 		 background: #e63955;
 		 color: white;
 		 margin-top: 61px;
	}
	.c_confirm_btn{
		 position: relative;
	    height: 33px;
	    line-height: 33px;
	}
	.c_confirm_btn span{
		position: absolute;
    	right: 10px;
	}
	.main span{
		color: #e63955;
		font-size:.1rem ;
		line-height: 26px;
	}
	.logo_right_bg,.logo_error_bg{
		width: .84rem;
	    height: .84rem;
	    background: #32b16c;
	    text-align: center;
	    line-height: 1rem;
	    border-radius: 50%;
	   	margin: 0 auto;
	}
	.logo_error_bg{
		background: #e63955;
	}
	.logo_right_bg img,.logo_error_bg img{
		zoom: .5;
	}
	.success_tip{
	    font-size: .2rem;
	    color: black;
	    font-weight: bold;
	    line-height: .5rem;
	    margin: 15px 0 0 0;
	}
	.result_right_info em,.result_error_info em{
	 font-size: .12rem;
    font-style: normal;
    color: #e63955;
    font-family: "微软雅黑";
	}
	.result_error_info em{
	 font-size: .12rem;	
	 color:#666666;
	}

</style>
@endsection

@section('content')
    <div class="mui-content">
   	    <div class="main">
	 	    <div class="card_no">
	 			<input type="text" placeholder="请输入充值卡号" name="card_num"/>
	 			<span class="hide error_tips">该卡已消费</span>
	 		</div>
			<div class="c_password">
			<input type="text" placeholder="请输入密码" name="card_pass"/>
			<span class="hide error_tips">卡号或密码错误，请重新输入！</span>
			</div>
			<div class="c_validate">
			<div><input type="text" name="captcha" placeholder="请输入验证码"/><img src="{{ URL('/captcha_m/1') }}"  onclick="this.src='{{ url('captcha_m') }}/'+Math.random();" id="captcha_img"></div>
			<span class="hide error_tips">验证码错误</span>
			</div>
			<div class="c_confirm">
	 			<input type="button" value="确认充值" onclick="submit(this)"/>
	 		</div>
 		</div>
 		
 		<div class="result_right_info hide">
 			<div class="logo_right_bg"><img src="{{ $h5_prefix }}images/logo-right.png"/></div>
 			<p class="success_tip">块乐豆充值成功!</p>
 			<em>100块乐豆=1RMB</em>
 			<div class="c_confirm">
                <a href="/category_m" data-url="/category_m"><div class="c_confirm_btn">去抽宝马<span>></span></div></a>
	 		</div>
 		</div>
 		
 		<div class="result_error_info hide">
 			<div class="logo_error_bg"><img src="{{ $h5_prefix }}images/logo-error.png"/></div>
 			<p class="success_tip">充值失败</p>
 			<em class="error_message"></em>
 			<div class="c_confirm">
	 			<div class="c_confirm_btn" id="go_back">返回</div>
	 		</div>
 		</div>
    </div>
   
@endsection

@section('my_js')
    <script>
        var flag = {{$flag}};
        var message = "{{$message}}";

        $(function(){
            $('#go_back').click(function(){
                $('.result_error_info').hide();
                $('.result_right_info').hide();
                $('.main').show();
            })
        })

        function submit(obj){
            obj = $(obj);
            obj.removeAttr('onclick');
            var card_num = $("input[name='card_num']").val();
            var card_pass = $("input[name='card_pass']").val();
            var captcha = $("input[name='captcha']").val();
            var _token = $("input[name='_token']").val();

            $('.error_tips').hide();
            if(!card_num || card_num == 'undefined'){
                $('.card_no').find('.error_tips').text('请输入卡号');
                $('.card_no').find('.error_tips').show();
                return false;
            }

            if(!card_pass || card_pass == 'undefined'){
                $('.c_password').find('.error_tips').text('请输入密码');
                $('.c_password').find('.error_tips').show();
                return false;
            }

            if(!captcha || captcha == 'undefined'){
                $('.c_validate').find('.error_tips').text('请输入验证码');
                $('.c_validate').find('.error_tips').show();
                return false;
            }

            if(flag == 0){
                $.ajax({
                    url: '/cz_sub',
                    type: 'post',
                    data: {card_num:card_num,card_pass:card_pass,captcha:captcha,_token:_token},
                    dataType: 'json',
                    success: function(res){
                        obj.attr('onclick', 'submit()');
                        if(res.status == 0){
                            $('.main').hide();
                            $('.result_right_info').show();
                        }else{
                            if(res.status == -2){
                                $('.c_validate').find('.error_tips').text(res.message);
                                $('.c_validate').find('.error_tips').show();
                                $('#captcha_img').click();
                                return false;
                            }else if(res.status == -3 || res.status == -5){
                                $('.c_password').find('.error_tips').text('卡号或密码输入错误，请重新输入');
                                $('.c_password').find('.error_tips').show();
                                $('#captcha_img').click();
                                return false;
                            }else if(res.status == -6){
                                $('.card_no').find('.error_tips').text(res.message);
                                $('.card_no').find('.error_tips').show();
                                $('#captcha_img').click();
                                return false;
                            }else{
                                $('.main').hide();
                                $('.error_message').text(res.message);
                                $('.result_error_info').show();
                            }
                        }
                    }
                })
            }else{
                obj.attr('onclick', 'submit()');
                $('.main').hide();
                $('.error_message').text(message);
                $('.result_error_info').show();
            }
        }
    </script>
@endsection
 