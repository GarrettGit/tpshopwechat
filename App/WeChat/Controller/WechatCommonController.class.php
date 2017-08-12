<?php
/**
 * Created by PhpStorm.
 * WechatCommonController.class.php微信平台管理公共控制器
 * author: Terry
 * Date: 2017/8/5
 * Time: 13:36
 * description:
 */
namespace WeChat\Controller;

use Think\Controller;
class WechatCommonController extends Controller{

    public  function __construct()
    {
        parent::__construct();
        $controllerAndActionName =   CONTROLLER_NAME.'-'.ACTION_NAME;
        //判断管理员是否登录
        if (empty(session('wechatName'))){
            if ($controllerAndActionName != 'WechatManagementPlat-login'){
                $js=<<<EOF
                       <script type='text/javascript'>
        window.top.location.href='/index.php/WeChat/WechatManagementPlat/login';
        </script>
EOF;
                exit($js);
            }

        }
    }
}
