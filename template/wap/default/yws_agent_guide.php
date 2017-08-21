<?php if (!defined('TWIKER_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>微商代理申请 — 云温商“新零售”</title>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/index.css"/>
</head>
<body>
<div id="main">
    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/bg.png" alt=""/>
    <div class="content">
        <h3>恭喜您！</h3>
        <p>成为第
            <span><?= $store_count?></span>
            位成员</p>
        <p>欢迎加入云温商·微代理创业大家庭</p>
    </div>
    <a href="./yws_agent_apply.php">
        <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/agent-travel.png" alt=""/>
    </a>
</div>
<script src="<?php echo TPL_URL; ?>js/yws_lz/lib/js/jquery-3.0.0.min.js"></script>
<script src="<?php echo TPL_URL; ?>js/yws_lz/agent/index.js"></script>
<?= $shareData?>
</body>
</html>