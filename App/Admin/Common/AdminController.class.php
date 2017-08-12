<?php
namespace Admin\Common;
use Think\Controller;
class AdminController extends Controller {
   public  function __construct()
   {    //设置缓存类型memcache
//      S(array('type'=>'memcache','host'=>'localhost','port'=>9880));
       parent::__construct();
       $adminId = session('adminId');
       $adminName = session('adminName');
       $newAC =CONTROLLER_NAME .'-'.ACTION_NAME;

       if(empty($adminName)){

           $allowAuth = 'Manager-login,Manager-logout,Manager-verifyImg';

           if (strpos($allowAuth,$newAC) ===false && !IS_AJAX){

               $js=<<<EOF
               <script type='text/javascript'>
window.top.location.href='/index.php/admin/manager/login';
</script>
EOF;
            echo $js;
           }

       }else{
           $roleInfo = M('manager')
                        ->alias(man)
                        ->field('role.role_auth_ac')
                        ->join('sp_role as role on man.role_id = role.role_id')
                        ->where(['mg_id'=>$adminId])
                        ->find();

           $allowAuth ='Manager-login,Manager-logout,Manager-verifyImg,Index-top,Index-left,Index-right,Index-center,Index-down,Index-index,Manager-checkVerifyCode';
           if(strpos($allowAuth,$newAC) === false && strpos($roleInfo['role_auth_ac'],$newAC) === false &&admin !=$adminName){
               exit('对不起,您没有访问权限！');
           }
       }
   }
}