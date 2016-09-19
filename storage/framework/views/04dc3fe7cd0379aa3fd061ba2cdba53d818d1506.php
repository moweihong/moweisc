<?php /*个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件*/ ?>

<?php $__env->startSection('title','购买记录'); ?>
<?php $__env->startSection('content_right'); ?>
<style>
.m-buy-num dt{height:42px}/*和订单收货地址冲突，在这写一个防止冲突*/
</style>
<div id="member_right" class="member_right b_record_box">
    <ul class="b_record_title">
        <ul class="b_record_title">
            <li class="<?php echo e($type==0 ? 'b_record_this':''); ?>"><a href="<?php echo e(url('user/buy',['type'=>0])); ?>">进行中<span class="b_record_block"><?php echo e($beforoLottery); ?></span></a></li>
            <li class="<?php echo e($type==1 ? 'b_record_this':''); ?>"><a href="<?php echo e(url('user/buy',['type'=>1])); ?>">即将揭晓<span class="b_record_block1"><?php echo e($startLottery); ?></span></a></li>
            <li class="<?php echo e($type==2 ? 'b_record_this':''); ?>"><a href="<?php echo e(url('user/buy',['type'=>2])); ?>">已揭晓<span class="b_record_block2"><?php echo e($overLottery); ?></span></a></li>
        </ul>
        <!-- <li><a href="javascript:;">免税记录</a><span class="c_see c_see_other">查看物流</span></li> -->
    </ul>
    <!-- E 购买记录模块标题 -->
    <!-- S 购买记录模块内容 -->
    <div class="b_record_buy">
        <!-- 购买记录 -->
        <div class="b_record_list b_record_cloud" style="display:block;">
			<!-- 进行中时间筛选 -->
            <div class="b_record_info" style="display:none">
                <div class="b_choose">
                    <ul class="b_choose_day">
                        <li class="b_choose_this" onclick="setTime(0)">全部</li>
                        <li onclick="setTime(1)">今天</li>
                        <li onclick="setTime(2)">本周</li>
                        <li onclick="setTime(3)">本月</li>
                        <li onclick="setTime(4)">最近三个月</li>
                    </ul>
                    <dl class="b_choose_cal">
                        <dd>选择时间段：</dd>
                        <dd><input id="startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', maxDate: '#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                        <dd>&nbsp;-&nbsp;</dd>
                        <dd><input id="endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', minDate: '#F{$dp.$D(\'startTime\')}', maxDate: '2020-10-01'})"></dd>
                        <dd class="b_choose_search" onclick="actionSearch()">搜索</dd>
                    </dl>
                </div>
            </div>
			<!-- 即将接晓时间筛选 -->
            <div class="b_record_info2" style="display:none">
                <div class="b_choose">
                    <ul class="b_choose_day">
                        <li class="b_choose_this" onclick="setTime2(0)">全部</li>
                        <li onclick="setTime2(1)">今天</li>
                        <li onclick="setTime2(2)">本周</li>
                        <li onclick="setTime2(3)">本月</li>
                        <li onclick="setTime2(4)">最近三个月</li>
                    </ul>
                    <dl class="b_choose_cal">
                        <dd>选择时间段：</dd>
                        <dd><input id="startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', maxDate: '#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                        <dd>&nbsp;-&nbsp;</dd>
                        <dd><input id="endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', minDate: '#F{$dp.$D(\'startTime\')}', maxDate: '2020-10-01'})"></dd>
                        <dd class="b_choose_search" onclick="actionSearch2()">搜索</dd>
                    </dl>
                </div>
            </div>
			<!-- 已接晓时间筛选 -->
            <div class="b_record_info3" style="display:none">
                <div class="b_choose">
                    <ul class="b_choose_day">
                        <li class="b_choose_this" onclick="setTime3(0)">全部</li>
                        <li onclick="setTime3(1)">今天</li>
                        <li onclick="setTime3(2)">本周</li>
                        <li onclick="setTime3(3)">本月</li>
                        <li onclick="setTime3(4)">最近三个月</li>
                    </ul>
                    <dl class="b_choose_cal">
                        <dd>选择时间段：</dd>
                        <dd><input id="startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', maxDate: '#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                        <dd>&nbsp;-&nbsp;</dd>
                        <dd><input id="endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', minDate: '#F{$dp.$D(\'startTime\')}', maxDate: '2020-10-01'})"></dd>
                        <dd class="b_choose_search" onclick="actionSearch3()">搜索</dd>
                    </dl>
                </div>
            </div>
            <!-- 即将揭晓、进行中、已揭晓商品样式 -->
            <!--进行中-->
            <?php if($type == 0): ?>
            <table id="ongoingTable">
                <tbody>
                    <tr class="b_part_title">
                        <th class="b_th1">商品图片</th>
                        <th class="b_th2">商品名称</th>
                        <th class="b_th3">购买状态</th>
                        <th class="b_th4">参与人次</th>
                        <th class="b_th6">操作</th>
                    </tr>
                    <?php foreach($list as $val): ?>
                        <tr>
                            <td><a href="<?php echo e(url('/product',['id'=>$val->object->id])); ?>"><img src="<?php echo e($val->goods->thumb); ?>" alt=""></a></td>
                           <td id="div_0"><div class="b_goods_name">
                                   <span><a href="<?php echo e(url('/product',['id'=>$val->object->id])); ?>">(第<?php echo e($val->object->periods); ?>期)<?php echo e($val->goods->title); ?></a></span>
                                   <b class="b_all_require">价值:￥<?php echo e($val->goods->money); ?></b><div class="bgSilver" style="margin-right:0px"><span class="bgRed" style="width:<?php echo e(round($val->object->participate_person/$val->object->total_person*100,2)); ?>%;"></span></div>
                                   <div style="overflow: hidden;"><span class="orange fl" style="width:33%;height: 36px;line-height: 16px;"><em style="display: block;"><?php echo e($val->object->participate_person); ?></em>已参与</span><span class="gray6 fl" style="width:33%;height: 36px;line-height: 16px;text-align: center;"><em style="display: block;"><?php echo e($val->object->total_person); ?></em>总需人次</span><span class="blue fr" style="width:33%;height: 36px;line-height: 16px;text-align: right;"><em style="display: block;"><?php echo e($val->object->total_person - $val->object->participate_person); ?></em>剩余</span></div>
                               </div></td>
                           <td class="b_color"><span>进行中</span><span class="ongoing_append"><a onclick="addtoCart(<?php echo e($val->g_id); ?>,1)" href="javascript:void(0);">追加</a></span></td>
                           <td class="times0"><?php echo e(count(json_decode($val->buyno))); ?>人次</td>
                           <td><a href="javascript:;" onclick="yunNum('<?php echo url('/product',['id'=>$val->object->id]);?>',<?php echo $val->id;?>)" class="viewAll2">查看所有块乐码</a></td>
                        </tr>               
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!--即将接晓-->
            <?php elseif($type == 1): ?>
            <table id="soonTable">
                <tbody>
                    <tr class="b_part_title">
                        <th class="b_th1">商品图片</th>
                        <th class="b_th2">商品名称</th>
                        <th class="b_th3">购买状态</th>
                        <th class="b_th4">参与人次</th>
                        <th class="b_th6">操作</th>
                    </tr>
                    <?php foreach($list as $val): ?>
                    <tr>
                        <td><a href="<?php echo e(url('/product',['id'=>$val->object->id])); ?>"><img src="<?php echo e($val->goods->thumb); ?>" alt=""></a></td>
                        <td id="div_0"><div class="b_goods_name">
                                <span><a href="<?php echo e(url('/product',['id'=>$val->object->id])); ?>">(第<?php echo e($val->object->periods); ?>期)<?php echo e($val->goods->title); ?></a></span>
                                <b class="b_all_require">价值:￥<?php echo e($val->goods->money); ?></b><div class="bgSilver2"><span class="bgRed2"></span></div>
                            </div></td>
                        <td class="b_soonTable">正在揭晓中</td><td class="times0"><?php echo e(count(json_decode($val->buyno))); ?>人次</td>
                        <td><a href="javascript:;" onclick="yunNum('<?php echo url('/product',['id'=>$val->object->id]);?>',<?php echo $val->id;?>)"  class="viewAll2" >查看所有块乐码</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!--已接晓-->
            <?php elseif($type == 2): ?>
            <table id="ongoingTable">
                <tbody>
                    <tr class="b_part_title">
                        <th class="b_th1">商品图片</th>
                        <th class="b_th2">商品名称</th>
                        <th class="b_th3">购买状态</th>
                        <th class="b_th4">参与人次</th>
                        <th class="b_th6">操作</th>
                    </tr>
                    <?php foreach($list as $val): ?>
                    <tr>
                        <td><a href="<?php echo e(url('/product',['id'=>$val->object->id])); ?>"><img src="<?php echo e($val->goods->thumb); ?>" alt=""></a></td>
                        <td id="div_0"><div class="b_goods_name">
                                <span><a href="<?php echo e(url('/product',['id'=>$val->object->id])); ?>">(第<?php echo e($val->object->periods); ?>期)<?php echo e($val->goods->title); ?></a></span>
                                <b class="b_all_require">获得者:<?php echo e($val->user->nickname); ?></b><b class="b_all_require">幸运码：<?php echo e($val->object->lottery_code); ?></b>
                                <b class="b_all_require">本期总需:<?php echo e($val->object->total_person); ?>人次</b><b class="b_all_require">揭晓时间：<?php echo e(date('Y-m-d H:i:s',(int)($val->object->lottery_time/1000))); ?></b>
                            </div></td>
                        <td class="b_color"><span>已揭晓</span><span class="ongoing_append"><a onclick="addtoCart(<?php echo e($val->g_id); ?>,1)" href="javascript:void(0);">继续众筹</a></span></td>
                        <td class="times0"><?php echo e(count(json_decode($val->buyno))); ?>人次</td>
                        <td><a href="javascript:;" onclick="yunNum('<?php echo url('/product',['id'=>$val->object->id]);?>',<?php echo $val->id;?>)" class="viewAll2">查看所有块乐码</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <?php if($list->count() == 0): ?>
            <div style="text-align:center;width:948px;height:165px;padding-top:107.5px;">
                <a target="_blank" href="/category">
                    <img alt="暂无数据" src="<?php echo e(asset('foreground/img/no_record.png')); ?>" style="width:377px;height:49px;">
                </a>
            </div>
            <?php endif; ?>
            
            <center>
                <div id="pageDforder" class="pageStr" style="display: block;">
                    <?php echo $list->render(); ?>

                </div>
            </center>

        </div>
        </div>
    </div>
		<!-- S 购买记录详情页面内容 -->
