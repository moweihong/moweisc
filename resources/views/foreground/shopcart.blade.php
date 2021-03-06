@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/my_cart.css">
    <link rel="stylesheet" href="{{ asset('foreground/css/registerNew.css') }}"/>
@endsection

@section('content')
        <!--content start-->
<div class="c_my_cart">
    <div class="c_shop_bag">

        <h4 id="h4">我的购物车</h4>
        <!-- 购物车为空 start -->
        <div class="c_no_goods" id="null" style="display: none;">
            <div class="c_no_right y_no_left"><img src="static/img/front/cloud_global/shop_bag_no.png"></div>
            <div class="c_no_left y_no_right">
                <p>你的购物车还是空的赶紧行动吧！</p>
                <a href="/goods/allCat.do" class="c_quick_shop" hidefocus="">马上去购物</a>
            </div>
        </div>
        <!-- 购物车为空 end -->
        <div class="catbox c_goods_info" id="data" style="">
            <!-- 2015.5.25 start -->
            <table id="cartTable">
                <thead>
                <tr style="border-bottom:1px solid #ddd;">
                	<th></th>
                    <th><span class="c_goods_text">商品</span></th>
                    <th>购买人次</th>
                    <th>小计</th>
                    <th style="width:100px;">操作</th>
                </tr>
                </thead>
                <tbody id="listTable">
                @if(count($list) > 0)
                	@foreach ($list as $good)
                        <tr id="{{ $good['cart_id'] }}">
                    		<td class="checkbox"><input name="checkCart" value="{{ $good['id'] }}" class="check-one check" type="checkbox" checked="checked" onclick=""></td>
                    		<td class="goods"><a href="javascript:gotoGoods(1568,21)"><img src="{{ $good['thumb'] }}" alt=""></a><span><a href="javascript:gotoGoods(1568,21)">{{ $good['title'] }}</a></span><b class="c_goods_price">总需<i>{{ $good['total_person'] }}</i>人次参与，还剩<i class="last_person">{{ $good['total_person'] - $good['participate_person'] }}</i>人次</b></td>
                    		<td class="count" style="padding-left:120px;"><div class="w_one_new"><span class="reduce reduce_n" >-</span><input width="70px"  class="count-input buytimes" onkeydown="onlyNum();" oninput="amountChange(this, 0);" type="text" maxlength="7" value="{{ $good['bid_cnt'] }}" ><span class="add add_n" >+</span></div></td>
                    		<td class="subtotal">{{ $good['bid_cnt'] * $good['minimum'] }}</td><input type="hidden" class="bid_cnt" value="{{ $good['bid_cnt'] }}"><input type="hidden" class="minimum" value="{{ $good['minimum'] }}"><td class="operation"><span class="delete" g_id="{{$good['id']}}" onclick="deleteCart(this)">删除</span></td>
                    	</tr>
                    @endforeach
                @else
                	<tr>
                		<td colspan="5" style="height:80px"><p style="color:#808080">您的清单里还没有任何商品，<a href="/" style="text-decoration:underline;color:#39f">马上去逛逛~</a></p></td>
                	</tr>
                @endif
                </tbody>
            </table>
			<div id='good_json' style='display:none'>@if(count($list) > 0)@foreach ($list as $good){id:"{{$good['id']}}",count:"{{$good['bid_cnt']}}"},@endforeach @endif</div>
            <div class="c_total c_order_total" id="c_total" style="margin-top:5px;position:relative;">
                <label class="fl select-all"><input id="SelectAll" type="checkbox"  class="check-all check">&nbsp;全选</label>
                <a class="fl delete" style="display:none" id="deleteAll" href="javascript:void(0);">删除</a>
                <div class="fr total">
                    <span class="c_total_text">支付总额：</span><span id="priceTotal">{{ $total_amount }}</span>
                    <span class="c_total_text">块</span></div>
