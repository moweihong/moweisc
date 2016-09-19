{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','用户提现')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection
@section('content_right')
    <!--提现和佣金转余额 start-->
    <div id="member_right" class="member_right">
        <!--tit start-->
        <div class="u_questit tabtit clearfix">
            <a class="u_quet_a u_quet_acurr" href="javascript:void(0)" title="用户提现">用户提现</a>
        </div>
        <!--tit end-->
        <!--main start-->
        <div class="p-recharge-container">
            <!--提现类型 start-->
            <div class="prec-t-box clearfix" style="padding:10px 0px 0px">
                <span class="prec-tlable">提现类型</span>
                <div class="prec-drawbox prec-withdraw clearfix">
                    <ul>
                         <li class="money-curr" data-drawtype="1" data-drawname="佣金转余额">佣金转余额<i></i></li>
                        <li  onclick="cheakmoney({{ $commission }})" data-drawtype="0" data-drawname="提现银行卡" >佣金转银行卡<i></i></li>                       
                    </ul>
                </div>
            </div>
            <!--提现类型 end-->
            <!--银行卡类型 start-->
            <div class="draw-typebox draw-bank">
                <!--选择银行 start-->
                <div class="prec-t-box clearfix" style="padding:10px 0px 20px">
                    <span class="prec-tlable">选择银行</span>
                    <div class="prec-drawbox clearfix">
                        @if($list == null)
                                <div class="dbank-addbank">
                                    <a href="addbankcard" class="addbank-link"><i class="abank-linkico"></i>添加银行卡</a>
                                </div>
                        @else
                        <div class="draw-listbank clearfix">
                            @foreach($list as $key=>$val)
                                <div class="dbank-box {{$key == 0 ? 'dbank-box-on':''}}">
                                    <b class="a_bankcard_ico a_bankcard_{{$val['bank']}}" title="{{$val['bankname']}}"></b>
                                    <span class="mycard-no" data-banknumber="{{$val['banknum']}}">{{$val['banknum']}}</span>
                                    <i class="dbank-box-ico"></i>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    
                </div>
                
                <!--选择银行 end-->
                <!--账户余额 start-->
                <div class="prec-t-box clearfix" style="padding:10px 0px 0px">
                    <span class="prec-tlable">可提佣金</span>
                    <div class="prec-drawbox clearfix">
                        <div class="money-ye"><span class="money-yelast">{{ $commission }}</span> 元</div>
                    </div>
                </div>
                <!--账户余额 end-->
                <!--输入金额 start-->
                <div class="prec-t-box clearfix" style="padding: 20px 0px 0px 0px;">
                    <span class="prec-tlable">提现金额</span>
                    <div class="prec-drawbox  clearfix">
                        <input type="text" class="draw-moneyinput" data-maxmoney="{{ $commission }}" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" /> <span class="draw-moneyuan">元</span>
                        <span class="d-moneytip"></span>
                    </div>
                </div>
                <!--输入金额 end-->
                <!--but start-->
                <div class="prec-t-button">
                    @if($list == null)
                        <input class="recharge-button" type="button" value="立即提现" />
                    @else
                        <input class="recharge-button withdraw-button" type="button" value="立即提现" />
                    @endif
                    
                    <label class="recharge-hetong"><input type="checkbox" checked="checked" class="protocol-check"> 我已阅读并同意<a href="#" class="reg-hetonglink" style="color: #ff5d5b;">《服务协议》</a></label>
                </div>
                <!--but end-->
            </div>
            <!--银行卡类型 end-->

            <!--转入账户余额类型 end-->
            <div class="draw-typebox draw-balance"  style="display: block;">
                <!--账户余额 start-->
<!--                <div class="prec-t-box clearfix" style="padding: 0px 0px 10px 0px">
                    <span class="prec-tlable">可提佣金</span>
                    <div class="prec-drawbox clearfix">
                        <div class="money-ye"><span class="money-yelast">100.00</span> 元  <span class="money-forecast">预计到账余额为： <b class="total-money">100.00</b> 元</span></div>
                    </div>
                </div>-->
                <!--账户余额 end-->
                <!--当前佣金 start-->
                <div class="prec-t-box clearfix" style="padding: 0px 0px 10px 0px">
                    <span class="prec-tlable">可提佣金</span>
                    <div class="prec-drawbox clearfix">
                        <div class="money-ye"><span class="money-yelast">{{ $commission }}</span> 元</div>
                    </div>
                </div>
                <!--账户余额 end-->
                <!--转入余额 start-->
                <div class="prec-t-box clearfix" style="padding: 20px 0px 0px 0px;">
                    <span class="prec-tlable">转入余额</span>
                    <div class="prec-drawbox  clearfix">
                        <input type="text" class="draw-commission" data-maxmoney="{{ $commission }}" data-balance="100" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" /> <span class="draw-moneyuan">元</span>
                        <span class="d-commissiontip"></span>
                    </div>
                </div>
                <!--转入余额 end-->
                <!--but start-->
                <div class="prec-t-button">
                    <input class="recharge-button draw-commissionbutton" type="button" value="立即转入" />
                    <label class="recharge-hetong"><input type="checkbox" checked="checked" class="protocol-check"> 我已阅读并同意<a href="#" class="reg-hetonglink" style="color: #ff5d5b;">《服务协议》</a></label>
                </div>
                <!--but end-->
            </div>
            <!--转入账户余额类型 end-->


            <!--温馨提示 start-->
            <div class="p-recwarm_info">
                <h2 class="p-recw-h2"><i></i>温馨提示</h2>
                <div class="p-recw-txt">
                    <p>若您在提现过程中遇到问题，可联系客服进行人工处理。</p>
                    <p>用户须知：</p>
                    <p>1.每日的提现限额依据各银行限额为准；</p>
                </div>
            </div>
            <!--温馨提示 end-->
        </div>
        <!--main end-->
    </div>
    <!--提现和佣金转余额 end-->
    <!--提现提醒 start-->
    <div class="p-rec-tips">
        <h2 class="rec-tiph2">请您在新开的页面上完成提现！</h2>
        <div class="rec-tiptxt">
            <p>提现完成之前，请不要关闭本窗口！</p>
            <p>完成提现后根据您的个人情况完成此操作！</p>
        </div>
        <p class="rec-tipbut clearfix"><a href="#" class="rect-record">查看提现记录</a><a href="javascript:window.location.reload();" class="rect-reload">重选提现方式</a></p>
    </div>
    <!--提现提醒 end-->
    <!--佣金转入余额提醒 start-->
    <div class="p-commission-tips">
        <h2 class="rec-tiph2">请您在新开的页面上完成提现！</h2>
        <div class="rec-tiptxt">
            <p>提现完成之前，请不要关闭本窗口！</p>
            <p>完成提现后根据您的个人情况完成此操作！</p>
        </div>
        <p class="rec-tipbut clearfix"><a href="#" class="rect-record">查看佣金转入余额记录</a><a href="javascript:window.location.reload();" class="rect-reload">重选提现方式</a></p>
    </div>
    <!--佣金转入余额提醒 end-->
    <!--服务协议 start-->
    <div class="p-rec-protocol">
        <p>欢迎您访问并使用充满互动乐趣的购物网站——特速一块购 （http://www.ts1kg.com/)，作为为用户提供全新、趣味购物模式的电子商务公司，特速一块购通过在线交易为您提供各项相关商品消费及服务。当使用特速一块购的各项具体服务时，您和特速一块购都将受到本服务协议规则的约束，特速一块购将持续推出各项新的商品及服务，您在接受各项商品及服务的同时视为您接受本服务协议及网站相关服务条款的制约。请您在注册并使用服务前务必认真阅读此服务协议相关条款，如有任何疑问，请致电特速一块购及时咨询。一旦您注册成功，视为接受本服务协议，本服务协议即在用户和特速一块购之间产生法律效力。请您在注册过程中点击“同意”按钮即表示您完全接受本协议中的全部条款，随后按照页面给予的提示完成全部的注册步骤。</p>
        <p>特速一块购将本着服务客户、尊重法律的原则，不定期的修改本服务协议的有关条款，并保留在必要时对此协议中的所有条款进行修订的权利。一旦协议内容有所修改，特速一块购将会在网站重要页面或社区的醒目位置第一时间给予通知。如果您继续使用特速一块购的服务，则视为您接受协议的改动内容。如果不同意本站对协议内容所做的修改，特速一块购会及时取消您的相关服务使用权限，本站保留修改或中断服务而不需告知用户的权利，本站行使修改或中断服务的权利时，不需对用户或第三方负责。用户须认真阅读网站服务条款，不得以未阅读本服务条款内容作任何形式的抗辩。</p><h4>一、用户注册</h4><p>1、用户注册是指用户登录特速一块购，按要求填写相关用户信息并确认同意本服务协议的过程。</p><p>2、特速一块购用户须为具有完全民事行为能力的自然人，或者具有合法持续经营资格的组织。无民事行为能力人、限制民事行为能力人以及无经营或特定经营资格的组织不得注册为特速一块购用户，超过其民事权利或行为能力范围与特速一块购进行交易，则交易自始无效，特速一块购有权立即停止与该用户的交易、注销该用户账户，并有权要求其承担相应法律责任。</p><h4>二、用户账户、密码和安全性</h4>
        <p>用户一旦注册成功，成为本站的合法用户，用户将对用户名和密码安全负全部责任。此外，每个用户都要对以其用户名进行的所有活动和事件负全责。用户若发现任何非法使用用户帐号或存在安全漏洞的情况，请立即告知本站。</p>
        <h4>三、账户提现及使用规则</h4><p>1、用户在成为特速一块购会员后，可以通过“我的特速一块购”提现购买网盘，我们将赠送您块，购买1元的网盘赠送1块，您在网站参与购买使用块即可。</p>
        <p>2、块仅限特速一块购商城使用，不能用于购买或兑换其他网站商品或转移给其他用户。</p>
        <p>3、本网站为创新购买商品及服务的网站，遵守国家关于反洗钱相关法律规范的要求，并且为了防止信用卡套现和洗钱等行为，因此本网站不允许提现。</p>
        <h4>四、特速一块购原则</h4>
        <p>平等原则：用户和特速一块购在交易过程中具有同等的法律地位。</p>
        <p>自由原则：用户享有自主、自愿在特速一块购参与购买商品及服务的权利，任何人不得非法干预。</p>
        <p>公平原则：用户和特速一块购行使权利、履行义务应当遵循公平原则。</p>
        <p>诚信原则：用户和特速一块购行使权利、履行义务应当遵循诚实信用原则。</p>
        <p>尊重规则原则：用户向特速一块购参与商品及服务分享购买时，用户和特速一块购皆有义务依法根据本服务协议的约定完成该交易（法律或本协议禁止的交易除外）。</p>
        <h4>五、用户的权利和义务</h4>
        <p>1、用户有权独立拥有并支配其在特速一块购的用户名及密码，并用该用户名和密码登录特速一块购参与商品购买。用户不得以任何形式转让或授权他人使用自己的特速一块购账户。</p>
        <p>2、用户有权根据本协议规则以及特速一块购网站上发布的相关规则在特速一块购上查询商品信息、发表使用体验、参与商品讨论、邀请关注好友、上传商品图片、参加特速一块购等各项有关活动，以及享受特速一块购提供的其它信息服务。</p>
        <p>3、用户有义务在注册时提供自己的真实身份信息，并保证诸如电子邮件地址、联系电话、联系地址、邮政编码等内容的有效性及真实性，保证特速一块购可以通过上述联系方式与用户本人取得联系。同时，用户也有义务在相关资料发生变更时及时更新有关注册资料。用户不得以他人信息资料在特速一块购进行注册和参与商品及服务分享购买。</p>
        <p>4、用户应当保证在特速一块购参与商品及服务分享购买时遵守诚实信用原则，不扰乱网上交易的正常秩序。</p>
        <p>5、用户通过参与特速一块购服务获得奖品后须在7天登录特速一块购提交或确认收货地址，否则视为放弃该奖品，用户因此行为造成的损失公司不承担任何责任。</p>
        <p>6、若用户存在任何违法或违反本服务协议约定的行为，特速一块购有权视用户的违法或违规情节适用以下一项或多项处罚措施：</p>
        <p>（1）责令用户改正违法或违规行为；</p>
        <p>（2）中止、终止部分或全部服务；</p>
        <p>（3）取消用户购物订单并取消奖品发放（若用户已获得奖品），且用户已获得的块不予退回；</p>
        <p>（4）冻结或注销用户账号及其块（如有）；</p>
        <p>（5）其他特速一块购认为适当的措施。</p>
        <p>7、用户享有法律规定的言论自由权利，并拥有适度修改、删除自己发表的文章的权利，用户不得在特速一块购发表包含涉及以下内容的任何言论：</p>
        <p>（1）反对宪法所确定的基本原则，煽动、抗拒、破坏宪法和法律、行政法规实施的；</p>
        <p>（2） 煽动颠覆国家政权，推翻社会主义制度，煽动、分裂国家，破坏国家统一的；</p>
        <p>（3） 损害国家荣誉和利益的；</p>
        <p>（4） 煽动民族仇恨、民族歧视，破坏民族团结的；</p>
        <p>（5） 任何包含对种族、性别、宗教、地域内容等歧视的；</p>
        <p>（6） 捏造或者歪曲事实，散布谣言，扰乱社会秩序的；</p>
        <p>（7） 宣扬封建迷信、邪教、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；</p>
        <p>（8） 公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；</p>
        <p>（9） 损害国家机关信誉的；</p>
        <p>（10） 其他违反宪法和法律行政法规的。</p>
        <p>8、特速一块购有依国家机关要求、依据自身审查或依被侵权人请求对于用户言论信息进行处理的权利。或若用户发表侵犯他人权利或违反法律规定的言论，特速一块购有权停止传输并删除其言论、禁止该用户发言、注销用户账号及其块（如有），同时，特速一块购保留根据国家法律法规、相关政策向有关机关上报权利。</p>
        <p>9、用户在发表使用体验、讨论图片等，除遵守本条款外，还应遵守该讨论区的相关规则。</p>
        <p>10、未经特速一块购同意，禁止用户在网站发布任何形式的广告。</p>
        <h4>六、特速一块购的权利和义务</h4>
        <p>1、特速一块购有义务在现有技术上维护整个网上交易平台的正常运行，并努力提升和改进技术，使用户网上交易活动得以顺利进行；</p>
        <p>2、对用户在注册和使用特速一块购网上交易平台中所遇到的与交易或注册有关的问题及反映的情况，特速一块购客服中心应及时作出回复；</p>
        <p>3、对于用户在特速一块购网站上作出下列行为的，特速一块购有权作出删除相关信息、终止提供服务等处理，而无须征得用户的同意：</p>
        <p>1) 特速一块购有权对用户的注册信息及购买行为进行查阅，发现注册信息或购买行为中存在任何问题的，有权要求用户合理时间进行解释及改正的通知或者作出删除等处理措施；</p>
        <p>2) 用户违反本协议规定或有违反法律法规和地方规章的行为的，特速一块购有权停止传输并删除其信息，禁止用户发言，注销用户账户并按照相关法律规定向相关主管部门进行披露。</p>
        <p>3) 对于用户在特速一块购进行的下列行为，特速一块购有权对用户采取删除其信息、禁止用户发言、注销用户账户等限制性措施：包括发布或以电子邮件或以其他方式传送存在恶意、虚假和侵犯他人人身财产权利内容的信息，进行与分享购物无关或不是以分享购物为目的的活动，恶意注册、签到、评论等方式试图扰乱正常购物秩序，将有关干扰、破坏或限制任何计算机软件、硬件或通讯设备功能的软件病毒或其他计算机代码、档案和程序之资料，加以上载、发布、发送电子邮件或以其他方式传送，干扰或破坏特速一块购网站和服务或与特速一块购网站和服务相连的服务器和网络，或发布其他违反公共利益或可能严重损害特速一块购和其它用户合法利益的信息。</p>
        <p>4、用户在此免费授予特速一块购永久性的独家使用权(并有权对该权利进行再授权)，使特速一块购有权在全球范围内(全部或部分地)使用、复制、修订、改写、发布、翻译和展示用户公示于特速一块购网站的各类信息，或制作其派生作品，或以现在已知或日后开发的任何形式、媒体或技术，将上述信息纳入其它作品内。</p>
        <p>5、对于特速一块购网络平台已上架商品，特速一块购有权根据市场变动修改商品价格，而无需提前通知客户。</p>
        <p>6、如果发生下列情况，特速一块购有权取消用户购物订单：</p>
        <p>（1）因不可抗力、特速一块购网络系统发生故障或遭受第三方攻击，或发生其他公司无法控制的情形；</p>
        <p>（2）根据公司已经发布的或将来可能发布或更新的各类规则、公告的规定，公司有权取消用户订单情形；</p>
        <p>（3）公司有权取消用户订单后，用户可申请退还块至自己的账户，所退还块将在3个工作日内退还至用户账户中。</p>
        <p>7、特速一块购分享购物模式，秉持双方自愿原则，分享购物存在风险，特速一块购不对抽取的“幸运编号”结果承担责任，望所有用户谨慎参与。</p>
        <h4>七、配送及费用</h4>
        <p>1、特速一块购将会把产品送到您所指定的送货地址。全国大陆区域免费配送（港澳台地区除外）。如需配送至西藏、新疆（乌鲁木齐、石河子、五家渠市、吐鲁番、昌吉州、塔城地区除外）等偏远地区时，特速一块购按比例收取一定运费。</p>
        <p>请清楚准确地填写您的真实姓名、收货地址及联系方式。因如下情况造成配送延迟或无法配送等，本站将不承担责任：</p>
        <p>（1）客户提供错误信息和不详细的地址；</p>
        <p>（2）货物送达无人签收，由此造成的重复配送所产生的费用及相关的后果。</p>
        <p>（3）不可抗力，例如：自然灾害、交通戒严、突发战争等。</p>
        <p>2、由于地域限制，特速一块购所有汽车不在配送范围内，奖品获得者需自行提取，提车地点：山西太原。</p>
        <p>3、汽车价格不包含购置税、上牌费、保险费费用，奖品获得者拥有该汽车20年免费使用权。</p>
        <h4>八、商品缺货规则</h4>
        <p>用户通过参与特速一块购所获得的商品如果发生缺货，用户和特速一块购皆有权取消该交易，所花费的金额特速一块购将全部返还。或特速一块购对缺货商品进行预售登记，特速一块购会尽最大努力在最快时间内满足用户的购买需求，当缺货商品到货，特速一块购将第一时间通过短信或电话通知用户，方便用户进行购买。预售登记并不做交易处理，不构成要约。</p>
        <h4>九、责任限制</h4>
        <p>在法律法规所允许的限度内，因使用特速一块购服务而引起的任何损害或经济损失，特速一块购承担的全部责任均不超过用户所购买的与该索赔有关的商品价格。这些责任限制条款将在法律所允许的最大限度内适用，并在用户资格被撤销或终止后仍继续有效。</p>
        <h4>十、网络服务内容的所有权</h4>
        <p>本站定义的网络服务内容包括：文字、软件、声音、图片、录象、图表、广告中的全部内容；电子邮件的全部内容；本站为用户提供的其他信息。所有这些内容受著作权法、商标法、专利法等相关知识产权法律的保护。用户只能在本站和广告商授权下才能使用这些内容，而不能擅自复制、再造这些内容、或创造与内容有关的派生产品。本站所有的文章版权归原文作者和本站共同所有，任何人需要转载本站的文章，必须征得原文作者或本站授权。</p>
        <h4>十一、用户隐私保护制度</h4>
        <p>我们不会向任何第三方提供，出售，出租，分享和交易用户的个人信息。当在以下情况下，用户的个人信息将部分或全部被善意披露：</p>
        <p>1、经用户同意，向第三方披露；</p>
        <p>2、如用户是符合资格的知识产权投诉人并已提起投诉，应被投诉人要求，向被投诉人披露，以便双方处理可能的权利纠纷；</p>
        <p>3、根据法律的有关规定，或者行政或司法机构的要求，向第三方或者行政、司法机构披露；</p>
        <p>4、如果用户出现违反中国有关法律或者网站政策的情况，需要向第三方披露；</p>
        <p>5、为提供你所要求的产品和服务，而必须和第三方分享用户的个人信息；</p>
        <p>6、其它本站根据法律或者网站政策认为应当披露的事项。</p>
        <h4>十二、法律管辖和适用</h4>
        <p>1、本协议的订立、执行和解释及争议的解决均应适用中国法律。</p>
        <p>2、如发生本站服务条款与中国法律相抵触时，则这些条款将完全按法律规定重新解释，而其它合法条款则依旧保持对用户产生法律效力和影响。</p>
        <p>3、本协议的规定是可分割的，如本协议任何规定被裁定为无效或不可执行，该规定可被删除而其余条款应予以执行。</p>
        <p>4、如双方就本协议内容或其执行发生任何争议，双方应尽力友好协商解决；双方协商未达成一致时，任何一方均可向特速一块购网站所在地的有管辖权的人民法院提起诉讼。</p>
    </div>
    <!--服务协议 end-->
 
