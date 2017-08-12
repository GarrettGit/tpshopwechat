<?php
namespace Admin\Controller;

use Admin\Common\AdminController;

class UserController extends AdminController{

    /**
     * @showlist用户列表
     * @author : Terry
     * @return
     */
    public  function showlist(){
       $userInfo = D('user')-> getAllData();
       $this->assign('userInfo',$userInfo['list']);
       $this->assign('page',$userInfo['page']);
       $this->display();
    }


    /**
     * @blocked账户冻结
     * @author : Terry
     * @return
     */
    public function  blocked(){
        $userBlockState =  D('user')->userBlocked(I('post.'));
        exit($userBlockState);
    }

    /**
     * @delUser 删除会员
     * @author : Terry
     * @return
     */
    public  function  delUser(){
        $userData['user_id'] = I('post.user_id');
        $userData['flag'] = 0;
        if(M('user')->save($userData)){
            exit(json_encode(['status'=>200,'message'=>'删除会员成功']));
        }
        exit(json_encode(['status'=>202,'message'=>'删除会员失败']));
    }


    /**
     * @exportUser导出用户
     * @author : Terry
     * @return
     */
    public function  exportUser($page=0){
        D('user')->export_execl($page);
    }

    /**
     * @membersLevel 添加会员级别
     * @author : Terry
     * @return
     */
    public function membersLevel(){
        if (IS_POST){
            $memberLevel= D('memberLevel');
            if ($memberLevel->create()){
                if ($memberLevel->add()){
                    $this->success('添加成功',U('memberList'),2);
                }else{
                    $this->error('添加失败',U('memberLevel'),2);
                }
                exit();
            }else{
                $this->assign('errorInfo',$memberLevel->getError());
            }

        }
            $this->display();



    }

    /**
     * @memberList 会员级别列表
     * @author : Terry
     * @return
     */
    public  function memberList(){
        $memberLevelInfo= M('memberLevel')->where(['flag'=>1])->select();
        $this->assign('memberLevelInfo',$memberLevelInfo);
        $this->display();
    }

    /**
     * @delMember 删除会员级别
     * @author : Terry
     * @return
     */
    public  function  delMember()
    {
        $memberData['flag'] = 0;
        $memberData['id']   = I('post.member_id');
        if (M('memberLevel')->save($memberData)) {
           $returnInfo['status']=200;
           $returnInfo['message']='删除成功';
        }else{
            $returnInfo['status']=202;
            $returnInfo['message']='删除失败';
        }
        //调用Thinkphp封装的ajaxReturn方法 直接返回json
        $this->ajaxReturn($returnInfo);
    }

    /**
     * @updMember 修改会员级别
     * @author : Terry
     * @return
     */
    public  function  updMemberLevel($member_id){
        $memberLevel=  D('memberLevel');
        if (IS_POST) {
            if (session('member_id') == I('post.id')) {
                $memberData = I('post.');
                if ($memberLevel->save($memberData)) {
                    $this->success('修改成功', U('memberList'), 2);
                } else {
                    $this->error('修改失败', U('updMemberLevel', ['member_id' => $memberData['id']]), 2);
                }
        }
        }else{
            session('member_id',$member_id);
            $memberInfo= $memberLevel->find($member_id);
            $this->assign('memberInfo',$memberInfo);
            $this->display();
        }


    }



    /**
     * @insterUser循环写入虚假用户
     * @author : Terry
     * @return
     */
    public  function insterUser(){
        set_time_limit(0);
        for ($i=0;$i<=10000;$i++){
            $data['username']=substr(MD5(time()),10,7).$i.'0';
            $data['password']=MD5(123456);
            $data['user_email']= $data['username'].'@163.com';
            $data['user_sex']=1;
            $data['user_time']=time();
            M('user')->add($data);
            if ($i>10000){
                exit('成功');
            }
        }

    }
}
