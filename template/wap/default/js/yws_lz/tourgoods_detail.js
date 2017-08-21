window.onload = function () {
    //分享按钮
    var Top = [];
    /*页面滚动过的距离*/
    $(window).scroll(function () {
        var top = $(window).scrollTop();
        Top.push(top);
    });
    $("#share-bt").click(function () {
        var length = Top.length;
        if (length == 0) {
            top = 0;
        } else {
            top = -Top[length - 1];
        }
        $(".share-model").css({
            'position': 'fixed',
            'top': top,
            'left': 0,
            'right': 0,
            'bottom': 0,
            'margin-top': 0,
            'display': 'block',
            'z-index': 1000
        });
    });
    $('.share-model').click(function () {
        $('.share-model').css("display", "none");
    })
    //轮播
    $dragBln = false;
    $(".main_image").touchSlider({
        flexible: true,
        speed: 200,
        btn_prev: $("#btn_prev"),
        btn_next: $("#btn_next"),
        paging: $(".flicking_con a"),
    });
    timer = setInterval(function () {
        $("#btn_next").click();
    }, 5000);


    $(".main_image").bind("touchstart", function () {
        clearInterval(timer);
    }).bind("touchend", function () {
        timer = setInterval(function () {
            $("#btn_next").click();
        }, 1000);
    });
}