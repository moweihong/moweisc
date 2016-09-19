/**
 * 异步分页脚本
 * 使用前需要引入jquery库,需要引入page.css,在需要插入分页的地方创建<div class="page"></div>即可
 * 脚本会自动在页面创建id=curpage的隐藏域来存放当前页面信息
 * 调用方式
 * _page(total,curpage,pagesize,totalpage,funcname);
 * total是总条数，curpage是当前页，pagesize分页size，totalpage共多少页,funcname调用方法名，默认传入参数是page即funcname(page);
 * 分页上所有节点自动绑定事件，直接返回page，依据该page进行ajax请求来获取新的数据即可。
 *
 * Useing DEMO
 * _page(1,1,1,1,reflushData);
 * function reflushData(page)
 * {
 *    //Do you business
 * }
 * */

function _page(total, curpage, pagesize, totalpage, funcname) {

    //如果总页数小于等于1，终止分页显示
    if(parseInt(totalpage)<=1){
        return ;
    }
    _page_render(total, curpage, pagesize);//渲染分页
    //对input窗口进行限制，必须是数字，且不能超过规定值
    $('#txtGotoPage').on('input propertychange', function (e, previous) {
        //将输入转为数字
        var inputvalue = Math.abs(parseInt($(this).val()));
        if (inputvalue && inputvalue <= totalpage) {
            $(this).val(inputvalue);
        }
        if (!inputvalue) {
            if (parseInt(previous)) {
                $(this).val(parseInt(previous));
            } else {
                $(this).val(0);
            }
        }
        if (inputvalue > totalpage) {
            $(this).val(totalpage);

        }
    });
    //对新的分页进行事件绑定
    $('.pageStr').find('a').bind('click', function () {
        //先判断指令 是否是上一页和下一页
        var page = 0;
        var action = $(this).attr("id");
        if (action == 'pre_page') {
            page = parseInt($('#curpage').val());
            if ((parseInt(page) - 1) > 0) {
                page--;
            } else {
                page = page;
            }
        }
        else if (action == 'last_page') {
            page = $('#curpage').val();
            if ((parseInt(page) + 1) <= totalpage) {
                page++;
            } else {
                page = page;
            }
        }
        else if (action == 'btnGotoPage') {
            page = parseInt($('#txtGotoPage').val());
        }
        else {
            //获取curpage
            if (parseInt($(this).html())) {
                var page = parseInt($(this).html())
            } else {
                var page = 1;
            }
        }
        if (page == $('#curpage').val() || page==0) {
            return false;//如果选中页面=当期页面，不做任何操作
        }
        //修改选中的样式
        $(this).parent('span').siblings().removeClass("current");
        $("#page_" + page).parent('span').addClass("current");
        $("#curpage").val(page);//修改隐藏域当前页
        _page_handler(total, page, pagesize, totalpage, funcname);
    });

}
//刷新分页，执行函数
function _page_handler(total, page, pagesize, totalpage, funcname) {
    _page(total, page, pagesize, totalpage, funcname);//刷新分页
    funcname(page);//执行方法
}

