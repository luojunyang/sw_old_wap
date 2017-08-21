<?php
/**
 *  任我行活动
 */

define('TWIKER_PATH', dirname(__FILE__) . '/../');
define('GROUP_NAME', 'wap');
define('IS_SUB_DIR', true);
require_once TWIKER_PATH . 'source/init.php';

/*是否移动端*/
$is_mobile = is_mobile();
/*是否微信端*/
$is_weixin = is_weixin();

if($is_mobile && $is_weixin){
    require_once dirname(__FILE__) . '/global.php';
    $uid = $_SESSION['user']['uid'];

}else{
    $uid = '';
    $shareData='';
}




$share_from = $_GET['share_from'];

//分享配置 start
$share_conf = array(
    'title'   => '云温商-任我行【帝都爆款】5日游', // 分享标题
    'desc'    => '【帝都爆款】北京品质双卧纯玩5日游;【帝都爆款】北京5日4晚跟团游', // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_tour.php?share_from='.$_SESSION['user']['uid'], // 分享链接
    'imgUrl'  => 'http://www.yunwenshang.com/template/wap/default/css/images/shareios.jpg', // 分享图片链接
    'type'    => 'link', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
logs($share_conf['imgUrl'],'img');
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
//dump($shareData);

if($share_from){
    $_SESSION['share_from']=$share_from;
}
include display('yws_tour');

echo ob_get_clean();