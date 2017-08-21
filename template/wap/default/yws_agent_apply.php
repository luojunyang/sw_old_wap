<?php if (!defined('TWIKER_PATH')) exit('deny access!'); ?>
    <!DOCTYPE html>
    <html class="no-js" lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="<?php echo $config['seo_keywords']; ?>" />
        <meta name="description" content="<?php echo $config['seo_description']; ?>" />
        <meta name="HandheldFriendly" content="true" />
        <meta name="MobileOptimized" content="320" />
        <meta name="format-detection" content="telephone=no" />
        <meta http-equiv="cleartype" content="on" />
        <title>微商代理申请 — 云温商“新零售”</title>
        <link rel="icon" href="<?php echo $config['site_url']; ?>/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>

        <!--    <link rel="stylesheet" href="--><?php //echo TPL_URL; ?><!--css/base.css"/>-->
        <link href="<?php echo TPL_URL; ?>css/yws_lz/agent/LArea.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/base.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/info.css"/>
        <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.min.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=DD279b2a90afdf0ae7a3796787a0742e"></script>
        <script src="<?php echo TPL_URL; ?>js/base.js"></script>
        <script type="text/javascript">
            var pay_url = 'yws_agent_apply_pay.php';
            var latitude = ''; // 纬度，浮点数，范围为90 ~ -90
            var longitude = ''; // 经度，浮点数，范围为180 ~ -180。
            var speed = ''; // 速度，以米/每秒计
            var accuracy = ''; // 位置精度
        </script>
        <!--    <script src="--><?php //echo TPL_URL; ?><!--js/yws_99agent_pay.js"></script>-->
    </head>
    <body style="background: white">
    <div class="header">
        您正在进行云温商“新零售”微商代理申请：
    </div>
    <div class="main">
        <ul>
            <li>
                <span>代理品类</span>
                <span data-type_id="464" class="classify active">食品类</span>
                <span data-type_id="175" class="classify">数码类</span>
                <span data-type_id="176" class="classify">日用百货类</span>
            </li>
            <li>
                <span>微店名称</span>
                <input type="text" name="store_name" placeholder="请输入您的店铺名称" value="<?= $agent_data['store_name']?>" maxlength="30" onkeyup="lengthCheck(this,30)"/>
            </li>
            <li>
                <span>小主姓名</span>
                <input type="text" name="name" placeholder="请输入您的姓名" value="<?= $agent_data['name']?>" maxlength="30" onkeyup="lengthCheck(this,20)"/>
            </li>
            <li>
                <span>身份证号</span>
                <input type="text" name="idCard" value="<?= $agent_data['idcard']?>" placeholder="请输入您的身份证号码" maxlength="18" onkeyup="IdCheck(this,18)"/>
            </li>
            <li>
                <span>手机号码</span>
                <input type="number" name="tel" value="<?= $agent_data['tel']?>" placeholder="请输入您常用的手机号码" maxlength="11" onkeyup="phoneCheck(this,11)"/>
            </li>
            <li class="loaction" id="demo1">
                <span>所在区域</span>
                <div class="wrap" style="display: inline-block;padding-left: 1rem;width:78%"  >
                    <div class="citySelect">
                        <div class="citySelect_area">
                            <div class="content-block">
                                <input type="text" readonly unselectable="on" onfocus="this.blur()" placeholder="请选择区域" value="" id="demo" style="width: 100%"/>
                                <input id="value" type="hidden" value="20,234,504"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--      <img src="<?php /*echo TPL_URL; */?>css/images/yws_lz/agent/more.png" alt=""/>-->
            </li>
            <li>
                <span>详细地址</span>
                <input type="text" name="address_detail" placeholder="请输入你的常驻地址信息" value="<?= $agent_data['address_detail']?>" maxlength="200"/>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="pay-btn">
        <span>微信支付 ￥99 开启代理</span>
    </div>
    <div class="content-block">
        <input id="value1" type="hidden" value="20,234,504">
    </div>

    <div id="allmap"></div>
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/yws_lz/agent//common.js"></script>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/agent//city.data.min.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/yws_lz/agent//LArea.js"></script>

    <!--<script src="<?php /*echo TPL_URL; */?>js/yws_lz/agent/LAreaData1.js"></script>
