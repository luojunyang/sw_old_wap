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
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/showcase.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css?time=<?php echo time() ?>"/>

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

    <div class="content">
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
                全程升级国五酒店住宿；全程0自费，推一罚十；多个特色餐，赠送泰式按摩、夜秀。 大皇宫 > 玉佛寺 > 畅游湄南河+水上风情 > 阿南达宫 > 清迈小镇 > 银湖葡萄园 > 公主号游船 > 芭提雅红灯去步行街 > 三合一夜秀 > 金沙岛+翡翠岛>富贵黄金屋（或）小火车矿石博物馆等。
            </p>
            <div class="detail-price" style="overflow: hidden;">
                <div class="now-price">￥<?= $nowProduct['price']?></div>
<!--                <div class="old-price">￥--><?//= $nowProduct['market_price']?><!--</div>-->
                <div class="sale-count"><?= empty($sum)?0:$sum?>笔销量</div>
            </div>
            <div class="jindu" style="padding: 10px">
                <?php if($pre==100):?>
                    <div>开奖号码：<span style="color: red"><?= $onlyorder['number']?></span></div>
                    <?php if($luckly):?>
                        <div style="margin-top: 5px;text-align: center;"><span style="color: red">恭喜您，中奖了。</span></div>
                    <?php else:?>
                        <div style="margin-top: 5px;text-align: center;"><span style="color: #ddd">抱歉，您的幸运值还差一丢丢。</span></div>
                    <?php endif;?>
                <?php else: ?>
                    <div class="out" style="float: left; width: 60%;height: 20px;line-height: 20px;border-radius: 20px;background-color: #FCD6D1;">
                        <div class="inner" style="white-space :  nowrap ;width: <?= empty($pre)?0:$pre.'%'?>;border-radius: 35px;height: <?= empty($pre)?0:20?>px;line-height: 20px;background-color: #FF842E;padding-left:10px;color: white;font-size: 14px;">
                            已有<?php echo empty($sum) ? 0 : $sum?>人抢购(<?= $pre?>%)
                        </div>
                    </div>
                    <div class="nowqianggou" style="float: right;width=90%;height: 40px;color:red;">
                        <?php echo empty($sum) ? 0 : $sum?>/<span style="color: #b1b1b1;"><?= (int)$nowProduct['market_price']?></span>
                    </div>
                    <div class="clear" style="clear: both;"></div>
                <?php endif;?>
                <div class="clear" style="clear: both;"></div>
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
                    <span>含6晚住宿</span>
                </dt>
            </dl>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon2.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>含15个景点</span>
                </dt>
            </dl>
            <dl style="display: inline-block">
                <dd style="display: inline-block">
                    <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/icon3.png" alt=""/>
                </dd>
                <dt style="display: inline-block">
                    <span>往返飞机</span>
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
            <span  class="comm-count">评价（0）</span>
            <span class="good-comm"> <span >好评率 <b>100%</b></span>
                <img src="<?php echo TPL_URL; ?>css/images/yws_lz/tour/u221.png" alt=""/>
            </span>
        </div>
        <!--会员描述-->
        <div data-product-id="<?php echo $nowProduct['product_id']; ?>" class="section_body info_detail">
            <div>
                <!--<div id="div_nav_fixed">
                    <div class="div_nav" id="div_nav">
                        <ul class="box">
                            <li><a class="xuanxiangka">评价</a></li>
                        </ul>
                    </div>
                </div>-->
                <div class="div_sections" id="div_sections">
                    <section class="section_section section_detail on">
                        <section id="info_detail_2_section">

                        </section>
                    </section>
                    <section class="section_comments section_section" data-type="default">
                        <!--<div>
                            <div class="tabber tabber_menu tabber-ios clearfix js-comment-tab">
                                <a class="active" style="border-right: 1px solid #fe5842" data-tab="0">好评</a>
                                <a style="border-right: 1px solid #fe5842" data-tab="1">中评</a>
                                <a style="width: 34%;" data-tab="2">差评</a>
                            </div>
                        </div>-->
                        <div id="list_comments">
                            <ul class="list_comments on" id="list_comments_0" data-page="1" data-type="default"
                                next="true">
                            </ul>
                            <ul class="list_comments" id="list_comments_1" data-page="1" data-type="default"
                                next="true">
                            </ul>
                            <ul class="list_comments" id="list_comments_2" data-page="1" data-type="default"
                                next="true">
                                <div class="s_empty" id="noMoreTips">已无更多评价！</div>
                            </ul>
                            <div class="wx_loading0" style="display:none;"><i class="wx_loading_icon"></i></div>
                            <div class="wx_loading1" style="display:none;"><i class="wx_loading_icon"></i></div>
                            <div class="wx_loading2" style="display:none;"><i class="wx_loading_icon"></i></div>
                            <div class="empty-list" style="margin-top:40px;display: none">
                                <div><span class="font-size-16 c-black">神马，还没有评价？</span></div>
                                <div><span class="font-size-12">怎么能忍？</span></div>
                            </div>
                            <div class="s_empty" id="noMoreTips">已无更多评价！</div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <hr/>
        <div class="load">
            <span class="xuanxiangka"></span>
            <span id="loadMore" class="xuanxiangka">查看全部评价</span>
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
        <?php if($pre==100):?>
            <div class="addCart" style="background-color: #d1d1d1">
                已开奖
            </div>
        <?php else: ?>
            <div class="addCart js-buy-it">
                立即购买
            </div>
        <?php endif;?>
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