<!--                <div class="w_popup_window" style="float:right;margin-right:12px;bottom:-16px;right:0px;position:absolute;">
                    现在可以一次参与多期奖品哦
                    <a href="javascript:showWindows()">详情</a>
                </div>
  -->
            </div>

            <div class="c_user_reduce_box">
                <span style="margin:0 20px;position:relative;color:red;">*红包抵扣和块乐豆抵扣只能使用一种</span>
            </div>

            <div class="c_user_reduce" id="redDiv" style="margin:0 10px;position:relative;">
                @if(count($red) > 0)
                	<input id="red" class="order_checkbox" type="checkbox">
                	<span style="margin-left: 5px">使用红包抵扣部分金额</span>
                	<div id="redTips" style="position:absolute;left: 328px;top: 1px;color: #dd2726;display:none;">购物卡结算不能使用红包</div>
<!--                <div class="c_order_select" style="">
                    <div class="select_box selectBox">
                        <div class="select_showbox selectDiv" style="cursor: pointer;display:none">暂无可用红包</div>
                    </div>
                </div>
-->
				
    				<select name="red" style="margin-left:8px;" disabled="disabled">
    					<option value="0">请选择</option>
                    	@foreach ($red as $key => $row)
                    		<option value="{{ $key }}">{{ $row['name'] }}</option>
                    	@endforeach
                    </select>
                @else
                	<input id="red" class="order_checkbox" type="checkbox" disabled="disabled">
                	<span>当前没有可用红包</span>
                @endif
            </div>

            <div class="c_user_reduce_box" id="klbeanDiv">
                <div class="c_user_reduce klbean_font" style="margin:0 10px;border:0px;">
                    <input id="klbean" class="order_checkbox" type="checkbox">
                    <span>使用块乐豆抵扣，剩余块乐豆：<span><span id="klbean">{{ $user['kl_bean'] }}</span></span>个（抵扣比例为100块乐豆抵扣1块）</span>
                    <span style="float:right;font-size:14px">块乐豆抵扣：<span class="minus-klbean total" id="minus-klbean">0.00</span>块</span>
                </div>
            </div>
