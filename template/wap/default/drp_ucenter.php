<?php if (!defined('TWIKER_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title><?php echo $now_store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_dis.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/homepage.css?time=<?= time()?>"/>
    <style type="text/css">
        .header-r .try-tip {
            width: 100px;
        }
    </style>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.reveal.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_func.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
    <script>
        var store_id = "<?= $now_store['store_id']?>";
        //alert(store_id);
    </script>
</head>

<body class="body-gray">
<!--<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small"><a class="menu-icon" href="./"><span></span></a></section>
        <section class="middle tab-bar-section">
            <h1 class="title">我的店铺</h1>
        </section>
    </nav>
</div>-->
<div class="panel memberhead" style="margin-top: 0px;">
    <div class="header-l"><i class="icon-level-dis" style="background: url('http://www.yunwenshang.cn/home/img/yws-jmdl/p2-1.png') no-repeat 0 0">
            <img src="http://www.yunwenshang.cn/home/img/yws-jmdl/p2-1.png" alt="">
        </i></div>
    <div class="header-r"> <!--<a href="./drp_store.php?a=account">--><span class="name"><?php echo $now_store['name']; ?></span>
        <br/>
        <!--<i class="try-tip"><?php
        if ($now_store['drp_approve']) {
            echo '分销商';
        } else {
            echo '待审核分销商';
        }
        if ($now_store['agent_approve']) {
            echo '、代理商';
        } ?></i>
		<i class="arrow"></i>--> </a> </div>
</div>
<div class="row count">
    <div class="small-4 large-4 columns mid">
        <a href="./drp_store.php?a=sales" class="count-a">
            <p class="count-dis-mony"><?php printf('%.2f', $now_store['sales']); ?></p>
            <span class="count-title">销售总额(元)</span></a></div>
    <div class="small-4 large-4 columns mid">
        <a href="./balance.php?a=index" class="count-a">
            <p class="count-dis-mony"><?php printf('%.2f', $wap_user['balance']); ?></p>
            <span class="count-title">账户余额(元)</span></a></div>
    <div class="small-4 large-4 columns mid">
        <a href="./balance.php?a=index" class="count-a">
            <p class="count-dis-mony"><?php printf('%.2f', $wap_user['consumer']); ?></p>
            <span class="count-title">消费钱包(元)</span></a></div>
</div>
<div class="menu-list">
    <ul>
        <li style="width: 33%;">
            <a href="./drp_store.php?a=edit">
                <img src="<?php echo TPL_URL; ?>images/tb/dpgl.png" alt="">
                <p>店铺信息</p>
            </a>
        </li>
        <li style="width: 33%;">
            <a href="./balance.php?a=recharge">
                <img src="<?php echo TPL_URL; ?>images/tb/cz.png" alt="">
                <p>账户充值</p>
            </a>
        </li>
        <li style="width: 33%;">
            <a href="./balance.php?a=withdrawal">
                <img src="<?php echo TPL_URL; ?>images/tb/wdgz.png" alt="">
                <p>佣金提现</p>
            </a>
        </li>
        <!--<li>
            <a href="./qrcode.php">
                <img src="<?php /*echo TPL_URL; */?>images/tb/ewm.png" alt="">
                <p>店铺二维码</p>
            </a>
        </li>-->
    </ul>
</div>
<!--<div class="panel member-nav">
	<ul class="side-nav">
		<li class="last"><a href="./drp_ucenter.php?a=profile"> <i class="icon-personal"></i> <span class="text">我的资料</span> <span id="personStatus" class=""></span> <i class="arrow"></i> </a> </li>
	</ul>
</div>-->
<div class="panel member-nav">
    <ul class="side-nav">
        <li><a href="./drp_team.php"><i class="icon-lowLevel"></i><span class="text">我的团队</span><i class="arrow"></i></a>
        <li><a href="./drp_order.php?a=index"><i class="icon-disorder"></i><span class="text">店铺订单</span><i class="arrow"></i></a></li>
        <li><a href="./balance.php?a=statistics"><i class="icon-commission"></i><span class="text">我的佣金</span><i class="arrow"></i></a></li>
<!--        <li><a href="drp_products.php"><i class="icon-myorder"></i><span class="text">商品列表</span><i class="arrow"></i></a></li>-->
<!--        <li style="height: 5px;background: #eee;"></li>-->
<!--        <li><a href="app_z.php"><i class="icon-card"></i><span class="text">云温商众筹</span><i class="arrow"></i></a></li>-->
<!--        <li class="last"><a href="app_z_my.php"><i class="icon-shop"></i><span class="text">我的众筹</span><i class="arrow"></i></a></li>-->
    </ul>
</div>
<?php
if ($now_store['agent_id']) {
    /*
        <div class="panel member-nav">
        <ul class="side-nav">
            <li id="brokerage" class="last"><a href="./agent.php"><i class="icon-client"></i><span
                        class="text">代理中心</span><i class="arrow"></i></a></li>
        </ul>
    </div>
    */
}
//include display('drp_footer');


echo $shareData;
?>
<script src="<?php echo TPL_URL; ?>css/yws_lz/agent/font/iconfont.js"></script>
<!--底部导航-->
<div class="toolbar">
    <div class="tu1">
        <svg class="icon " aria-hidden="true">
            <use xlink:href="#icon-zhuye"></use>
        </svg>
        <p >微主页</p>
    </div>
    <div class="tu2">
        <svg class="icon " aria-hidden="true">
            <use xlink:href="#icon-feiji"></use>
        </svg>
        <p >微推广</p>
    </div>
    <div class="tu3">
        <svg class="icon active" aria-hidden="true">
            <use xlink:href="#icon-wode13"></use>
        </svg>
        <p class="active">我的</p>
    </div>
</div>
<script src="<?php echo TPL_URL; ?>js/yws_lz/agent/homepage.js"></script>
<script>
    //$(document).foundation().foundation('joyride', 'start');
</script>
</body>
</html>