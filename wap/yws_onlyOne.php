<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';


//分享配置 start
$DATA = "";
$share_conf = array(
    'title'   => "云温商 一元购-中国“新零售”领导品牌", // 分享标题
    'desc'    => "马上开抢吧，狂欢让利", // 分享描述
    'link'    => 'http://www.yunwenshang.com/wap/yws_onlyOne.php', // 分享链接
    'imgUrl'  => 'http://www.yunwenshang.com/template/wap/default/css/images/yws_lz/onlyone/banner_02.png', // 分享图片链接
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
include display('yws_onlyOne');

echo ob_get_clean();