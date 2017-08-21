<?php
/**
 *  引导页
 */
require_once dirname(__FILE__).'/global.php';

$res = D('User')->where(array('uid'=>"157651"))->setInc('balance',1);
dump($res);
if('35.60' >= 20){
    //$res = D('User')->where(array('uid'=>157651))->setInc('balance',1);
    //dump($res);
    exit();
}

//$query = "select * from tp_order limit 1";
//$data = D('')->query($query);
//dump($data);
$query = "select o.order_id,o.total,o.order_id,op.name,op.order_id,op.product_id from tp_order o left JOIN tp_order_product op on o.order_id=op.order_id where o.status=2 AND op.product_id=13267";
$data = D('')->query($query);
$num='';
foreach ($data as $v){
    $num += $v['total'];
    $order_id[]=$v['order_id'];
}
$str_ids = implode(',',$order_id);
dump($str_ids);
$g_sql = "select * from tp_yws_onlyone where order_id NOT IN ($str_ids) AND goods_id=13267 AND status=1";
$data = D('')->query($g_sql);
dump($data);
echo "苹果：".$num."<br>";
$query = "select o.order_id,o.total,o.order_id,op.name,op.order_id,op.product_id from tp_order o left JOIN tp_order_product op on o.order_id=op.order_id where o.status=2 AND op.product_id=13270";
$data = D('')->query($query);
$num='';
foreach ($data as $v){
    $num += $v['total'];
    $order_id[]=$v['order_id'];
}

$str_ids = implode(',',$order_id);
dump($str_ids);
$g_sql = "select * from tp_yws_onlyone where order_id NOT IN ($str_ids) AND goods_id=13270";
$data = D('')->query($g_sql);
dump($data);

echo "相机：".$num."<br>";
$query = "select o.order_id,o.total,o.order_id,op.name,op.order_id,op.product_id from tp_order o left JOIN tp_order_product op on o.order_id=op.order_id where o.status=2 AND op.product_id=13276";
$g_sql = "select * from tp_yws_onlyone where order_id NOT IN ()";
$data = D('')->query($query);
$num='';
foreach ($data as $v){
    $num += $v['total'];
    $order_id[]=$v['order_id'];
}

echo "电视：".$num."<br>";
$query = "select o.order_id,o.total,o.order_id,op.name,op.order_id,op.product_id from tp_order o left JOIN tp_order_product op on o.order_id=op.order_id where o.status=2 AND op.product_id=13277";
$data = D('')->query($query);
$num='';
foreach ($data as $v){
    $num += $v['total'];
    $order_id[]=$v['order_id'];
}
dump($order_id);
echo "泰国：".$num."<br>";
$query = "select o.order_id,o.total,o.order_id,op.name,op.order_id,op.product_id from tp_order o left JOIN tp_order_product op on o.order_id=op.order_id where o.status=2 AND op.product_id=13278";
$data = D('')->query($query);
$num='';
foreach ($data as $v){
    $num += $v['total'];
    $order_id[]=$v['order_id'];
}
dump($order_id);
echo "电脑：".$num."<br>";
//$query = "select o.order_id,o.total,o.order_id,op.name,op.order_id,op.product_id from tp_order o left JOIN tp_order_product op on o.order_id=op.order_id where o.status=2 AND op.product_id IN (13267,13270,13276,13277,13278)";
$data = D('')->query($query);
$num='';