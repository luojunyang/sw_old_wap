<?php

/**
 * 商品
 * User: pigcms_21
 * Date: 2015/3/21
 * Time: 17:48
 */
class ProductAction extends BaseAction
{

    public function index()
    {
        //$product = D('ProductView');
        $product = D('ProductTestView');
//        $to_group = M('ProductToGroup');
//        $group = M('ProductGroup');
        $category_db = M('ProductCategory');

        $where = array();
        if ($this->_get('type', 'trim') && $this->_get('keyword', 'trim')) {
            if ($this->_get('type', 'trim') == 'product_id') {
                //$where['Product.product_id'] = $this->_get('keyword', 'trim,intval');
                $where['Product_test.product_id'] = $this->_get('keyword', 'trim,intval');
            } else if ($this->_get('type', 'trim') == 'name') {
                //$where['Product.name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
                $where['Product_test.name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            } else if ($this->_get('type', 'trim') == 'store') {
                $where['Store.name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            } else if ($this->_get('type', 'trim') == 'create_u_name') {
                $where['User.nickname'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            } else if ($this->_get('type', 'trim') == 'create_uid') {
                $where['User.uid'] = $this->_get('keyword', 'trim,intval');
            }
        }

        //var_dump($where);exit;
        $isfx = 0;
        if ($this->_get('isfx', 'trim') && is_numeric($this->_get('isfx', 'trim'))) {
            if ($this->_get('isfx') == '2') {
                //$where['source_product_id'] = array("eq", 0);
                $where['is_fx'] = 0;
                $isfx = 2;
            } else {
                $isfx = $this->_get('isfx');
                $where['is_fx'] = $isfx;
            }
        }

        $ischk = 0;
        if ($this->_get('ischk', 'trim') && is_numeric($this->_get('ischk', 'trim'))) {
            if ($this->_get('ischk') == '2') {
                //$where['source_product_id'] = array("eq", 0);
                $where['status'] = 0;
                $ischk = 2;
            } else {
                $ischk = $this->_get('ischk');
                $where['status'] = $ischk;
            }
        }

        $ishot = 0;
        if ($this->_get('ishot', 'trim') && is_numeric($this->_get('ishot', 'trim'))) {
            if ($this->_get('ishot') == '2') {
                //$where['source_product_id'] = array("eq", 0);
                $where['is_hot'] = 0;
                $ishot = 2;
            } else {
                $ishot = $this->_get('ishot');
                $where['is_hot'] = $ishot;
            }
        }

        $isred = 0;
        if ($this->_get('isred', 'trim') && is_numeric($this->_get('isred', 'trim'))) {
            if ($this->_get('isred') == '2') {
                //$where['source_product_id'] = array("eq", 0);
                $where['is_recommend'] = 0;
                $isred = 2;
            } else {
                $isred = $this->_get('isred');
                $where['is_recommend'] = $isred;
            }
        }

        if ($this->_get('category', 'trim,intval')) {
            //$where['Product.category_id'] = $this->_get('category', 'trim,intval');
            $where['Product_test.category_id'] = $this->_get('category', 'trim,intval');
        }
        if (isset($_GET['allow_discount']) && is_numeric($_GET['allow_discount'])) {
            //$where['Product.allow_discount'] = $this->_get('allow_discount', 'trim,intval');
            $where['Product_test.allow_discount'] = $this->_get('allow_discount', 'trim,intval');
        }
        if (isset($_GET['invoice']) && is_numeric($_GET['invoice'])) {
            //$where['Product.invoice'] = $this->_get('invoice', 'trim,intval');
            $where['Product_test.invoice'] = $this->_get('invoice', 'trim,intval');
        }
        if ($this->_get('group', 'trim,intval')) {
            //$where['_string'] = "Product.product_id IN (SELECT product_id FROM " . C('DB_PREFIX') .
            $where['_string'] = "Product_test.product_id IN (SELECT product_id FROM " . C('DB_PREFIX') .
                "product_to_group WHERE group_id = '" . $this->_get('group', 'trim,intval') . "')";
        }

        //$product_count = $product->where($where)->count('Product.product_id');
        $product_count = $product->where($where)->count('Product_test.product_id');
        import('@.ORG.system_page');
        $page = new Page($product_count, 20);
        $tmp_products =
            //$product->where($where)->order('Product.product_id DESC')->limit($page->firstRow, $page->listRows)
            $product->where($where)->order('Product_test.product_id DESC')->limit($page->firstRow, $page->listRows)
                ->select();
        //print_r($product->getLastSql());exit;

        $products = array();
        foreach ($tmp_products as $tmp_product) {
//            $to_groups = $to_group->field('group_id')->where(array('product_id' => $tmp_product['product_id']))->select();
//            if ($to_groups) {
//                $group_ids = array();
//                foreach ($to_groups as $value) {
//                    $group_ids[] = $value['group_id'];
//                }
//                if ($group_ids) {
//                    $group_ids = implode(',', $group_ids);
//                    $group_names = $group->field('group_name')->where(array('group_id' => array('in', $group_ids)))->select();
//                    $tmp_group_names = array();
//                    if ($group_names) {
//                        foreach ($group_names as $group_name) {
//                            $tmp_group_names[] = $group_name['group_name'];
//                        }
//                    }
//                }
//                if ($tmp_group_names) {
//                    $group_name = implode(',', $tmp_group_names);
//                }
//            } else {
//                $group_name = '';
//            }
            $products[] = array(
                'product_id' => $tmp_product['product_id'],
                'image' => getAttachmentUrl($tmp_product['image']),
                'name' => $tmp_product['name'],
                'category' => $tmp_product['category'],
                //'group' => $group_name,
                'store' => $tmp_product['store'],
                'createUName' => $tmp_product['createUName'],
                'createUid' => $tmp_product['createUid'],
                'price' => $tmp_product['price'],
                'cost_price' => $tmp_product['cost_price'],
                'quantity' => $tmp_product['quantity'],
                'sales' => $tmp_product['sales'],
                'buyer_quota' => $tmp_product['buyer_quota'],
                'allow_discount' => $tmp_product['allow_discount'],
                'invoice' => $tmp_product['invoice'],
                'date_added' => $tmp_product['date_added'],
                'is_hot' => $tmp_product['is_hot'],
                'is_recommend' => $tmp_product['is_recommend'],
                'is_fx' => $tmp_product['is_fx'],
                'is_boom'=>$tmp_product['is_boom'],
                'status' => $tmp_product['status'],
                //'source_product_id' => $tmp_product['source_product_id']
            );
        }
        //dump($products);
        $categories = $category_db->order('cat_path ASC')->select();

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        //$this->assign('groups', $groups);
        $this->assign('categories', $categories);

        $this->assign("isfx", $isfx);
        $this->assign("ishot", $ishot);
        $this->assign("isred", $isred);
        $this->assign("ischk", $ischk);

        $this->display();
    }

//	public function status()
//	{
//		$product = M('Product');
//
//		$product_id = $this->_post('id', 'trim,intval');
//		$status = $this->_post('status', 'trim,intval');
//		if($product->where(array('product_id' => $product_id))->save(array('status' => $status))) {
//			$this->success('操作成功');
//			exit;
//		}
//		else {
//			$this->error('操作失败');
//		}
//	}

    public function set()
    {
        $key = $this->_post('key', 'trim');
        $val = $this->_post('val', 'trim,intval');
        //dump($key);
        //dump($val);
        if (!$key || !$val) {
            $this->error('参数错误！');
        }
        $db = M('Product');
        $status = $db->where(array('product_id' => $val))->getField($key);
        //dump($status);
        if ($status) {
            $db->where(array('product_id' => $val))->save(array($key => 0));
            $this->success('0');
        } else {
            $db->where(array('product_id' => $val))->save(array($key => 1));
            $this->success('1');
        }
    }

    public function sets()
    {
        $ids = I('post.ids', '', 'trim');
        $type = I('post.type', '', 'trim');
        $val = I('post.val', 0, 'trim,intval');
        if (!$ids || !$type) $this->error('参数错误！');

        $where = array('product_id' => array('in', explode(',', $ids)));
        if (M('Product')->where($where)->save(array($type => $val))) {
            $this->success('操作成功！');
        } else {
            $this->error('操作失败！');
        }
    }

    function dels()
    {
        $ids = I('post.ids', '', 'trim');
        if (!$ids) $this->error('参数错误！');

        $where = array('product_id' => array('in', explode(',', $ids)));
        if (M('Product')->where($where)->delete()) {
            $this->success('操作成功！');
        } else {
            $this->error('操作失败！');
        }
    }

//	public function ishot()
//	{
//		$product = M('Product');
//
//		$product_id = $this->_post('id', 'trim,intval');
//		$is_hot = $this->_post('is_hot', 'trim,intval');
//		if($product->where(array('product_id' => $product_id))->save(array('is_hot' => $is_hot))) {
//			$this->success('操作成功');
//			exit;
//		}
//		else {
//			$this->error('操作失败');
//		}
//	}

    public function category()
    {
        $category_db = M('ProductCategory');
//==========================================================所有推荐分类
        $all_recommend = $category_db->where(array('is_recommend'=>1,array('cat_fid'=>array('gt',0))))->select();

        foreach ($all_recommend as $k=>$val){
            if($val['cat_fid'] == 465 || $val['cat_id']==465){
                $cat_ids[] = $k;
            }
        }
        foreach ($cat_ids as $id){
            unset($all_recommend[$id]);
        }

        $this->assign('all_recommend', $all_recommend);
//=====================end=========================================
        $where = array();
        if ($this->_get('cat_id', 'trim,intval')) {

            $where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR cat_fid = '" .
                $this->_get('cat_id', 'trim,intval') . "'";
        }
        $category_count = $category_db->where($where)->count('cat_id');
        import('@.ORG.system_page');
        $page = new Page($category_count, 30);
        $categories = $category_db->where($where)->order('cat_path ASC')->limit($page->firstRow, $page->listRows)->select();
        if ($this->_get('cat_id', 'trim,intval')==465) {
            $categories = array_merge($categories,$all_recommend);

            $categorie = array_shift($categories);
            foreach($categories as &$items) {
                $sort[] = $items['cat_sort'];
            }
            array_multisort($sort,$categories);
            array_unshift($categories,$categorie);
        }

        //======================================所有分类
        $all_categories = $category_db->order('cat_path ASC')->select();

        $this->assign('all_categories', $all_categories);

        //        // 全部分类
//        $categories = // 'cat_level' => 1,
//            $category->where(array('cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
//        $array = array();
//        $this->categoryTree($categories, 0, '', $array);
//        $this->assign('all_categories', $array);
        //dump($all_categories);
        $this->assign('categories', $categories);
        $this->assign('page', $page->show());
        $this->display();
    }

//    public function categoryTree($data, $parent, $prefix = '', &$return = array())
//    {
//        foreach ($data as $item) {
//            if ($item['cat_fid'] != $parent) continue;
//
//            $item['prefix'] = $prefix;
//            $return[] = $item;
//            $this->categoryTree($data, $item['cat_id'], $prefix . '|——', $return);
//        }
//    }
    /**
     * 获取当前id的子ID
     * @param array $data 原始数组
     * @param int $id 当前id
     * @param int $layer 当前层级
     */
    public function genCate($data, $pid = 0, $level = 0)
    {
        //$l        = str_repeat("    ", $level);
        //$l        = $l.'└';
        static $arrcat    = array();
        $arrcat    = empty($level) ? array() : $arrcat;
        foreach($data as $k => $row)
        {
            /**
             * 如果父ID为当前传入的id
             */
            if($row['cat_fid'] == $pid)
            {
                //如果当前遍历的id不为空
                //$row['name']    = $l.$row['name'];
                $row['level']    = $level;
                $arrcat[]    = $row;
                //var_array($arr);
                $this->genCate($data, $row['cat_id'], $level+1);//递归调用
            }
        }
        return $arrcat;
    }

    public function category_add()
    {
        $category_db = M('ProductCategory');

        if (IS_POST) {
            //pc端小图标ico
            /* 			if ($_FILES['pic']['error'] != 4) {
                            //上传图片
                            $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                            $upload_dir = './upload/category/' . $rand_num . '/';
                            if (!is_dir($upload_dir)) {
                                mkdir($upload_dir, 0777, true);
                            }
                            import('ORG.Net.UploadFile');
                            $upload = new UploadFile();
                            $upload->maxSize = 10 * 1024 * 1024;
                            $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                            $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                            $upload->savePath = $upload_dir;
                            $upload->saveRule = 'uniqid';
                            if ($upload->upload()) {
                                $uploadList = $upload->getUploadFileInfo();

                                $attachment_upload_type = C('config.attachment_upload_type');
                                if ($attachment_upload_type == '1') {
                                    import('upyunUser', './source/class/upload/');
                                    upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
                                }

                                $_POST['cat_pc_pic'] = 'category/' . $rand_num . '/' . $uploadList[0]['savename'];
                            } else {

                                $this->frame_submit_tips(0, $upload->getErrorMsg());
                            }
                        }	 */

            if ($_FILES['pic']['error'] != 4 && $_FILES['pic_pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/category/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';

                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();
                    //var_dump($uploadList);
                    // 上传到又拍云服务器
//                    $attachment_upload_type = C('config.attachment_upload_type');
//                    if ($attachment_upload_type == '1') {
//                        import('upyunUser', './source/class/upload/');
//                        upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
//                    }
                    $_POST['cat_pic'] = 'category/' . $rand_num . '/' . $uploadList[0]['savename'];
                    $_POST['cat_pc_pic'] = 'category/' . $rand_num . '/' . $uploadList[1]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            } else {
                $this->frame_submit_tips(0, '请上传分类图片！');
            }

            $data = array();
            $data['cat_fid'] = $this->_post('parent_id', 'trim,intval');
            $data['cat_name'] = $this->_post('name', 'trim');
            $data['cat_sort'] = $this->_post('order_by', 'trim,intval');
            $data['cat_status'] = $this->_post('status', 'trim,intval');
            $data['is_recommend'] = $this->_post('is_recommend', 'trim,intval');
            $data['cat_desc'] = $this->_post('desc', 'trim');
            if ($_POST['cat_pic']) {
                $data['cat_pic'] = $_POST['cat_pic'];
            }
            if ($_POST['cat_pc_pic']) {
                $data['cat_pc_pic'] = $_POST['cat_pc_pic'];
            }
            //商品属性类别
            $property_str = $this->_post('property', 'trim');
            /*$property_arr = array_unique($property_arr);
            if (is_array($property_arr)) {
                $data['filter_attr'] = implode(',', $property_arr);
            } else {
                if (is_int($property_arr))
                    $data['filter_attr'] = $property_arr;
            }*/
            $data['filter_attr'] = $property_str;
            if (!empty($data['cat_fid'])) {
                $data['cat_level'] = 2;
                $path = $category_db->where(array('cat_id' => $data['cat_fid']))->getField('cat_path');
                $data['cat_path'] = $path;
            } else {
                $data['cat_path'] = 0;
            }

            $data['tag_str'] = join(',', $this->_post('tag', 'trim'));
            if (empty($data['tag_str'])) {
                $data['tag_str'] = '';
            }

            if ($cat_id = $category_db->add($data)) {
                if ($cat_id <= 9) {
                    $str_cat_id = '0' . $cat_id;
                } else {
                    $str_cat_id = $cat_id;
                }
                $path = $data['cat_path'] . ',' . $str_cat_id;
                $data = array('cat_path' => $path, 'cat_level' => count(explode(',', $path)) - 1);
                $category_db->where(array('cat_id' => $cat_id))->save($data);
                $this->frame_submit_tips(1, '添加成功！');
            } else {
                $this->frame_submit_tips(0, '添加失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');

//        // 全部分类
//        $categories = // 'cat_level' => 1,
//            $category->where(array('cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
//        $array = array();
//        $this->categoryTree($categories, 0, '', $array);
//        $this->assign('categories', $array);
        //所有分类
        $categories = $category_db->order('cat_path ASC')->select();
        $this->assign('categories', $categories);

        //获取属性类别
        $property_type = M('SystemPropertyType')->where(array('type_status' => 1))->select();
        $system_tag_list = D('system_tag')->select();

        $system_tag_list_group = array();
        foreach ($system_tag_list as $tmp) {
            $system_tag_list_group[$tmp['tid']][] = $tmp;
        }

        $tag_str = '{';
        foreach ($system_tag_list_group as $key => $system_tag) {
            $tag_str .= $key . ':{';
            foreach ($system_tag as $i => $tmp) {
                if ($i != 0) {
                    $tag_str .= ',';
                }

                $name = str_replace('"', "'", $tmp['name']);
                $tag_str .= $tmp['id'] . ':"' . $name . '"';
            }
            $tag_str .= '},';
        }
        $tag_str .= '}';

        $this->assign('tag_str', $tag_str);
        $this->assign('property_type', $property_type);
        $this->display();
    }

    public function category_edit()
    {
        $category_db = M('ProductCategory');

        if (IS_POST) {
            $cat_id = $this->_post('cat_id', 'trim,intval');
            $now_cat = $category_db->find($cat_id);

//            if ($this->_post('parent_id', 'trim,intval') && $this->_post('property', 'trim') == '') {
//                $this->frame_submit_tips(0, '分类属性不能为空！');
//            }

            if (empty($now_cat['cat_pic']) && $_FILES['pic']['error'] == 4) {
                $this->frame_submit_tips(0, '请上传分类WAP图片！');
            }
            if (empty($now_cat['cat_pc_pic']) && $_FILES['pic_pic']['error'] == 4) {
                $this->frame_submit_tips(0, '请上传分类PC图片！');
            }

            if ($_FILES['pic']['error'] != 4 || $_FILES['pc_pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/category/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();
                    // 上传到又拍云服务器
//                    $attachment_upload_type = C('config.attachment_upload_type');
//                    if ($attachment_upload_type == '1') {
//                        import('upyunUser', './source/class/upload/');
//                        upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
//                    }

                    $j = 0;
                    if ($_FILES['pic']['error'] != 4) {
                        if ($now_cat['cat_pic'] && file_exists('./upload/' . $now_cat['cat_pic'])) {
                            @unlink('./upload/' . $now_cat['cat_pic']);
                        }
                        $_POST['cat_pic'] = 'category/' . $rand_num . '/' . $uploadList[$j]['savename'];
                        $j = 1;
                    }
                    if ($_FILES['pc_pic']['error'] != 4) {
                        if ($now_cat['cat_pc_pic'] && file_exists('./upload/' . $now_cat['cat_pc_pic'])) {
                            @unlink('./upload/' . $now_cat['cat_pc_pic']);
                        }
                        $_POST['cat_pc_pic'] = 'category/' . $rand_num . '/' . $uploadList[$j]['savename'];
                    }
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }

            $data = array();
            $data['cat_fid'] = $this->_post('parent_id', 'trim,intval');
            $data['cat_name'] = $this->_post('name', 'trim');
            $data['cat_sort'] = $this->_post('order_by', 'trim,intval');
            $data['cat_status'] = $this->_post('status', 'trim,intval');
            $data['cat_desc'] = $this->_post('desc', 'trim');

            //商品属性类别
//			$property_arr = $this->_post('property', 'trim');
//			$property_arr = array_unique($property_arr);
//			if (is_array($property_arr)) {
//				$data['filter_attr'] = implode(',', $property_arr);
//			} else {
//				if (is_int($property_arr))
//					$data['filter_attr'] = $property_arr;
//			}
            $data['filter_attr'] = $this->_post('property', 'trim');

            $data['tag_str'] = join(',', $this->_post('tag', 'trim'));
            if (empty($data['tag_str'])) {
                $data['tag_str'] = '';
            }

            if ($_POST['cat_pic']) {
                $data['cat_pic'] = $_POST['cat_pic'];
            }
            if ($_POST['cat_pc_pic']) {
                $data['cat_pc_pic'] = $_POST['cat_pc_pic'];
            }

            if (!empty($data['cat_fid'])) {
                $data['cat_level'] = 2;
                $path = $category_db->where(array('cat_id' => $data['cat_fid']))->getField('cat_path');
                $data['cat_path'] = $path;
            } else {
                $data['cat_level'] = 1;
                $data['cat_path'] = 0;
            }

            if ($category_db->where(array('cat_id' => $cat_id))->save($data)) {
                if ($cat_id <= 9) {
                    $str_cat_id = '0' . $cat_id;
                } else {
                    $str_cat_id = $cat_id;
                }
                $path = $data['cat_path'] . ',' . $str_cat_id;
                $data = array('cat_path' => $path, 'cat_level' => count(explode(',', $path)) - 1);
                $category_db->where(array('cat_id' => $cat_id))->save($data);

//                if ($_POST['cat_pic'] && $now_cat['cat_pic']) {
//                    unlink('./upload/' . $now_cat['cat_pic']);
//
////                    $attachment_upload_type = C('config.attachment_upload_type');
////                    // 删除又拍云服务器
////                    if ($attachment_upload_type == '1') {
////                        import('upyunUser', './source/class/upload/');
////                        upyunUser::delete('/' . $now_cat['cat_pic']);
////                    }
//                }
//                if ($_POST['cat_pc_pic'] && $now_cat['cat_pc_pic']) {
//                    unlink('./upload/' . $now_cat['cat_pc_pic']);
//
////                    $attachment_upload_type = C('config.attachment_upload_type');
////                    // 删除又拍云服务器
////                    if ($attachment_upload_type == '1') {
////                        import('upyunUser', './source/class/upload/');
////                        upyunUser::delete('/' . $now_cat['cat_pc_pic']);
////                    }
//                }
                $this->frame_submit_tips(1, '修改成功！');
            } else {
                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }

        $this->assign('bg_color', '#F3F3F3');
        $id = $this->_get('id', 'trim,intval');
        $category = $category_db->find($id);
        if (empty($category)) $this->frame_submit_tips(0, '分类不存在！');

        $category['cat_pic'] = getAttachmentUrl($category['cat_pic']);
        $category['cat_pc_pic'] = getAttachmentUrl($category['cat_pc_pic']);
        $this->assign('category', $category);

        // 全部分类
//        $categories = // 'cat_level' => 1,
//            $category_db->where(array('cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
//        $array = array();
//        $this->categoryTree($categories, 0, '', $array);
//        $this->assign('categories', $array);
        $categories = $category_db->order('cat_path ASC')->select();
        $this->assign('categories', $categories);

        //获取属性类别的 所有属性
        $attr_list = D('SystemProductProperty')->get_property_list();
        $property_type = array();
        if ($category['filter_attr']) {
            $filter_attr = explode(",", $category['filter_attr']);  //把多个筛选属性放到数组中
            foreach ($filter_attr as $k => $v) {
                if ($k != 0) {
                    break;
                }

                $property_type_id = M('SystemProductProperty')->where(array('pid' => $v))->find($v);
                $property_type[$k]['goods_type_list'] =
                    D('SystemPropertyType')->get_PropertyType_list($property_type_id['property_type_id']);  //取得每个属性的商品类型
                $property_type[$k]['filter_attr'] = $v;
                $attr_option = array();

                foreach ($attr_list[$property_type_id['property_type_id']] as $val) {
                    $attr_option[key($val)] = current($val);
                }

                $property_type[$k]['option'] = $attr_option;
                $property_type[$k]['option_selected_id'] = $v;

                $edit_type = 1;
            }

            $this->assign('filter_attr', $filter_attr);
        } else {
            //获取属性类别
            $property_type = M('SystemPropertyType')->where(array('type_status' => 1))->select();
            $edit_type = 2;
        }

        $system_property_type_list = D('system_property_type')->where(array('type_status' => 1))->select();
        $system_tag_list = D('system_tag')->select();

        $tag_arr = explode(',', $category['tag_str']);
        $tag_list = array();
        $system_tag_list_group = array();
        foreach ($system_tag_list as $tmp) {
            $system_tag_list_group[$tmp['tid']][] = $tmp;

            if (in_array($tmp['id'], $tag_arr)) {
                $tag_list[] = $tmp;
            }
        }

        $tag_str = '{';
        foreach ($system_tag_list_group as $key => $system_tag) {
            $tag_str .= $key . ':{';
            foreach ($system_tag as $i => $tmp) {
                if ($i != 0) {
                    $tag_str .= ',';
                }

                $name = str_replace('"', "'", $tmp['name']);
                $tag_str .= $tmp['id'] . ':"' . $name . '"';
            }
            $tag_str .= '},';
        }
        $tag_str .= '}';

        $this->assign('edit_type', $edit_type);  //1:有属性 修改 2：无属性修改
        $this->assign('property_type', $property_type);
        $this->assign('system_property_type_list', $system_property_type_list);
        $this->assign('system_tag_list', $system_tag_list);
        $this->assign('system_tag_list_group', $system_tag_list_group);
        $this->assign('tag_str', $tag_str);
        $this->assign('tag_list', $tag_list);
        $this->display();
    }

    //删除分类
    public function category_del()
    {
        $category_db = M('ProductCategory');

        $cat_id = $this->_get('id', 'trim,intval');
        if ($category_db->delete($cat_id)) {
            $category_db->where(array('cat_fid' => $cat_id))->delete(); //删除子分类
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }

    //修改分类状态
    public function category_status()
    {
        $category_db = M('ProductCategory');

        $cat_id = $this->_post('cat_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $category_db->where(array('cat_id' => $cat_id))->save(array('cat_status' => $status));
        $category_db->where(array('cat_fid' => $cat_id))->save(array(
            'cat_status' => $status,
            'cat_parent_status' => $status
        ));
    }

    //加入推荐分类状态
    public function category_recommend()
    {
        $category_db = M('ProductCategory');

        $cat_id = $this->_post('cat_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $category_db->where(array('cat_id' => $cat_id))->save(array('is_recommend' => $status));
        $category_db->where(array('cat_fid' => $cat_id))->save(array(
            'is_recommend' => $status,
        ));
    }

    public function group()
    {
        $group = D('ProductGroupView');

        $where = array();
        if ($this->_get('type', 'trim') && $this->_get('keyword', 'trim')) {
            if ($this->_get('type') == 'group') {
                $where['ProductGroup.group_name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            }
            if ($this->_get('type') == 'store') {
                $where['Store.name'] = array('like', array('like', '%' . $this->_get('keyword', 'trim') . '%'));
            }
        }

        $group_count = $group->where($where)->count('group_id');
        import('@.ORG.system_page');
        $page = new Page($group_count, 20);
        $groups = $group->where($where)->limit($page->firstRow, $page->listRows)->select();

        $all_groups = $group->select();

        $this->assign('groups', $groups);
        $this->assign('all_groups', $all_groups);
        $this->assign('page', $page->show());
        $this->display();
    }

    //被分销的商品列表
    public function fxlist()
    {
        $product = D('ProductView');
        $to_group = M('ProductToGroup');
        $group = M('ProductGroup');
        $category_db = M('ProductCategory');

        $where = array();
        //$where['source_product_id']=array("gt",0);
        //$where['is_hot']=array("eq",1);

        $where = array(
            'is_fx' => 1,
            'source_product_id' => array("eq", 0)
        );


        if ($this->_get('type', 'trim') && $this->_get('keyword', 'trim')) {
            if ($this->_get('type', 'trim') == 'product_id') {
                $where['Product.product_id'] = $this->_get('keyword', 'trim,intval');
            } else if ($this->_get('type', 'trim') == 'name') {
                $where['Product.name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            } else if ($this->_get('type', 'trim') == 'store') {
                $where['Store.name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            }
        }
        //是否热门  0：否 1：是
        if (in_array($this->_get('is_hot', 'trim'), array('0', '1'))) {
            $where['Product.is_hot'] = $this->_get('is_hot', 'trim,intval');
        }
        //仓库中 //上架中
        if (in_array($this->_get('status', 'trim'), array('0', '1'))) {
            $where['Product.status'] = $this->_get('status', 'trim,intval');
        }

        if ($this->_get('category', 'trim,intval')) {
            $where['Product.category_id'] = $this->_get('category', 'trim,intval');
        }
        if (isset($_GET['allow_discount']) && is_numeric($_GET['allow_discount'])) {
            $where['Product.allow_discount'] = $this->_get('allow_discount', 'trim,intval');
        }
        if (isset($_GET['invoice']) && is_numeric($_GET['invoice'])) {
            $where['Product.invoice'] = $this->_get('invoice', 'trim,intval');
        }
        if ($this->_get('group', 'trim,intval')) {
            $where['_string'] = "Product.product_id IN (SELECT product_id FROM " . C('DB_PREFIX') .
                "product_to_group WHERE group_id = '" . $this->_get('group', 'trim,intval') . "')";
        }

        $product_count = $product->where($where)->count('Product.product_id');
        import('@.ORG.system_page');
        $page = new Page($product_count, 20);
        $tmp_products =
            $product->where($where)->order('Product.product_id DESC')->limit($page->firstRow, $page->listRows)
                ->select();

        $products = array();
        foreach ($tmp_products as $tmp_product) {
            $to_groups =
                $to_group->field('group_id')->where(array('product_id' => $tmp_product['product_id']))->select();
            if ($to_groups) {
                $group_ids = array();
                foreach ($to_groups as $value) {
                    $group_ids[] = $value['group_id'];
                }
                if ($group_ids) {
                    $group_ids = implode(',', $group_ids);
                    $group_names =
                        $group->field('group_name')->where(array('group_id' => array('in', $group_ids)))->select();
                    $tmp_group_names = array();
                    if ($group_names) {
                        foreach ($group_names as $group_name) {
                            $tmp_group_names[] = $group_name['group_name'];
                        }
                    }
                }
                if ($tmp_group_names) {
                    $group_name = implode(',', $tmp_group_names);
                }
            } else {
                $group_name = '';
            }
            $products[] = array(
                'product_id' => $tmp_product['product_id'],
                'image' => getAttachmentUrl($tmp_product['image']),
                'name' => $tmp_product['name'],
                'category' => $tmp_product['category'],
                'group' => $group_name,
                'store' => $tmp_product['store'],
                'price' => $tmp_product['price'],
                'market_price' => $tmp_product['market_price'],
                'quantity' => $tmp_product['quantity'],
                'sales' => $tmp_product['sales'],
                'buyer_quota' => $tmp_product['buyer_quota'],
                'allow_discount' => $tmp_product['allow_discount'],
                'invoice' => $tmp_product['invoice'],
                'date_added' => $tmp_product['date_added'],
                'status' => $tmp_product['status'],
                'is_hot' => $tmp_product['is_hot'],
                'source_product_id' => $tmp_product['source_product_id']
            );
        }

        $groups = $group->select();

        $categories = $category_db->order('cat_path ASC')->select();

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        $this->assign('groups', $groups);
        $this->assign('categories', $categories);
        $this->display();
    }

    //商品评价删除
    public function comment_del()
    {

        $comment = M('Comment');
        $delete_flg = $this->_get('delete', 'trim,intval');
        $comment_id = $this->_get('comment_id', 'trim,intval');

        if ($comment->where(array('id' => $comment_id))->save(array('delete_flg' => $delete_flg))) {
            $this->success('操作成功');
            exit;
        } else {
            $this->error('操作失败');
        }
    }

    //商品评价审核操作
    public function comment_status()
    {

        $comment = M('Comment');

        $comment_id = $this->_post('id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        if ($comment->where(array('id' => $comment_id))->save(array('status' => $status))) {
            $this->success('操作成功');
            exit;
        } else {

            $this->error('操作失败');
        }
    }

    //商品评价管理
    public function comment()
    {
        $config = C('config');
        //$where['delete_flg'] = 0;
        $where['type'] = 'PRODUCT';
        $comment_model = D('Comment');
        $isdelete = $this->_get("isdelete");
        if (in_array($isdelete, array('0', '1'))) {
            $where['delete_flg'] = $isdelete;
        }


        $count = $comment_model->getCount($where);
        if ($count > 0) {
            $limit = 15;
            import('@.ORG.system_page');
            $page = new Page($count, $limit);


            $comment_list = $comment_model->getList($where, 'id desc', $page->listRows, $page->firstRow, true);

            foreach ($comment_list['comment_list'] as $k => $v) {
                $product_new_arr[] = $v['relation_id'];
            }

            $in_array = $product_new_arr;

            $produdcts = D('Product')->where(array('product_id' => array('in', $in_array)))->select();
            if (is_array($produdcts)) {
                foreach ($produdcts as $k => $v) {
                    $product_arr[$v['product_id']] = $v;
                }
            }
            //dump($comment_list);
            $this->assign('comments', $comment_list);
            $this->assign('page', $page->show());
            $this->assign('config', $config);
            $this->assign('isdelete', $isdelete);
            $this->assign('product_arr', $product_arr);
        }
        $this->display();
    }

    //商铺品牌列表
    public function brand()
    {

        if ($this->_get('type_id', 'trim,intval')) {
            $where['_string'] = "type_id = '" . $this->_get('type_id', 'trim,intval') . "'";
        }

        $count = M('StoreBrand')->where($where)->count();

        import('@.ORG.system_page');
        $page = new Page($count, 10);
        $list = M('StoreBrand')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        //类别
        $brandtype = M('StoreBrandType')->where(array('status' => 1))->order('order_by ASC, type_id ASC')->select();

        $this->assign('all_brandtypes', $brandtype);
        $this->assign('brands', $list);
        $this->assign('page', $page->show());
        $this->display();
    }

    //修改商品品牌类别状态
    public function brand_status()
    {
        $StoreBrand = M('StoreBrand');
        $brand_id = $this->_post('brand_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $StoreBrand->where(array('brand_id' => $brand_id))->save(array('status' => $status));
    }

    //添加商铺品牌
    public function brand_add()
    {
        $brand = M('StoreBrand');

        if (IS_POST) {
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/brand/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/brand/' . $rand_num . '/' . $uploadList[0]['savename'],
                            '/brand/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['pic'] = 'brand/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }
            $data = array();

            $data['store_id'] = $this->_post('storeid', 'trim');
            $data['type_id'] = $this->_post('type_id', 'trim');
            if (empty($data['store_id']) || empty($data['type_id'])) $this->frame_submit_tips(0, '添加失败！请重试~');
            $data['name'] = $this->_post('name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['desc'] = $this->_post('desc', 'trim');
            if ($_POST['pic']) {
                $data['pic'] = $_POST['pic'];
            }


            if ($brand_id = $brand->add($data)) {

                $this->frame_submit_tips(1, '添加成功！');
            } else {
                echo $brand->getLastSql();
                exit;
                $this->frame_submit_tips(0, '添加失败！请重试~~~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $brandtypes = M('StoreBrandType')->where(array('status' => 1))->order('order_by ASC,type_id ASC')->select();
        //echo M('StoreBrandType')->getLastSql();
        //dump($brandtypes);exit;
        $this->assign('brandtypes', $brandtypes);
        $this->display();
    }

    //修改商铺品牌
    public function brand_edit()
    {
        $StoreBrand = M('StoreBrand');

        if (IS_POST) {
            $brand_id = $this->_post('brand_id', 'trim,intval');
            $now_brand = $StoreBrand->find($brand_id);
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/brand/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/brand/' . $rand_num . '/' . $uploadList[0]['savename'],
                            '/brand/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['pic'] = 'brand/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }

            $data = array();
            $data['store_id'] = $this->_post('storeid', 'trim');
            $data['type_id'] = $this->_post('type_id', 'trim');
            if (empty($data['store_id']) || empty($data['type_id'])) $this->frame_submit_tips(0, '添加失败！请重试~');
            $data['name'] = $this->_post('name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['desc'] = $this->_post('desc', 'trim');
            if ($_POST['pic']) {
                $data['pic'] = $_POST['pic'];
            }


            $store_status = $StoreBrand->where(array('brand_id' => $brand_id))->save($data);
            if ($store_status === 0 || $store_status) {

                if ($_POST['pic'] && $now_brand['pic']) {
                    unlink('./upload/' . $now_brand['pic']);

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $now_brand['pic']);
                    }
                }
                $this->frame_submit_tips(1, '修改成功！');
            } else {

                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $id = $this->_get('id', 'trim,intval');

        $brandtype = M('StoreBrandType')->where(array('status' => 1))->order('order_by ASC, type_id ASC')->select();
        $StoreBrand = $StoreBrand->find($id);
        $StoreBrand['pic'] = getAttachmentUrl($StoreBrand['pic']);
        if ($StoreBrand['store_id']) {
            $Store = M('Store')->find($StoreBrand['store_id']);
            $StoreBrand['store_name'] = $Store['name'];

        }
        $this->assign('brandtype', $brandtype);
        $this->assign('StoreBrand', $StoreBrand);
        $this->display();
    }

    //删除商铺品牌
    public function brand_del()
    {
        $StoreBrand = M('StoreBrand');
        $brand_id = $this->_get('id', 'trim,intval');

        $now_brand = $StoreBrand->find($brand_id);
        if ($StoreBrand->delete($brand_id)) {
            //删除图片
            if ($now_brand['pic']) {
                unlink('./upload/' . $now_brand['pic']);
                // 上传到又拍云服务器
                $attachment_upload_type = C('config.attachment_upload_type');
                if ($attachment_upload_type == '1') {
                    import('upyunUser', './source/class/upload/');
                    upyunUser::delete('/' . $now_brand['pic']);
                }
            }

            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }
}

