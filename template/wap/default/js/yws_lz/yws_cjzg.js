/**
 * Created by zxjBigPower on 2017/6/22.
 */
$(function () {
    for(var i=0;i<$("#conBox").find("li").length;i++){
        $("#conBox").find("li").eq(i).css({"transition":"all .8s "+((i%2==1?i:i-1)/5+.5)+"s","-webkit-transition":"all .8s "+((i%2==1?i:i-1)/5+.5)+"s"});
        $("#conBox").find("li").addClass("active");
    }
})