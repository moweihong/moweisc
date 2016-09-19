{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','用户充值')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
	<style>
		.member_right{min-height:200px}
	</style>
@endsection
@section('content_right')
        <!--提现和佣金转余额 start-->
    <div id="member_right" class="member_right">
        <!--tit start-->
        <div class="u_questit tabtit clearfix">
            <a class="u_quet_a u_quet_acurr" href="javascript:void(0)" title="用户充值">用户充值</a>
        </div>
        <!--tit end-->
        <!--main start-->
        <div class="p-recharge-container">
        <!--选择金额 start-->
        <div class="prec-t-box clearfix">
            <span class="prec-tlable">选择金额</span>
            <div class="prec-moneylist ">
                <div class="pay-money-ul clearfix">
                    <ul>
                    	<li class="money-curr" data-val="10"><span class="moneyp-number">10</span>元<i></i></li>
                        <li data-val="50"><span class="moneyp-number">50</span>元<i></i></li>
                        <li data-val="100"><span class="moneyp-number">100</span>元<i></i></li>
                        <li data-val="200"><span class="moneyp-number">200</span>元<i></i></li>
                        <li data-val="500"><span class="moneyp-number">500</span>元<i></i></li>
                        <li data-val="1000"><span class="moneyp-number">1000</span>元<i></i></li>
                        <li class="oht-money-input" data-val=""><input type="text" class="money-other" placeholder="请输入其它金额" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" /></li>
                    </ul>
                </div>
<!--                 <div class="pay-money-error">充值金额不能为空</div> -->
            </div>
        </div>
        <!--选择金额 end-->

        <!--支付方式 start-->
        <div class="prec-t-box clearfix" style="padding-top: 0px">
            <span class="prec-tlable">支付方式</span>
            <div class="prec-paylist clearfix">
                <ul>
                    <li class="paytype-curr" data-payType='weixin'><b class="paytype-ico paytype-wechat"></b><span>微信支付</span><i></i></li>
                    {{--<li data-payType='unionpay'><b class="paytype-ico paytype-yinlian" ></b><span>银联支付</span><i></i></li>--}}
                    <li data-payType='jdpay'><b class="paytype-jd" ></b><span style="padding-left:55px">网银在线支付</span><i></i></li>
                </ul>
            </div>
        </div>
        <!--支付方式 end-->
        <!--but start-->
        <div class="prec-t-button">
            <input class="recharge-button" type="button" value="立即充值" />
        <!--<label class="recharge-hetong"><input type="checkbox" checked="checked" class="protocol-check"> 我已阅读并同意<a href="#" class="reg-hetonglink" style="color: #ff5d5b;">《服务协议》</a></label> -->
        </div>
        <!--but end-->
 
    </div>
    <!--main end-->
	<h2 style='font-size:14px;font-weight:800;margin:0 0 10px 10px'>充值记录</h2>
</div>
<!--recharge end-->
<!--充值提醒 start-->
<div class="p-rec-tips-charge" style="display:none">
    <h2 class="rec-tiph2">请您在新开的页面上完成支付！</h2>
    <div class="rec-tiptxt">
        <p>付款完成之前，请不要关闭本窗口！</p>
        <p>完成付款后根据您的个人情况完成此操作！</p>
    </div>
    <p class="rec-tipbut clearfix" STYLE='text-align:center'><a href="/user/recharge" class="rect-record">查看充值记录</a><!--<a href="javascript:window.location.reload();" class="rect-reload">重选支付方式</a>--></p>
</div>
<!--充值提醒 end-->


    <div id="member_right" class="member_right b_record_box">
        <!-- S 充值记录模块内容 -->
        <div class="b_record_buy">
            <!--S 充值明细 -->
            <div class="b_record_list b_record_cloud" style="display: block;">
                <div class="b_record_info" style="display:none">
                    <!-- 充值按时间筛选 -->
                    <div class="b_choose a_choose" style="display: none;">
                    
                        <dl class="b_choose_cal a_choose_cal" style="display: none;">
                            <dd>选择时间段：</dd>
                            <dd><input id="brokerage_source_startTime" readonly="true" type="text"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="brokerage_source_endTime" readonly="true" type="text"></dd>
                        </dl>
                        <div class="a_clear a_margin_num" style="display: none;"></div>
                        <ul class="b_choose_day" style="display: none;">
                            <li class="b_choose_this">来源状态</li>
                        </ul>
                        <div class="a_select_choose" style="display: none;">
                            <ul>
                                <i></i>
                                <li id="payCode" class="a_select_info">
                                    <span><input value="" class="code" type="hidden"> 全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="" type="hidden"> 全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="weixin" type="hidden"> 微信支付</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="jdong" type="hidden"> 京东支付</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="ylian" type="hidden"> 银联支付</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="jcard" type="hidden"> 购物卡</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="zfb" type="hidden"> 支付宝支付</span>
                                </li>
                            </ul>
                            <em>-</em>
                            <ul>
                                <i></i>
                                <li id="payStatus" class="a_select_info">
                                    <span>全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span>全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span> <input class="status" type="hidden" value="1">成功</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="status" type="hidden" value="0">未付款</span>
                                </li>
                            </ul>
                        </div>
                        <dl class="b_choose_cal" style="display: none;">
                            <dd>交易号：</dd>
                            <dd>
                                <input id="tradeNo" type="text" maxlength="40" style="width: 299px;">
                            </dd>
                            <dd class="b_choose_search a_choose_search" onclick="actionRechargeSeach()">搜索</dd>
                        </dl>
                        <div class="a_clear" ></div>
                    </div>
                </div>
                <div class="b_record_table a_record_table">
                @if($list->count()==0)
                    <div style="text-align:center;width:948px;height:530px;padding-top:290px;"><a href="" target="_blank"><img style="width:377px;height:49px;" src="{{asset('foreground/img/no_num.png')}}" alt="暂无数据"></a></div>
                @else
                    <table id="rechargeList">
                        <tbody>
                            <tr class="b_part_title">
                                 
                                <th class="b_th2">充值时间</th>
                                <th class="b_th3">充值金额</th>
                                <th class="b_th4">支付状态</th>
                                <th class="b_th6">充值状态</th>
                            </tr>
                            @foreach ($list as $val)
                                <tr>
                                    <td>{{ date('Y-m-d H:i:s',$val->time) }}</td>
                                    <td>
									@if ($val->status == 1)
									<font color='#52cc14'>{{ $val->amount }}</font> 
									@else
									<font color='#ff0100'>{{ $val->amount }}</font> 
								    @endif
									元
									</td>
                                    <td>
                                        @if ($val->status == 1)
                                        支付成功
                                        @else
                                        未支付
                                        @endif
                                    </td>
                                    <td class="a_record_span">
                                        @if ($val->status == 1)
                                            <span>充值成功</span>
                                        @else
                                            <span>未充值</span>
                                        @endif                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
                <!-- S 分页 -->
                <center>
                    <div id="rechargeListPageStr" class="pageStr" style="display: block;">
                        {!! $list->render() !!}
                    </div>
                </center>
                <!-- E 分页 -->
            </div>
            <!--E 充值明细 -->
        </div>
        <!-- E 充值记录模块内容 -->
    </div>
 
@endsection
@section("my_js")
    <script>
        $(function(){
            /*选择金额 当前金额*/
            $(".pay-money-ul ul li").click(function(){
                var moneyval = $(this).attr("data-val");                                  // 获取当前金额数值
                $(this).addClass("money-curr").siblings("li").removeClass("money-curr");  // 移除其他选中红框状态
                $(".oht-money-input .money-other").blur(function(){                       //选择其他金额情况 填充金额
                    var othmoney = $(this).val()
                    $(this).parent(".oht-money-input").attr("data-val",othmoney);
                })
                if(!$(this).hasClass("oht-money-input")){                                  //选择其他金额情况，再点击定制金额，清楚数据为空
                    $(".money-other").val("");
                    $(".oht-money-input").attr("data-val","");
                }
            })
            /*选择充值方式 */
            $(".prec-paylist ul li").click(function(){
                $(this).addClass("paytype-curr").siblings("li").removeClass("paytype-curr");  // 移除其他选中红框状态
            })
     
            /*提交按钮 弹出窗提示*/
            $('.recharge-button').on('click', function(){
				var recharge_money = $('.money-curr').attr('data-val');
				var payType        = $('.paytype-curr').attr('data-payType');
				var _token = $("input[name='_token']").val();
				if(recharge_money==''){
					layer.alert('请填写充值金额！');
					return false;
				}
				if(parseInt(recharge_money) <= 0){
					layer.alert('充值金额不能为0！');
					return false;
				}
				//请求组装HTML网关数据
				$.ajax({      
					type:"post",
					url:"/orderSubmit",
					data:{'_token':_token,paytype:payType,recharge:true,recharge_money:recharge_money},       
					async :false,
					dataType:'json',
					success:function(res){   
						if(res.status == 0){   
							$('body').append(res.data.form);
						} 
					}    
				});
	  
				$("#pay_sub").click(); 
								
                layer.open({
                    type: 1,
                    title: '充值提醒',
                    area: ['434px', '290px'], //宽高
                    content: $('.p-rec-tips-charge'),
                    cancel: function(){
                    	window.location.reload();
                    }
                });
            });
        })
    </script>
@endsection