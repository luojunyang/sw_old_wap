<?php if (!defined('TWIKER_PATH')) exit('deny access!'); ?>
    <!DOCTYPE html>
    <html class="no-js admin <?php if ($_GET['ps'] <= 320) {
        echo ' responsive-320';
    } elseif ($_GET['ps'] >= 540) {
        echo ' responsive-540';
    }
    if ($_GET['ps'] > 540) {
        echo ' responsive-800';
    } ?>" lang="zh-CN">
    <head>
        <meta charset="utf-8"/>
        <meta name="keywords" content="<?php echo $config['seo_keywords']; ?>"/>
        <meta name="description" content="<?php echo $config['seo_description']; ?>"/>
        <meta name="HandheldFriendly" content="true"/>
        <meta name="MobileOptimized" content="320"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta http-equiv="cleartype" content="on"/>
        <link rel="icon" href="<?php echo $config['site_url']; ?>/favicon.ico"/>
        <title><?php echo $nowProduct['name']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css?time=<?php echo time() ?>"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/showcase.css"/>
        <?php if ($is_mobile) { ?>
            <script>var is_mobile = true;</script>
        <?php }else{ ?>
            <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/showcase_admin.css"/>
            <script>var is_mobile = false;</script>
        <?php } ?>
        <script type="text/javascript">
            var is_logistics = <?php echo $now_store['open_logistics'] ? 'true' : 'false' ?>;
            var is_selffetch = <?php echo $now_store['buyer_selffetch'] ? 'true' : 'false' ?>;

        </script>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/goods.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/drp_notice.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/coupon.css"/>
