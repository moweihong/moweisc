

@section('my_css')
<link rel="stylesheet" href="{{ asset('backend/uploadify/uploadify.css') }}" type="text/css">
@endsection

@section('my_uploadjs')

<script src="{{ asset('backend/uploadify/jquery.uploadify.mint.js') }}" type="text/javascript"></script>

 
 <script type="text/javascript">
  <?php $timestamp = time();?>
  var prizenum = {{$myprize}}; 
  var prizeurl =  location.href;

  $(function() {
   $('#file_upload').uploadify({
    
    //上传文件时post的的数据
    'formData'     : {
     'timestamp' : '<?php echo $timestamp;?>',
     'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
     'uid'  : '<?php echo session('user.id');?>',
    },
    'swf'      : editurl['webswf'],
    'uploader' : '/uploadify/up',
    'onInit'   : function(index){
     //alert('队列ID:'+index.settings.queueID);
    },
    'method'   : 'post', //设置上传的方法get 和 post
    'auto'    : true, //是否自动上传 false关闭自动上传 true 选中文件后自动上传
    //'buttonClass' : 'myclass', //自定义按钮的样式
    //'buttonImage' : '按钮图片',
    //'buttonText'  : '重选', //按钮显示的字迹
    //'fileObjName' : 'mytest'  //后台接收的时候就是$_FILES['mytest'] 
    //'checkExisting' : '/uploadify/check-exists.php', //检查文件是否已经存在 返回0或者1
    'fileSizeLimit' : '210000KB', //上传文件大小的限制
   // 'fileTypeDesc'  : '你需要一些文件',//可选择的文件的描述
    'fileTypeExts'  : '*.gif; *.jpg; *.png', //文件的允许上传的类型
    'progressData'  : 'speed', //文件的允许上传的类型
    //上传的时候发生的事件
    'onUploadStart' : function(file){
      //alert('开始上传了');
      },
    'uploadLimit'   : 10, //设置最大上传文件的数量
    /*
    'onUploadComplete' : function(result){
        for (var i in result.post){
         alert(i+':::'+result[i]);
        }
       },
    */
    //文件上传成功的时候
    'onUploadSuccess' : function(file, data, response) {
        //alert(data);
        $('#alterFace').attr('src',data);
        layer.msg('保存成功');


     },
     //
       'onUploadError' : function(file, errorCode, errorMsg, errorString) {
        // alert(file.name + '上传失败原因:' + errorString);
     },
     //'itemTemplate' : '追加到每个上传节点的html',
     'height'  : 30, //设置高度 button
     'width'  : 30, //设置宽度
     'onDisable' : function(){
      //alert('您禁止上传');
     },
     'onEnable'  : function(){
      //alert('您可以继续上传了');
     },
     //当文件选中的时候
     'onSelect'  : function(file){
     // alert(file.name+"已经添加到队列");
     }
   });
    if((prizeurl.indexOf("/user/prize") < 0) && (prizeurl.indexOf("/user/address/") < 0)){
        showwindow(prizenum);
    }
    function showwindow(num){
        if(num > 0){
         index = layer.open({
                type: 1,
                title: '',
                area: ['434px', '250px'], //宽高
                content: $("#myprize"),
            });
        }
    }
  });
 </script>
 @endsection
 
<div class="b_sup_content">
    <!-- S 会员资料 -->
    <div id="member_top" class="">
        <style>
            .c_out_a i, .c_first_out_a i {
                background: rgba(0, 0, 0, 0) url(../static/new/img/icon/member_comm/left_icon.pngg ") no-repeat scroll 0 0; } .c_personage_data { background: url(../../public/img/icon2.png) no-repeat top center
            }

            .c_login_code {
                background: url(../../public/img/icon3.png) no-repeat top center
            }

            .c_real_name {
                background: url(../../public/img/icon4.png) no-repeat top center
            }

            .c_investor_ul li {
                font-size: 12px;
            }

            .c_investor_ul li span {
                font-size: 12px;
            }

            .c_investor_ul li a {
                font-size: 12px;
            }

            .c_investor_ul li input {
                font-size: 12px;
            }

            .c_investor_ul {
                padding-left: 10px;
                font-size: 12px;
            }
        </style>
        <!--S 头部 -->
        <!--S 头部 -->
        <div class="c_homepage_header"     >
            <div class="c_homepage_headercon">
            	<!--<input type="button" id="file_upload" name="file_upload" class="button" value="上传图片"/>-->
                <div class="c_headercon_left">
                    <div class="c_investor_img">
                    <a href="javascript:void(0);">
                            <img id="alterFace" src="{{ session('user.photo')?:config('global.default_photo') }}" onerror="javascript:this.src='{{$url_prefix}}img/nodata/tx-loading.png';" />
                            <span class="c_text_top">编辑头像</span>
                   
                            <div class="c_top_bg"></div>
                            
                       </a>
                       <input type="button" id="file_upload" name="file_upload" class="button" value="上传图片"/>
                    </div>
                    <div class="c_investor_details">
                        <p><span id="timeMark">亲，您好</span>： <a href="javascript:void(0);" id="userName"></a><span
                                    id="prompt"></span></p>
                        <ul class="c_investor_ul">
                 
                            <li>手机：<span id="mobile"></span>{{ session('user.phone') }}<i>|</i></li>
                            <li>邮箱：<span id="email"></span>{{ session('user.email') }}<i>|</i></li>
                            <li>昵称：<input id="updateNickName" value="" maxlength="15" style="display: none;"
                                          type="text"/><a href="javascript:void(0)" style="color:#fff;"
                                                          id="nicknamemsg"></a>{{ session('user.nickname') }}<i>|</i></li>
                            <!--<li>会员等级：<span id="rankName"></span></li>-->
                        	<li><a href="/user/security">编辑信息<span ></span><i></i></a></li>
                        </ul>
                    </div>
                </div>
                <!--<div class="c_headercon_right">
                    <a href="javascript:sign();" class="c_personage_data">
                        <span id="signLogo" title="">今日签到</span>
                        <input type="hidden" id="signTime">
                        <input type="hidden" id="mid">
                    </a>
                    <a href="save.do~flag=1.html" class="c_login_code">
                        <span>登录密码</span>
                    </a>
                    <a href="address.do.html" class="c_real_name">
                        <span>收货地址</span>
                    </a>
                </div>-->
            </div>
        </div>
    </div>
</div>
 <div class="p-rec-tips" id="myprize" style="text-align:center;">
    <h2 class="rec-tiph2" style="padding-left:0px;color: #ff0000;font-weight: bold;">恭喜您获得了</h2>
    <div class="rec-tiptxt" style="padding-left:0px;">
        @if($myprize>0 && isset($my_prize_list))
        <p style="color: #ff0000;">
            @foreach($my_prize_list as $key=>$val)
                @if($key<3)
                "{{ str_limit($val,10,'...') }}"
                @else
                等商品
                @break
                @endif
            @endforeach
        </p>
        @endif
        <p>亲，请尽快登陆到个人中心完善收货地址信息</p>
    </div>
    <p class="rec-tipbut clearfix" style="margin-left:100px;"><a href="/user/prize"  class="rect-record" style="background-color: #ff0000">立即完善</a></p>
</div>
 