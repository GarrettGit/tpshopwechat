<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
class RoleController extends AdminController {
    public function showList(){
      $roleInfo =   M('role')->select();
        $this->assign('roleInfo',$roleInfo);
        $this->display();
    }

    /**
     * @distribute 分配权限
     *
     * @param int $role_id 角色id
     *
     * @author : Terry
     * @return
     */
    public function distribute($role_id=0){
        if (IS_AJAX && !empty($_POST)){
//            var_dump( I('post.roleId'));
            if (session('roleId') == I('post.roleId')){
                  $updAuth =   D('Role')->saveAuth(session('roleId'),I('post.authId'));
                  if ($updAuth){
                      session('roleId',null);
                      exit(json_encode(['msg'=>'分配成功!','status'=>200]));
                  }  else{
                      exit(json_encode(['msg'=>D('Role')->getError(),'status'=>202]));
                  }

            }

        }else{
            $roleInfo =  M('role')->find($role_id);
            session('roleId',$role_id);
            $authInfo =  M('auth')->where(['falg'=>1])->select();
            foreach ($authInfo as $auth){
                if(1 ==$auth['auth_level'] ){
                    $authInfoS[] = $auth;
                }elseif (0 ==$auth['auth_level'] ){
                    $authInfoP[] = $auth;
                }
            }
            $this->assign('roleInfo',$roleInfo);
            $this->assign('authInfoP',$authInfoP);
            $this->assign('authInfoS',$authInfoS);
            $this->display();
        }

    }


    /**
     * @addRole 添加角色
     * @author : Terry
     * @return
     */
    public function addRole(){
        if (IS_POST && !empty($_POST)){
          $roleId =   M('role')->add(['role_name'=>I('post.role_name')]);
            if($roleId){
                session('roleId', $roleId );
                exit(json_encode(['status'=>200,'message'=>'角色添加成功,即将跳转分配权限','role_id'=>$roleId]));
            }else{
                exit(json_encode(['status'=>202,'message'=>'角色添加失败,请与管理员联系','role_id'=>$roleId]));
            }
        }
        $this->display();
    }


    /**
     * @redirectUrl ajax添加角色后用于跳转  addRole.html
     * @author : Terry
     * @return
     */
//    public function redirectUrl(){
//         $this->redirect(distribute,['role_id'=>session('roleId')]);
//}


    /**
     * @delRole 删除角色
     * @author : Terry
     * @return
     */
    public  function  delRole(){

        if(IS_AJAX && !empty($_POST)){
            if(M('role')->delete(I('post.role_id'))){
                exit(json_encode(['status'=>200]));
            }
            exit([json_encode(['status'=>202])]);
        }

    }

}