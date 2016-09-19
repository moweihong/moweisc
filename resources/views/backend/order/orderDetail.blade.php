@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">订单管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">订单管理</a> <span class="divider">/</span></li>
            <li class="active">订单详情</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div>
        @if($order->pay_type == 'invite')
            <div>
                <span>商品类型：</span><span class="require-field" style="color: red;">邀友获得的商品</span>

            </div><br>
            <div>
                <span>商品名称：</span><span class="require-field">{{$order->g_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div><br>
            <div>
                <span>商品图片：</span>
                <div>
                    <img src="{{ $order->inviteGoods->img }}" style="width: 200px;height: 300px;"> </img>
                </div>
            </div><br>
        @else
            <div>
                <span>商品期数：</span><span class="require-field">第{{$order->g_periods}}期</span>

            </div><br>
            <div>
                <span>商品名称：</span><span class="require-field">{{$order->g_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span>购买总数：</span><span class="require-field">{{$order->buycount}}</span>  

            </div><br>
            <div>
                <span>购买的云购码：</span>
                <div class="b-yunnumber clearfix">
                    <ul>
                    <?php 
                        $list = json_decode($order->buyno);
                        foreach($list as $val){
                            if($val == $order->fetchno){
                                echo "<li class='number-curr'>".$val.'</li>';
                            }else{
                                echo '<li>'.$val.'</li>';
                            }                        
                        }
                   ?>
                    </ul>
                </div>
            </div><br>
            <div>
                <span>中奖云购码：</span><span class="require-field"><?php echo $order->fetchno ? $order->fetchno:'无';?></span>
            </div><br>
            <div>
                <span >商品图片：</span>
                <div>
                    <?php 
                        $list = unserialize($order->goods->picarr);
                        foreach($list as $val){
                            echo "<img src=\"$val\" style=\"width: 200px;height: 300px;\">";                  
                        }
                   ?>
                </div>
            </div><br>
        @endif
        <div>
            <span>订单状态：</span><span class="require-field">
                <?php
                    if($order->fetchno == NULL){
                        echo '支付完成';
                    }else if($order->fetchno != NULL){
                        switch ($order->status) {
                            case 0:
                                echo '未支付';
                                break;
                            case 1:
                                echo '正在支付'; 
                                break;
                            case 2:
                                echo '支付完成';
                                break;
                            case 3: 
                                echo '待发货'; 
                                break;
                            case 4: 
                                echo '已发货';
                                break;
                            case 5: 
                                echo '已完成待晒单';
                                break;
                            case 6: 
                                echo '已晒单';
                                break;
                            default:
                                echo '未支付';
                                break;
                        }
                    }
                ?>
            </span>
        </div><br>
        <div>
            <span>订单号：</span><span class="require-field"><?php echo $order->code;?></span>
        </div><br>
       
        @if($order->addressjson && $order->fetchno!=NULL)
        <div>
            <span>收货地址：</span><span class="require-field"><?php echo $order->addressjson->receiver;?> &nbsp;&nbsp;&nbsp;<?php echo $order->addressjson->province;?> &nbsp;&nbsp;<?php echo $order->addressjson->city;?>
            	&nbsp;&nbsp;<?php echo $order->addressjson->country;?> &nbsp;&nbsp;<?php echo $order->addressjson->area;?> &nbsp;&nbsp;</span>
            <span><?php echo $order->addressjson->mobile;?></span><br />
            <span>备注：<?php echo $order->addressjson->notice;?></span>
        </div><br>
        <div>
            
        </div><br>
        @else
            <div>
                <span>收货地址：</span><span class="require-field">收货地址未确认</span>
            </div><br>
            <div>
                <span>邮编：</span><span class="require-field"></span>
            </div><br>
        @endif
        <div>
            @if($order->status == 2)
<!--            <input type="button" onclick="cheackOrder({{$order->id}})" value="订单确认">-->
            @endif
        </div>
    </div>    
</div>        
</div>
</div>
@endsection
<script type="text/javascript">
function cheackOrder(id){
    var action ='ok';
    $.post("{{url('/backend/order/cheackorder')}}",{'id':id,'action':action,'_token':"{{csrf_token()}}"},function(data){
        if(data==null){
            alert('服务端错误');
        }        
        if (data.status==1){
            alert(data.msg);    
            location.href="{{url('/backend/order')}}";
        }
    },'json');  
}
</script>