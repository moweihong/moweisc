{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','未支付订单')
@section('content_right')
<style>
.b_th1{
    width:20%;
}
.b_th2{
    width:10%;
}
.b_th3{
    width:10%;
}
.b_th4{
    width:10%;
}
.b_th6{
    width:10%;
}
</style>
<div id="member_right" class="member_right b_record_box">
    <!-- E 购买记录模块标题 -->
    <!-- S 购买记录模块内容 -->
    <div class="b_record_buy">
        <!-- 未支付订单记录 -->
        <div class="b_record_list b_record_cloud" style="display:block;">
            <table id="ongoingTable">
                <tbody>
                    <tr class="b_part_title">
                        <th class="b_th1">订单号</th>
                        <th class="b_th2">商品详情</th>
                        <th class="b_th4">订单总额</th>
                        <th class="b_th4">支付金额</th>
                        <th class="b_th4">支付方式</th>
                        <th class="b_th4">使用余额</th>
                        <th class="b_th4">使用红包</th>
                        <th class="b_th3">状态</th>
                        <th class="b_th6">操作</th>
                    </tr>
                    @foreach ($list as $val)
                        <tr>
                            <td>{{ $val['code'] }}</td>
                           <td>
                           @if($val['type'] == 'buy')
                           	   @foreach ($val['good'] as $good)
                               	   <div class="b_goods_name" style="width:180px">
                                       <div style="word-wrap: break-word;">{{ $good['title'] }}</div>
                                       <b class="b_all_require">购买人次:{{ $good['bid_cnt'] }}</b>
                                   </div>
                               @endforeach
                           @else
                               <span>充值</span>
                           @endif
                           </td>
                           <td>{{ $val['total_amount'] }}块</td>
                           <td>{{ $val['money'] }}块</td>
                           <td>{{ $val['pay_type'] }}</td>
                           <td>{{ $val['pay_money'] }}块</td>
                           <td>抵扣{{ $val['red_amount'] }}块</td>
                           <td>未支付</td>
                           @if(intval($val['red_amount']) > 0 && $val['red_status'] != 0)
                           	   <td>此订单红包已使用</td>
                           @else
                           	   <td class="b_color"><span class="ongoing_append"><a href="javascript:void(0);" class="btn_pay" data-payurl="{{ $val['pay_url'] }}" data-paycode="{{ $val['code'] }}">去付款</a></span></td>
                        	@endif
                        </tr>               
                    @endforeach
                </tbody>
            </table>
            
            @if(count($list) == 0)
            <div style="text-align:center;width:948px;height:165px;padding-top:107.5px;">
                <a target="_blank" href="/category">
                    <img alt="暂无数据" src="{{asset('foreground/img/no_record.png')}}" style="width:377px;height:49px;">
                </a>
            </div>
            @endif

        </div>
        </div>
    </div>
    <form action="" method="post" style="display:none" id="payform">
    	<input type="text" name="code" value=""/>
    	{!! csrf_field() !!}
    	<input type="submit" value="提交" id="pay_sub">
    </form>
</div>
<!-- E 右侧 -->
</div>
<script type="text/javascript">
$('.btn_pay').click(function(){
	var pay_url = $(this).attr('data-payurl');
	var pay_code = $(this).attr('data-paycode');

	$('#payform').attr('action', pay_url);
	$('#payform').find("input[name='code']").val(pay_code);

	$('#pay_sub').click();
})
</script>
@endsection