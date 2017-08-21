<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';


//分享配置 start
$share_conf = array(
    'title'   => option('config.site_name'), // 分享标题
    'desc'    => str_replace(array("\r", "\n"), array('', ''), option('config.seo_description')), // 分享描述
    'link'    => getTwikerUrl($now_store['uid']), // 分享链接
    'imgUrl'  => option('config.site_logo'), // 分享图片
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end

/*$cats = D('Product_category')->field('cat_name,cat_id')->where(array('cat_fid'=>0,'cat_parent_status'=>1))->select();

$SQL = "select cat_fid , group_concat(cat_id) as str from tp_product_category where cat_fid > 0 group by cat_fid ";
$catidstr = D()->query($SQL);

foreach ($catidstr as $val){
    foreach ($cats as $cat){
        if($val['cat_fid']==$cat['cat_id']){
            $menu[$cat['cat_name']]=$val;
        }
    }
}*/

$menuearr[0] =array('464',"美食特产");
$menuearr[1] =array('173,179',"服装配饰");
$menuearr[2] =array('197',"办公用品");
$menuearr[3] =array('194',"母婴用品");
$menuearr[4] =array('186',"美妆护理");
$menuearr[5] =array('175',"数码产品");
$menuearr[6] =array('195',"家具家电");
$menuearr[7] =array('196',"家纺家饰");
$menuearr[8] =array('176',"日用百货");




/*foreach ($menuearr as $k=>$v){
    $cat_ids[$k]='';
    foreach ($menu as $s){
        if(in_array($s['cat_fid'],$v)){
            $cat_ids[$k] .= $s['str'].',';
        }
    }
}*/
//dump($cat_ids);
include display('yws_jczg1');
echo ob_get_clean();