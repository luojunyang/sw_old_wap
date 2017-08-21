<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';

$cat_fid = I('get.cat_fid');

//dump($cat_fid);
$storesid = D();
   //$sql = "select s.store_id as s_sid,p.store_id p_sid, s.name,s.date_added,s.logo,s.approve from tp_product p left join tp_store s on p.store_id=s.store_id where s.approve=1";
    $sql = "select *,count(*) num from (select s.sale_category_id, s.store_id as s_sid,p.store_id p_sid, s.name,s.date_added,s.logo,s.approve from tp_product_test p left join tp_store s on p.store_id=s.store_id where s.approve=1 ) as tmp group by p_sid order by num desc";
    //$sql = "select sale_category_id, store_id name,date_added,logo,approve from tp_store where approve=1";
    $storess = $storesid->query($sql);

//dump($storess);exit;

    foreach ($storess as $v){
        if(strpos($v['sale_category_id'],$cat_fid) !== false ){
            $news[]=$v;
        }
    }
//dump($news);
if($news){
    foreach ($news as $val){
        if(strpos($val['logo'],"yes_")!==false){
            $logo[]=$val;
        }else{
            $s[]=$val;
        }
    }
    if($logo && $s){
        $stores = array_merge($logo,$s);
    }else{
        $stores = empty($logo)?$s:$logo;
    }

}

    include display('yws_tofactory');
    echo ob_get_clean();



