{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','我的佣金')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection
@section('content_right')
    <div id="member_right" class="member_right">
        <!--invite result start-->
        <div class="mycommission">
            <!--tit start-->
            <div class="u_questit tabtit clearfix">
                <a class="u_quet_a u_quet_acurr" href="commission" title="招募合伙人">招募合伙人</a>
                <a class="u_quet_a" href="commissionsource" title="佣金来源">佣金来源</a>
                <a class="u_quet_a" href="commissionbuy" title="佣金消费">佣金消费</a>
                <a class="u_quet_a" href="mybankcard" title="我的银行卡">我的银行卡</a>
            </div>
            <!--tit end-->
            <!--txt start-->
            <div class="mycommission">
                <div class="b_partner_img"><a href="#" target="_blank"><img src="{{ $url_prefix }}img/ad/partner.jpg"></a></div>
                <ul class="b_partner_ul">
                    <li>
                        <em>我赚取的佣金（元）</em>
                        <b id="brokerageTotal">0</b>
                    </li>
                    <li class="b_partner_li_two">
                        <em>我的虚拟股权（股）</em>
                        <b id="equity">0</b>
                    </li>
                    <li class="b_partner_li_three">
                        <em>我的等级</em>
                        <b>
                            <span class="b_partner_x"></span>
                            <span class="b_partner_x"></span>
                            <span class="b_partner_x"></span>
                            <span class="b_partner_x"></span>
                            <span class="b_partner_x"></span>
                        </b>
                    </li>
                </ul>
                <div class="b_partner_dashed"></div>
                <!--数据 start-->
                <!-- <div class="b_partner_lc">
                    <li>
                					   	   	  <span>
                					   	   	  	<h2>邀请人数达到<tt id="invitationSumLimit">100</tt>人</h2>
                                <i class="b_partner_i">已邀请：<tt id="invitationSum">0</tt>人</i>
                					   	   	  </span>
                        <a href="invite" class="c_partner_color" style="background-image: none; background-attachment: scroll; background-color: rgb(221, 40, 39); color: rgb(255, 255, 255); background-position: 0px 0px; background-repeat: repeat repeat;">立即邀请</a>
                    </li>
                    <li><b></b></li>
                    <li>
                					   	   	  <span>
                					   	   	  	<h2>累计消费满<tt id="consumerSumLimit">100万</tt>元</h2>
                                <i class="b_partner_i">已消费：<tt id="rechangSum">0</tt>元</i>
                					   	   	  </span>
                        <a href="/category" class="c_partner_color">立即购买</a>
                    </li>
                    <li><b></b></li>
                    <li>
                					   	   	  <span>
                					   	   	  	<h2>恭喜您</h2>
                                <i>已成为平台<br>合伙人</i>
                					   	   	  </span>
                    </li>
                </div> -->
                <!--数据 end-->
                <!--说明 start-->
                <div class="b_partner_sm">
                    <span>详细说明：</span>
                    <ul>
                        <li>1、累计消费金额-——网站上线之日起您消费的充值金额都将计入的累计金额；</li>
                        <li>2、累计邀请人数——从邀请活动开始您邀请的人都计入您的累计邀请人数；</li>
                        <li>3、虚拟股权——计算方式：累计赚取佣金×提取比例（注：结果取四舍五入）；<em>注：累计赚取佣金——自“合伙人”活动上线之日算起</em></li>
                        <li>4、合伙人招募活动将持续至2016年6月30日；</li>
                        <li>5、股份赠送截止至2016年12月31日，股份赠送停止时佣金还将继续赠送；</li>
                        <li>6、如2018年10底之前未成功挂牌或上市，则股权按5元/股为您折现。</li>
                        <li>7、只要邀请人数达到<tt id="invitationSumLimit2">100</tt>人，并在平台累计消费满<tt id="consumerSumLimit2">100万</tt>元，用户将自动成为平台合伙人！</li>
                    </ul>
                </div>
                <!--说明 end-->
            </div>
            <!--txt start-->
        </div>
        <!--invite result end-->
    </div>
    <!-- E 右侧 -->
@endsection

