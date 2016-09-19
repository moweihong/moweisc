{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','我的银行卡')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection

@section('content_right')
    <div id="member_right" class="member_right">
        <!--mybankcard start-->
        <div class="mycommission">
            <!--tit start-->
            <div class="u_questit tabtit clearfix">
                <a class="u_quet_a" href="commission" title="招募合伙人" style="display: none;">招募合伙人</a>
                <a class="u_quet_a" href="commissionsource" title="佣金来源">佣金来源</a>
                <a class="u_quet_a" href="commissionbuy" title="佣金消费">佣金消费</a>
                <a class="u_quet_a u_quet_acurr" href="mybankcard" title="我的银行卡">我的银行卡</a>
            </div>
            <!--tit end-->
            <!--txt start-->
            <div class="user-mybanklist">
                <div class="a_record_list_bank"><p class="a_record_list_bank_tit">您已绑定了<span class="bank_card_own_count">{{ $banknum }}</span>张银行卡，还可以绑定<span class="bank_card_remain_count">{{ 3-$banknum }}</span>张。</p></div>
                <!--列表 start-->
                <div id="bank_card_list">
                    @if($list)
                        @foreach($list as $val)
                            <div class="a_bank_card_list">
                                <a href="{{ url('user/editbank',array('id'=>$val['id'])) }}" class="a_bank_card_img">
                                    <b class="a_bankcard_ico {{ 'a_bankcard_'.$val['bankinfo'] }}" title="{{ $val['bankname'] }}"></b>
                                    <span class="mycard-no">{{ $val['banknum'] }}</span>                                    
                                </a>
                                <a href="javascript:void(0);"><i class="a_bankcard_del" onclick="delBank({{$val['id']}})">删除</i></a>
                            </div>
                        @endforeach
                    @endif
                    @if($banknum < 3)
                        <div class="a_bank_add_a" id="bank_card_add"><a href="addbankcard">添加银行卡</a></div></div>
                    @endif
                <!--列表 end-->
            </div>
            <!--txt start-->
        </div>
        <!--mybankcard end-->
    </div>
    <!-- E 右侧 -->
@endsection
@section('my_js')
<script type="text/javascript">
function delBank(id){
    layer.confirm('确定删除此银行卡?', {icon: 3, title:'提示'}, function(index){
      //do something
        layer.close(index);
        $.ajax({
           type : 'post',
           url : '/user/delbank',
           data : {
               id : id,
                _token : "{{csrf_token()}}",
           },
           dataType : 'json',
           success : function(data) {
               if(data == null){
                    layer.msg('服务端错误！');
               }
               if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
               }else {
                    layer.msg(data.msg);
               }
           }
       });
    });
   
}
</script>
@endsection

