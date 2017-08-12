<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
class IndexController extends AdminController {


    public function index(){

       $this->display();
    }
    public function down(){
        $this->display();
    }
    public function center(){
        $this->display();
    }
    public function left(){
        $managerName =session('adminName');
        if ($managerName !=='admin'){
            //链表查询
            $managerInfo =   M('manager')
                ->alias('man')
                ->field('role.role_name,role.role_auth_ids,role.role_auth_ac')
                ->join('sp_role as role on man.role_id = role.role_id')
                ->where(['man.mg_id'=>session(adminId)])
                ->find();
            $authInfo =    M('auth')->where(['falg'=>1])->select($managerInfo['role_auth_ids']);

        }else{
            $authInfo =    M('auth')->where(['falg'=>1])->select();
        }

        foreach ($authInfo as $k =>  $authData){
            if (1 == $authData['auth_level']  ){
                $authInfoS[] =  $authData;
            } elseif (0 == $authData['auth_level'] ){
                $authInfoP[] =  $authData;
            }
        }
        $this->assign('authInfoP',$authInfoP);
        $this->assign('authInfoS',$authInfoS);
        $this->display();
    }


    public function right(){
        $this->display();
    }




}