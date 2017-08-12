<?php
/**
 * Created by PhpStorm.
 * WechatManagementPlatformController.class.php
 * author: Terry
 * Date: 2017/8/5
 * Time: 13:54
 * description:
 */
namespace WeChat\Controller;

use Think\Controller;

class WechatManagementPlatController extends Controller {
    /**
     * @login 登录
     * @author : Terry
     * @return
     */
    public function  login(){
        if (IS_POST){
            $managerName = I('post.name');
            $managerInfo = D('manager')->where(['mg_name'=>$managerName])->find();
            $managerPwd  = md5(I('post.Password').$managerInfo['salt']);
            if ($managerInfo['mg_pwd'] ===$managerPwd ){
                session('wechatName',$managerInfo['mg_name']);
                session('wechatId',$managerInfo['mg_id']);
                $this->index;
            }

        }
        $this->display();
    }

    /**
     * @logout 退出
     * @author : Terry
     * @return
     */
    public function logout(){
        session('wechatName',null);
        session('wechatId',null);
        $this->redirect('wechat/login');
    }

    public  function index(){
        $this->display();
    }
}