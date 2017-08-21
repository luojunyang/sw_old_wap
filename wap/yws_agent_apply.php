<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';

//分享配置 start
$share_conf = array(
    'title'   => '微商代理申请 — 云温商“新零售”', // 分享标题
    'desc'    => '欢迎加入我们               ——云温商', // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_agent_apply.php', // 分享链接
    'imgUrl'  => 'http://www.yunwenshang.com/template/wap/default/css/images/yws_lz/agent/join_us.jpg', // 分享图片链接
    'type'    => 'link', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSginAndlocation($share_conf);
//分享配置 end

$agent_data = D('Yws_agent_apply')->where(array('uid'=>$wap_user['uid']))->find();
include display('yws_agent_apply');
echo ob_get_clean();