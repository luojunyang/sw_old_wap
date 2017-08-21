<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__) . '/global.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none');
//查询分享数据
//dump($wap_user['uid']);
//$share = D('Yws_share')->where(array('share_from'=>$wap_user['uid']))->select();

//$conut = 0;
//foreach ($share as $val){
//    $count += $val['count'];
//}

// 预览切换
if(!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
    if(isset($_GET['ps']) && $_GET['ps'] == '800') {
        $config = option('config');

        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php?c=goods&a=index&id=' . $product_id . '&is_preview=1';
        echo redirect($url);
        exit;
    }
}
$cachKey = $wap_user['uid'].'_good_ids';
$cacheGoods = S($cachKey);
if(empty($cacheGoods))
{
    $cacheGoods = array($product_id);
    S($cachKey,$cacheGoods);
} else {
    if(!in_array($product_id,$cacheGoods))
    {
        array_push($cacheGoods,$product_id);
        S($cachKey,$cacheGoods);
    }
}
//商品默认展示
$nowProduct = D('Product_test')->where(array('product_id' => $product_id))->find();
//dump($nowProduct);
if(empty($nowProduct)) pigcms_tips('您访问的商品不存在', 'none');

if($nowProduct['image_size'] == '0') {
    $nowProduct['image_size'] = array();
}
else if($nowProduct['image_size']) {
    $nowProduct['image_size'] = unserialize($nowProduct['image_size']);
}
else {
    $nowProduct['image_size'] =
        D('Attachment')->field('`width`,`height`')->where(array('file' => $nowProduct['image']))->find();
    D('Product_test')->where(array('product_id' => $product_id))
        ->data(array('image_size' => serialize($nowProduct['image_size'])))->save();
}
$nowProduct['image'] = getAttachmentUrl($nowProduct['image']);


/**
 * @var $productImgM product_image_model
 */
