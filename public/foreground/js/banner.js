$(function () {
    var owl=$('#owl-demo').owlCarousel({
        items: 1,
        autoPlay: true,
        stopOnHover : true,
        navigation: true,
        navigationText: ["", ""]
    });

    $('#owl-demo').mouseover(function(){
        $(".owl-prev,.owl-next").css({"visibility":"visible"});
    });
    $('#owl-demo').mouseout(function(){
        $(".owl-prev,.owl-next").css({"visibility":"hidden"});
    });
    $("#owl-demo").css({"height":$(".item").css("height")});
});