<div class="member_right2" style="display:none">
    <div class="g-buyCon clrfix">
        <h3 class="gray3">众筹记录详情<a href="javascript:void(0)" class="details_back">返回</a></h3>
        <div class="m-mer-info clrfix">
            <ul id="showInfo">
            </ul>
        </div>
        <div class="m-buy-num clrfix">
            <dl id="showNum">
            </dl>
        </div>
    </div>
</div>
<!-- E购买记录详情页面内容-->
    <!-- S 购买记录模块内容 -->

<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/user_history.js"></script>
<script type="text/javascript">
function yunNum(url,id){
    $("#showInfo").html('');
    $("#showNum").html('');
    var index = layer.load();
    $.ajax({
            type : 'post',
            url : '/user/ajaxObtainOrderInfo',
            data : {
                id : id,
                 _token : "<?php echo e(csrf_token()); ?>",
            },
            dataType : 'json',
            success : function(data) {
                layer.close(index);
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    var appendStr = "";
                    var appendStr1 = "";
                    appendStr += "<li class=\"mer-pic\"><a target=\"_blank\" href=\""+url+"\"><img src=\""+data.img+"\"></a></li>";
                    appendStr += "<li class=\"other-winner\">";
                    appendStr += "<li class=\"other-winner\">";
                    appendStr += "<p><a class=\"gray3\" target=\"_blank\" href=\""+url+"\">(第"+data.periods+"期)"+data.title+"</a></p>";
                    appendStr += "<cite>价值：￥"+data.money+"</cite><span>您已参与<i class=\"orange\">"+data.buyno.length+"</i>人次</span>";
                    if(data.lottery == 2){
                       appendStr += "获得者：<a  class=\"blue\">"+data.name+"</a>";
                       appendStr +="<br>幸运块乐码："+data.code+"<br>揭晓时间："+data.lotterytime+"";
                    }
                    appendStr += "</li>";
                    appendStr1 += "<dt class=\"gray6\">本云商品您总共参与<i class=\"orange\">"+data.buyno.length+"</i>人次<em class=\"f-mar-left\">拥有<i class=\"orange\">"+data.buyno.length+"</i>个块乐码</em></dt>";
                    appendStr1 += "<dd><p>云购时间:"+data.time+"<em class=\"f-mar-left\"></em></p>";
                    for (var i = 0; i < data.buyno.length; i++) {
                        appendStr1 += "<span>"+data.buyno[i]+"</span>";
                    }
                    appendStr1 += "</dd>";
                    $("#showInfo").html(appendStr);
                    $("#showNum").html(appendStr1);
                }else if(data.status == 0){
                    layer.msg(data.msg);
                }
            }
    });
}
function addtoCart(g_id,num)
{
	$.ajax({
		url: '/addCart',
		type: 'post',
		dataType: 'json',
		data: {'g_id':g_id,'bid_cnt':num,'_token':"<?php echo e(csrf_token()); ?>"},
		success: function(res){
			if(res.status == 0){
				//添加成功，刷新购物车信息
				$('#cartI').text(res.data.count);
                location.href = '/mycart';
			}else if(res.status == ''){
				//未登录跳转
				window.location.href = '/login';
			}else{
				//添加失败
				layer.alert(res.message, {title:false,btn:false});
			}
		}
	})  
}
</script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('foreground.user_center', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>