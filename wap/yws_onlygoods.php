<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__) . '/global.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none');

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
$now_url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/yws_onlygoods.php?id='.$nowProduct['product_id'];

//商品的自定义字段
if($nowProduct['has_custom']) {
    $homeCustomField = M('Custom_field')->getParseFields($store_id, 'good', $nowProduct['product_id']);
}
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


//参看百分比
$order = D('Yws_onlyone')->where(array('goods_id'=>$product_id,'status'=>1))->select();
$sum = count($order);
//dump($sum);
//dump($product_id);
//dump((int)$nowProduct['market_price']);
$pre = round($sum*1 / $nowProduct['market_price']*1,2) * 100;
if($pre>100)$pre=100;
if($pre==100){
    $luckly = false;
    $onlyorder = D('Yws_onlyorder')->where(array('goods_id'=>$product_id))->find();

    if(empty($onlyorder)){
        $length = count($order);
        $rand = mt_rand(0,$length-1);
        $order_id = $order[$rand]['order_id'];
        $linkman = D('Order')->field('address , address_user , address_tel')->where(array('order_id'=>$order_id))->find();
        $data['order_id'] = $order_id;
        $data['uid'] = $order[$rand]['uid'];
        $data['goods_id'] = $product_id;
        $data['address'] = $linkman['address'];
        $data['address_name'] = $linkman['address_user'];
        $data['address_tel'] = $linkman['address_tel'];
        $data['number'] = $order[$rand]['number'];
        $res = D('Yws_onlyorder')->data($data)->add();
        if($data['uid'] == $wap_user['uid']){
            $luckly = true;
        }
        $order_product_ids = D('Order_product')->field('order_id')->where(array('product_id'=>$nowProduct['product_id']))->select();
        foreach ($order_product_ids as $v){
            if($order_id = $v['order_id']){
                continue;
            }
            $order_ids[] = $v['order_id'];
        }
        $red = D('Order')->where(array('order_id'=>array('in',$order_ids),'status'=>2))->data(array('status'=>4))->save();
        $onlyorder['number'] = $data['number'];
    }else{

        if($onlyorder['uid'] == $wap_user['uid']){
            $luckly = true;
        }
    }
}


//分享配置 start
$share_desc = ($product_id==13277 ?'全程升级国五酒店住宿；全程0自费，推一罚十；多个特色餐，赠送泰式按摩、夜秀。 大皇宫 > 玉佛寺 > 畅游湄南河+水上风情 > 阿南达宫 > 清迈小镇 > 银湖葡萄园 > 公主号游船 > 芭提雅红灯去步行街 > 三合一夜秀 > 金沙岛+翡翠岛>富贵黄金屋（或）小火车矿石博物馆等。':'云温商-一元购');
$share_conf = array(
    'title'   => "云温商-".$nowProduct['name'], // 分享标题
    'desc'    => $share_desc, // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_onlygoods.php?id='.$product_id, // 分享链接
    'imgUrl'  => $nowProduct['images'][0]['image'], // 分享图片链接
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
if($nowProduct['type']){
    include display('yws_onlytour');
}else{
    include display('yws_onlygoods');
}


echo ob_get_clean();
