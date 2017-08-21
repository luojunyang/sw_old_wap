var addressList = {};//,postage=0.00;
var l_express = true;
var l_friend = true;
var selffetch_obj = {};
var friend_obj = {};
$(function () {

    var nowScroll = 0;
    var payShowAfter = function () {
        $('html').css({'overflow': 'visible', 'height': 'auto', 'position': 'static'});
        $('body').css({'overflow': 'visible', 'height': 'auto', 'padding-bottom': '45px'});
        $(window).scrollTop(nowScroll);
    }
    $('#confirm-pay-way-opts .btn-pay').click(function () {
            var loadingCon = $('<div style="text-align: center; overflow:hidden;visibility:visible;position:absolute;z-index:1100;transition:opacity 300ms ease;-webkit-transition:opacity 300ms ease;opacity:1;top:' + (($(window).height() - 100) / 2) + 'px;left:' + (($(window).width() - 200) / 2) + 'px;"><div class="loader-container" style="width: 200px;background: #fff;padding: 50px 10px;text-align: center;"><div class="loader center">处理中，请稍候...</div></div></div>');
            var loadingBg = $('<div style="height:100%;position:fixed;top:0px;left:0px;right:0px;z-index:1000;opacity:1;transition:opacity 0.2s ease;-webkit-transition:opacity 0.2s ease;background-color:rgba(0,0,0,0.901961);"></div>');
            $('html').css({'position': 'relative', 'overflow': 'hidden', 'height': $(window).height() + 'px'});
            $('body').css({
                'overflow': 'hidden',
                'height': $(window).height() + 'px',
                'padding': '0px'
            }).append(loadingCon).append(loadingBg);
            nowScroll = $(window).scrollTop();
            $.post(pay_url, function (result) {
                payShowAfter();
                //loadingBg.css('opacity', 0);
                setTimeout(function () {
                    loadingCon.remove();
                    loadingBg.remove();
                }, 200);
                if (typeof(result) == 'object') {
                    if (result.err_code == 0) {
                        if (typeof(result.err_msg) == "object" && window.WeixinJSBridge) {
                            window.WeixinJSBridge.invoke("getBrandWCPayRequest", result.err_msg, function (res) {
                                WeixinJSBridge.log(res.err_msg);
                                if (res.err_msg == "get_brand_wcpay_request:ok") {
                                    //alert('./my.php');
                                    window.location.href = './my_order.php';
                                }
                                else {
                                    if (res.err_msg == "get_brand_wcpay_request:cancel") {
                                        var err_msg = "您取消了微信支付";
                                    }
                                    else if (res.err_msg == "get_brand_wcpay_request:fail") {
                                        var err_msg = "微信支付失败<br/>错误信息：" + res.err_desc;
                                    }
                                    else {
                                        var err_msg = res.err_msg + "<br/>" + res.err_desc;
                                    }
                                    motify.log(err_msg);
                                }
                            });
                        } else {
                            window.location.href = result.err_msg;
                        }
                    }else{
                        motify.log(result.err_msg);
                    }
                }
                else {
                    motify.log(result.err_msg);
                }
            });

    });
});


