<?php if (!defined('TWIKER_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>祈福九寨沟 — 云温商</title>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/jiuzhaigou/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/jiuzhaigou/index.css"/>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/lib/js/jquery-3.0.0.min.js"></script>
</head>
<body>
<img src="<?php echo TPL_URL; ?>css/images/yws_lz/jiuzhaigou/banner.png" alt="" class="banner"/>
<div class="news">
    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/jiuzhaigou/news1.png" alt=""/>
    <div class="zzc">
        <p>
            8月8日21时19分在四川阿坝州九寨沟县(北纬33.20度，东经103.82度)发生7.0级地震，震源深度20千米。
        </p>
        <p>
            截至8月9日8时10分，死亡人数增至12人（新增3人身份暂不明确），受伤175人（重伤28人）；被中断道路301线K79处已抢通便道，K83处仍有落石，暂无法抢通。
        </p>
    </div>
</div>
<div class="foot">
    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/jiuzhaigou/foot.png" alt="" class="xin"/>
    <button class="button" type="button">我要救助</button>
</div>
<img src="<?php echo TPL_URL; ?>css/images/yws_lz/jiuzhaigou/erweima_03.png" alt="" class="erweima"/>
<?= $shareData?>
<script>
    $('.button').click(function () {
        window.location.href = './yws_onlyOne.php';
    });
</script>
</body>
</html>
