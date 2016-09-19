@extends('foreground.mobilehead')
@section('title', '个人信息')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
	<style>
		html,body{background:#ECECEC}
	</style>
@endsection

@section('content')
<div class="mui-content">
   <div class='user_contain uc1' >
		<div class="user_content">
			<ul>
                <li	style='height:0.8rem;line-height:0.8rem'>
                <form enctype="multipart/form-data" id="userForm" action="/user_m/saveface" method="post">
                   {!! csrf_field() !!} 

					<div class='uc_title' >头像</div>
					<div class='uc_title2'>
						<div class="uc_portrait">
                            <img src="{{ $photo or $h5_prefix.'images/lazyload130.jpg'}}" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg'" alt="" id="img" onclick="$('#face').click();">
                            <input id="face" type="file" name="photo"  style="margin-left: 39%;display: none">
						</div>
                        <div class='uc_title'><center style="color:red">{{$errors->first('photo')}}</center></div>
					</div>
                    

                </form>
                </li>
                <li data-url="/user_m/setinfo"><div class='uc_title' >昵称</div><div class='uc_title2'>{{$username}}<span></span></div></li>
				<li data-url="/user_m/setinfo"><div class='uc_title' >生日</div><div class='uc_title2'>{{$birthday}}<span></span></div></li>
				<li data-url="/user_m/setinfo"><div class='uc_title' >性别</div><div class='uc_title2'>{{$sex}}<span></span></div></li>
			</ul>
		</div>
   </div>
   
   <div class='user_contain uc2' >
		<div class="user_content">
			<ul>
                <li ><div class='uc_title' >手机<span class='uc_small'></span></div><div class='uc_title2'>{{$mobile or '去绑定'}}</div></li>
<!--				<li><div class='uc_title' >Q&nbsp;&nbsp;Q <span class="uc_redbg">绑定奖励50块乐豆</span></div><div class='uc_title2'>去绑定<span></span></div></li>
				<li><div class='uc_title' >微信 <span class="uc_redbg">绑定奖励50块乐豆</span></div><div class='uc_title2'>去绑定<span></span></div></li>-->
				<li data-url="/user_m/bindmail"><div class='uc_title' >邮箱绑定</div><div class='uc_title2'>{{$user_email or '去绑定'}}<span></span></div></li>
			</ul>
		</div>
   </div>
   
   <div class='user_contain uc2' >
		<div class="user_content">
			<ul>
				<li data-url="/user_m/setinfo"><div class='uc_title' >家乡</div><div class='uc_title2'>{{$homeaddress}}<span></span></div></li>
				<li data-url="/user_m/setinfo"><div class='uc_title' >所在地</div><div class='uc_title2'>{{$nowaddress}}<span></span></div></li>
                <li data-url="/user_m/setinfo"><div class='uc_title' >月收入</div><div class='uc_title2'>{{$salary}}<span></span></div></li>
<!--				<li><div class='uc_title' >我的等级</div><div class='uc_title2'>土豪<span></span></div></li>-->
			</ul>
		</div>
   </div>
</div>
@endsection

@section('my_js')
   <script>
    $(function() { 
    $('#face').change(function() { 
        var file = this.files[0]; 
        var r = new FileReader(); 
        r.readAsDataURL(file); 
        $(r).load(function() { 
            $('#img').attr('src',this.result);           
        })
        $('#userForm').submit();
    }) 
})
   </script>
@endsection



 