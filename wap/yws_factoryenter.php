<?php
/**
 *  新零售
 */
require_once dirname(__FILE__).'/global.php';
require_once dirname(__FILE__).'/uploadfile.php';
//@unlink('./upload/images/2017/06/13/593f5ebbabba1.gif');

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
function ajax_upload_pic(&$pic,$key,$file)
{
    if($file['error'] != 4) {
        $upload_dir = "./upload/factoryenter/".date('Y/m/d',time())."/";
        if(!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $upload = new UploadFile();
        $upload->maxSize = 3 * 1024 * 1024;
        $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
        $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
        $upload->savePath = $upload_dir;
        $upload->saveRule = 'uniqid';
        $upload->files = $file;
        if($upload->upload()) {
            $uploadList = $upload->getUploadFileInfo();
            $pic[$key]= $uploadList[0]['savepath'].$uploadList[0]['savename'];
        }
        else {
            $pic[$key]='message:'.$upload->getErrorMsg();
        }
    }
    else {
        $pic[$key]='message:没有选择图片';
    }
}

//$sellmsg = M("yws_newzerosell")->select();
//dump($sellmsg);
$post = $_POST;
if($post){
    //dump($post);exit;
    $title = $_POST['yws_title'];
    //dump($title);
    $url = $config['site_url'];
    //dump($wap_user);
    $data['area'] = $post['area'];
    $data['linkman'] = $post['linkman'];
    $data['phone'] = $post['phone'];
    $data['wap_uid'] = $wap_user['uid'];
    $data['wap_nickname'] = $wap_user['nickname'];
    $data['wap_avatar'] = $wap_user['avatar'];
    $data['wap_openid'] = $wap_user['openid'];
    $data['wap_unionid'] = $wap_user['wechat_unionid'];
    $data['type']=trim($post['post'],'1,');

    logs(json_encode($_POST), 'INFO');

    foreach ($_FILES as $k=>$v){
        if($_FILES[$k]!=''){
            $files[$k]=$v;
        }
    }
    //dump($_FILES);die;
    $pic='';
    foreach ($files as $key=>$val){
        ajax_upload_pic($pic,$key,$val,$url);
    }
    //dump($pic);
    $data = array_merge($data,$pic);
    $res=implode('',$pic);

    //dump(strpos($res,'message'));
    if(strpos($res,'message')===false){
        //图片上传成功执行插入
        $sellmsg = M("Yws_factoryenter");
        $data['created_time'] = date('Y-m-d H:i:s',time());
        //dump($data);
        $insert = $sellmsg->add($data);
        //dump($insert);
        if($insert){
            $resoult =  '申请已提交,等待审核....';
        }else{
            foreach ($pic as $k=>$v){
                if(strpos($v,'message:')===false){
                    //dump($v);
                    @unlink($v);
                }
            }
            $resoult =  "出错了，请刷新后重试";
        }
        include display('yws_result');
        echo ob_get_clean();
    }else{
        foreach ($pic as $k=>$v){
            if(strpos($v,'message')!==false){
                $error[1]="上传的照片含有不合格文件，请从新上传";
            }else{
                @unlink($v);
            }
        }
        include display('yws_result');
        echo ob_get_clean();
    }
}else{
    if($_GET['contry']){
        $str=implode('',$_GET);
        $str2 = implode(',',$_GET);
        $json=file_get_contents('./factory.json');
        $json=json_decode($json,true);
        foreach($json as $key=>$val){
            if(strpos($str,$key)!==false || $key=='list'){
                $arr[$key]= $val;
            }
        }
        //var_dump($arr);
        foreach ($arr as $val){
            foreach ($val as $v){
                $data[] = $v;
            }
        }
        //dump($data);
        include display('yws_factoryenter2');
        echo ob_get_clean();
    }else{
        include display('yws_factoryenter1');
        echo ob_get_clean();
    }

}