$productImgM = M('Product_image');
$nowProduct['images'] = $productImgM->getImages($product_id, true);
$nowProduct['images_num'] = count($nowProduct['images']);
if($nowProduct['has_property']) {
    //库存信息
    $skuList =
        D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`')->where(array('product_id' => $product_id,
            'quantity'   => array('!=',
                '0')))
            ->order('`sku_id` ASC')->select();
    //如果有库存信息并且有库存，则查库存关系表
    if(!empty($skuList)) {
        $skuPriceArr = $skuPropertyArr = array();
        foreach ($skuList as $value) {
            $skuPriceArr[] = $value['price'];
            $skuPropertyArr[$value['properties']] = true;
        }
        if(!empty($skuPriceArr)) {
            $minPrice = min($skuPriceArr);
            $maxPrice = max($skuPriceArr);
        }
        else {
            $nowProduct['quantity'] = 0;
        }
        $tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property' => 'ptp',
            'Product_property'    => 'pp'))
            ->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`id` ASC')->select();
        if(!empty($tmpPropertyList)) {
            $tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')
                ->table(array('Product_to_property_value' => 'ptpv', 'Product_property_value' => 'ppv'))
                ->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`id` ASC')
                ->select();
            if(!empty($tmpPropertyValueList)) {
                foreach ($tmpPropertyValueList as $value) {
                    $propertyValueList[$value['pid']][] = array(
                        'vid'   => $value['vid'],
                        'value' => $value['value'],
                    );
                }
                foreach ($tmpPropertyList as $value) {
                    $newPropertyList[] = array(
                        'pid'    => $value['pid'],
                        'name'   => $value['name'],
                        'values' => $propertyValueList[$value['pid']],
                    );
                }
                if(count($newPropertyList) == 1) {
                    foreach ($newPropertyList[0]['values'] as $key => $value) {
                        $tmpKey = $newPropertyList[0]['pid'] . ':' . $value['vid'];
                        if(empty($skuPropertyArr[$tmpKey])) {
                            unset($newPropertyList[0]['values'][$key]);
                        }
                    }
                }
            }
        }
    }
}
else {
    $minPrice = $nowProduct['price'];
    $maxPrice = 0;
}
if($nowProduct['postage_type']) {

    $supplier_id = $nowProduct['store_id'];

    $postage_template = M('Postage_template')->get_tpl($nowProduct['postage_template_id'], $supplier_id);
    if($postage_template['area_list']) {
        foreach ($postage_template['area_list'] as $value) {
            if(!isset($min_postage)) {
                $min_postage = $max_postage = $value[2];
            }
            else if($value[2] < $min_postage) {
                $min_postage = $value[2];
            }
            else if($value[2] > $max_postage) {
                $max_postage = $value[2];
            }
        }
    }
    if($min_postage == $max_postage) {
        $nowProduct['postage'] = $min_postage;
    }
    else {
        $nowProduct['postage_tpl'] = array('min' => $min_postage, 'max' => $max_postage);
    }
}

//当前页面的地址
//$now_url = $config['wap_site_url'] . '/good.php?id=' . $nowProduct['product_id'];
$now_url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/yws_tourgoods.php?id='.$nowProduct['product_id'];

//商品的自定义字段
if($nowProduct['has_custom']) {
    $homeCustomField = M('Custom_field')->getParseFields($store_id, 'good', $nowProduct['product_id']);
}


$good_history = $_COOKIE['good_history'];
if(empty($good_history)) {
    $new_history = true;
}
else {
    $good_history = json_decode($good_history, true);
    if(!is_array($good_history)) {
        $new_history = true;
    }
    else {
        $new_good_history = array();
        foreach ($good_history as &$history_value) {
            if($history_value['id'] != $nowProduct['product_id']) {
                $new_good_history[] = $history_value;
            }
        }
        if(!empty($new_good_history)) {
            array_push($new_good_history,
                array('id'    => $nowProduct['product_id'], 'name' => $nowProduct['name'],
                    'image' => $nowProduct['image'], 'price' => $nowProduct['price'], 'url' => $now_url,
                    'time'  => $_SERVER['REQUEST_TIME']));
        }
        else {
            $new_history = true;
        }
    }
}
if($new_history) {
    $new_good_history[] = array(
        'id'    => $nowProduct['product_id'],
        'name'  => $nowProduct['name'],
        'image' => $nowProduct['image'],
        'price' => $nowProduct['price'],
        'url'   => $now_url,
        'time'  => $_SERVER['REQUEST_TIME']
    );
}
//setcookie('good_history', json_encode($new_good_history), $_SERVER['REQUEST_TIME'] + 86400 * 365, '/');
cookies::put('good_history', json_encode($new_good_history), 365);


// 查看本产品是否参与活动
$reward = '';
if($nowProduct['source_product_id'] == 0) {
    $reward = M('Reward')->getRewardByProduct($nowProduct);
}

$allow_drp = true;
$open_drp = option('config.open_store_drp');
$drp_register_url = './drp_register.php'; // ?id=' . $store_id;

if($nowProduct['is_fx'] && $open_drp && $_SESSION['user']['uid'] != $now_store['uid']) {
    $allow_drp = true;
}
else {
    $allow_drp = false;
}

$exchange = $config['point_exchange'] + 0;
$buyer_ratio = $config['promoter_ratio_1'] + 0;
$nowProduct['rebate'] = round(($nowProduct['price'] * 1.00 - $nowProduct['cost_price'] * 1.00) * $buyer_ratio / 100, 2);
if($config['default_point']) {
    $nowProduct['point'] = round($nowProduct['rebate'] * $exchange, 0);
    $nowProduct['rebate'] = 0.00;
}

$store = D('Store');
$supplierStoreInfo = $store->where(array('uid' => $nowProduct['uid']))->find();

//var_dump($supplierStoreInfo);exit;

//$imUrl = getImUrl($_SESSION['user']['uid'], $store_id);
$share_from = $_GET['share_from'];
if($share_from){
    $_SESSION['share_from']=$share_from;
}

//分享配置 start
/*
$share_conf = array(
    'title'   => $nowProduct['name'], // 分享标题
    'desc'    => $DATA,//分享描述
    'link'    => $_SERVER['HTTP_HOST'].'/wap/yws_tourgoods.php?id='.$nowProduct['product_id'].'&share_from='.$_SESSION['user']['uid'], // 分享链接
    'imgUrl'  => $nowProduct['images'][0]['image'], // 分享图片链接
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);*/
$DATA = $nowProduct['product_id']==13007?'登天安门，长城，游故宫，《颐和园、慈禧水道（乘船自费100元）》，鸟巢外景，水立方外景，（如果政策性关闭毛主席纪念堂则观看外景），人民大会堂外景，人民英雄纪念碑，十三陵，奥运会杂技精彩演出':'登天安门、八达岭长城，游故宫、天坛、鸟巢、水立方，逛王府井大街、颐和园、圆明园，参观老北京胡同、四合院、什刹海、恭王府、清华北大及军事博物馆，观看傅琰东魔术城堡演出。';
$share_conf = array(
    'title'   => $nowProduct['name'], // 分享标题
    'desc'    => $DATA, // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_tourgoods.php?id='.$nowProduct['product_id'].'&share_from='.$_SESSION['user']['uid'], // 分享链接
    'imgUrl'  => $nowProduct['images'][0]['image'], // 分享图片链接
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
logs($share_conf['link'],'url');
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end

include display('yws_tourgoods');

echo ob_get_clean();