<!--        <link rel="stylesheet" href="--><?php //echo TPL_URL ?><!--css/comment.css"/>-->
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/goods.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/yws_lz/yws_tourgoods.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css"/>
        <script>
            var show_flag=true, storeId =<?php echo $now_store['store_id'];?>,yws_create=true , product_id =<?php echo $nowProduct['product_id'];?>, showBuy = false, hasActivity = !!<?php echo intval($nowActivity);?>, activityId =<?php echo intval($nowActivity['id']);?>, activityType =<?php echo intval($nowActivity['type']);?>, activityDiscount =<?php echo floatval($nowActivity['discount']);?>, activityPrice =<?php echo floatval($nowActivity['price']);?>;
        </script>
        <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.min.js"></script>
        <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.waterfall.js"></script>
        <script src="<?php echo $config['oss_url']; ?>/static/js/idangerous.swiper.min.js"></script>
        <script src="<?php echo TPL_URL; ?>js/base.js?time=<?php echo time(); ?>"></script>
        <script src="<?php echo TPL_URL; ?>js/sku.js"></script>
        <script src="<?php echo TPL_URL; ?>js/good.js"></script>
        <script src="<?php echo TPL_URL; ?>js/drp_notice.js"></script>

        <style type="text/css">
            .custom-richtext p {
                margin: 0;
            }
        </style>
    </head>

    <body <?php if ($is_mobile) { ?> class="body-fixed-bottom" <?php } ?>>

    <div class="container1 content">
        <!--轮播图-->
        <div class="custom-image-swiper"
             data-max-height="<?php echo $nowProduct['image_size']['height']; ?>"
             data-max-width="<?php echo $nowProduct['image_size']['width']; ?>">
            <div class="swiper-container" style="height: 350px;">
                <div class="swiper-wrapper">
                    <?php foreach ($nowProduct['images'] as $value) { ?>
                        <div class="swiper-slide" style="height: 350px;">
                            <a class="js-no-follow" href="javascript:;" style="height: 350px;">
                                <img width="100%" src="<?php echo $value['image']; ?>"/></a></div>
                    <?php } ?>
                </div>
            </div>
            <div class="swiper-pagination">
                <?php
                if ($nowProduct['images_num'] > 1) {
                    for ($i = 0; $i < $nowProduct['images_num']; $i++) { ?>
                        <span class="swiper-pagination-switch <?php echo $i == 0 ? 'swiper-active-switch' : ''; ?>"></span>
                        <?php
                    }
                } ?>
            </div>
        </div>
        <!--信息-->
        <div id="info">
            <div class="location">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/location.png" style="height: 30px;" alt=""/>
                <span class="start-local">武汉出发</span>
                <span class="time">
             <b> <?php echo $nowProduct['name']; ?></b>
            </span>
            </div>
            <p>
                <?php echo $nowProduct['product_id']==13007?'登天安门，长城，游故宫，《颐和园、慈禧水道（乘船自费100元）》，鸟巢外景，水立方外景，（如果政策性关闭毛主席纪念堂则观看外景），人民大会堂外景，人民英雄纪念碑，十三陵，奥运会杂技精彩演出':'登天安门、八达岭长城，游故宫、天坛、鸟巢、水立方，逛王府井大街、颐和园、圆明园，参观老北京胡同、四合院、什刹海、恭王府、清华北大及军事博物馆，观看傅琰东魔术城堡演出。'?>
            </p>
            <div class="detail-price" style="overflow: hidden;">
                <div class="now-price">￥<?= $nowProduct['price']?></div>
                <div class="old-price">￥<?= $nowProduct['market_price']?></div>
                <div class="sale-count"><?php echo empty($nowProduct['sales'])?'11':$nowProduct['sales']; ?>笔销量</div>
            </div>

        </div>
        <hr/>
        <!--产品摘要-->
        <div id="pro-intro">
            <h5>产品概要</h5>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon1.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>含四晚住宿</span>
                </dt>
            </dl>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon2.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>含<?php echo $nowProduct['product_id']==13007? '12' : '18'?>个景点</span>
                </dt>
            </dl>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon3.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span><?php echo $nowProduct['product_id']==13007? '空调大巴' : '往返硬卧'?></span>
                </dt>
            </dl>
            <br/>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon5.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>导游陪同</span>
                </dt>
            </dl>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon5.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>景点门票</span>
                </dt>
            </dl>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon6.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>个人险</span>
                </dt>
            </dl>
        </div>
        <hr/>
        <!--图文详情-->
        <div id="pic">
            <div class="title">
                <i>———— &nbsp;&nbsp;</i>
                <span>图文详情</span>
                <i> &nbsp;&nbsp;————</i>
            </div>
            <div>
                <?php if ($nowProduct['info']) { ?>
                    <div class="custom-richtext">
                        <?php echo str_replace('http://www.yun-ws.com','http://www.yunwenshang.com',$nowProduct['info']); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr/>
        <!--评价-->
        <div id="comm">
            <span  class="comm-count">评价（3）</span>
            <span class="good-comm"> <span >好评率 <b>100%</b></span>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/u221.png" alt=""/>
            </span>
        </div>
        <!--会员描述-->
        <div class="vip">
            <div class="vip-info">
                <img style="border-radius: 51px;" width="50" src="http://wx.qlogo.cn/mmopen/ic7vuCEHF9XZs21Miby6Gp4U0sa0lnkZofvAwxKEAYUZ2xTHsIFqe6qwEfchoLeriaibhzj4HguZPiacWjArTjr0TOKVeJKyGpy5q/0" alt=""/>
                <span class="vname">
                    <span class="span1">王启辉</span>
                    <br/>
                    <span class="span2">2017-06-21</span>
                </span>
            <span class="star">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
            </span>
            </div>
            <p>很愉快的一次旅游,值得体验
            </p>
            <div class="comm-pic">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view10.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view6.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view4.png" alt=""/>
            </div>
            <p class="lv-name">
                北京五日游
            </p>
        </div>
        <hr/>
        <div class="vip">
            <div class="vip-info">
                <img style="border-radius: 51px;" width="50" src="http://wx.qlogo.cn/mmhead/SCug0ESSOHicrg5jyiczJOyPY6icH8cqXicPe5f25Lsmc8CeQDtdbk4aFg/0" alt=""/>
                <span class="vname">
                <span class="span1">maybe</span>
                <br/>
                <span class="span2">2017-06-25</span>
            </span>
                <span class="star">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                </span>
            </div>
            <p>不错不错，纯玩，没有任何绑架买卖
            </p>
            <div class="comm-pic">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view1.png" alt="" />
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view7.png" alt="" />
            </div>
            <p class="lv-name">
                北京五日游
            </p>
        </div>
        <hr/>
        <div class="vip">
            <div class="vip-info">
                <img style="border-radius: 51px;" width="50" src="http://wx.qlogo.cn/mmhead/Q3auHgzwzM6zIveGBWUpESOwBqwUlDliamUyBZAZpL2rXv74XBC7baA/0" alt=""/>
                <span class="vname">
                <span class="span1">周婷</span>
                <br/>
                <span class="span2">2017-06-22</span>
            </span>
                <span class="star">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/start.png" alt=""/>
                </span>
            </div>
            <p>美得不行不行的，哈哈。导游挺好，一路欢笑。
            </p>
            <div class="comm-pic">
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view2.png" alt=""/>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/view5.png" alt="" />

            </div>
            <p class="lv-name">
                北京五日游
            </p>
        </div>
        <hr/>
        <div class="load">
            <span id="loadMore">查看全部评价</span>
        </div>
    </div>
    <!--底部导航-->
    <div id="ToolBar">
        <div class="bt" id="share-bt">
            <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/share.png" alt=""/>
            <p >分享</p>
        </div>
        <div class="bt bt1 item_uc" id="BizQQWPA" >
            <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/kefu.png" alt="" />
            <p>客服</p>
        </div>
        <div class="bt" id="my_cart">
            <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/car.png" alt=""/>
            <p>购物车</p>
        </div>
        <div class="addCart js-buy-it">
            立即购买
        </div>
    </div>
    <!--分享弹出框-->
    <div class="share-model">
        <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/zu.png" alt=""/>
    </div>

    <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.event.drag-1.5.min.js"></script>
    <script src="<?php echo $config['oss_url']; ?>/static/js/jquery.touchSlider.js"></script>
    <script src="<?php echo TPL_URL; ?>js/yws_lz/tourgoods_detail.js"></script>

    <?php echo $shareData; ?>
    <script>
        $('#my_cart').click(function () {
            location.href='./cart.php';
        });
        $('#BizQQWPA').click(function(){
            location.href='http://wpa.qq.com/msgrd?v=3&uin=727211510&site=qq&menu=yes';
        });

    </script>
    </body>
    </html>
<?php Analytics($now_store['store_id'], 'goods', $nowProduct['name'], $_GET['id']); ?>