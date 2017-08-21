<?php
/**
 *  处理订单
 */
require_once dirname(__FILE__) . '/global.php';

$uid = $wap_user['uid'];
$store_id = $_GET['store_id'];
$comment_limit = 4;
$nowStore = D('Store')->where(array('store_id'=>$store_id))->find();

if(empty($nowStore)) pigcms_tips('您的店铺不存在', 'none');


//分享配置 start
$share_conf = array(
    'title'   => $nowStore['name']."——云温商”新零售“领导品牌", // 分享标题
    'desc'    => $wap_user['nickname']."：我在 云温商 开了一家店铺，快来凑个热闹吧！", // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_store_home.php?store_id='.$nowStore['store_id'], // 分享链接
    'imgUrl'  => $wap_user['avatar'], // 分享图片链接
    'type'    => 'link', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
$agent_apply = D('Yws_agent_apply')->where(array('store_id'=>$store_id))->find();
//dump($agent_apply);
//dump($nowStore);
//数据整合
if(empty($agent_apply)){
    $category= D('Product_category')->field('`cat_name`,`cat_id`')->where(array('cat_fid'=>0,'cat_status'=>1))->order('`cat_sort` asc')->select();
}else{
    $agent_type = explode(',',$agent_apply['agent_type']);
    $category = D('Product_category')->field('`cat_name`,`cat_id`')->where(array('cat_id'=>array('in',$agent_type),'cat_status'=>1))->order('`cat_sort` asc')->select();
    //dump($category);
}


//经过申请流程
$apply = true;
if(count($category)>3){
    $apply = false;
    $i = 0;
    foreach ($category as $item){
        if($item['cat_id'] == 465){
            $i = 0;
            continue;
        }
        $limit = 4;
        if($i==0){
            $limit = 10;
        }
        $goods[$i]['cat_name'] = $item['cat_name'];
        $goods[$i]['cat_id'] = $item['cat_id'];
        $goods[$i]['list'] = D('Product_test')->where(array('category_fid'=>$item['cat_id'],'status'=>1))->order('`product_id` desc')->limit($limit)->select();


        $sql = "select GROUP_CONCAT(`cat_id`) as cat_ids from tp_product_category where cat_fid={$item['cat_id']}";

        $cat_ids = D('')->query($sql);
        $goods[$i]['cat_ids'] = $cat_ids[0]['cat_ids'];
        $newProductIds[] = $item['cat_id'];
        $i++;
    }
}else{
    foreach ($category as $k=>$item){
        $limit = 4;
        if($k==0){
            $limit = 10;
        }
        $goods[$k]['cat_name'] = $item['cat_name'];
        $goods[$k]['cat_id'] = $item['cat_id'];
        $goods[$k]['list'] = D('Product_test')->where(array('category_fid'=>$item['cat_id'],'status'=>1))->order('`product_id` desc')->limit($limit)->select();

        $sql = "select GROUP_CONCAT(`cat_id`) as cat_ids from tp_product_category where cat_fid={$item['cat_id']} ";
        $cat_ids = D('')->query($sql);
        $goods[$k]['cat_ids'] = $cat_ids[0]['cat_ids'];
        $newProductIds[] = $item['cat_id'];
    }
}
//新品
$newGoods = D('Product_test')->where(array('category_fid'=>array('in',$newProductIds)))->order('`product_id` desc')->limit($comment_limit)->select();

$lunbo =array(
    array('img'=>"http://www.yunwenshang.com/template/wap/default/css/images/yws_lz/onlyone/banner_02.png",'url'=>'./yws_onlyOne.php'),
    array('img'=> "http://www.yunwenshang.com/template/wap/default/css/images/yws_lz/tour/images/banner123.png",'url'=>'./yws_tour.php')
);

//dump($goods);
//dump($newGoods);
//dump($newProductIds);


include display('yws_store_home');

echo ob_get_clean();