<!--           <div class="c_user_reduce_box">
                <div class="c_user_reduce" style="margin:0 10px;border:0px;">
                    <input id="card" class="order_checkbox" type="checkbox">
                    使用购物卡余额支付，购物卡余额：
                    <span id="cardMoney">0</span>块
                    <i id="cardTips" style="margin-left:20px;color: #dd2726;display:none;">红包结算不能使用购物卡</i>
                </div>
            </div>
 -->  
            <div class="c_user_reduce_box">
                <div class="c_user_reduce money_font" style="margin:0 10px;border:0px;">
                    <input id="money" class="order_checkbox" type="checkbox">
                    使用账户余额支付，账户余额：<span><span id="userMoney">{{ $user['money'] }}</span></span>块
                <span style="float:right;font-size:14px">余额抵扣：<span class="minus-money total" id="minus-money">0.00</span>块</span>    
                </div>
            </div>

            <!-- 充值 -->
            <dl class="c_account_enougth" style="margin: 30px 10px 0 20px;"><!-- 2015.09.14 订单支付方式 修改 -->
                <dd class="c_no_enougth">若账户余额不足，请选择以下方式完成支付</dd>
                <dd class="c_inter_bank">使用<span id="payTypeMsg">微信支付</span><span class="total"><span id="rechargeMoney">{{ $total_amount }}</span></span> 块</dd>
            </dl>
            <!-- 2015.09.14 订单支付方式 start -->
            <ul class="c_pay_way c_cloud_way c_pay_add c_pay_margin" style="margin-top:15px;height:72px"><!-- 2015.09.24 充值 增加类“c_pay_margin” -->
                <i style="float:left;margin-left:20px;">支付方式：</i><!-- 2015.09.24 充值 style修改为：float:left; -->
                <div style="width:1010px;float:left;">　
                    <li class="paytype c_kik_icon c_pay_this" data-paytype="weixin" data-checked='1'>
						<a href="javascript:void(0);" style="display:block;width: 115px;height:100%;float:right;">微信支付</a><span class="c_right_bottom"></span>
					</li>
                    {{--<li class="paytype c_unionpay" data-paytype="unionpay" data-checked='0'>
						<a href="javascript:void(0);" style="display:block;width: 120px;height:100%;float:right;">银联支付</a><span class="c_right_bottom"></span>
					</li>--}}
                    <li class="paytype c_jdpay" data-paytype="jdpay" data-checked='0'>
                        <a href="javascript:void(0);" style="display:block;width: 110px;height:100%;float:right;">网银在线支付</a><span class="c_right_bottom"></span>
                    </li>
                    <!--                     <li class="c_pay_icon" data-val="JD_PC" title="京东"><a href="javascript:void(0);" style="display:block;width: 120px;height:100%;float: right;">京东支付</a><span class="c_right_bottom"></span></li>
                                        <li class="c_wy_icon" data-val="JD_GW" title="网银"><a href="javascript:void(0);" style="display:block;width: 120px;height:100%;float: right;">网银在线</a><span class="c_right_bottom"></span></li>
                                        <li data-val="JD_PC" title="信用卡"><a href="javascript:void(0);" style="display:block;width: 148px;height:100%;float: right;">信用卡支付</a><span class="c_right_bottom"></span></li>
                                        <div class="clear:both;"></div> -->
                </div><!-- 2015.09.24 充值 增加此行 -->
            </ul>
            <div class="tab_btn_cz tab_btn_pay" style="margin-left:102px;width:990px;"><!-- 2015.09.24 充值 修改style为：margin-left:102px;width:990px; -->
                <ul class="payment">
                    <!-- 1. 招商、工商、建行、农行 、中行-->
                    <li class="top">
                        <input type="radio" value="3080" name="account" id="bankType3080" checked="checked"><label for="bankType3080"><span class="zh_bank"></span></label>
                        <input type="radio" value="1025" name="account" id="bankType1025"><label for="bankType1025"><span class="gh_bank"></span></label>
                        <input type="radio" value="105" name="account" id="bankType105"><label for="bankType105"><span class="jh_bank"></span></label>
                        <input type="radio" value="103" name="account" id="bankType103"><label for="bankType103"><span class="nh_bank"></span></label>
                        <input type="radio" value="104" name="account" id="bankType104"><label for="bankType104"><span class="zg_bank"></span></label>
                    </li>
                </ul>
            </div>
            <!-- 充值提醒弹窗 -->
            <div class="c_recharge_remind" style=" display: none;z-index: 9; left: 729px; top: 203px;">
                <h4 class="c_update_title" style=" margin: 12px 0 0 16px;"> 充值提醒<span class="c_remind_close"></span></h4>
                <p class="c_pay_remind">请您在新开的页面上完成支付！</p>
                <p>付款完成之前，请不要关闭本窗口！</p>
                <p>完成付款后根据您的个人情况完成此操作！</p>
                <p class="c_remind_btn"><a href="javascript:gotoRechangeList();">查看充值记录</a>
                    <a href="javascript:closeRechange();">重选支付方式</a></p>
                <div class="c_qq_close"></div><!-- 2015.07.15 关闭按钮 新增 -->
            </div>
            <div class="c_remind_bj" style="height: 2016px;"></div>
            <!--  充值end-->
            <!-- 提示 -->
            <div class="c_update_tel c_tel_f" style="/*display: none;*/ left: 729px; top: 258px;">
                <h2 class="c_update_title">温馨提示</h2>
                <form class="c_form_update">
                    <p style="text-align:center;" id="showTieleP"></p>
                    <a href="javascript:void(0);" class="c_tel_next">确定</a>
                </form>
                <div class="c_qq_close"></div>
            </div>
            <!-- 提示 -->

            <p class="c_pay_protocal w_pay_protocal"><input type="checkbox" id="agreement" checked=""><b>我已阅读并同意</b><i id="serve_contract">《服务协议》</i></p>
            @if(count($list) <= 0) 
				<div class="c_total_back" ><a href="javascript:void(0)" style="background:#999" class="c_account_btn c_total_pay" style="display: block;" id="submit_btn">确认支付</a></div>
		    @else
            	<div class="c_total_back"><a href="javascript:void(0)" onclick="orderSubmit()" class="c_account_btn c_total_pay" style="display: block;" id="submit_btn">确认支付</a></div>
            @endif
            <div class="clear"></div>
            <div class="w_miss_problem">
                <p>
                    付款遇到问题:</p>
                <p>1、如您未开通网上银行，即可以使用储蓄卡快捷支付轻松完成付款；</p>
                <p>2、如果银行卡已经扣款，但您的账户中没有显示，有可能因为网络原因导致，请及时联系客服400-6626-985。</p>
            </div>
        </div>
    </div>
    
    <!-- S 协议-->
