<?php
/**
 *  处理订单
 */
require_once dirname(__FILE__) . '/global.php';

$uid = $wap_user['uid'];
/*dump($_POST);
dump(trim(I('post.type'),','));
dump(strip_tags(I('post.store_name')));
dump(strip_tags(I('post.name')));
dump(strip_tags(I('post.tel')));
dump(I('post.idCard'));
dump(I('post.address'));
dump(I('post.address_detail'));*/


//表单数据
$agent['agent_type'] = trim(I('post.type'),',');
$agent['store_name'] = strip_tags(I('post.store_name'));
$agent['uid'] = $uid;
$agent['name'] =strip_tags(I('post.name'));
$agent['idcard'] = I('post.idCard');
$agent['tel'] = strip_tags(I('post.tel'));
$agent['area'] = I('post.address');
$agent['address_detail'] = strip_tags(I('post.address_detail'));

//生成订单
$order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
$nowOrder['agent_id'] = 91;
$nowOrder['store_id'] = 91;
$nowOrder['order_no'] = $nowOrder['trade_no'] = $order_no;
$nowOrder['uid'] = $uid;
$nowOrder['address'] = json_encode($agent['area'].'_'.$agent['address_detail']);
$nowOrder['address_user'] = $agent['name'];
$nowOrder['address_tel'] = $agent['tel'];
$nowOrder['openStroePay'] = 1;
$nowOrder['sub_total'] = 99;
$nowOrder['total'] = 99;
$nowOrder['status'] = 1;
$nowOrder['pro_num'] = 1;
$nowOrder['profit'] = 99;
$nowOrder['factory'] = 0;
$nowOrder['pro_count'] = '1';
$nowOrder['postage'] = 0;
$nowOrder['type'] = $_POST['type'] ? (int)$_POST['type'] : 0;
$nowOrder['bak'] = '';
$nowOrder['add_time'] = $_SERVER['REQUEST_TIME'];
$nowOrder['pay_money'] = 99;

$db_agent_apply = D('Yws_agent_apply');
$agent_apply = $db_agent_apply->where(array('uid'=>$uid))->find();

//查找是否有店
$database_store = D('Store');
$store = $database_store->where(array('uid' => $uid))->find();

if(!empty($agent_apply)){
    if($agent_apply['status']==1){
        json_return(1004,'您的申请已提交，可在个人中心查看店铺状态');
    }else{
        $nowOrder_old = D('Order')->where(array('order_id'=>$agent_apply['order_id']))->find();
        if(!$nowOrder_old){
            $order_id = D('Order')->data($nowOrder)->add();
            if (empty($order_id)) {
                json_return(1004, '订单产生失败，请重试'); // .$db_order->last_sql
            }

            if (empty($store)) {
                $data = array('uid' => $uid,
                    'name' => $agent['store_name'],
                    'logo' => $wap_user['avatar'],
                    'tel' => $agent['tel'],
                    'date_added' => time(),
                    'drp_supplier_id' => 0,
                    'open_logistics' => 1,
                    'offline_payment' => 0,
                    'open_friend' => 0,
                    'status' => 1
                );
                $store['store_id'] = $database_store->data($data)->add();
                if(!$store['store_id']){json_return(1004, '数据创建失败，请重试');}
                D('User')->where(array('uid'=>$wap_user['uid']))->data(array('stores'=>1))->save();
                logs(var_export($store,true),'Store');
            }
            $update_agent['order_id'] = $order_id;
            $db_agent_apply->where(array('id'=>$agent_apply['id']))->data($update_agent)->save();
        }
        $db_agent_apply->where(array('uid' => $uid))->data($agent)->save();

    }
}else{

    //保存数据
    $agent_id =$db_agent_apply->data($agent)->add();
    if (empty($agent_id)) {
        json_return(1004, '数据保存失败，请重试');
    }

    //dump($nowOrder);exit('haha');
    $order_id = D('Order')->data($nowOrder)->add();
    if (empty($order_id)) {
        json_return(1004, '订单产生失败，请重试'); // .$db_order->last_sql
    }

    if (empty($store)) {
        $data = array('uid' => $uid,
            'name' => $agent['store_name'],
            'logo' => $wap_user['avatar'],
            'tel' => $agent['tel'],
            'date_added' => time(),
            'drp_supplier_id' => 0,
            'open_logistics' => 1,
            'offline_payment' => 0,
            'open_friend' => 0,
            'status' => 1
        );

        $store['store_id'] = $database_store->data($data)->add();

        logs(var_export($store,true),'Store111');

        if(!$store['store_id']){json_return(1004, '数据创建失败:(，请重试');}

        D('User')->where(array('uid'=>$wap_user['uid']))->data(array('stores'=>1))->save();
    }
    $update_agent['order_id'] = $order_id;
    $update_agent['store_id'] = $store['store_id'];
    $db_agent_apply->where(array('id'=>$agent_id))->data($update_agent)->save();

}

$nowOrder['order_no_txt'] = option('config.orderid_prefix') . $nowOrder['order_no'];

$payType="weixin";
$payMethodList = M('Config')->get_pay_method();
import('source.class.pay.Weixin');
$openid = $_SESSION['openid'];
logs($openid . ',' .
    var_export($nowOrder, true) . ',' .
    var_export($payMethodList[$payType]['config'], true) . ',' .
    var_export($wap_user, true), 'INFO');
$payClass = new Weixin($nowOrder, $payMethodList[$payType]['config'], $wap_user['openid'], 'pay');
$payInfo = $payClass->pay();
logs('payInfo:' . json_encode($payInfo), 'INFO');
if ($payInfo['err_code']) {
    //dump($payInfo['err_msg']);
    json_return(1013, $payInfo['err_msg']);
} else {
    json_return(0, json_decode($payInfo['pay_data']));
}
