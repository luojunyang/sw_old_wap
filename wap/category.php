<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__) . '/global.php';
$keyword = $_GET['keyword'];
$storeid = $_GET['storeid'];
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

$supplier_uid = intval($_GET['suid']); //供应商UID
//dump('lzuig-'.$supplier_uid);
//dump();
if (isset($_GET['discount'])) {
    //dump(0);
    $db_banner = M('Adver');
    
    $banner = $db_banner->get_adver_by_key('wap_lottery_top', 0);
    //print_r($banner);
    $footer = $db_banner->get_adver_by_key('wap_lottery_footer', 0);
    //print_r($footer);

    // 顶级分类和子分类
    /**
     * @var $product_category_model product_category_model
     */
    $product_category_model = M('Product_category');
    $category = $product_category_model->db->field('cat_id,cat_name')->where(array('cat_fid' => 0,'cat_status'=>1))->order('cat_sort desc')->select();
    include display('index_category_discount');
}
elseif(empty($keyword) && !$supplier_uid){
    //dump('lz_1');
    include display('index_category');
}
else{

	$key_id = intval($_GET['id']);
    //dump($key_id);
	// 顶级分类和子分类
    /**
     * @var $product_category_model product_category_model
     */
	$product_category_model = M('Product_category');
	$category_detail = $product_category_model->getCategory($key_id);
    //dump($category_detail);
	$property_list = array();
	if (!empty($category_detail)) {

		$property_list = M('System_product_property')->getPropertyAndValue($category_detail['filter_attr']);
	}
    //dump($property_list);
    //分享配置 start
    $img = D('Product_category')->field('cat_pic,cat_name')->where(array('cat_id'=>$key_id))->find();
    $omg_url = "http://www.yunwenshang.com/upload/".$img['cat_pic'];
    $share_conf = array(
        'title'   => option('config.site_name'), // 分享标题
        //'desc'    => str_replace(array("\r", "\n"), array('', ''), option('config.seo_description')), // 分享描述
        'desc'    => option('config.site_name')."——".$img['cat_name'], // 分享描述
        'link'    => getTwikerUrl($now_store['uid']), // 分享链接
        'imgUrl'  => $omg_url, // 分享图片
        'type'    => '', // 分享类型,music、video或link，不填默认为link
        'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
    );
    import('WechatShare');
    $share = new WechatShare();
    $shareData = $share->getSgin($share_conf);
//分享配置 end

	include display('index_category_detail');
}
echo ob_get_clean();
