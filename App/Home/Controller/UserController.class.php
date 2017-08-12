<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\oAuth;
use Common\Common\SaeTClientV2;
class UserController extends Controller {

    /**
     * @register用户注册
     * @author : Terry
     * @return
     */
    public  function  register(){
        if(IS_POST && !empty($_POST)){
            $verifyCode = I('post.checkCode');
                $user =D('User');
            if (session('manager_Code') ==$verifyCode || session('manager_Code')!=null){
                if ($userData = $user->create()){
                    if ($user->adduser($userData)){
                        $this->success('注册成功,请前往'.$userData['user_email'].'激活帐户',U('login'),3);
                    } else{
                        $this->error($user->getError(),U('register'),3);
                    }
                    }else{
                    $this -> assign('errorinfo',$user->getError());
                }

                }

        }else{
            $this->display();
        }

    }

    /**
     * @login 用户登录
     * @author : Terry
     * @return
     */
    public  function  login(){
        if (IS_POST ){
           $user = D('user');
           $userState=  $user ->checkUserInfo(I('post.'));
           if ($userState){
               $backUrl = session('callBack');
               if(!empty($backUrl)){
                   session('callBack',null);
                   $this->redirect($backUrl);
               }
               $this->redirect('Index/index');
           }
           $this->assign('errorInfo', $user->getError());
        }
        $this->display();
    }


    /**
     * @logout退出登录
     * @author : Terry
     * @return
     */
    public function logout(){
        session(null);
        $this->redirect('User/login');
    }


    /**
     * @QQLoginqq授权窗口
     * @author : Terry
     * @return
     */
    public  function  QQLogin(){
        Vendor('QQAPI.qqConnectAPI');
        $qc = new \QC();
        $qc->qq_login();

    }


    /**
     * @callbackqq回调函数
     * @author : Terry
     * @return
     */
    public  function  callback(){
        //引入QQapi类
        Vendor('QQAPI.qqConnectAPI');
        //获取qq用户信息类
        $qc = new \QC();
        $backCode =  $qc->qq_callback();
        $openId = $qc->get_openid();
        $qc = new \QC($backCode,$openId);
        $QQuserInfo = $qc->get_user_info();
        //如果获取到用户信息
        if ($QQuserInfo){
          $user=D('user');
          //通过openid查看数据库中是否有该用户信息
            $returnUserInfo = $user->getOneData(['openid'=>$openId]);
            if ($returnUserInfo){
                //查到用户信息判断用户是否修改过用户名
                if ($returnUserInfo['username']!=$QQuserInfo['nickname']){
                    //如修改过用户名 修改数据库中用户名
                    $user->where(['user_id'=>$returnUserInfo['user_id']])->save(['username'=>$QQuserInfo['nickname']]);
                }
                //通过查出数据判断该用户是否被冻结
                if ($returnUserInfo['flag'] ==2 ||$returnUserInfo['flag'] ==3 ){
                    $this->error('该用户已被冻结,请与管理员联系');
                }
                    //授权通过 没有冻结 则允许用户登录
                    session('userId',$returnUserInfo['user_id']);
                    session('userName', $QQuserInfo['nickname']);
                    $this->success('登录成功,即将跳转',U('index/index'),2);
            }else{
                //若用户第一次授权登录 则将获取到的用户信息写入数据库
                $userInfo['username']  = $QQuserInfo['nickname'];
                $userInfo['is_active'] = '激活';
                $userInfo['openid']    = $openId;
                $userInfo['user_time'] = time();
                if ($newId =$user->add($userInfo)){
                    //用户信息写入成功 允许用户登录
                    session('userId',$newId);
                    session('userName', $userInfo['username']);
                    $this->success('登录成功,即将跳转',U('index/index'),2);
                }
            }

        }
        //关闭授权小窗口
        echo <<<EOF
<script type='text/javascript'>
window.opener.location.href='/';
window.close();
</script>
EOF;

    }

    /**
     * @tel_register手机快速注册
     * @author : Terry
     * @return
     */
    public  function  tel_register(){
        if (IS_AJAX && IS_POST) {
            $phone = I('post.user_tel');
            //判断session验证码是否与接收到的一直
            if (session($phone . 'code') == I('post.codeNum') && !empty($phone)) {
                //清除验证码
                session($phone.'code',null);
                //实例化user
                $user = D('User');
                if ($user->create()) {
                    $reg_state = $user->userTelRegiste($phone);
                    if ($reg_state) {
                        $errorCode['code']    = '200';
                        $errorCode['info']    = '注册成功,默认密码为手机号后8位！';
                        $errorCode['backUrl'] = U('user/login');
                        exit(json_encode($errorCode));
                    }
                }else {
                    $errorCode['code'] = '202';
                    $errorCode['info'] = ($user->getError())['user_tel'];
                    exit(json_encode($errorCode));
                }
            }
                $errorCode['code'] = '202';
                $errorCode['info'] = '注册失败,请稍候再试！';
                exit(json_encode($errorCode));
        }
        $this->display();
    }


    /**
     * @sendCheckCode发送手机验证码
     * @author : Terry
     * @return
     */
    public  function  sendCheckCode(){
        if (IS_AJAX && IS_POST){
            //获取手机号码
            $telphone = I('post.phone');
            //设置错误信息代码 200成功
            $errorCode =  array('code'=>200,'info'=>'发送失败!');
            //手机号码，替换内容数组，模板ID
            $res = sendTemplateSMS($telphone,'',"1");
            if($res){
                $errorCode['info']='发送成功！';
            }else{
                $errorCode['code']='202';
                $errorCode['info']='发送失败,请稍候再试！';
            }
            echo json_encode($errorCode);
        }
    }


