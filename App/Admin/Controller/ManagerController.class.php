<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
class ManagerController extends AdminController {
    public function login(){
        if(IS_POST && !empty($_POST)){
            $verifyCode = I('post.manager_code');
            if ($verifyCode===session('manager_Code')){
                session('manager_Code',null);
                $managerName = I('post.manager_name');
                $managerInfo = D('manager')->where(['mg_name'=>$managerName])->find();
                $managerPwd  = md5(I('post.manager_pwd').$managerInfo['salt']);
                if ($managerInfo['mg_pwd'] ===$managerPwd ){
                    session('adminName',$managerInfo['mg_name']);
                    session('adminId',$managerInfo['mg_id']);
                    $this->redirect('index/index');
                }
                $this->assign('errorLogin','密码不正确');
//
            }else{
                $this->assign('errorLogin','验证码不正确');
            }
        }
       $this->display();
    }


    /**
     * @verifyImg生成验证码
     * @author : Terry
     * @return
     */
    public function  verifyImg(){
        $config =[
            'useImgBg'  =>  false,           // 使用背景图片
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'fontSize'=> 19,
            'imageH'  => 45,
            'imageW'  => 130,
            'length'  => 1,
            'fontttf' => '4.ttf'
        ];
        $verify = new \Think\Verify($config);
        $verify->entry();
    }


    /**
     * @checkVerifyCode验证码校验
     * @author : Terry
     * @return
     */
    public function checkVerifyCode(){
        $verifyCode = I('post.manager_code');
        $verifyCheck = new \Think\Verify();
        if ($verifyCheck->check($verifyCode)){
            session('manager_Code',$verifyCode );
            exit(json_encode(['status'=>200]));
        }else{
            exit(json_encode(['status'=>202]));
        }
    }

    /**
     * 退出
     */
    public function logout(){
        session('adminName',null);
        session('adminid',null);
        $this->redirect('manager/login');
    }

    /**
     * 管理员列表
     * author Fox
     */
    public function showlist(){
        $managerInfo = M('manager')
            ->alias('man')
            ->field('man.mg_id,man.mg_name,role.role_name')
            ->join('sp_role as role on man.role_id = role.role_id')
            ->where('flag=1')
            ->select();
        $this->assign('managerInfo',$managerInfo );
        $this->display();
    }

    /**
     * author Fox
     * 删除管理员
     */
    public function delManager(){
        $manId = I('post.manager_id');
        $manFalg =  M('manager')->where(['mg_id'=>$manId])->save(['flag'=>0]);
        if ($manFalg){
            exit(json_encode(['status'=>200,'message'=>'删除成功']));
        }
        exit(json_encode(['status'=>202,'message'=>'删除失败']));
    }

    /**添加管理员
     * author Fox
     */
    public function addManager(){
        if(IS_AJAX && !empty($_POST)){
            $manager=D('manager');
            if($manInfo = $manager->create()){
                $manInfo['salt']=substr(md5(time()),5,8);
                $manInfo['mg_pwd'] = md5(I('post.mg_pwd').$manInfo['salt']);
                if ($manager->add($manInfo)){
                    exit(json_encode(['status'=>200,'message'=>'管理员添加成功']));
                }
            }else{
                exit(json_encode(['status'=>202,'message'=>'管理员添加失败']));
            }


        }else{
           $roleInfo =  M('role')->select();
           $this->assign('roleInfo',$roleInfo);
        }
        $this->display();
    }

    /**
     * 修改管理员密码
     * @param int $manager_id
     * author Fox
     */
    public  function updMan($manager_id=0){
        if (IS_AJAX && !empty($_POST)){
            $manInfo =I('post.');
            if (!isset($manInfo['mg_pwd'])){
                unset($manInfo['mg_pwd']);
            }else{
                $manInfo['mg_pwd'] =md5( $manInfo['mg_pwd']);
            }
            $manager=D('manager');
            if ($upData = $manager->create()){
                if ($manager->where(['mg_id'=>$manInfo['mg_id']])->save($upData)){
                    exit(json_encode(['status'=>200,'message'=>'修改成功']));
                }
            }
            exit(json_encode(['status'=>202,'message'=>'修改失败']));
        }else{
            $manInfo = M(manager)->find($manager_id);
            $roleInfo =  M('role')->select();
            $this->assign('roleInfo',$roleInfo);
            $this->assign('manInfo',$manInfo);
        }

        $this->display();
    }


}