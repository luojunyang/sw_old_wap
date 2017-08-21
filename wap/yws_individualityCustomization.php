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
    'imgUrl'  => option('config.site_logo'), // 分享图片
    'type'    => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end
$cats = D('Product_category')->field('cat_name,cat_id,cat_pic')->where(array('cat_fid'=>0,'cat_parent_status'=>1))->order('cat_sort DESC')->select();



$SQL = "select cat_fid , group_concat(cat_id) as str from tp_product_category where cat_fid > 0 group by cat_fid ";
$catidstr = D()->query($SQL);

foreach ($catidstr as $val){
    foreach ($cats as $cat){
        if($val['cat_fid']==$cat['cat_id']){
            //array_push($val,'http://www.yunwenshang.com/upload/'.$cat['cat_pic']);
            $val['cat_pic'] = 'http://www.yunwenshang.com/upload/'.$cat['cat_pic'];
            $val['cat_name'] = $cat['cat_name'];
            $menu[$cat['cat_name']]=$val;
        }
    }
}
//var_export($menu);
//dump($menu);
//$str = '1母婴用品,2服装配饰,3鞋子箱包,4美食特产,5美妆护理,6数码产品,7汽车配件,8家电生活,9家纺家饰,10厨具收纳';

$menuearr[0] =array('194',"母婴用品");
$menuearr[1] =array('176',"日用百货");
$menuearr[2] =array('197',"办公用品");
$menuearr[3] =array('464',"美食特产");
$menuearr[4] =array('186',"美妆护理");
$menuearr[5] =array('175',"数码产品");
$menuearr[6] =array('189',"汽车配件");
$menuearr[7] =array('195',"家具家电");
$menuearr[8] =array('196',"家纺家饰");
$menuearr[9] =array('173',"服装配饰");


foreach ($menuearr as $k=>$v){
    $cat_ids[$k]='';
    foreach ($menu as $s){
        if(in_array($s['cat_fid'],$v)){
            $cat_ids[$k]['ids'] .= $s['str'].',';
            $cat_ids[$k]['cat_pic'] = $s['cat_pic'];
            $cat_ids[$k]['name'] = $s['cat_name'];
        }
    }
}
//dump($cat_ids);
include display('yws_individualityCustomization');

echo ob_get_clean();
