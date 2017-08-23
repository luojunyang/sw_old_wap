<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 15:21
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>微信大转盘抽奖</title>
    <link rel="stylesheet" href="../template/wap/default/css/dindex.css"/>
</head>
<body>
<div class="container">
    <div id="img">
        <img src="../template/wap/default/images/333.png" id="shan-img" style="display:none;" />
        <img src="../template/wap/default/images/222.png" id="diy2-img" style="display:none;" />
        <img src="../template/wap/default/images/444.png" id="diy1-img" style="display:none;" />
        <img src="../template/wap/default/images/555.png" id="diy3-img" style="display:none;" />
        <img src="../template/wap/default/images/777.png" id="diy4-img" style="display:none;" />
        <img src="../template/wap/default/images/888.png" id="diy5-img" style="display:none;" />
        <img src="../template/wap/default/images/666.png" id="diy6-img" style="display:none;" />
        <img src="../template/wap/default/images/222.png" id="diy7-img" style="display:none;" />
        <img src="../template/wap/default/images/222.png" id="diy8-img" style="display:none;" />
        <img src="../template/wap/default/images/111.png" id="diy9-img" style="display:none;" />
    </div>
    <div class="banner" style="margin-top: 46%">
        <div class="turnplate" style="background-image:url(../template/wap/default/images/cj_bg1.png);background-size:100% 100%;">
            <canvas class="item" id="wheelcanvas" width="422px" height="422px"></canvas>
            <div id="start"><img id="startbtn" class="pointer" src="../template/wap/default/images/jt3.png"/></div>
        </div>
        <div class="title">
            <p >您还有 <b>3</b> 次抽奖机会</p>
        </div>
    </div>
</div>
<div class="jilu"><p>中奖记录</p></div>
<div id="d">
    <div class="detail">
        <img src="../template/wap/default/images/333.png" alt=""/>
        <p class="pname">iphone7</p>
        <p>领取</p>
    </div>
    <div class="detail">
        <img src="../template/wap/default/images/333.png" alt=""/>
        <p class="pname">iphone7</p>
        <p>领取</p>
    </div>
    <div class="detail">
        <img src="../template/wap/default/images/333.png" alt=""/>
        <p class="pname">iphone7</p>
        <p>领取</p>
    </div>
    <div class="detail">
        <img src="../template/wap/default/images/333.png" alt=""/>
        <p class="pname">iphone7</p>
        <p>领取</p>
    </div>
</div>
<div class="rules">
    <span>活动规则：</span>
