<?php
namespace  Home\Model;

use Think\Model;

class  UserModel extends Model{


    protected $patchValidate = true;
    protected  $_validate = [
        ['username','require','用户名必须填写'],
        ['username','','用户名已经存在',0,'unique'],
        ['user_tel','','该手机已经存在',0,'unique'],
        ['password','require','密码必须填写'],
        ['user_email','require','邮箱必须填写'],
        ['user_email','email','邮箱格式不正确',2],
        ['pwd','require','确认密码必须填写'],
        ['password','pwd','确认密码不正确',0,'confirm'],
        ['user_email','email','邮箱格式不正确',2],
    ];

    /**
     * 用户登录校验
     * @param array $param
     *
     * @return bool
     * author Fox
     */
    public function checkUserInfo(array $param){
        //判断用户名登录还是手机登录
        $preg ='/^1[34578]\d{9}$/';
        if (preg_match($preg,$param['username'])){
            $where=['user_tel'=>$param['username'],'password'=>md5($param['password'])];
        }else{
            $where=['username'=>$param['username'],'password'=>md5($param['password'])];
        }

       $result =  $this->where($where)->find();
        if ($result === null){
            $this->error='用户不存在或账户密码错误请';
            return false;
        }
        //判断是否激活
       if ($result['is_active'] == '未激活'){
           $this->error='该用户未激活,请前往'.$result['user_email'].'进行激活';
           return false;
       }

       //判断账户状态
       if ($result['flag'] == 0){
           $this->error='该用户已被注销,请与网站管理员联系';
           return false;
       }elseif ($result['flag'] == 2){
           //如果是冻结 判断冻结时间是否已过期 若没过去 提示冻结 过期 解冻允许登录
           if($result['blocked_time']>time()){

               $this->error='该用户已被冻结,解冻时间为'.date('Y-m-d H:i:s',$result['blocked_time']);
               return false;
           }else{
               $this->where(['user_id'=>$result['user_id']])->save(['flag'=> 1]);
               session('userId',$result['user_id']) ;
               session('userName',$result['username']);
               return true;
           }

       }elseif ($result['flag'] == 3){
           $this->error='该用户已被永久冻结,请与网站管理员联系';
        return false;
       }
       //允许登录
        if($result !== null){
            session('userId',$result['user_id']) ;
            session('userName',$result['username']);
            return true;
       }

        $this->error='系统错误,请与管理员联系';
        return false;

    }

    /**
     * 用户手机快速注册
     * author Fox
     */
public function userTelRegiste( $param){
    $user['user_tel'] = $param;
    $user['password'] = md5(substr($param,3,8));
    $user['is_active'] = '激活';
    $user['username'] = substr(md5(time()),16,4).date('ymd').substr($param,6,4);
    return $this->add($user);
}

    /**
     * 获取一条数据
     * author Fox
     */
    public function  getOneData($param){
        if (is_array($param)){
            return $this->where($param)->find();
        }
        return $this->find($param);
    }

    /**
     * 修改密码
     * @param $param
     * author Fox
     */
    public function userUpdPwd($param){
        if ($param['pwd'] == $param['pwd2']){
           return  $this->where(['user_tel'=>$param['phone']])->save(['password'=>md5($param['pwd'])]);
        }

    }

    /**
     * 用户验证通过 发送激活邮件  写入数据库
     * author Fox
     */
    public function adduser(array $param){
        $param['password'] = MD5($param['password']);
        $newUser = $this->add($param);
        if($newUser){
            //生成激码
            $activeCode = date('YmdHis').substr(md5(time()),10,6).substr(md5($param['username']),10,6);
            $data['user_id']=$newUser;
            $data['active_code']=$activeCode;
            $data['rig_time']=time();
            $data['user_email']=$param['user_email'];
            if (M('UserActive')->add($data)){
                $title='大神商城激活邮件';
                $content = "欢迎注册大神商城,请在两小时内点击激活 http://www.tpshop.com/index.php/Home/user/userActive/id/".$newUser."/activeCode/".$activeCode;
                if(sendMail($title, $content, $param['user_email'])){
                    return true;
                }
                $this->error='激活邮件发送失败,请与管理员联系';
                return false;
            }
            $this->error='系统错误,请与管理员联系';
            return false;

        }
            $this->error='系统错误,请与管理员联系';
            return false;

    }
}