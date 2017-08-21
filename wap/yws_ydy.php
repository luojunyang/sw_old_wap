<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';
/*//$page =     I('get.page');
$page = $_GET['page'];
define('TWIKER_PATH', dirname(__FILE__) . '/../');
define('GROUP_NAME', 'wap');
define('IS_SUB_DIR', true);
//    require_once dirname(__FILE__) . '/global.php';
require_once TWIKER_PATH . 'source/init.php';*/
//分享配置 start
$share_conf = array(
    'title'   => option('config.site_name'), // 分享标题
    'desc'    => str_replace(array("\r", "\n"), array('', ''), option('config.seo_description')), // 分享描述
    'link'    => getTwikerUrl(91), // 分享链接
    'imgUrl'  => "http://www.yunwenshang.cn/home/img/yws-jmdl/p2-1.png", // 分享图片
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
$page = $_GET['page'];
if($page==1){
    include display('yws_ydy1');
}else{
    include display('yws_ydy');
}

echo ob_get_clean();