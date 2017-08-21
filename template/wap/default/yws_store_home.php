<?php if (!defined('TWIKER_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="keywords" content="<?php echo $config['seo_keywords']; ?>" />
    <meta name="description" content="<?php echo $config['seo_description']; ?>" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="cleartype" content="on" />
    <title><?= $nowStore['name']?></title>
<!--    <link rel="stylesheet" href="--><?php //echo TPL_URL; ?><!--css/goods.css"/>-->
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/showcase.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/agent/homepage.css?time=<?= time()?>"/>
    <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.min.js"></script>
<!--    <script src="--><?php //echo $config['oss_url']; ?><!--/static/js/jquery.waterfall.js"></script>-->
    <script src="<?php echo $config['oss_url']; ?>/static/js/idangerous.swiper.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/base.js?time=<?php echo time(); ?>"></script>
<!--    <script src="--><?php //echo TPL_URL; ?><!--js/sku.js"></script>-->
<!--    <script src="--><?php //echo TPL_URL; ?><!--js/good.js"></script>-->
    <script>
        var store_id=<?= $store_id?>;
    </script>
    <script src="<?php echo TPL_URL; ?>js/drp_notice.js"></script>
    <script src="<?php echo TPL_URL; ?>css/yws_lz/agent/font/iconfont.js"></script>
    <style>

    </style>
</head>
<body>
<!--轮播图-->
<!--<div class="WSCSlideWrapper">-->
<!--    <div class="WSCSlide WSCSlideTransition">-->
<!--        <a href="">-->
<!--            <img class="WSCSlide_img" src="--><?php //echo TPL_URL; ?><!--css/images/yws_lz/agent/banner2.png"/>-->
<!--        </a>-->
<!--        <a href="">-->
<!--            <img class="WSCSlide_img" src="--><?php //echo TPL_URL; ?><!--css/images/yws_lz/agent/4.jpg" />-->
<!--        </a>-->
<!--    </div>-->
<!--    <div class="WSCSlideStatus"></div>-->
<!--</div>-->
<div class="content" style="height: 400px;">
    <!--轮播图-->
    <div class="custom-image-swiper"
         data-max-height="400"
         data-max-width="800">
        <div class="swiper-container" style="height: 350px;">
            <div class="swiper-wrapper">
                <?php foreach ($lunbo as $value) { ?>
                    <div class="swiper-slide" style="height: 350px;">
                        <a class="js-no-follow" href="<?= $value['url']?>" style="height: 350px;">
                            <img width="100%" src="<?php echo $value['img']; ?>"/></a></div>
                <?php } ?>
            </div>
        </div>
        <div class="swiper-pagination">
            <?php
            if (count($lunbo) > 1) {
                for ($i = 0; $i < count($lunbo) ; $i++) { ?>
                    <span class="swiper-pagination-switch <?php echo $i == 0 ? 'swiper-active-switch' : ''; ?>"></span>
                    <?php
                }
            } ?>
        </div>
    </div>

<!--新品上市-->
<div class="new">
    <div class="title">
        <i>————&nbsp;</i><span>新品上市</span><i>&nbsp;————</i>
    </div>
    <div class="new-content">
        <?php foreach ($newGoods as $item):?>
            <a href="./good.php?id=<?= $item['product_id']?>&store_id=<?= $nowStore['store_id']?>">
                <dl>
                    <dt>
                        <img height="70" width="100%" src="<?php echo $config['oss_url']; ?>/upload/<?= $item['image']?>" alt=""/>
                    </dt>
                    <dd>
                        <b>￥<?= $item['price']?></b>
                        <br>
                        <span>￥<?= $item['market_price']?></span>
                    </dd>
                </dl>
            </a>
        <?php endforeach;?>
    </div>
</div>
<!--一元抢购-->
<div class="one">
    <a href="./yws_onlyOne.php">
        <div class="one-left">
            <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/yiyuan.png" alt=""/>
            <p>好货大搜罗 优质品牌送到家</p>
            <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/yiyuan1.png" alt=""/>
        </div>
    </a>
    <div class="one-right">
        <div class="one-top">
            <a href="./category.php">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/xianshi.png" alt=""/>
                <b>限时抢购</b>
                <p>人气爆款</p>
                <p>限时特卖</p>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/san.png" alt=""/>
            </a>
        </div>
        <div class="one-bottom">
            <a href="./yws_active.php">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/hot.png" alt=""/>
                <b>爆款特价</b>
                <p>量大质优</p>
                <p>打破底价</p>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/mianmo.png" alt=""/>
            </a>
        </div>
    </div>
</div>
<!--banner-->
<img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/banner.png" alt="" class="banner1"/>
<!--代理品类1-->
<div class="goods_list">
    <?php foreach($goods as $k=>$val):?>
        <?php if($k==0):?>
            <div class="daili1" style="overflow: hidden;">
                <div class="title1">
                    <div class="category_type" style=""><?= $val['cat_name']?></div>
                    <a href="./category2.php?cat_ids=<?= $val['cat_ids']?>&store_id =<?= $nowStore['store_id']?>">更多>></a>
                </div>
                <?php $k=1;?>
                <?php foreach($val['list'] as $key=>$value):?>
                    <?php if($key<4):?>
                        <!--两排商品-->
                        <a href="./good.php?id=<?= $value['product_id']?>&store_id=<?= $nowStore['store_id']?>">
                            <div class="two-left <?php  echo $k%2==1 ? 'two-right-boder': '' ;?>">
                                <b><?= $value['name']?></b>
<!--                                <p>商品二级名称</p>-->
                                <img height="70%" src="<?php echo $config['oss_url']; ?>/upload/<?= $value['image']?>" alt=""/>
                            </div>
                        </a>
                    <?php else:?>
                        <!--三排产品-->
                        <a href="./good.php?id=<?= $value['product_id']?>&store_id=<?= $nowStore['store_id']?>">
                            <div class="three-left <?php  echo $k%3==0 ? 'three-both-boder': '' ;?>">
                                <p><?= $value['name']?></p>
<!--                                <p>商品二级名称</p>-->
                                <img height="68%" src="<?php echo $config['oss_url']; ?>/upload/<?= $value['image']?>" alt=""/>
                            </div>
                        </a>
                    <?php endif;?>
                    <?php $k++;?>
                <?php endforeach;?>
            </div>

        <?php else:?>
            <img src="<?php echo TPL_URL; ?>css/images/yws_lz/agent/banner.png" alt="" class="banner"/>
            <!--代理品类2-->
            <div class="daili2">
                <div class="title1">
                    <div class="category_type" style=""><?= $val['cat_name']?></div>
                    <a href="./category2.php?cat_ids=<?= $val['cat_ids']?>&store_id =<?= $nowStore['store_id']?>">更多>></a>
                </div>
                <?php foreach ($val['list'] as $value):?>
                    <!--两排商品-->
                    <a href="./good.php?id=<?= $value['product_id']?>&store_id=<?= $nowStore['store_id']?>">
                        <div class="fen-left">
                            <img height="165" src="<?php echo $config['oss_url']; ?>/upload/<?= $value['image']?>" alt=""/>
                            <p><?= $value['name']?></p>
                            <b>￥<?= $value['price']?></b>
                            <span>￥<?= $value['market_price']?></span>
                        </div>
                    </a>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<div class="bottom" style="width: 100%;height: 50px;background-color: white"></div>
</div>
<!--底部导航-->
<div class="toolbar">
    <div class="tu1">
        <svg class="icon active" aria-hidden="true">
            <use xlink:href="#icon-zhuye"></use>
        </svg>
        <p class="active" >微主页</p>
    </div>
    <div class="tu2">
        <svg class="icon " aria-hidden="true">
            <use xlink:href="#icon-feiji"></use>
        </svg>
        <p >微推广</p>
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