<div id="b_Contract" class="b_modal">
  <div class="b_modal-header">
    <button type="button" class="b_close1"></button>
    <h3 id="b_ContractLabel">一块购服务协议</h3>
  </div>
  <div class="b_modal-body">
 <p>
欢迎您访问并使用一块购频道（ ts1kg.com 以下或称“一块购”），一块购服务指的是一块购为用户间众筹活动提供平台和技术服务。
我们并不是您或商家的任何一方，所有交易仅存在于您和商家之间，请您（以下简称“用户”）认真阅读此服务协议的内容（特别是粗体、下划线标注内容）。
如不同意此服务协议，请勿使用或注册该服务。用户在注册过程中勾选“我已认真阅读并接受用户服务协议”，并登陆一块购账户或填写用户信息完成注册。
即表示用户完全接受本协议中的全部内容，此后，用户不得以未阅读本服务条款内容作任何形式的抗辩。
</p>

<h4>一、用户注册</h4>
<p>
1、用户使用一块购服务的前提是认真阅读本协议并通过注册。用户注册是指用户登录一块购（  ts1kg.com ），按用户注册流程要求填写相关信息并同意接受本服务协议的过程。<br/>
2、使用该服务的用户必须是完全民事行为能力人，具备相应的权利能力和行为能力，能够独立承担法律责任。限制民事行为能力人和无民事行为能力人不能注册或使用该服务。如经发现，一块购有权立即停止与该用户的交易、注销该用户账户。<br>
3、用户在注册时需要完善个人资料，保证遵守法律法规、社会主义制度、国家利益、公民合法权益、公共秩序、社会道德风尚和信息真实，不得在资料中出现违法和不良信息。若用户注册资料存在违法和不良信息的，一块购有权采取通知限期改正、暂停使用、注销用户、向政府主管部门报告等措施。<br>
4、用户应提供真实有效的个人信息并进行实名认证，未经实名认证，不能使用一块购服务。<br>
5、若用户注册资料存在违法或不良信息的，或者注册资料不真实、不准确的，一块购有权采取通知限期改正、暂停使用、注销用户、向政府主管部门报告等措施。<br>
6、用户在注册本网站账号时,同意关联注册特速集团旗下全木行(www.allwood.com.cn) 和链金所(www.ccfax.cn) 的账号。用户在本站注册的登录账号和密码均可在另外两个平台进行使用。<br>
</p>

<h4>二、账号和密码安全</h4>
<p>
1、用户应负责保管其账号和密码，对该账户下的所有活动和时间负全部责任。如果用户未保管好自己的账号和密码而对用户本人、一块购或第三方造成损害，用户承担全部责任。<br>
2、用户同意若发现任何非法使用用户账号或安全漏洞的情况，应立即通知一块购。<br>
</p>

