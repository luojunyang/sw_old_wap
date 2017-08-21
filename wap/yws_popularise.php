<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';
$store_id = $_GET['store_id'];

$nowStore = D('Store')->where(array('store_id'=>$store_id))->find();

if(empty($nowStore)) pigcms_tips('您的店铺不存在', 'none');

$store_id = $nowStore['store_id'];

$wap_user = D('User')->where(array('uid'=>$nowStore['uid']))->find();
//分享配置 start
$share_conf = array(
    'title'   => $nowStore['name']."——云温商”新零售“领导品牌", // 分享标题
    'desc'    => $wap_user['nickname']."：我在 云温商 开了一家店铺，快来凑个热闹吧！", // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_popularise.php?store_id='.$nowStore['store_id'], // 分享链接
    'imgUrl'  => $wap_user['avatar'], // 分享图片链接
    'type'    => 'link', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
include display('yws_popularise');
echo ob_get_clean();