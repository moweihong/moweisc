//商品详情页面异步方法
$.getScript("/foreground/js/paginate.js", function () {
//点击查看全部跳转到所有参与记录
	$('.view_ALL').click(function(){
		$('body').scrollTop($('.w_calculate_nav').offset().top);//跳转到参与记录
		$('.w_calculate_nav').find('dd').removeClass('tabtita-on').eq(1).addClass('tabtita-on')//换到所有参与记录这个选项卡来
		$(".tabcon-box").eq(1).show().siblings(".tabcon-box").hide();//将所有参与记录这个选项卡所对应的模块显示出来，将其他的隐藏掉
		if ($('.tabtita').attr('data-divshow') !== 1) {
            var curpage = $('#curpage_record').val();
            $("#curpage").val(curpage);
            $('.page').remove();
            $("#pro_page1").after("<div class='page'></div>");
            reflushData(curpage);
        }
	})
    $(".tabtit .tabtita").click(function () {
        var k = $(this).attr("data-divshow");
        $(".tabcon-box").eq(k).show().siblings(".tabcon-box").hide();
        $(this).addClass("tabtita-on").siblings(".tabtita").removeClass("tabtita-on");
        if ($(this).attr('data-divshow') == 0) {
            //不做任何操作
        }
        if ($(this).attr('data-divshow') == 1) {
            var curpage = $('#curpage_record').val();
            $("#curpage").val(curpage);
            $('.page').remove();
            $("#pro_page1").after("<div class='page'></div>");
            reflushData(curpage);
        }
        if ($(this).attr('data-divshow') == 2) {
            var curpage = $('#curpage_show').val();
            $("#curpage").val(curpage);
            $('.page').remove();
            $("#pro_page2").after("<div class='page'></div>");
            reflushShow(curpage)
        }
    });
//刷新所有购买记录
        function reflushData(page) {
            page = parseInt(page);
            if (parseInt(page) > 0) {
                $("#curpage_record").val(page);//修改隐藏域中的页码存储当前记录页面
            }
            //刷新所有参与记录
            //获取数据
            var url = $("#recordpath").val() + "/" + $("#product_id").val() + "?page=" + page;
            //如果隐藏域中存在参数则通过隐藏域的值刷新分页脚本
            if ($("#curpage_isload").val() > 0) {
                _page(parseInt($("#curpage_total").val()), page, parseInt($("#curpage_pagesize").val()), parseInt($("#curpage_totalpage").val()), reflushData);
            }
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = eval('(' + data + ')');
                    var curpage = data.data.current_page;
                    var total = data.data.total;
                    var totalpage = data.data.last_page;
                    var pagesize = data.data.per_page;
                    data = data.data.data;
                    var strbody = '';
                    for (var i = 0; i < data.length; i++) {
                        //遍历一个data数组
                        strbody += '<tr class=tr_record>' +
                            '<td>' + data[i]['bid_time'] + '</td>' +
                            '<td>' +
                            '<a href="/him/'+data[i]['usr_id']+'">' +
                            '<img class="lazy20"' +
                            'data-original="/foreground/img/nodata/tx-loading.png"' +
                            'src="' + data[i]['user_photo'] + '"' +
                            'style="display: inline;">' +
                            '<noscript>&amp;amp;lt;img' +
                            'src=""/&amp;amp;gt;' +
                            '</noscript>' +
                            '<tt class="name">' + data[i]['nickname'] + '</tt>' +
                            '</a>' +
                            '</td>' +
                            '<td class="w_hover_add" style="width:160px;">' +
                            '<em></em><strong>' + data[i]['buycount'] + '</strong><span onclick="lookYgCodes(event)" style="display: none;">查看夺宝码</span>' +
                            '<label class="code" style="display:none;">""</label>' +
                            '<p class="w_add_explain" style="display: none;">' +
                            '<b>由于该用户参与多期此商品夺宝，因此由系统自动为其分配相应数量的夺宝码。</b></p>' +
                            '</td>' +
                            '<td>' + data[i]['login_ip'] + '</td>' +
                            '<td><i class="w_five"></i>' + data[i]['pay_type'] + '</td>' +
                            '</tr>';
                    }
                    $(".tr_record").remove();
                    $('#tbody_record').append(strbody);
                    //初始化的时候加载
                    if ($("#curpage_isload").val() == 0) {
                        _page(total, curpage, pagesize, totalpage, reflushData);
                    }
                    $("#curpage_total").val(total);
                    $("#curpage_pagesize").val(pagesize);
                    $("#curpage_totalpage").val(totalpage);
                    $("#curpage_isload").val(1);


                }
            });

        }
 function reflushShow(page) {

            page = parseInt(page);

            if (parseInt(page) > 0) {
                $("#curpage_show").val(page);//修改隐藏域中的页码存储当前记录页面
            }
            //刷新所有参与记录
            //获取数据
            var url = $("#showpath").val() + "/" + $("#product_id").val() + "?page=" + page;

            //如果隐藏域中存在参数则通过隐藏域的值刷新分页脚本
            if ($("#curpage_isload").val() > 0) {
                _page(parseInt($("#curpage_show_total").val()), page, parseInt($("#curpage_show_pagesize").val()), parseInt($("#curpage_show_totalpage").val()), reflushShow);
            }
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var data = eval('(' + data + ')');
                    var curpage = data.data.current_page;
                    var total = data.data.total;
                    var totalpage = data.data.last_page;
                    var pagesize = data.data.per_page;
                    data = data.data.data;
                    var strbody = '';
                    for (var i = 0; i < data.length; i++) {

                        strbody += '<div class="sun" id="product_sun">' +
                            '<div class="w_calculate_three">' +
                            '<div class="w_results_left">' +
                            '<div class="w_results_border">' +
                            '<img class="lazy54"' +
                            'data-original="'+data[i]['user_photo']+'"' +
                            'src="'+data[i]['user_photo']+'"' +
                            'style="display:inline;">' +
                            '<noscript>&lt;img' +
                            'src="'+data[i]['user_photo']+'"' +
                            '/&gt;</noscript>' +
                            '</div>' +
                            '<a href="">'+data[i]['nickname']+'</a>' +
                            '</div>' +
                            '<div class="w_results_right">' +
                            "<div class=\"w_results_top\" title=\""+data[i]['sd_title']+"\">" +
                            '<b>第'+data[i]['sd_periods']+'期晒单</b>' +
                            '<a href="javascript:void(0)">'+data[i]['title']+'</a>' +
                            '<span>'+data[i]['sd_time']+'</span>' +
                            '</div>' +
                            '<div class="w_results_bottom">' +
                            "<p style=\"overflow: hidden;text-overflow: ellipsis; white-space: nowrap;display:block;\" title=\""+data[i]['sd_content']+"\">" +
                            ''+data[i]['content']+'</p>' +
                            '<div class="w_imgBorder">';
                        for(var j=0;j<data[i]['sd_photolist'].length;j++){
                            strbody +='<a href="javascript:void(0)"><img class="lazy200"' +
                            'src="'+data[i]['sd_photolist'][j]+'"' +
                            'style="display:inline;"></a>';
                        }
                           strbody += '<div class="w_clear">' +
                            '</div> </div> </div> </div> </div> </div>';

                    }
                    $("#product_show").find('.sun').remove();
                    $("#pro_page2").before(strbody);

                    //初始化的时候加载
                    if ($("#curpage_show_isload").val() == 0) {
                        _page(total, curpage, pagesize, totalpage, reflushShow);
                    }
                    $("#curpage_show_isload").val(1);
                    $("#curpage_show_total").val(total);
                    $("#curpage_show_pagesize").val(pagesize);
                    $("#curpage_show_totalpage").val(totalpage);
                }
            });
        }

    $('#buy_record').trigger('click');//模拟点击初始化ajax事件
    $('#show_record').trigger('click');
    $('#goods_info').trigger('click');
});