<h4>三、一块购规则</h4>
<p>
1、一块购商品的提供商即商家，将商品售价以一元为基数等分成若干份，每份对应一个块乐码。参加一块购的用户每支持一份可获得一个随机分配的块乐码，当具体商品所对应的块乐码分配完毕后，商家应当根据规则计算出一个幸运号码，并在持有该幸运号码的用户填写完整信息后向该用户履行商家责任。所有商品交易仅存在于您和商家之间。<br>
2、用户参加具体商品的一块购项目时，支持1元钱可获得一个随机分配的块乐码。某件商品的全部块乐码均被支持并分配完毕后，根据一块购规则计算出的一个幸运号码，持有该幸运号码的用户获得该商品。如果您拥有幸运号码的，则您将作为受赠人，接受其他用户的赠与，并购买幸运号码对应的商品。无论您是否拥有幸运号码，您参与一块购活动支付的资金由我们代为收取，并最终为幸运号码获得者购买指定商品的货款，支付给商家。<br>
3、用户下单未支付的订单可以保留半个小时，若半个小时内未支付，订单将过期关闭，需要用户重新提交订单。<br>
4、一块购参与成功以获得块乐码为准，若未获得块乐码，则为参与失败，用户所支付款项会退还至用户名下账户中。<br>
5、用户获得一块购商品后，应在十五天内登录填写或确认真实的收件人姓名、准确的收货地址及联系方式。若逾期未填写提交的，视为放弃该商品。用户因此行为造成的损失，一块购不承担任何责任。因如下情况造成配送迟延或无法配送的，一块购不承担责任：<br>
（1） 客户提供的收货信息错误和不详细的地址；<br>
（2） 货物送达无人签收，由此造成的重复配送所产生的费用及相关的后果；<br>
（3） 不可抗力情形，例如自然灾害、突发战争等。<br>
6、若持有幸运号码的用户逾期未填写提交收货地址，则一块购将视为本次商品参与失败，一块购将退款至用户名下账户中。<br>
7、用户通过参与一块购获得的商品，享受该商品商家提供的三包服务，具体三包规定以该商品生产厂家公布的为准。一块购商品不支持退货，若出现严重质量问题，可联系此次一块购项目的商家更换同款商品。一块购商品由一块购商家进行发货。售后服务由商家负责，商品可享受厂家所提供的全国联保服务，非质量问题不在三包范围内，不给予退换货。<br>
8、如快递无法配送至获得者提供的送货地址，将默认配送到距离最近的送货地，由获得者本人自提。需当场验货签收，若货品有严重质量问题，可拒收，并在二十四小时之内进行反馈；若用户已签收有质量问题的商品，需在二十四小时之内进行反馈，逾期未反馈，一块购不承担任何责任。<br>
9、作为服务平台，用户在获得商品并完善地址后，一块购和供应货物商家约定为最快可1个工作日内发货，如果遇到平台系统、商品订单量大等原因，商家会根据订单顺序第一时间安排发货，实际发货时间以商家为准，最迟发货时间不超过7个工作日。预售和特殊商品等以该商品的详情页说明为准。提供货物的商家对发货的时效和服务负责，一块购不承担任何责任。<br>
10、如遇提供货物商家出现商品短缺无法配送的情况，则会由供应商家或者平台向第三方电商平台进行下单，配送到用户指定地址。<br>
11、用户收到商品七天内需确认收货，逾期未确认，系统将自动确认收货。<br>
12、如果下列情形发生，一块购有权取消用户的一块购订单：<br>
（1）因不可抗力、一块购系统发生故障或遭受第三方攻击，或发生其他无法控制的情形；<br>
（2）根据已经发布的或将来可能发布或更新的平台及一块购各类规则、公告的规定，一块购有权取消用户订单的情形。<br>
13、一块购取消用户订单后，用户可申请退还支持的费用，并在 一至十五 个工作日内退还至用户账户中。<br>
14、当订单支付成功，但获取块乐码失败，用户支付的支持款项会在一至十五个工作日内退还至用户账户中。<br>
15、"特速一块购"只是中间服务平台商，不提供发票，发票由商家直接提供。<br>
16、用户知悉并确认，除本协议另有约定外，无论是否获得一块购商品，用户一旦支持项目，其所支持的具体款项均将作为一块购商品的支持款而不能退还；用户完全了解其参与一块购活动可能存在的风险，并清楚其参与一块购项目并不必然可获得商品。<br>
17、用户进行与分享购物无关或不是以分享购物为目的的活动，恶意注册、签到、评论等方式试图扰乱平台正常秩序，或通过非法途径获得账户余额、块乐豆及红包等，平台有权作出删除相关信息、终止提供服务等处理，而无须征得用户的同意，情节严重者，公司将追究法律责任。<br>
</p>