//分页函数，输出分页样式
function _page_render(total, curpage, pagesize) {
    //判断是否存在隐藏域，如果不存在就创建
    if (!$('#curpage').val()) {
        $('body').before("<input type='hidden' id='curpage' value='1'/>");
    }
    $('.page').children().remove();//生成样式之前清楚页面原来的分页
    //根据总页数和当前页数进行分页样式输出
    //计算总页数
    var totalpage = Math.ceil(total / pagesize);
    if(totalpage==0){
        curpage=0;
    }
    //页面只有四页的时候，返回固定格式
    if (totalpage <= 7) {
        var str = '', str2 = '', str3 = '';
        str += '<div id="pageStr" class="pageStr" style="margin: 64px auto;"><span class="f-noClick" ><a href="javascript:;" id="pre_page"><i class="f-tran f-tran-prev">&lt;</i>上一页</a></span>'
        for (var i = 0; i < totalpage; i++) {
            if (i == 0)
                str2 += '<span class="current"><a id="page_1">1</a></span>';
            if (i == 1)
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_2">2</a></span>';
            if (i == 2)
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_3">3</a></span>';
            if (i == 3)
                str2 += '<span><a href="javascript:;"class="tcdNumber" id="page_4">4</a></span>';
            if (i == 4)
                str2 += '<span><a href="javascript:;"class="tcdNumber" id="page_5">5</a></span>';
            if (i == 5)
                str2 += '<span><a href="javascript:;"class="tcdNumber" id="page_6">6</a></span>';
            if (i == 6)
                str2 += '<span><a href="javascript:;"class="tcdNumber" id="page_7">7</a></span>';
        }
        str3 += '<span><a title="下一页" href="javascript:;" class="nextPage" id="last_page">下一页<i class="f-tran f-tran-next">' +
            '&gt;</i></a></span>' +
            '<span class="f-mar-left">共<em>' + totalpage + '</em>页，去第</span>' +
            '<span><input type="text" id="txtGotoPage" value="' + curpage + '">页</span>' +
            '<span class="f-mar-left"><a title="确定" href="javascript:;" id="btnGotoPage">确定</a></span></div>';
    }
    //页面大于四页
    if (totalpage > 7) {
        //获取当前页码
        var str = '', str2 = '', str3 = '';
        str += '<div id="pageStr" class="pageStr" style="margin: 64px auto;"><span class="f-noClick" ><a href="javascript:;" id="pre_page"><i class="f-tran f-tran-prev">&lt;</i>上一页</a></span>' +
            '<span class="current" ><a id="page_1">1</a></span>';
        //根据当前页面生成中间部分
        //情况一 大于第四页的样式
        if (curpage > 4) {
            curpage=parseInt(curpage);
            str2 += '<span>...</span><span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage - 2) + '">' + parseInt(curpage - 2) + '</a></span>';
            str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage - 1) + '">' + parseInt(curpage - 1) + '</a></span>';
            str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage) + '">' + curpage + '</a></span>';
            if (totalpage >= (curpage + 1))
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage + 1) + '">' + parseInt(curpage + 1) + '</a></span>';
            if (totalpage > (curpage + 2))
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage + 2) + '">' + parseInt(curpage + 2) + '</a></span>';
            if (totalpage > (curpage + 3))
                str2 += '<span>...</span>';
            if ((totalpage - curpage) >= 2)
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + totalpage + '">' + totalpage + '</a></span>';
            str3 += '<span><a title="下一页" href="javascript:;" class="nextPage" id="last_page">下一页<i class="f-tran f-tran-next">' +
                '&gt;</i></a></span>' +
                '<span class="f-mar-left">共<em>' + totalpage + '</em>页，去第</span>' +
                '<span><input type="text" id="txtGotoPage" value="' + curpage + '">页</span>' +
                '<span class="f-mar-left"><a title="确定" href="javascript:;" id="btnGotoPage">确定</a></span></div>';
        }
        //情况二 小于四页的样式
        if (curpage <= 4) {
            curpage=parseInt(curpage);
            if ((curpage - 2) > 1)
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage - 2) + '">' + parseInt(curpage - 2) + '</a></span>';
            if ((curpage - 1) > 1)
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage - 1) + '">' + parseInt(curpage - 1) + '</a></span>';
            if (curpage != 1)
                str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage) + '">' + curpage + '</a></span>';
            str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage + 1) + '">' + parseInt(curpage + 1) + '</a></span>';
            str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + parseInt(curpage + 2) + '">' + parseInt(curpage + 2) + '</a></span>';
            str2 += '<span>...</span>';
            str2 += '<span><a href="javascript:;" class="tcdNumber" id="page_' + totalpage + '">' + totalpage + '</a></span>';
            str3 += '<span><a title="下一页" href="javascript:;" class="nextPage" id="last_page">下一页<i class="f-tran f-tran-next">' +
                '&gt;</i></a></span>' +
                '<span class="f-mar-left">共<em>' + totalpage + '</em>页，去第</span>' +
                '<span><input type="text" id="txtGotoPage" value="' + curpage + '">页</span>' +
                '<span class="f-mar-left"><a title="确定" href="javascript:;" id="btnGotoPage">确定</a></span></div>';
        }
    }
    $('.page').append(str + str2 + str3);//插入分页
    _page_style_init(curpage, totalpage);//对新生成的分页进行初始化设置
}
//初始化分页样式
function _page_style_init(page, totalpage) {
    //修改上一页和下一页样式
    if (page > 1 && page >= totalpage) {
        //上一页可用,下一页不可用
        $("#pre_page").parent('span').removeClass("f-noClick");
        $("#last_page").parent('span').addClass("f-noClick");
    }
    if (page > 1 && page < totalpage) {
        //上一页可用,下一页可用
        $("#pre_page").parent('span').removeClass("f-noClick");
        $("#last_page").parent('span').removeClass("f-noClick");
    }
    if (page <= 1 && page >= totalpage) {
        //上一页不可用,下一页不可用
        $("#pre_page").parent('span').addClass("f-noClick");
        $("#last_page").parent('span').addClass("f-noClick");
    }
    if (page <= 1 && page < totalpage) {
        //上一页不可用,下一页可用
        $("#pre_page").parent('span').addClass("f-noClick");
        $("#last_page").parent('span').removeClass("f-noClick");
    }
    //修改选中当前页的样式
    $(".pageStr").find('span').removeClass("current");
    $("#page_" + page).parent('span').addClass("current");
}

//input事件监听
$.event.special.valuechange = {
    teardown: function (namespaces) {
        $(this).unbind('.valuechange');
    },
    handler: function (e) {
        $.event.special.valuechange.triggerChanged($(this));
    },
    add: function (obj) {
        $(this).on('keyup.valuechange cut.valuechange paste.valuechange input.valuechange', obj.selector, $.event.special.valuechange.handler)
    },
    triggerChanged: function (element) {
        var current = element[0].contentEditable === 'true' ? element.html() : element.val()
            , previous = typeof element.data('previous') === 'undefined' ? element[0].defaultValue : element.data('previous')
        if (current !== previous) {
            element.trigger('valuechange', [element.data('previous')])
            element.data('previous', current)
        }
    }
}