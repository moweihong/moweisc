$(function(){
  //我的晒单选项卡
     $(".b_record_title li").click(function(){
        var index=$(this).index(".b_record_title li");  //获取选中元素的索引
        $(this).addClass("b_record_this").siblings().removeClass("b_record_this");//为选中元素的增加样式
        $(".b_record_list").eq(index).show().siblings().hide();  //与选中元素相对应的模块内容显示
    })
})