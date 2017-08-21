<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="zxjBigPower">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>厂家直供-中国“新零售”领导品牌</title>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/yws_cjzg.css">
    <script src="<?php echo TPL_URL; ?>js/yws_lz/lib/js/jquery-3.0.0.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/base.js"></script>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/yws_cjzg.js"></script>
</head>
<body>

<div class="con">
    <div class="con-box clearfix">
        <ul id="conBox">
            <?php foreach ($menuearr as $v):?>
                <li><a href="./yws_tofactory.php?cat_fid=<?php echo $v[0]?>"><span><?= $v[1]?></span></a></li>
            <?php endforeach;?>

            <!--<li><a href="#"><span>服装配饰</span></a></li>
            <li><a href="#"><span>美食特产</span></a></li>
            <li><a href="#"><span>母婴用品</span></a></li>
            <li><a href="#"><span>美妆护理</span></a></li>
            <li><a href="#"><span>数码产品</span></a></li>
            <li><a href="#"><span>汽车配件</span></a></li>
            <li><a href="#"><span>家电生活</span></a></li>
            <li><a href="#"><span>家纺家饰</span></a></li>
            <li><a href="#"><span>厨具收纳</span></a></li>-->
        </ul>
        <div class="logo"></div>
    </div>
</div>
</body>
</html>