<script src="<?php /*echo TPL_URL; */?>js/yws_lz/agent/LAreaData2.js"></script>
<script src="<?php /*echo TPL_URL; */?>js/yws_lz/agent/LArea.js"></script>-->
    <script src="<?php echo TPL_URL; ?>js/yws_lz/agent/info.js"></script>
    <script>

        var area = new LArea();
        area.init({
            'trigger': '#demo', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
            'valueTo': '#value', //选择完毕后id属性输出到该位置
            'keys': {
                id: 'value',
                name: 'text'
            }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
            'type': 1, //数据源类型
            'data': LAreaData //数据源
        });
        area.value = [16, 0, 0];//控制初始位置，注意：该方法并不会影响到input的value

        var regMobile=/^1[3,4,5,8]\d{9}$/;
        var tel_flag = false,idCard_flag = false;
        //身份证验证
        function validateIdCard(idCard){
            //15位和18位身份证号码的正则表达式
            var regIdCard=/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;

            //如果通过该验证，说明身份证格式正确，但准确性还需计算
            if(regIdCard.test(idCard)){
                if(idCard.length==18){
                    var idCardWi=new Array( 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ); //将前17位加权因子保存在数组里
                    var idCardY=new Array( 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
                    var idCardWiSum=0; //用来保存前17位各自乖以加权因子后的总和
                    for(var i=0;i<17;i++){
                        idCardWiSum+=idCard.substring(i,i+1)*idCardWi[i];
                    }
                    var idCardMod=idCardWiSum%11;//计算出校验码所在数组的位置
                    var idCardLast=idCard.substring(17);//得到最后一位身份证号码
                    //如果等于2，则说明校验码是10，身份证号码最后一位应该是X
                    if(idCardMod==2){
                        if(idCardLast=="X"||idCardLast=="x"){
                            idCard_flag = true;
                            //motify.log("恭喜通过验证啦！");
                        }else{
                            idCard_flag = false;
                            motify.log("身份证号码错误！");
                            return;
                        }
                    }else{
                        //用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
                        if(idCardLast==idCardY[idCardMod]){
                            idCard_flag = true;
                            //motify.log("恭喜通过验证啦！");
                        }else{
                            idCard_flag = false;
                            motify.log("身份证号码错误！");
                            return;
                        }
                    }
                }
            }else{
                idCard_flag = false;
                motify.log("身份证格式不正确!");
                return;
            }
        }
        //手机号验证
        function validateTel(tel){
            if(regMobile.test(tel)){
                tel_flag = true;
            }else{
                tel_flag = false;
                motify.log('手机号格式错误');
            }
        }
        //定长截断
        function lengthCheck(str, maxLen){
            var w = 0;
            var tempCount = 0;
            //length 获取字数数，不区分汉子和英文
            for (var i=0; i<str.value.length; i++) {
                //charCodeAt()获取字符串中某一个字符的编码
                var c = str.value.charCodeAt(i);
                //单字节加1
                if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                    w++;
                } else {
                    w+=4;
                }
                if (w > maxLen) {
                    str.value = str.value.substr(0,i);
                    break;
                }
            }
        }
        function IdCheck(str, maxLen){
            var w = 0;
            var tempCount = 0;
            //length 获取字数数，不区分汉子和英文
            for (var i=0; i<str.value.length; i++) {
                //charCodeAt()获取字符串中某一个字符的编码
                var c = str.value.charCodeAt(i);
                //单字节加1
                if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                    w++;
                } else {
                    w+=4;
                }
                if (w > maxLen) {
                    str.value = str.value.substr(0,i);
                    break;
                }
                str.value=str.value.replace(/[^\w\.\/]/ig,'');
            }

        }
        //只能输入数字
        function phoneCheck(str, maxLen){
            var w = 0;
            var tempCount = 0;
            //length 获取字数数，不区分汉子和英文
            for (var i=0; i<str.value.length; i++) {
                //charCodeAt()获取字符串中某一个字符的编码
                var c = str.value.charCodeAt(i);
                //单字节加1
                if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                    w++;
                } else {
                    w+=4;
                }
                if (w > maxLen) {
                    str.value = str.value.substr(0,i);
                    break;
                }
                str.value=str.value.replace(/[\D]/g,'');
            }

        }
        var postData = {};
        $(".pay-btn").click(function(event) {
            /* Act on the event */
            //var type = new Array();
            console.log(area);
            var type = '';
            //选择类型
            $('.classify').each(function(index, el) {
                if($(this).hasClass('active')){
                    //type[index] = ;
                    type += $(this).data('type_id') + ",";
                }
            });
            //获取数据
            var store_name = $('input[name=store_name]').val() , name = $('input[name=name]').val() , tel = $('input[name=tel]').val();
            var idCard =  $('input[name=idCard]').val() , address = area.trigger.value , address_detail = $('input[name=address_detail]').val();
            if(!type){motify.log('请填选择代理种类');return;}
            if(!store_name){motify.log('请填写微店名称');return;}
            if(!name){motify.log('请填写小主姓名');return;}
            if(!idCard){motify.log('请填写身份证号');return;}
            if(!tel){motify.log('请填写手机号');return;}
            if(!address){motify.log('请填写所在区域');return;}
            if(!address_detail){motify.log('请填写详细地址');return;}

            validateIdCard(idCard);

            validateTel(tel);
            postData.type = type;
            postData.store_name = store_name;
            postData.name = name;
            postData.idCard = idCard;
            postData.tel = tel;
            postData.address = address;
            postData.address_detail = address_detail;

            //WXPay
            if(idCard_flag && tel_flag){
                var nowScroll = 0;
                var payShowAfter = function () {
                    $('html').css({'overflow': 'visible', 'height': 'auto', 'position': 'static'});
                    $('body').css({'overflow': 'visible', 'height': 'auto', 'padding-bottom': '45px'});
                    $(window).scrollTop(nowScroll);
                };
                var loadingCon = $('<div style="text-align: center; overflow:hidden;visibility:visible;position:absolute;z-index:1100;transition:opacity 300ms ease;-webkit-transition:opacity 300ms ease;opacity:1;top:' + (($(window).height() - 100) / 2) + 'px;left:' + (($(window).width() - 200) / 2) + 'px;"><div class="loader-container" style="width: 200px;background: #fff;padding: 50px 10px;text-align: center;"><div class="loader center">处理中，请稍候...</div></div></div>');
                var loadingBg = $('<div style="height:100%;position:fixed;top:0px;left:0px;right:0px;z-index:1000;opacity:1;transition:opacity 0.2s ease;-webkit-transition:opacity 0.2s ease;background-color:rgba(0,0,0,0.901961);"></div>');
                $('html').css({'position': 'relative', 'overflow': 'hidden', 'height': $(window).height() + 'px'});
                $('body').css({
                    'overflow': 'hidden',
                    'height': $(window).height() + 'px',
                    'padding': '0px'
                }).append(loadingCon).append(loadingBg);
                nowScroll = $(window).scrollTop();
                $.post(pay_url, postData ,function (result) {
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
            }
        });

    </script>

    <?= $shareData?>
    </body>
    </html>
<?php Analytics($nowOrder['store_id'], 'pay', '订单支付', $nowOrder['order_id']); ?>