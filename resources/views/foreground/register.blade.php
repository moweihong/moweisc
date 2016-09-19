<!DOCTYPE html>
<html lang="en">
<head>
<meta name="keywords"content=""/>
<meta http-equiv="Content－Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
<meta name="format-detection" content="telephone=no,address=no,email=no"/>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/> 
<meta name="renderer" content="webkit"/>
<link rel="stylesheet" href="{{ asset('foreground/css/registerNew.css') }}"/>
<link rel="stylesheet" href="{{ asset('foreground/css/comm.css') }}"/>
<script type="text/javascript" src="{{ asset('foreground/js/jquery190.js') }}"></script>
<title>一块购-注册</title>
 
</head>
<body>

<div class="ygqq_login">
    <div class="ygqq_login_logo ygqq_register_logo">
		<div class='reg_logo'>
			<a href="/"><img src="{{ asset('foreground/img/logo.png') }}"/></a>
			
			<div class="ygqq_login_text ">
				<span>已有账号？<a href="/login">登录</a></span>
            </div>
			
		</div>
    </div>
	<div class='zhzz23'><p>账号注册</p></div>
	
    <div class="ygqq_login_form" >
      <form class="ygqq_form" style="display:block">
      	  {!! csrf_field() !!}
          <div class="ygqq_login_dx_input  ">
              <label>
				  <i class="regicon1"></i>
                  <input type="text" class='reginput' id="mobile"  name="mobile" maxlength="11"  placeholder="建议使用常用手机"/>
                  <!--[if lt IE 10]>
                  <b class="input_tips i1">建议使用常用手机</b>
                  <![endif]-->
                  <i class="ygqq_i"></i>
              </label>
			  <div class='fcstps'><div class='rgipt1'><span>！</span>完成验证后，可以使用该手机登录和找回密码</div></div>
          </div>
          <div class="ygqq_login_dx_input">
              <label>
				  <i class="regicon2"></i>
                  <!--<input class="input" type="text" name="pas" id="pas" placeholder="密码为6-16位字符"/>-->
                  <input class='reginput' type="password" name="password" maxlength="20" id="password" placeholder="设置密码"  />
                  <!--[if lt IE 10]>
                  <b class="input_tips i2">密码为6-16位字符</b>
                  <![endif]-->
                  <i class="ygqq_i"></i>
              </label>
			  <div class='fcstps'><div class='rgipt2'><span>！</span>建议使用字母，数字和符号两种及以上的组合，6-20个字符</div></div>
          </div>  
		  <div class="ygqq_login_dx_input">
              <label>
				  <i class="regicon2"></i>
                  <!--<input class="input" type="text" name="pas" id="pas" placeholder="密码为6-16位字符"/>-->
                  <input class='reginput' type="password" name="password2" maxlength="20" id="password2" placeholder="再次确认密码"  />
                  <!--[if lt IE 10]>
                  <b class="input_tips i3">密码为6-16位字符</b>
                  <![endif]-->
                  <i class="ygqq_i"></i>
              </label>
			  <div class='fcstps'><div class='rgipt3'><span>！</span>再次输入密码</div></div>
          </div> 
		  
          <div class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts" style="display: none;">
              <label>
                  <input type="text" name="captcha" id="captcha" class="form-control reg-input">
              </label>
          </div>
          <div id="TCaptcha" class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts"  style="height: 48px"></div>
		  
		  
		  
          <div class="ygqq_login_dx_input" style='margin-top:30px'>
              <label>
				  <i class="regicon3"></i>
                  <input type="text"  id="smsCode" placeholder="请输入短信验证码" class="ygqq_login_dx_ym "/>
                  <!--[if lt IE 10]>
                  <b class="input_tips i4">短信验证码</b>
                  <![endif]-->
                  <i class="ygqq_i1"></i>
              </label>
              <a href="javascript:void(0);" id='getcode' class="ygqq_login_dx_a ygqq_register_dx_a">点击获取验证码</a>
              <a href="javascript:void(0);" id='getcode2' style='display:none' class="ygqq_login_dx_a"></a>
          </div>
		  
          <div class="ygqq_register_text1">
              <a>邀请码 <b style='color:#dd2726;'>(选填)</b></a>
          </div>
		  <?php if(empty($code) && empty($recommend_id)){   ?>
          <div class="ygqq_login_dx_input ygqq_register_xz"  >
              <input type="text" id="registerCode" placeholder="邀请码" class="ygqq_xt reg-input">
              <!--[if lt IE 10]>
              <b class="input_tips">邀请码</b>
              <![endif]-->
          </div>
		  <?php }else{  
			if(empty($code)){
				$code = $recommend_id;
			}
		  ?>
		   <div class="ygqq_login_dx_input ygqq_register_xz">
              <input type="text" id="registerCode" class="ygqq_xt" value="{{$code}}" disabled='disabled'>
          </div>
		  <?php } ?>
		  
		   <div class="regxieyi">
              <input type="checkbox"   id='ykgzcxy'>我已阅读并同意<a href='Javascript:;'>《一块购用户协议》</a>
          </div>
		  
          <div style="margin-top:15px">
              <input class="ygqq_button" onclick="doRegister()" type="button" value="立即注册"></input>
          </div>
      </form>
    </div>
	<div class="hrhr"></div>
