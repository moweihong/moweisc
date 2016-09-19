@section('my_css')
<link rel="stylesheet" href="{{ asset('backend/uploadify/uploadify.css') }}" type="text/css">
@endsection

@section('my_uploadjs')

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
                            <img  src="{{ $himinfo->user_photo?:config('global.default_photo') }}" onerror="javascript:this.src='{{$url_prefix}}img/nodata/tx-loading.png';" />
                            <span class="c_text_top">编辑头像</span>
                   
                            <div class="c_top_bg"></div>
                            
                       </a>
                      
                    </div>
                    <div class="c_investor_details">
                        <p><span id="timeMark">亲，您好</span>： <a href="javascript:void(0);" id="userName"></a><span
                                    id="prompt"></span></p>
                        <ul class="c_investor_ul">
                 
                            <li>昵称：<input id="updateNickName" value="" maxlength="15" style="display: none;"
                                          type="text"/><a href="javascript:void(0)" style="color:#fff;"
                                                          id="nicknamemsg"></a>{{ $himinfo->nickname }}<i></i></li>
                            <!--<li>会员等级：<span id="rankName"></span></li>-->
                      
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
 