<h4>四、责任声明</h4>
<p>
1、在参加一块购活动中如遭受任何人身或财务的损失、损害或伤害，不论原因为何，一块购不负任何责任，用户可以直接向产品服务的提供商提出权利要求。<br>
2、用户对其在一块购中所做出的一切行为、行动及违法、违规或疏忽行为（不论是否故意）负全部责任。<br>
3、如系统发生故障影响到用户服务的正常运行，一块购承诺及时处理进行修复。但用户因此而产生的损失，一块购不承担责任。<br>
4、涉及到互联网服务，可能会受到各个环节不稳定因素的影响，存在因不可抗力、计算机病毒、黑客攻击、系统不稳定、用户所在位置、用户关机以及其他任何网络、技术、通信线路等原因造成的服务中断或不能满足用户要求的风险，用户须自行承担以上风险，一块购不承担任何责任。<br>
5、用户明确同意使用一块购服务的风险由用户个人承担。一块购明确表示不提供任何类型的担保，不论是明确的或隐含的。用户理解并接受由其承担系统受损、资料丢失以及其它任何风险。<br>
6、用户享有言论自由权利，但用户在一块购中不得发表含有如下内容的言论，否则一块购有权删除用户所发言论，并有权采取停止用户服务、拒绝用户参加所有抢宝商品项目等措施：<br>
（1）反对宪法所确定的基本原则，煽动、抗拒、破坏宪法和法律、行政法规的；<br>
（2）煽动颠覆国家政权，推翻社会主义制度，煽动、分裂国家，破坏国家统一的；<br>
（3）损害国家荣誉和利益的；<br>
（4）煽动民族仇恨、民族歧视，破坏民族团结的；<br>
（5）任何包含对种族、性别、宗教、地域内容等歧视的；<br>
（6）捏造或者歪曲事实，散布谣言，扰乱社会秩序的；<br>
（7）宣扬封建迷信、邪教、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；<br>
（8）公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；<br>
（9）损害国家机关信誉的；<br>
（10）其他违反宪法和法律行政法规的。<br>
</p>

<h4>五、服务条款的变更与修订</h4>
<p>
用户接受一块购有权在必要时修改本服务协议有关条款或中断服务，且无需对用户和第三方负责。一旦协议内容有所修改，将会在网站重要页面或醒目位置第一时间给予通知。用户在享受该服务时，应当及时查阅了解修改的内容，并自觉遵守本服务协议。如果您继续使用一块购的服务，则视为您同接受该协议的改动内容。
</p>
<br>
 
    </div>
    <div class="b_modal-footer">
      <button class="b_btn b_btn-primary serve_confim">确认</button>
    </div>
</div>
<!-- E 协议-->
</div>
<!--content end-->
<script>
$(document).ready(function(){
	$('.c_unionpay,.c_kik_icon,.c_jdpay').click(function(){
		claerOtherPay();
		$(this).addClass('c_pay_this');
		$(this).attr('data-checked',1);
		$('#payTypeMsg').text($(this).find('a').text());
	});
	
	function claerOtherPay(){
		$('.c_kik_icon,.c_unionpay,.c_jdpay').removeClass('c_pay_this');
		$('.c_kik_icon,.c_unionpay,.c_jdpay').attr('data-checked',0);
	}

	var user_money = {{$user['money']}};
	if(user_money > 0){
		$('#money').click();
	}
});

$(function(){
	$('#serve_contract').click(function(){
    	$('#b_Contract').css('display', 'block');
    });

    $('.serve_confim').click(function(){
    	$('#b_Contract').css('display', 'none');
    })
})

</script>
@endsection

