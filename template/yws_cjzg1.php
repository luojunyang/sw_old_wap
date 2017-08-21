<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';




$cats = D('Product_category')->field('cat_name,cat_id')->where(array('cat_fid'=>0,'cat_parent_status'=>1))->select();

$SQL = "select cat_fid , group_concat(cat_id) as str from tp_product_category where cat_fid > 0 group by cat_fid ";
$catidstr = D()->query($SQL);

foreach ($catidstr as $val){
    foreach ($cats as $cat){
        if($val['cat_fid']==$cat['cat_id']){
            $menu[$cat['cat_name']]=$val;
        }
    }
}

$menuearr[0] =array('197',"鞋子箱包");
$menuearr[1] =array('173','179',"服装配饰");
$menuearr[2] =array('464',"美食特产");
$menuearr[3] =array('194',"母婴用品");
$menuearr[4] =array('186',"美妆护理");
$menuearr[5] =array('175',"数码产品");
$menuearr[6] =array('189',"汽车配件");
$menuearr[7] =array('195',"家电生活");
$menuearr[8] =array('196',"家纺家饰");
$menuearr[9] =array('176',"厨具收纳");



foreach ($menuearr as $k=>$v){
    $cat_ids[$k]='';
    foreach ($menu as $s){
        if(in_array($s['cat_fid'],$v)){
            $cat_ids[$k] .= $s['str'].',';
        }
    }
}
//dump($cat_ids);
include display('yws_jczg1');
echo ob_get_clean();