</div>
</body>
</html>
<script src="../template/wap/default/js/jquery-1.10.2.js"></script>
<script type = "text/javascript" src = "../template/wap/default/js/jQueryRotate.2.2.js"></script>
<script type = "text/javascript" src = "../template/wap/default/js/jquery.easing.min.js"></script>
<script src="../template/wap/default/js/awardRotate.js"></script>
<script>
    var count=$('.title>p>b').html();
    var turnplate={
        restaraunts:[],				//大转盘奖品名称
        colors:[],					//大转盘奖品区块对应背景颜色
        outsideRadius:192,			//大转盘外圆的半径
        textRadius:155,				//大转盘奖品位置距离圆心的距离
        insideRadius:10,			//大转盘内圆的半径
        startAngle:0,				//开始角度
        bRotate:false				//false:停止;ture:旋转
    };

    $(document).ready(function(){
        //动态添加大转盘的奖品与奖品区域背景颜色
        turnplate.restaraunts = ["联想小新", "谢谢参与","日本清酒","富光保温杯", "谢谢参与", "奔驰GLA", "晴雨伞", "iphone7 ", "谢谢参与","5元红包 "];

        turnplate.colors = ["#FFEEBE","#FEE08B", "#FFEEBE", "#FEE08B", "#FFEEBE","#FEE08B", "#FFEEBE", "#FEE08B","#FFEEBE","#FEE08B" ];


        var rotateTimeOut = function (){
            $('#wheelcanvas').rotate({
                angle:0,
                animateTo:2160,
                duration:8000,
                callback:function (){
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };

        //旋转转盘 item:奖品位置; txt：提示语;
    });

    /*var goods='';
     function getGoods()
     {
     $.ajax({
     type:'get',
     dateType:'json',
     cache:false,
     url:'',
     success:function(data){
     goods = data;
     },
     error:function(){}
     });
     }
     getGoods();
     for(item in goods){
     $('#img').append("<img src='"+item.img+"' id='shan-img' style='display:none;'/>");
     }*/

    //页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
    window.onload=function(){
        drawRouletteWheel();
    };
    function drawRouletteWheel() {
        var canvas = document.getElementById("wheelcanvas");
        if (canvas.getContext) {
            //根据奖品个数计算圆周角度
            var arc = Math.PI / (turnplate.restaraunts.length/2);
            var ctx = canvas.getContext("2d");
            //在给定矩形内清空一个矩形
            ctx.clearRect(0,0,422,422);
            //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
            ctx.strokeStyle = "#CF2722";
            //font 属性设置或返回画布上文本内容的当前字体属性
            ctx.font = 'bold 16px Microsoft YaHei';
            for(var i = 0; i < turnplate.restaraunts.length; i++) {
                var angle = turnplate.startAngle + i * arc;
                ctx.fillStyle = turnplate.colors[i];
                ctx.beginPath();
                //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);
                ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
                ctx.stroke();
                ctx.fill();
                //锁画布(为了保存之前的画布状态)
                ctx.save();

                //改变画布文字颜色
                var b = i+2;
                if(b%2){
                    ctx.fillStyle = "#CF2722";
                }else{
                    ctx.fillStyle = "#CF2722";
                };

                //----绘制奖品开始----


                var text = turnplate.restaraunts[i];
                var line_height = 17;
                //translate方法重新映射画布上的 (0,0) 位置
                ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);

                //rotate方法旋转当前的绘图
                ctx.rotate(angle + arc / 2 + Math.PI / 2);
                /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
                if(text.indexOf("盘")>0){//判断字符进行换行
                    var texts = text.split("盘");
                    for(var j = 0; j<texts.length; j++){
                        ctx.font = j == 0?'bold 20px Microsoft YaHei':'bold 18px Microsoft YaHei';
                        if(j == 0){
                            ctx.fillText(texts[j]+"盘", -ctx.measureText(texts[j]+"盘").width / 2, j * line_height);
                        }else{
                            ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height*1.2); //调整行间距
                        }
                    }
                }else if(text.indexOf("盘") == -1 && text.length>8){//奖品名称长度超过一定范围
                    text = text.substring(0,8)+"||"+text.substring(8);
                    var texts = text.split("||");
                    for(var j = 0; j<texts.length; j++){
                        ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                    }
                }else{

                    //在画布上绘制填色的文本。文本的默认颜色是黑色

                    //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
                    ctx.fillText(text, -ctx.measureText(text).width/2 , 0);
                }

                //添加对应图标
                if(text.indexOf(turnplate.restaraunts[7])>=0){
                    var img= document.getElementById("shan-img");
                    img.onload=function(){
                        ctx.drawImage(img,-35,20);
                    };
                    ctx.drawImage(img,-18,20,35,60);
                };
                if(text.indexOf(turnplate.restaraunts[8])>=0){
                    var img= document.getElementById("diy2-img");
                    img.onload=function(){
                        ctx.drawImage(img,-35,20);
                    };
                    /*  ctx.translate(5,10);*/
                    ctx.drawImage(img,-20,20,40,40);
                };
                if(text.indexOf(turnplate.restaraunts[9])>=0){
                    var img= document.getElementById("diy1-img");
                    img.onload=function(){
                        ctx.drawImage(img,-15,35);
                    };
                    ctx.drawImage(img,-15,20,35,35);
                };
                if(text.indexOf(turnplate.restaraunts[0])==0){
                    var img= document.getElementById("diy3-img");
                    img.onload=function(){
                        ctx.drawImage(img,-25,20);
                    };
                    ctx.drawImage(img,-32,15,60,50);
                };
                if(text.indexOf(turnplate.restaraunts[2])>=0){
                    var img= document.getElementById("diy9-img");
                    img.onload=function(){
                        /* ctx.drawImage(img,-30,20);*/
                    };
                    ctx.drawImage(img,-15,20,25,70);
                };
                if(text.indexOf(turnplate.restaraunts[3])>=0){
                    var img= document.getElementById("diy6-img");
                    img.onload=function(){
                        ctx.drawImage(img,-35,20);
                    };
                    ctx.drawImage(img,-15,20,35,70);
                };
                if(text.indexOf(turnplate.restaraunts[5])>=0){
                    var img= document.getElementById("diy4-img");
                    img.onload=function(){
                        ctx.drawImage(img,-30,20);
                    };
                    ctx.drawImage(img,-20,20,30,65);
                };

                if(text.indexOf(turnplate.restaraunts[6])>=0){
                    var img= document.getElementById("diy5-img");
                    img.onload=function(){
                        ctx.drawImage(img,-35,20);
                    };
                    ctx.drawImage(img,-30,20,60,60);
                };


                //把当前画布返回（调整）到上一个save()状态之前
                ctx.restore();
                //----绘制奖品结束----
            }
        }
    };

    $(function() {
        $("#startbtn").click(function() {
            count--;
            $('.title>p>b').html(count);
            console.log(this);
            var style=getComputedStyle(this);
            var  height = parseFloat(style.height);
            var  width = parseFloat(style.width);
            console.log(height,width);
            var res = height*1 - (width/2 );
            console.log(height,width,res);
            $(this).css('transform-origin','center '+res+'px');
            lottery();
        });
    });
    var html="";
    console.log(html);
    function lottery() {
        $.ajax({
            type: 'POST',
            url: './zpajax.php',
            dataType: 'json',
            cache: false,
            error: function(msg) {
                console.log(msg);
                alert('Sorry，出错了！');
                return false;
            },
            success: function(json) {
                $("#startbtn").unbind('click').css("cursor", "default");
                var angle = json.angle; //指针角度
                var prize = json.prize; //中奖奖项标题
                $("#startbtn").rotate({
                    duration: 3000,//转动时间 ms
                    angle: 0, //从0度开始
                    animateTo: 1818 + angle,//转动角度
                    easing: $.easing.easeOutSine, //easing扩展动画效果
                    callback: function() {
                        html+=$('.award>p').html(prize);
                        var resulte = confirm('恭喜您中得' + prize + '\n想要继续吗？');
                        if (resulte) { //若是点击确定，继续抽奖
                            count--;
                            $('.title>p>b').html(count);
                            if(count<0){
                                alert('抽奖机会用完了，下次再来吧');
                                $('.title>p>b').html(0);
                                return;
                            }
                            lottery();
                        }
                    }
                });
            }
        });
    }

</script>
