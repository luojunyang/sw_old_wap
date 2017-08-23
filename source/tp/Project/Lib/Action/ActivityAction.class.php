<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22
 * Time: 11:35
 */
class ActivityAction extends BaseAction
{
    //奖品列表
    public function index(){
        $agent = M('yws_prize');
        $agent_count = $agent->count('id');
        import('@.ORG.system_page');
        $page = new Page($agent_count, 20);
        $list = $agent->order('`id` DESC')->limit($page->firstRow, $page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $page->show());
        $this->display();
    }
    //添加奖品
    public function add(){
        if(IS_POST) {
            $pic = $_FILES['pic'];                           //奖品图片
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/activity/' . $rand_num . '/';
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
                    $pic = $upload_dir . $uploadList[0]['savename'];

                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            } else {
                $this->frame_submit_tips(0, '请上传分类图片！');
            }
            $_POST['pic'] = $pic;

            $activity = D('yws_prize')->data($_POST)->add();

            if ($activity) {
                $this->frame_submit_tips(1, '添加成功！');
            } else {
                $this->frame_submit_tips(0, '添加失败！请重试~');
            }

        }
        else{
            $this->display();
        }

    }
    //修改奖品
    public function edit(){
        if(IS_POST){
            $result = $this->upload();
            if($result['code']!=0){
                if(isset($result["pic"])){
                    $_POST["pic"]=$result["pic"];
                }
                $activity = D("yws_prize")->where(array("id"=>$_POST['id']))->save($_POST);
                $this->frame_submit_tips(1, '修改成功！');
            }else{
                $this->frame_submit_tips(0, $result['msg']);
            }
        }else{
            $id = I("id");
            $activity = D('yws_prize')->field(true)->where(array("id"=>$id))->find();
            if($activity && !empty($activity)){
                $this->assign('activity', $activity);
                $this->display();
            }else{
                $this->frame_submit_tips(0, '错误，该数据不存在');
            }
        }
    }

    //删除奖品
    public function del(){
        $id = I("id");
        $activity['id'] = intval($id);
        if(D('yws_prize')->where($activity)->delete()) {
            $this->success('删除成功！');
        }
        else {
            $this->error('删除失败！请重试~');
        }
    }
}