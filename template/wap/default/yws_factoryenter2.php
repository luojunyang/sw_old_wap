<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="zxjBigPower">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>厂家入驻-中国“新零售”领导品牌</title>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/yws_factoryenter2.css">
    <script src="<?php echo TPL_URL; ?>js/yws_lz/lib/js/jquery-3.0.0.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/base.js"></script>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/yws_factoryenter2.js"></script>
</head>
<body>
<div id="alertBox">
    <div id="newzeroselltips" >
        <div id="msg">您上传的图片过大，请重新上传</div>
        <div  id="iknow">知道了</div>
    </div>
</div>
<div class="con">
    <input type="hidden" value="<?php echo $arr?>" id="factoryjson" name="ahha">
    <form action="./yws_factoryenter.php" id="factoryenter" enctype="multipart/form-data" method="post">
        <div class="con-box">
            <input type="hidden" value="<?= $str2?>" name="post">
            <input type="hidden" name="yws_title" value="厂家入驻">
            <h3>提交资料</h3>
            <p>您需提供：<span style="margin-left: -3px">（支持png、gif、jpg且文件小于3M）</span></p>
            <ul id="con-box">
                <?php foreach ($data as $k=>$val):?>
                    <li>
                        <p><?= $k+1;?><?php echo "、".$val['title']?>:&nbsp;&nbsp; <i>*</i></p>
                        <div class="con-box-son clearfix">
                            <div class="img-box"></div>
                            <a href="#">+
                                <input onclick="showFile(this,<?php echo $k?>)" type="file" name="<?php echo $val['nameId']?>" id="<?php echo $val['nameId']?>" accept="image/png,image/gif,image/bmp,image/jpg" />
                            </a>
                            <div class="filebox">
                                <div class="filebox-box"></div>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="next_page">下一步</div>
        </div>
        <div id="dowebok">
            <div class="section section3">
                <div class="showbox">
                    <div class="con_input con-end">
                        <ul>
                            <h6>基本信息</h6>
                            <li>
                                <p><span>所在地区</span>
                                    <input type="text" name="area" id="szdq" >&nbsp;&nbsp;&nbsp; </p>
                            </li>
                            <li>
                                <p><span>联系人</span>
                                    <input type="text" name="linkman" id="lxr" >&nbsp;&nbsp;&nbsp; </p>
                            </li>
                            <li>
                                <p><span>联系电话</span>
                                    <input type="text" name="phone" id="tel" maxlength="11" >&nbsp;&nbsp;&nbsp; </p>
                            </li>
                            <div id="notnull" style="font-size: 13px;color:red;"></div>
                            <div class="prev-page" id="endPage">上一步</div>
                            <input type="submit" class="finish" id="finish" value="提交">
                        </ul>
                    </div>
                </div>
            </div>
    </form>
    <!--<div class="finish" id="finish">完成</div>-->
    <script>
        $(".next_page").click(function(){
            $('.con-end').css('display','block');
            $('.con-box').css('display','none');
        });
        $("#endPage").click(function(){
            $('.con-end').css('display','none');
            $('.con-box').css('display','block');
        });

        var countlength = $('.con-box ul li').length;
        /*
         * 选择照片并显示
         * file：file文件选择，show：展示页
         * */
        //console.log(countlength);
        var picArray =[],nextpageflag=true;str='';
        function showFile(file,pic_url) {
            //console.log(countlength);
            file = $(file)[0];
            show=$('.filebox-box')[pic_url];
            file.onchange = function () {
                var reader = new FileReader();
                //console.log(typeof this.files[0]);
                var file= this.files[0];
                //console.log(file);
                var size=file.size;
                //console.log(size);
                if(size>=3145728){
                    //console.log('图片过大');
                    $('#alertBox').css('display','block');
                    //$('.showbox').css('background-color','#E8E8E8');
                    $('.showbox').css('z-index','999');
                    $('#msg').html('您上传的图片过大，请重新上传');
                    nextpageflag=false;
                    return;
                }
                reader.readAsDataURL(this.files[0]);
                reader.onload = function () {
                    //console.log(reader.result)
                    show.style.background = "url(" + reader.result + ") no-repeat center/contain";
                    picArray[pic_url] = pic_url;
                }
            }
        }
        $('#iknow').click(function(){
            //$('.showbox').css('background-color','rgba(255,255,255,0)');
            nextpageflag=true;
            $('.showbox').css('z-index','999');
            $('#alertBox').css('display','none');
        });
        var flaginput = true;

        //电话号码匹配；
        var flag_phone = false;
        $("#tel").bind('keyup blur',function () {
            //console.log($(this).val());
            //获取值：
            var keyUpval=$(this).val()-0;
            //console.log(keyUpval);
            //匹配是否符合
            var isTel=/^1(3|4|5|7|8)\d{9}$/.test(keyUpval);//console.log(isTel);
            if(!isTel){
                $(this).css({"borderColor":"red"});
                flag_phone = false;
            }else{
                $(this).css({"borderColor":"black"});
                flag_phone = true;
            }
        });
        $('#finish').click(function(){

            var flaginput = true;
            $('input').each(function(){
                if($(this).val()==''){
                    flaginput = false;
                }
            });
            str='';
            for(var i in picArray){
                str += picArray[i];
            }
            if(str.length*1 <= countlength*1-1 || !flaginput){
                nextpageflag=false;
                $('.showbox').css('z-index','999');
                $('#alertBox').css('display','block');
                $('#msg').html('请填写完整');
                return;
            }
            if(!flag_phone){
                nextpageflag=false;
                $('.showbox').css('z-index','999');
                $('#alertBox').css('display','block');
                $('#msg').html('手机号格式错误');
                return;
            }
            $('#finish').val('申请提交中...');
            nextpageflag=true;

        });

        $('#factoryenter').submit(function(){
            if($(this).hasClass('loading')){
                $('.showbox').css('z-index','999');
                $('#alertBox').css('display','block');
                $('#msg').html('申请提交中...');
                return false;
            }
            if(nextpageflag){
                //console('true');
                $('#finish').val('申请提交中...');
                $(this).addClass('loading');
                return true;
            }else{
                return false;
            }
        });
    </script>
</div>
</body>
</html>
<!--arttemplate模板拼接-->


