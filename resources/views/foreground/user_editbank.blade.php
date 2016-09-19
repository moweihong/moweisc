{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','编辑我的银行卡')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection

@section('content_right')
    <div id="member_right" class="member_right">
        <!--addbankcard start-->
        <div class="mycommission">
            <!--tit start-->
            <div class="u_questit tabtit clearfix">
                <a class="u_quet_a" href="/user/commission" title="招募合伙人" style="display: none;">招募合伙人</a>
                <a class="u_quet_a" href="/user/commissionsource" title="佣金来源">佣金来源</a>
                <a class="u_quet_a" href="/user/commissionbuy" title="佣金消费">佣金消费</a>
                <a class="u_quet_a u_quet_acurr" href="/user/mybankcard" title="我的银行卡">我的银行卡</a>
            </div>
            <!--tit end-->
            <!--txt start-->
            <div class="user-mybanklist">
                <div class="a_record_list_bank"><p class="a_record_list_bank_tit">您已绑定了<span class="bank_card_own_count">{{ $banktotal }}</span>张银行卡，还可以绑定<span class="bank_card_remain_count">{{ 3-$banktotal }}</span>张。</p></div>
                <!--addbank start-->
                <div class="a_record_bank_add">
                    <p class="a_bank_card_add_title">请选择银行<em>（绑定提现银行卡，仅能添加与您实名认证信息一致的储蓄卡）</em></p>
                    <div class="a_bankcard_list clearfix">
                        <ul>
                            <li class="{{ $bankinfo=='ICBC' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_ICBC" title="中国工商银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='ABC' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_ABC" title="中国农业银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='CCB' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_CCB" title="中国建设银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='PSBC' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_PSBC" title="中国邮政储蓄银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='CMB' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_CMB" title="招商银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='BOC' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_BOC" title="中国银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='COMM' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_COMM" title="交通银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='CEB' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_CEB" title="中国光大银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='CITIC' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_CITIC" title="中信银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='SPABANK' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_SPABANK" title="平安银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='CMBC' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_CMBC" title="中国民生银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='CIB' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_CIB" title="兴业银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='GDB' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_GDB" title="广发银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='HXBANK' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_HXBANK" title="华夏银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='SPDB' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_SPDB" title="浦发银行"></span><i></i></li>
                            <li class="{{ $bankinfo=='BJBANK' ? 'a_bank_liclick':'' }}"><span class="a_bankcard_ico a_bankcard_BJBANK" title="北京银行"></span><i></i></li>
                        </ul>
                    </div>
                </div>
                <!--addbank end-->
                <!--table start-->
                <div class="c_address a_address">
                    <div class="c_form_con clearfix" style="margin-bottom:0px;">
                        <label>持卡人  ：</label>
                        <div class="c_form_right">
                            <input maxlength="10" id="bank_ower_name" class="c_khname" type="text" onkeyup="value=value.replace(/[^a-zA-Z\u4E00-\u9FA5]/g,'');" value="{{ $bank->username }}" >
                        </div>
                    </div>
                    <p class="a_ts_bank">该银行卡开户姓名必须为以上填写的姓名，否则会提现失败！</p>
                    <div class="c_form_con">
                        <label>开户行  ：</label>
                        <div class="c_form_right">
                            <input maxlength="30" id="bank_name" class="c_khname" type="text" value="{{ $bank->bankname }}" readonly="readonly" style="font-size: 16px;">
                        </div>
                        <div class="c_clear"></div>
                    </div>
                    <p class="a_ts_bank"><span>银行账户类型为借记卡，不支持信用卡</span></p>
                    <div class="c_form_con">
                        <div class="a_card_number" style="border: 1px solid #dd2726;color:#dd2726; display:none;font-weight:bold;font-size:16px;height: 36px;left: 100px; line-height: 36px; position: absolute;top: -38px;width: 210px;padding:0 8px;background:#fff;"></div>
                        <label>卡号：</label>
                        <div class="c_form_right">
                            <input id="card_input" class="c_details_contact a_details_contact" maxlength="19" value="{{ $bank->banknum }}" onkeyup="value=value.replace(/[^0-9]/g,'').replace(/\s/g,'');" type="text">
                            <p class="c_error">请输入卡号</p>
                        </div>
                        <div class="c_clear"></div>
                    </div>
                    <div class="c_form_con">
                        <label>支行 ：</label>
                        <div class="c_form_right">
                            <input maxlength="30" id="bank_subname" value="{{ $bank->subbranch }}" class="c_details_contact a_details_contact" type="text" onkeyup="value=value.replace(/[^a-zA-Z\u4E00-\u9FA5]/g,'');">
                            <p class="c_error">请输入支行</p>
                        </div>
                        <div class="c_clear"></div>
                    </div>
                    <div class="c_form_con" style="display: none;">
                        <label>持卡人地区：</label>
                        <ul class="c_form_right">
                            <li class="c_contact">
                                <div class="select_showbox" id="provinceDiv">
                                    <select id="province" style="display: block;"><option value="-1">请选择省份</option><option value="2">北京市</option><option value="3">天津市</option><option value="4">河北省</option><option value="5">山西省</option><option value="6">内蒙古自治区</option><option value="7">辽宁省</option><option value="8">吉林省</option><option value="9">黑龙江省</option><option value="10">上海市</option><option value="11">江苏省</option><option value="12">浙江省</option><option value="13">安徽省</option><option value="14">福建省</option><option value="15">江西省</option><option value="16">山东省</option><option value="17">河南省</option><option value="18">湖北省</option><option value="19">湖南省</option><option value="20">广东省</option><option value="21">广西壮族自治区</option><option value="22">海南省</option><option value="23">重庆市</option><option value="24">四川省</option><option value="25">贵州省</option><option value="26">云南省</option><option value="27">西藏自治区</option><option value="28">陕西省</option><option value="29">甘肃省</option><option value="30">青海省</option><option value="31">宁夏回族自治区</option><option value="32">新疆维吾尔自治区</option></select>
                                </div>
                                <span>省</span>
                                <p class="c_error" style="width: 110px; padding-left: 20px; left: 5px;">请输入省份</p>
                            </li>
                            <li class="c_contact">
                                <div class="select_showbox" id="cityDiv"><select id="city" style="display: block;"><option value="-1">请选择市</option></select></div>
                                <span>市</span>
                                <p class="c_error" style="width: 110px; padding-left: 20px; left: 5px;">请输入地市</p>
                            </li>
                            <li class="c_contact">
                                <div class="select_showbox" id="areaDiv"><select id="city" style="display: block;"><option value="-1">请选择市</option></select></div>
                                <span>县</span>
                                <p class="c_error" style="width: 110px; padding-left: 20px; left: 5px;">请输入区县</p>
                            </li>
                        </ul>
                        <div class="c_clear"></div>
                    </div>
                    <div class="c_form_con" style="display: none;">
                        <label>验&nbsp;&nbsp;&nbsp;&nbsp;证&nbsp;&nbsp;&nbsp;码：</label>
                        <div class="c_form_right">
                            <input maxlength="6" id="bank_valid_code" class="c_test" type="text">
                            <p class="c_error">请输入认证手机验证码</p>
                            <button id="bank_get_code_btn" class="c_veri_code a_veri_code_bank">获取短信验证码</button>
                            <b class="c_add_tips">验证码发送至：<span id="bank_valid_code_send_to"></span>请查收</b>
                        </div>
                        <div class="c_clear"></div>
                    </div>
                    <div class="c_form_con">
                        <button id="bank_submit_btn"  class="c_save" onclick="addBank()">确认提交</button><button class="c_save_other" onclick="window.location='/user/mybankcard'">返回上一步</button>
                    </div>
                </div>
                <!--table end-->
            </div>
            <!--txt start-->
        </div>
        <!--addbankcard end-->
    </div>
    <!-- E 右侧 -->
@endsection
@section('my_js')
    <script>
        $(function(){
            //银行卡选择器
            $(".a_bankcard_list ul li").click(function(){
                $(this).addClass("a_bank_liclick").siblings("li").removeClass("a_bank_liclick");
                var bankname = $(this).find(".a_bankcard_ico").attr("title");
                $("#bank_name").val(bankname);
            })
            /*银行卡号书写提示框*/
            $("#card_input").keyup(function(){
                $(".a_card_number").show();
                var cardno = $(this).val();
                $(".a_card_number").html(cardno.replace(/(\d{4})(?=\d)/g,'$1 '));
            })
            $("#card_input").blur(function(){
                $(".a_card_number").html("");
                $(".a_card_number").hide();
            })

            //发送获取验证码倒计时
            var wait= 59;
            var yzmobj = $(".c_veri_code");
            $(".c_veri_code").click(function(){
                time();
            });
            function time() {
                if (wait == 0) {
                    yzmobj.removeAttr("disabled");
                    yzmobj.html("发送短信获取验证码");
                    wait = 59;
                } else {
                    yzmobj.attr("disabled","disabled");
                    yzmobj.html(wait + "秒后重新发送短信");
                    wait--;
                    setTimeout(function() {
                                time(yzmobj)
                            },
                            1000)
                }
            }
        })
        // 添加和修改银行卡信息
        function addBank(){
            // 校验信息合法性
            if($("#bank_ower_name").val() == ""){
                    layer.tips('持卡人姓名不能为空','#bank_ower_name');
                    return false;
            }
            if(/[<>'"\/\(\)=]+/.test($("#bank_ower_name").val())){
                    layer.tips('持卡人姓名格式不正确','#bank_ower_name');
                    return false;
            }
            if($("#bank_name").val() == ""){
                    layer.tips('持卡人姓名不能为空','#bank_name');
                    return false;
            }
            if($("#card_input").val() == ""){
                    layer.tips('卡号不能为空','#card_input');
                    return false;
            }
            if(isNaN($("#card_input").val()) || $("#card_input").val().length < 13 || $("#card_input").val().length > 19){
                    layer.tips('卡号格式不正确','#card_input');
                    return false;
            }
            if($("#bank_subname").val() == ""){
                    layer.tips('支行不能为空','#bank_subname');
                    return false;
            }
//            if($("#province").val()=="-1"){
//                    layer.tips('不能为空','#province');
//                    return false;
//            }
//            if($("#city").val()=="-1"){
//                    layer.tips('不能为空','#city');
//                    return false;
//            }
//            if($("#area").val()=="-1"){
//                    layer.tips('不能为空','#area');
//                    return false;
//            }
//            if($("#bank_valid_code").val()==""){
//                    layer.tips('不能为空','#bank_valid_code');
//                    return false;
//            }
            $.ajax({
                    type : 'post',
                    url : '/user/savebank',
                    data : {
                        action : 'update',
                        subbranch : $("#bank_subname").val(),
                        bankname : $("#bank_name").val(),                        
                        username : $("#bank_ower_name").val(),
                        banknum : $("#card_input").val(),
                        id : {{ $bank->id }},
                        _token : "{{csrf_token()}}",
                    },
                    dataType : 'json',
                    success : function(data) {
                        if(data == null){
                            layer.msg('服务端错误！');
                        }
                        if(data.status == 1){
                            layer.msg(data.msg);
                            location.href = '/user/mybankcard';
                        }else {
                          layer.msg(data.msg);
                        }
                    }
            });
        }
    </script>
@endsection