    /**
     * @center用户中心
     * @author : Terry
     * @return
     */
        public function center(){
            $this->display();
        }


    /**找回密码
     * @getBackPwd
     * @author : Terry
     * @return
     */
        public function getBackPwd(){
            if (IS_AJAX && IS_POST){
                $phone = I('post.phone');
                $errorCode['code']='202';
                $user= D('user')->getOneData(['user_tel'=>$phone]);
                //如果不是平台用户不给予找回密码
                if (empty($user)){
                    $errorCode['info']='该用户'.$phone.'不存在,请先注册！';
                    exit(json_encode($errorCode));
                }
                //每个验证码只可使用一次
                if (empty(session($phone.'code'))){
                    $errorCode['info']='验证码已失效！';
                    exit(json_encode($errorCode));
                }
                //与session中验证码进行匹配
                if (session($phone.'code') == I('post.codeNum') && !empty($phone)){
                    session($phone.'code',null);
                    $errorCode['code']='200';
                    $errorCode['user_id']=$user['user_id'];

                }else{
                    $errorCode['code']='202';
                    $errorCode['info']='验证码错误,请稍候再试！';
                }
                exit(json_encode($errorCode));
            }
                $this->display();
        }


    /**
     * @updPwd修改密码
     * @author : Terry
     * @return
     */
     public function updPwd(){
         if (I('post.pwd') == I('post.pwd2')){
             if(D('user')-> userUpdPwd(I('post.'))){
                 $this->success('密码修改成功',U('login'),2);
             }
             $this->error('密码修改失败,请与管理员联系',U('getBackPwd'),2);
         }
         $this->error('两次密码不一致');

     }


    /**
     * @userActive用户激活
     * @author : Terry
     * @return
     */
    public function  userActive(){
        //获取用户id
        $userId = I('get.id');
        //获取当前用户状态
        $userActiveState = M('UserActive')->find($userId);
        //当前时间减去注册时间
        $currentTime = (time() - $userInfo['rig_time']);
        $user = D('User');
        //获取当前用户信息
        $userInfo=$user->getOneData($userId);
        //若当前用户已激活 提示用户直接登录
           if ($userInfo['is_active'] == '激活'){
               $this->error('该用户已激活,请直接登录',U('login'),3);
           }
           //如果激活时间大于7200秒 提示用户激活链接已失效 请重新注册
           if ($currentTime > 7200){
                $this->error('链接已过期,请重新注册',U('register'),3);
           }else{
               //若当前时间小于7200秒 判断激活码是否匹配 同时激活该用户
               if ($userActiveState['active_code'] == I('get.activeCode')){
                   if($user->where(['user_id'=>$userId])->save(['is_active'=>'激活'])){
                       $this->success('激活成功,请登录',U('login'),3);
                       exit;
                   }
                   $this->error('激活失败,请与管理员联系',U('login'),3);
               }
           }


    }



    /**
     * @weiboLoginCallback微博登录回调函数
     * @author : Terry
     * @return
     */
    public function weiboLoginCallback(){
        //实例化微博oAuth类
        $oAuth = new oAuth( C('WB_AKEY') , C('WB_SKEY') );
        //直接使用微博aouth dome代码
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = C('SITE')."/index.php/home/user/weiboLoginCallback";
            try {
                $token = $oAuth->getAccessToken( 'code', $keys ) ;
            } catch (OAuthException $e) {
            }
        }
        //获取到assoc_token
        if ($token) {
            setcookie( 'weibojs_'.$oAuth->client_id, http_build_query($token) );
            //实例化SaeTClientV2类获取到用户信息 注意:该类在oauth类中下半部分 注意修改构造方法中实例化的oauth类
            $oAuthResult = new SaeTClientV2( C('WB_AKEY') , C('WB_SKEY'), $token['access_token'] );
            //获取用户uid
            $uid_get = $oAuthResult->get_uid();
            //根据uid获取微博用户信息
            $user_message = $oAuthResult->show_user_by_id($uid_get['uid']);

            //事例话user模型  将用户信息写入数据库
            $user=D('user');
            //以下部分与qq授权相同
            $returnUserInfo = $user->getOneData(['wb_id'=>$user_message['id']]);
            if ($returnUserInfo){
                if ($returnUserInfo['username']!=$user_message['name']){
                    $user->where(['user_id'=>$returnUserInfo['user_id']])->save(['username'=>$user_message['name']]);

                }
                session('userId',$returnUserInfo['user_id']);
                session('userName', $user_message['name']);
                $this->success('登录成功,即将跳转',U('index/index'),2);
            }else{
                //如果获取到微博用户信息
                $userInfo['username']  = $user_message['name'];
                $userInfo['is_active'] = '激活';
                $userInfo['wb_id']    = $user_message['id'];
                $userInfo['user_time'] = time();
                if ($newId =M('user')->add($userInfo)) {
                    session('userId', $newId);
                    session('userName', $userInfo['username']);
                    $this->success('登录成功,即将跳转', U('index/index'), 2);
                }
            }

        } else {
            $this->success('授权失败,请与管理员联系','', 2);
        }

    }


    /**
     * @weibologin微博oauth2.0授权登录
     * @author : Terry
     * @return
     */
    public function weibologin(){
        //实例化微博oauth类 获取授权窗口
        $oAuth = new oAuth( C('WB_AKEY') , C('WB_SKEY') );
        $code_url = $oAuth->getAuthorizeURL( C('SITE')."/index.php/home/user/weiboLoginCallback");
        echo <<<EOF
        <script type='text/javascript'>
        window.location.href="$code_url";
        </script>
EOF;
    }



}