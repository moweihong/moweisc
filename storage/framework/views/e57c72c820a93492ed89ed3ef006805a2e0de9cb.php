<?php $__env->startSection('my_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/customer.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/page.css"/>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>
            <!--列表 start-->
    <div class="w_con">
        <h4 class="w_guide">
            <a href="/index">首页</a>&gt;
            <a href="/category" class="w_accord">全部商品</a>
        </h4>
        <!--商品板块 start-->
        <div class="w_goods_nav">
            <input type="hidden" value="<?php echo e($data['cateid']); ?>" id="from_cateid"/>
            <h2>全部商品<span>（共<a href="/category" class="goodscount"><?php echo e($data['count']); ?></a>件商品）</span></h2>
            <div class="w_choose">
                <dl class="w_choose_list clearfix">
                    <?php if(!empty($category['category'])): ?>
                    <?php foreach($category['category'] as $key=>$val): ?>
                        <dd><a href="javascript:void(0);" data-id="<?php echo e($val['cateid']); ?>" class="w_selected"><span
                                        class="w_icon w_icon<?php echo e($key+1); ?>"></span><b><?php echo e($val['name']); ?></b></a></dd>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </dl>

            </div>
        </div>
        <!--商品板块 end-->
        <!--排序 start-->
        <div class="w_product_con">
            <dl class="w_new">
                <dd>排列：</dd>
                <dd><a href="javascript:void(0)" class="w_announced" data-id="default">即将揭晓</a></dd>
                <dd><a href="javascript:void(0)" data-id="person">剩余人次</a></dd>
                <dd><a href="javascript:void(0)" data-id="hots">热卖</a></dd>
                <dd><a href="javascript:void(0)" data-id="new">最新商品</a></dd>
                <dd>
                    <a class="w_last" href="javascript:void(0)" data-id="price" id="arrow">价格
                        <span class="caret-white-up  caret-black-up" id="arrow_up"></span>
                          <span class="caret-white-down caret-black-down" id="arrow_down"></span>
                    </a>
                </dd>
            </dl>
        </div>
        <!--排序 end-->
        <!--商品列表 start-->
        <div class="w_goods_con">
            <!--box start-->
            <!--box end-->
        </div>
        <!-- 分页 start-->
        <div class="page">
        </div>
        <!-- 分页 end-->
    </div>
    <!--列表 end-->
    <input type="hidden" id="catid" value="0"/>
    <input type="hidden" id="order" value="default"/>
    <input type="hidden" id="brandid" value="0"/>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('my_js'); ?>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/paginate.js"></script>

    <script type="text/javascript">
        //页面默认加载数据
        $(window).load(function () {
            var catid = $('#catid').val();
            var url = "<?php echo e(config('global.base_url')); ?>" + "category/postdata";
            var order = 'default';
            var arr = [];
            $("#catid").val(arr['catid'] = catid);
            $("#order").val(arr['order'] = order);
            $("#brandid").val(arr['brandid'] = 0);
            flushProducts(url, arr);
        });
        //执行排序方法
        $('.w_new').find('a').click(function () {
            $('.w_new').find('a').removeClass('w_announced');//清楚所有选中样式
            $(this).addClass('w_announced');//添加选中样式
            var order = $(this).attr('data-id');
            if (order == 'price') {
                //获取隐藏域中的order字段
                var horder = $('#order').val();
                $("#arrow_down").removeClass("caret-black-down");
                $("#arrow_up").removeClass("caret-black-up");
                if (horder == 'price_desc') {
                    order = 'price_asc';
                     $("#arrow_down").addClass("caret-black-down");
                } else {
                    order = 'price_desc';
                       $("#arrow_up").addClass("caret-black-up");
                }
            }
            //获取默认排序方式
            var url = "<?php echo e(config('global.base_url')); ?>" + "category/postdata";
            var arr = [];
            $("#catid").val(arr['catid'] = $('#catid').val());
            $("#order").val(arr['order'] = order);
            $("#brandid").val(arr['brandid'] = $('#brandid').val());
            flushProducts(url, arr);

        });
        //根据一级分类刷新页面所有数据
        $(".w_selected").click(function () {
            var catid = $(this).attr('data-id');
            var url = "<?php echo e(config('global.base_url')); ?>" + "category/postdata";
            var order = $("#order").val();
            var arr = [];
            $("#catid").val(arr['catid'] = catid);
            $("#order").val(arr['order'] = order);
            $("#brandid").val(arr['brandid'] = 0);
            flushProducts(url, arr);
        });

        //根据二级分类刷新页面所有数据
        function brand(id) {
            //选定二级分类样式改变
            var catid = $(this).attr('data-id');
            var url = "<?php echo e(config('global.base_url')); ?>" + "category/postdata";
            var order = $('#order').val();
            var arr = [];
            $("#catid").val(arr['catid'] = $("#catid").val());
            $("#order").val(arr['order'] = order);
            $("#brandid").val(arr['brandid'] = id);
            flushProducts(url, arr);
        }

        //只刷新商品区域
        function flushPdt(page) {
            var catid = $('#catid').val();
            var url = "<?php echo e(config('global.base_url')); ?>" + "category/postdata?page=" + page;
            var order = $('#order').val();
            var brandid = $('#brandid').val();
            var arr = [];
            $("#catid").val(arr['catid'] = $("#catid").val());
            $("#order").val(arr['order'] = order);
            $("#brandid").val(arr['brandid'] = brandid);
            flushOnlyProducts(url, arr);
        }

        //异步刷新商品区域，包含二级分类和分页
        function flushProducts(url, postdata) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {catid: postdata.catid, order: postdata.order, brandid: postdata.brandid},
                success: function (data) {
                    //刷新商品二级分类
                    data = eval('(' + data + ')');
                    var data_brand = data.data.brand;
                    if(data_brand){
                    $('.w_all_class').remove();
                    var child1 = '<div class="w_all_class">' +
                            '<div class="w_choose_more">' +
                            '<dl class="w_goods_brand c_newgoods_brand">' +
                            '<dd class="c_newgoods_brand_name">分类</dd>' +
                            '<dd class="w_specific_class1">' +
                            '<ul>' +
                            '<li><a  id="brand0" onclick="brand(0)" href="javascript:void(0)">全部</a></li>';
                    var child2 = '';
                    for (var i = 0; i < data_brand.length; i++) {
                        child2 += '<li><a class="brand" id="brand' + data_brand[i]['id'] + '" onclick="brand(' + data_brand[i]['id'] + ')" href="javascript:void(0);" data-id=' +
                                data_brand[i]['id'] +
                                '>' +
                                data_brand[i]['name'] +
                                '</a></li>';
                    }
                    var child3 = '</ul>' +
                            '</dd>' +
                            '<div class="w_clear"></div>' +
                            '</dl>' +
                            '</div>' +
                            '</div>';
                    $(".w_choose_list").after(child1 + child2 + child3);
                    }
                    //选定二级分类样式改变
                    $('#brand' + postdata.brandid).addClass('w_effect c_all_effect');
                    //修改商品数据
                    if (data.data.brandidpdt) {
                        data.data.catpdt = data.data.brandidpdt;//如果存在brand商品，优先覆盖catpdt商品
                    }
                    //如果存在catpdt则刷新商品详情
                    if (data.data.catpdt) {
                        $('.w_goods_one').remove();//清空页面所有商品信息
                        //重置隐藏域页面
                        $("#curpage").val(1);
                        //从隐藏域获取当前页面数
                        var c_page=$("#curpage").val();
                        if(!c_page){
                            c_page=data.data.catpdt['current_page'];
                        }
                        $(".page").children().remove();
                        _page(data.data.catpdt['total'],c_page, data.data.catpdt['per_page'], data.data.catpdt['last_page'], flushPdt);//调用分页脚本
                        var data_pdt = data.data.catpdt.data;
                        var counts=data.data.catpdt.total;
                        $('.goodscount').html(counts);//修改商品总数量
                        var row = data_pdt.length / 4;
                        var str = '<ul class="w_goods_one">';
                        for (var i = 0; i < data_pdt.length; i++) {
                            if (i % 4 == 0 && i != 0) {
                                //四个一行,此时该换行了
                                //将str append到页面节点
                                $(".w_goods_con").append(str);
                                //清空str
                                str = '<ul class="w_goods_one">';
                            }
                            str += '<li class="w_goods_details ">' +
                                    '<div class="w_imgOut" data-gid="' + data_pdt[i]['g_id'] +
                                    '" data-pid="' + data_pdt[i]['id'] +
                                    '">' +
                                    '<a data-gid="' + data_pdt[i]['g_id'] + '" data-pid="' + data_pdt[i]['id'] +
                                    '" target="_blank" class="w_goods_img" href="/product/' + data_pdt[i]['id'] + '">' +
                                    '<img id="img_0" data-gid="' + data_pdt[i]['g_id'] + '" data-pid="' + data_pdt[i]['id'] +
                                    '" class="lazy0" data-original="' + data_pdt[i]['thumb'] + '"' +
                                    'src="'+data_pdt[i]['thumb']+'" style="display: inline;">' +
                                    '</a></div>' +
                                    '<a class="w_goods_three" target="_blank" href="/product/' + data_pdt[i]['id'] +
                                    '" data-gid="' + data_pdt[i]['g_id'] +
                                    '" data-pid="' + data_pdt[i]['id'] +
                                    '" title="' + data_pdt[i]['title'] + '"> (第' + data_pdt[i]['periods'] + '期) ' + data_pdt[i]['title'] + ' </a>' +
                                    '<b>价值：￥' + data_pdt[i]['money'] + '</b>' +
                                    '<div class="w_line"><span style="width:' + data_pdt[i]['rate'] + '%"></span></div>' +
                                    '<ul class="w_number">' +
                                    '<li class="w_amount">' + data_pdt[i]['participate_person'] + '</li>' +
                                    '<li class="w_amount">' + data_pdt[i]['total_person'] + '</li>' +
                                    '<li class="w_amount">' + data_pdt[i]['surplus'] + '</li>' +
                                    '<li>已购买人次</li>' +
                                    '<li>总需人次</li>' +
                                    '<li>剩余人次</li>' +
                                    '</ul><div class="c_rob_box">' +
                                    '<dl class="w_rob">' +
                                    '<dd><a class="w_slip" href="/product/'+data_pdt[i]['id']+'" onclick="">立即一块购</a></dd>' +
                                    '<dd class="w_rob_out"><a class="w_rob_in" href="javascript:void(0);" onclick="addCart('+data_pdt[i]['g_id']+',1)">加入购物车</a></dd>' +
                                    '</dl></div></li>';
                            $("img.lazy0").lazyload({
                                effect: "fadeIn"
                            });
                            if ((i + 1) == data_pdt.length) {
                                str += '</ul>';
                                $(".w_goods_con").append(str);
                            }
                            if (i % 4 == 3) {
                                str += '</ul>';
                            }
                        }
                    }
                    $("img.lazy0").lazyload({
                        effect: "fadeIn"
                    });
                }
            });
        }
        //异步之刷新商品区域
        function flushOnlyProducts(url, postdata) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {catid: postdata.catid, order: postdata.order, brandid: postdata.brandid},
                success: function (data) {

                    //异步返回数据,使页面滑动到顶部
                    var speed=200;//滑动的速度
                    $('body,html').animate({ scrollTop:$(".w_new").offset().top-21}, speed);

                    //刷新商品二级分类
                    data = eval('(' + data + ')');
                    if (data.data.brandidpdt) {
                        data.data.catpdt = data.data.brandidpdt;//如果存在brand商品，优先覆盖catpdt商品
                    }
                    //如果存在catpdt则刷新商品详情
                    if (data.data.catpdt) {
                        $('.w_goods_one').remove();//清空页面所有商品信息
                        var data_pdt = data.data.catpdt.data;
                        var counts=data.data.catpdt.total;
                        $('.goodscount').html(counts);//修改商品总数量
                        var row = data_pdt.length / 4;
                        var str = '<ul class="w_goods_one">';
                        for (var i = 0; i < data_pdt.length; i++) {
                            if (i % 4 == 0 && i != 0) {
                                //四个一行,此时该换行了
                                //将str append到页面节点
                                $(".w_goods_con").append(str);
                                //清空str
                                str = '<ul class="w_goods_one">';
                            }
                            str += '<li class="w_goods_details ">' +
                                    '<div class="w_imgOut" data-gid="' + data_pdt[i]['g_id'] +
                                    '" data-pid="' + data_pdt[i]['id'] +
                                    '">' +
                                    '<a data-gid="' + data_pdt[i]['g_id'] + '" data-pid="' + data_pdt[i]['id'] +
                                    '" target="_blank" class="w_goods_img" href="/product/' + data_pdt[i]['id'] + '">' +
                                    '<img id="img_0" data-gid="' + data_pdt[i]['g_id'] + '" data-pid="' + data_pdt[i]['id'] +
                                    '" class="lazy0" data-original="' + data_pdt[i]['thumb'] + '"' +
                                    'src="'+data_pdt[i]['thumb']+'" style="display: inline;">' +
                                    '</a></div>' +
                                    '<a class="w_goods_three" target="_blank" href="/product/' + data_pdt[i]['id'] +
                                    '" data-gid="' + data_pdt[i]['g_id'] +
                                    '" data-pid="' + data_pdt[i]['id'] +
                                    '" title="' + data_pdt[i]['title'] + '"> (第' + data_pdt[i]['periods'] + '期) ' + data_pdt[i]['title'] + ' </a>' +
                                    '<b>价值：￥' + data_pdt[i]['money'] + '</b>' +
                                    '<div class="w_line"><span style="width:' + data_pdt[i]['rate'] + '%"></span></div>' +
                                    '<ul class="w_number">' +
                                    '<li class="w_amount">' + data_pdt[i]['participate_person'] + '</li>' +
                                    '<li class="w_amount">' + data_pdt[i]['total_person'] + '</li>' +
                                    '<li class="w_amount">' + data_pdt[i]['surplus'] + '</li>' +
                                    '<li>已购买人次</li>' +
                                    '<li>总需人次</li>' +
                                    '<li>剩余人次</li>' +
                                    '</ul><div class="c_rob_box">' +
                                    '<dl class="w_rob">' +
                                    '<dd><a class="w_slip" href="/product/'+data_pdt[i]['id']+'" >立即购买</a></dd>' +
                                    '<dd class="w_rob_out"><a class="w_rob_in" href="javascript:void(0);" onclick="addCart('+data_pdt[i]['g_id']+',1)">加入购物车</a></dd>' +
                                    '</dl></div></li>';
                            $("img.lazy0").lazyload({
                                effect: "fadeIn"
                            });
                            if ((i + 1) == data_pdt.length) {
                                str += '</ul>';
                                $(".w_goods_con").append(str);
                            }
                            if (i % 4 == 3) {
                                str += '</ul>';
                            }
                        }
                    }
                    $("img.lazy0").lazyload({
                        effect: "fadeIn"
                    });

                }
            });
        }

       //检测是否有传入的cateid
        var cateid=$("#from_cateid").val();
        $(".w_selected").each(function(){

            if($(this).attr('data-id')==cateid){
                $(this).click();
            }

        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>