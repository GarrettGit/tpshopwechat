<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
class AuthController extends AdminController {
    /**
     * @showList 权限列表
     * @author : Terry
     * @return
     */
    public function showList(){
      $authInfo  =   M('auth')->where(['falg'=>1])->select();
        $authInfo = generateTree($authInfo);
        $this->assign('authInfo',$authInfo);
        $this->display();
    }


    /**
     * @addAuth添加权限
     * @author : Terry
     * @return
     */
    public  function  addAuth(){

        if (IS_AJAX && !empty(I('post.auth_name'))){
            $authInfo = I('post.');
            $authInfo['auth_level'] = $authInfo['auth_pid'] == '0' ? '0' :'1';
            if (M('auth')->add($authInfo)){
                exit(json_encode(['status'=>200,'message'=>'权限添加成功']));
            }
            exit(json_encode(['status'=>202,'message'=>'权限添加失败']));
        }else{
            $pAuth = M('auth')->where(['level'=>0,'falg'=>1])->select();
            $this->assign('pAuth',$pAuth);
            $this->display();
        }

    }


    /**
     * @delAuth 删除权限
     * @author : Terry
     * @return
     */
    public function delAuth(){
       $authId = I('post.auth_id');
       $authFalg =  M('auth')->where(['auth_id'=>$authId])->save(['falg'=>0]);
       if ($authFalg){
           exit(json_encode(['status'=>200,'message'=>'删除成功']));
       }
        exit(json_encode(['status'=>202,'message'=>'删除失败']));
    }


    /**
     * @updAuth修改权限
     *
     * @param int $auth_id权限id
     *
     * @author : Terry
     * @return
     */
    public function updAuth($auth_id=0){
        $auth = M('auth');
        if (IS_AJAX && !empty($_POST)){
            $updAuthInfo = I('post.');
         $authState =     $auth ->save($updAuthInfo );
         if ($authState){
             exit(json_encode(['status'=>200,'message'=>'修改成功']));
         }
            exit(json_encode(['status'=>202,'message'=>'修改失败']));
        }else{
            $allAuth =$auth->where(['level'=>0,'falg'=>1])->select();
            $authInfo = $auth ->find($auth_id);
            $this->assign('authInfo',$authInfo);
            $this->assign('allAuth',$allAuth);
//            var_dump($allAuth,$authInfo);
        }
        $this->display();
    }


}