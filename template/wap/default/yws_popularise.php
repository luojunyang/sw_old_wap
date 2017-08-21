<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>微推广 — <?= $nowStore['name']?></title>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/popularize.css"/>
    <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.min.js"></script>
    <script src="<?php echo TPL_URL; ?>css/yws_lz/agent/font/iconfont.js"></script>
    <script>
        var store_id=<?= $nowStore['store_id']?>;
    </script>
</head>
<body>
<div class="main">
    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/agent-bg.png" alt=""/>
    <div class="person-info">
        <div>
            <img style="border-radius: 100px;" src="<?= $wap_user['avatar']?>" alt=""/>
        </div>
        <div class="info1">
            <p>
                <?php //dump($wap_user)?>
                <span style="display: inline-block">我是 </span>
                <span style="display: inline-block"> <?= $wap_user['nickname']?></span>
            </p>
            <p >我为  <span style="display: inline-block; margin-top: 5px;"> 云温商 </span>  代言</p>
        </div>
    </div>
    <div class="pic">
        <p>云温商新零售微商代理正式开启</p>
        <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/jinxu.png" alt="" class="img1"/>
        <br/>
        <i>代理 百万温商 产品</i>
        <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/images/avatar.jpg" alt="" class="img2"/>
        <p>长按上方二维码关注</p>
    </div>
</div>
<div class="toolbar">
    <div class="tu1">
        <svg class="icon" aria-hidden="true">
            <use xlink:href="#icon-zhuye"></use>
        </svg>
        <p >微主页</p>
    </div>
    <div class="tu2">
        <svg class="icon active" aria-hidden="true">
            <use xlink:href="#icon-feiji"></use>
        </svg>
        <p class="active">微推广</p>
    </div>
    <div class="tu3">
        <svg class="icon" aria-hidden="true">
            <use xlink:href="#icon-wode13"></use>
        </svg>
        <p>我的</p>
    </div>
</div>

<script src="<?php echo TPL_URL; ?>js/yws_lz/agent/homepage.js"></script>
<?= $shareData?>
</body>
</html>