</div>
 
<!-- S 遮罩浮层-->
<!--<div class="ygqq_float">
</div>-->
<!-- E 遮罩浮层-->
<!-- S 注册安全认证-->
<!--<div class="register_img_con">
    <h3>注册安全验证</h3>
    <div class="register_img_close"></div>
    <form class="qq_form">
       <div class="register_activate_yz_all">
          <div class="register_activate_yz_label ygqq_ts">
              <input type="text" style="ime-mode:disabled " id="imgCode" maxlength="6" value="请输入图形验证码"/>
              <i class="ygqq_i1"></i>
          </div>
          <div class="register_activate_yz_img">
              <a><img id="register_activate_yz_img" onClick="this.src='/api/uc/validCode.do?t=' + Math.random()+'&mobile='+$('#mobile').val();"/></a>
          </div>
      </div>
      <div class="qq_form_btn">
         <input type="button" value="确定" class="ygqq_xt"/>
      </div>
    </form>
</div>-->
<!-- E 注册安全认证-->
<!-- S微信登录
<div class="ygqq_float_con">
    <div class="ygqq_float_left">
        <h3>微信登录</h3>
        <img src="/static/userCenter/newImages/ewm.jpg"/>
        <em>扫描二维码登陆一块购</em>
    </div>
    <div class="ygqq_float_right">
    </div>
</div> -->
<!-- E 微信登录 -->
<!-- S qq登录-->
 <div class="ygqq_float_qq_con">
        <h3>亲爱的一块购用户</h3>
        <a class="ygqq_float_qq_no" href="register_other.html">没有一块购账号注册</a>
        <a class="ygqq_float_qq_yes" href="register_other.html">已有一块购账号绑定</a>
        <div class="ygqq_float_close"></div>
  </div>
<!-- E qq登录-->
<!-- S 协议-->
<div id="b_Contract" class="b_modal">
  <div class="b_modal-header">
    <button type="button" class="b_close1"></button>
    <h3 id="b_ContractLabel">一块购注册协议</h3>
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
      <button class="b_btn b_btn-primary">确认</button>
    </div>
</div>
<!-- E 协议-->
<script>
var time = 120;
</script>
<script type="text/javascript" src="{{$imgjsUrl}}"></script>
<script>
var capOption={callback :cbfn};
capInit(document.getElementById("TCaptcha"), capOption);
//回调函数：验证码页面关闭时回调
function cbfn(retJson)
{
    if(retJson.ret==0)
    {
        // 用户验证成功
        $("#captcha").val(retJson.ticket);
    }
    else
    {       
		layer.msg('请先点击完成验证');
        //用户关闭验证码页面，没有验证
    }
}
$(document).ready(function(){
	if({{ $time }} != -1){
		time = {{ $time }};
		$(".ygqq_register_dx_a").css({display:"none"});
		$("#getcode2").css({display:"block"});
		$("#getcode2").html("<em class='ygqq_login_dx_time'>"+time+"</em>秒后重新获取");
		get_code($(".ygqq_login_dx_time"),$('#getcode2'));
	}
	
	var code = {{$code}};
	if(code){
		$('.ygqq_register_text1').click();
	}
})


$(function(){
    if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
        //alert('你是使用IE')
        $(".reg-input").keyup(function(){
            $(this).siblings(".input_tips").hide();
            if($(this).val()=="" || $(this).val()==" "){
                $(this).siblings(".input_tips").show();
            }
        })
    }

	//手机号验证
	function checkMobile(mobile){
		var reg = new RegExp('^1[34578][0-9]{9}$');
		if(!reg.test(mobile)){
			return false;	
		}
		return true;
	}
})
</script>
<script src="{{ asset('foreground/js/layer/layer.js') }}"></script><!-- 提示框js -->
<script src="{{ asset('foreground/js/regi.js') }}"></script>
<script src="{{ asset('foreground/js/alert.js') }}"></script>
<script type="text/javascript" src="{{ asset('foreground/js/reg.js') }}"></script>
</body>
</html>
