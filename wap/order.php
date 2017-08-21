<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__) . '/global.php';

if(IS_POST && $_GET['orderid'] && $_POST['confirm']) {
	$order_id = $_GET['orderid'];
	if(!$order_id) {
		echo json_encode(array('status' => false, 'msg' => '参数错误！'));
		exit;
	}

	// 实例化order_model
	$order_model = M('Order');
	$order = $order_model->findOrderById($order_id);

	// 权限判断是否可以确认订单
	if($order['uid'] != $wap_user['uid']) {
		echo json_encode(array('status' => false, 'msg' => '您无权操作！'));
		exit;
	}

	if($order['status'] != 3) {
		echo json_encode(array('status' => false, 'msg' => '此订单不能确认收货！'));
		exit;
	}

	// 确认收货，完成订单
	$order_model->confirmOrder($order);

	//TODO 给用户发通知

	echo json_encode(array('status' => true, 'msg' => '订单已完成！', 'data' => array('nexturl' => 'refresh')));
	exit;
}

// 查看订单详情
if ($_GET['orderid'] * 1 || $_GET['orderno']) {
	// if(empty($wap_user)) redirect('./login.php');

    /**
     * @var $order_m order_model
     */
    $order_m = M('Order');
	if ($_GET['orderid'])
		$nowOrder = $order_m->findOrderById($_GET['orderid']);
	else
		$nowOrder = $order_m->find(I('get.orderno', '', 'trim'));
	if(empty($nowOrder)) pigcms_tips('该订单不存在', 'none');

	//dump($nowOrder);
	if($wap_user['uid'] != $nowOrder['uid'] &&
		$now_store['store_id'] != $nowOrder['store_id'] &&
		$now_store['store_id'] != $nowOrder['agent_id']
	) pigcms_tips('您无权查看访订单！', 'none');
	//print_r($nowOrder);exit;

	//店铺资料
	$this_store = M('Store')->wap_getStore($nowOrder['store_id']);
	//if(empty($this_store)) pigcms_tips('您访问的店铺不存在', 'none');
	// 查看满减送
	$order_ward_list = M('Order_reward')->getByOrderId($nowOrder['order_id']);
	// 使用优惠券
	$order_coupon = M('Order_coupon')->getByOrderId($nowOrder['order_id']);

//===================================================	一元购


    $onlyone = D('Yws_onlyone')->field('number')->where(array('order_id'=>$nowOrder['order_id']))->select();
    if(!empty($onlyone ) && $nowOrder['status']==2){
        $only_res = true;
        foreach ($onlyone as $v){
            $num_code[] = $v['number'];
        }
        $number_str = implode(',<br/>',$num_code);
        $nowOrder['status_txt'] = '待开奖';
        $goods_id = $nowOrder['proList'][0]['product_id'];

        $only_result = D('Yws_onlyorder')->where(array('goods_id'=>$goods_id))->find();

        if(!empty($only_result)){
            $codeNumber = $only_result['number'];
            $my_code = 1;
            if($only_result['uid']==$wap_user['uid'] && $only_result['order_id']==$nowOrder['order_id']){
                $my_code = 2;
                $nowOrder['status_txt'] = '中奖';
            }else{
                $nowOrder['status_txt'] = '未中奖' ;
            }

        }
    }
//===================================================== end
	include display('order_detail');
	echo ob_get_clean();
	exit;
}
// 取消订单
if(!empty($_GET['del_id'])) {
	$condition_order['order_id'] = intval($_GET['del_id']);
	$condition_order['uid'] = $wap_user['uid'];
	$condition_order['status'] = array('<', '2');

	$nowOrder = D('Order')->where($condition_order)->find();
	if(empty($nowOrder))
		json_return(1001, '该订单不存在或已关闭');

	// 更改订单状态
    /**
     * @var $orderM order_model
     */
    $orderM = M('Order');
    $orderM->cancelOrder($nowOrder);

	json_return(0, '关闭订单成功');
}

//	//分享配置 start
//	$share_conf = array(
//		'title'   => $now_store['name'] . '-店铺订单', // 分享标题
//		'desc'    => str_replace(array("\r", "\n"), array('', ''), $now_store['intro']), // 分享描述
//		'link'    => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // 分享链接
//		'imgUrl'  => $now_store['logo'], // 分享图片链接
//		'type'    => '', // 分享类型,music、video或link，不填默认为link
//		'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
//	);
//	import('WechatShare');
//	$share = new WechatShare();
//	$shareData = $share->getSgin($share_conf);
//	//分享配置 end
//
//	// dump($orderList);
//	include display('order');
//}