@endsection
@section("my_js")
    <script>
        $(function(){
            //提现类型切项
            $(".prec-withdraw ul li").click(function(){
                var dtype = $(this).attr("data-drawtype");
                $(this).addClass("money-curr").siblings("li").removeClass("money-curr");
                $(".draw-moneyinput").val("");
                $(".draw-commission").val("");
                $(".draw-typebox").eq(dtype).show().siblings(".draw-typebox").hide();
            })

            //银行卡选择器
            $(".draw-listbank .dbank-box").click(function(){
                $(this).addClass("dbank-box-on").siblings(".dbank-box").removeClass("dbank-box-on");
                var bankname = $(this).find(".a_bankcard_ico").attr("title");
                var banknumber = $(this).find(".mycard-no").attr("data-banknumber");
                layer.msg(bankname + banknumber,{time:1000});
            })

            /*提现银行卡，键盘和失焦js验证*/
            $(".d-moneytip").text("");
            checkmoney();
            function checkmoney(){
                //键盘键入验证
                $(".draw-moneyinput").keyup(function(){
                    var maxmoney = $(this).attr("data-maxmoney");        //限制最大转入金额，其实为用户账户金额
                    var realmoney = parseInt($(this).val());             //获取用户输入的真实金额
                    if( realmoney == 0 || realmoney == "" || realmoney == null || isNaN(realmoney)){
                        $(".d-moneytip").text("您输入的金额有误！");
                        $(this).val("");
                        return false;
                    }
                    else if(realmoney > maxmoney){
                        $(".d-moneytip").text("提现金额不能超出账户余额" + maxmoney + "元！");
                        $(this).val(parseInt(maxmoney));
                        return false;
                    }
                    else{
                        $(".d-moneytip").text("");
                    }
                })
                /*失去焦点验证*/
                $(".draw-moneyinput").blur(function(){
                    var maxmoney = $(this).attr("data-maxmoney");         //限制最大转入金额，其实为用户账户金额
                    var realmoney = parseInt($(this).val());              //获取用户输入的真实金额
                    if( realmoney == 0 || realmoney == "" || realmoney == null || isNaN(realmoney)){
                        $(".d-moneytip").text("您输入的金额有误！");
                        $(this).val("");
                        return false;
                    }
                    else if(realmoney > maxmoney){
                        $(".d-moneytip").text("");
                        $(this).val(parseInt(maxmoney));
                    }
                    else{
                        $(".d-moneytip").text("");
                    }
                })

            }

            /*提现银行卡，提交按钮*/
            $('.withdraw-button').on('click', function(){
                var maxmoney = $(".draw-moneyinput").attr("data-maxmoney");     //限制最大转入金额，其实为用户账户金额
                var realmoney = parseInt($(".draw-moneyinput").val());                    //获取用户输入的真实金额
                if( realmoney == 0 || realmoney == "" || realmoney == null || isNaN(realmoney)){
                    $(".d-moneytip").text("您输入的金额有误！");
                    $(".draw-moneyinput").val("");
                    $(".draw-moneyinput").focus();
                    return false;
                }
                else if(realmoney > maxmoney){
                    $(".d-moneytip").text("");
                    $(".draw-moneyinput").focus();
                    return false;
                } else if(realmoney < 100){
                        $(".d-moneytip").text("提现金额最低为100元！");
                        $(".draw-moneyinput").val("");
                        $(".draw-moneyinput").focus();
                        return false;
                    }
                else{
//                    $(".d-moneytip").text("");
//                    layer.open({
//                        type: 1,
//                        title: '提现提醒',
//                        area: ['434px', '290px'], //宽高
//                        content: $('.p-rec-tips'),
//                    });
                    var bankname = $(".dbank-box-on").find(".a_bankcard_ico").attr("title");
                    $.post("{{url('/user/commitobank')}}",{'bankname':bankname,'money':realmoney,'_token':"{{csrf_token()}}"},function(data){
                        if(data==null){
                            layer.msg('服务端错误');
                        }
                        if (data.status == 1){
                            layer.msg(data.msg);
                            location.reload();
                        }
                        if (data.status == 0){
                            layer.msg(data.msg);
                        }
                    },'json');
                }
            });

            /*佣金转入余额，键盘和失焦js验证*/
            $(".d-commissiontip").text("");
            $(".total-money").text("100");
            checkcommission();
            function checkcommission(){
                //键盘键入验证
                $(".draw-commission").keyup(function(){
                    var maxcommoney = $(this).attr("data-maxmoney");                         //限制最大转入金额，其实为用户佣金金额
                    var lastmoney = $(this).attr("data-balance");                            //获取用户剩余金额
                    var realcommoney = parseInt($(this).val());                              //获取用户输入的真实金额
//                    var totalmoney = realcommoney + parseInt(lastmoney);                     //当输入金额小于提现佣金时，总共金额 = 真实金额 + 剩余金额
//                    var newtotalmoney = parseInt(maxcommoney) + parseInt(lastmoney);         //当输入金额大于提现佣金时，总共金额 = 最大金额 + 剩余金额
                    if( realcommoney == 0 || realcommoney == "" || realcommoney == null || isNaN(realcommoney)){
                        $(".d-commissiontip").text("您输入的金额有误！");
                        $(this).val("");//为空重置
                        $(".draw-commission").focus();
                        return false;
                    }
                    else if(realcommoney > maxcommoney){
                        $(".d-commissiontip").text("提现金额不能超出账户余额" + maxcommoney + "元！");
                        $(this).val(parseInt(maxcommoney));
                        $(".total-money").text(newtotalmoney);
                    }
                    else{
                        $(".d-commissiontip").text("");
                        $(".total-money").text(totalmoney);
                    }
                })
                /*失去焦点验证*/
                $(".draw-commission").blur(function(){
                    var maxcommoney = $(this).attr("data-maxmoney");                         //限制最大转入金额，其实为用户佣金金额
                    var lastmoney = $(this).attr("data-balance");                            //获取用户剩余金额
                    var realcommoney = parseInt($(this).val());                              //获取用户输入的真实金额
                    var totalmoney = realcommoney + parseInt(lastmoney);                     //当输入金额小于提现佣金时，总共金额 = 真实金额 + 剩余金额
                    var newtotalmoney = parseInt(maxcommoney) + parseInt(lastmoney);         //当输入金额大于提现佣金时，总共金额 = 最大金额 + 剩余金额
                    if( realcommoney == 0 || realcommoney == "" || realcommoney == null || isNaN(realcommoney)){
                        $(".d-commissiontip").text("您输入的金额有误！");
                        $(this).val("");//为空重置
                        $(".draw-commission").focus();
                        return false;
                    }
                    else if(realcommoney > maxcommoney){
                        $(".d-commissiontip").text("提现金额不能超出账户余额" + maxcommoney + "元！");
                        $(this).val(parseInt(maxcommoney));
                        $(".total-money").text(newtotalmoney);
                    }
                    else{
                        $(".d-commissiontip").text("");
                        $(".total-money").text(totalmoney);
                    }
                })

            }
            /*佣金转余额，提交按钮*/
            $('.draw-commissionbutton').on('click', function(){
                var maxcommoney = $(".draw-commission").attr("data-maxmoney");                         //限制最大转入金额，其实为用户佣金金额
                var lastmoney = $(".draw-commission").attr("data-balance");                            //获取用户剩余金额
                var realcommoney = parseInt($(".draw-commission").val());                //获取用户输入的真实金额
                var totalmoney = realcommoney + parseInt(lastmoney);                     //当输入金额小于提现佣金时，总共金额 = 真实金额 + 剩余金额
                var newtotalmoney = parseInt(maxcommoney) + parseInt(lastmoney);         //当输入金额大于提现佣金时，总共金额 = 最大金额 + 剩余金额
                if( realcommoney == 0 || realcommoney == "" || realcommoney == null || isNaN(realcommoney)){
                    $(".d-commissiontip").text("您输入的金额有误！");
                    $(".draw-commission").val("");//为空重置
                    $(".draw-commission").focus();
                    return false;
                }
                else if(realcommoney > maxcommoney){
                    $(".d-commissiontip").text("提现金额不能超出账户余额" + maxcommoney + "元！");
                    $(".draw-commission").val(maxcommoney);
                    $(".total-money").text(newtotalmoney);
                }
                else{
                    $(".d-commissiontip").text("");
                    $(".draw-commissionbutton").val("正在转入...");
                    $.post("{{url('/user/commitomoney')}}",{'money':realcommoney,'_token':"{{csrf_token()}}"},function(data){
                        if(data==null){
                            layer.msg('服务端错误');
                        }
                        if (data.status == 1){
                            layer.msg(data.msg);
                            location.href='/user/account';
                        }
                        if (data.status == 0){
                            layer.msg(data.msg);
                            $(".draw-commissionbutton").val("立即转入");
                        }
                    },'json');
                }
            });

            /*服务协议 弹出窗提示*/
            $('.reg-hetonglink').on('click', function(){
                layer.open({
                    type: 1,
                    title: '服务协议',
                    area: ['810px', '540px'], //宽高
                    content: $('.p-rec-protocol'),
                });
            });
        })
        function cheakmoney(money)
        {
            if(money < 100){
                layer.msg('不好意思，提现佣金最低为100元，你可以转余额去购买，也可以邀请好友加入，赢取更多的佣金！',{time:5000},function(){
                    location.reload();
                });
            }
        }
    </script>
@endsection