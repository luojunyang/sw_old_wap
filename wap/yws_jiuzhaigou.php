<?php
/**
 *  新零售
 */
require_once dirname(__FILE__).'/global.php';
//分享配置 start
$share_conf = array(
    'title'   => '祈福九寨沟 — 云温商', // 分享标题
    'desc'    => ' 8月8日21时19分在四川阿坝州九寨沟县(北纬33.20度，东经103.82度)发生7.0级地震，震源深度20千米。截至8月9日8时10分，死亡人数增至12人（新增3人身份暂不明确），受伤175人（重伤28人）；被中断道路301线K79处已抢通便道，K83处仍有落石，暂无法抢通。', // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_jiuzhaigou.php', // 分享链接
    'imgUrl'  => 'http://www.yunwenshang.com/template/wap/default/css/images/yws_lz/jiuzhaigou/banner.png', // 分享图片链接
    'type'    => 'link', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
include display('yws_jiuzhaigou');
echo ob_get_clean();