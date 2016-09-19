@extends('foreground.mobilehead')
@section('title', '修改个人资料')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	label{color:#333}
	input{text-align:right;color:#A4A4A4}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
       <form name="form" action="/user_m/saveinfo" method="post">
            {!! csrf_field() !!} 
 
	    <div class="mui-input-group">
            <div class="mui-input-row" >
               <label>昵称</label>
               <input type="text" value="{{ $username }}" name="nickname" maxlength="8">
            </div>
		</div>
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>生日</label>
               <select style="width:30px;margin-right: 0.03rem;" id="day" name="day">
                   <option value="{{ $day }}">{{$day}}</option>;
                </select>
                <select style="width:30px;" id="month" name="month">
                    <option value="{{ $month }}">{{$month}}</option>;
                </select>
                <select style="width:45px;margin-right: 0.03rem;" id="year" name="year" value="{{ $year }}">
                   <option value="{{ $year }}">{{$year}}</option>;
                </select>
            </div>
		</div>
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>性别</label>
                <select id="sexselect" name="sex" style="width:80px;margin-right: 0.03rem;">
                    <option value="男" <?php echo $sex=='男'?'selected':'';?>>男</option>
                    <option value="女" <?php echo $sex=='女'?'selected':'';?>>女</option>
                </select>
            </div>
		</div>
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>家乡</label>
               <input type="text" name="home_address" value="{{ $homeaddress}}" placeholder="输入家乡所在地" maxlength="30">
            </div>
		</div>
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>所在地</label>
               <input type="text" name="now_address" value="{{ $nowaddress}}" placeholder="输入现所在地" maxlength="30">
            </div>
		</div>
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>月收入</label>
               <input type="text" name="salary" value="{{$salary}}" placeholder="输入收入"  maxlength="8">

            </div>
		</div>
		 
	 
		 

        <div class="button-common"><button type="submit" class="mui-btn mui-btn-danger mui-btn-block">保存</button></div>

      </form>
   </div>
@endsection

@section('my_js')
   <script>
   var error = "{{$errors->first()}}";
   if(error!=''){
	   myalert(error);
   }
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
        var yearid = $('#year')    //年所在的控件
        var monthid = $('#month')    //月所在的控件
        var dayid = $('#day')    //天所在的控件
        var myDate = new Date();
        var year = myDate.getFullYear();
        for (var i = (year - 5); i >= (year - 80); i--) {
            yearid.append('<option value="' + i + '">' + i + '</option>')
        }
        yearid.change(function() {
            monthid.html('')
            for (var i = 1; i <= 12; i++) {
                monthid.append('<option value="' + i + '">' + i + '</option>')
            }
            monthid.change()
        })

        monthid.change(function() {
            var yearValue = yearid.val()
            var monthValue = parseInt(monthid.val())
            var dayvalue;
            dayid.html('')


            if (monthValue == 1 || monthValue == 3 || monthValue == 5 || monthValue == 7 || monthValue == 8 || monthValue == 10 || monthValue == 12) {
                dayvalue = 31
            } else if (monthValue == 4 || monthValue == 6 || monthValue == 11 || monthValue == 9) {
                dayvalue = 30
            } else if (monthValue == 2) {

                if (yearValue % 4 == 0 && (yearValue % 100 != 0 || yearValue % 400 == 0)) { //闰年
                    dayvalue = 29
                } else {
                    dayvalue = 28
                }
            }

            for (var i = 1; i <= dayvalue; i++) {
                dayid.append('<option value="' + i + '">' + i + '</option>')
            }

        })
       $(".mui-btn").click(function(){
           layer.open({type: 2});
       })
   </script>
@endsection



 


