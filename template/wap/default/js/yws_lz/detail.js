(function ( ){
    window.onload= function () {
        //����ť
        var Top = [] ;/*ҳ��������ľ���*/
        $(window).scroll(function() {
            var top = $(window).scrollTop();
            Top.push(top);
        });
        $("#share-bt").click(function () {
            var length = Top.length;
            if(length == 0) {
                top = 0;
            }else {
                top = -Top[length-1];
            }
            $(".share-model").css({
                'position':'fixed',
                'top':top,
                'left':0,
                'right':0,
                'bottom':0,
                'margin-top':0,
                'display':'block'
            });
        });
      /*  $('.share-model').tap(function () {
            $('.share-model').css("display","none");
        })*/

        $(".share-model").live('tap', function() {
            $('.share-model').css("display","none"); // Ϊ��ҳ�󶨵���¼�
        });
        //�ֲ�
        $dragBln = false;
        $(".main_image").touchSlider({
            flexible : true,
            speed : 200,
            btn_prev : $("#btn_prev"),
            btn_next : $("#btn_next"),
        });

        var timer;
        timer = setInterval(function(){
            $("#btn_next").click();
        }, 3000);
        $(".main_visual").hover(function(){
            clearInterval(timer);
        },function(){
            timer = setInterval(function(){
                $("#btn_next").click();
            },3000);
        });
        $(".main_image a").click(function(){
            if($dragBln) {
                return false;
            }
        });
        $(".main_image").bind("touchstart",function(){
            clearInterval(timer);
        }).bind("touchend", function(){
            timer = setInterval(function(){
                $("#btn_next").click();
            }, 3000);
        });
    }
}());