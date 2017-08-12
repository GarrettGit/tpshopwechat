<?php
namespace Admin\Controller;

use Admin\Common\AdminController;

/**
 * Created by PhpStorm.
 * ExtensionController.class.php  推广平台
 * author: Terry
 * Date: 2017/7/3
 * Time: 20:02
 * description:
 */

class ExtensionController extends AdminController{
    
    
    protected $reids;
    public  function __construct()
    {
        parent::__construct();
        //实例化redis
        $this->redis = new \Redis();
        $this->redis->connect(C('REDIS_HOST'),C('REDIS_PORT'));
    }
    

    /**
     * @emailExtension 邮件推广
     * @author : Terry
     * @return
     */
    public function emailExtension(){
        if (IS_POST && IS_AJAX){
                //设置php运行时间为最大
                set_time_limit(0);
                $ext_id = I('post.ext_id',2);
                //根据id获取推广信息
                $extInfo = D('extension')->getOneData($ext_id);
                //根据推广基数查询用户 2000
                $userData = D('user')->getUser($extInfo['ext_number']);
                $salt=md5(time());
                //构建list Key值
                $listName = 'mailList'.$salt;
                //将用户邮箱写入list
                for ( $i=0; $i<count($userData);$i++){
                    //把用户id拼接邮箱写list
                    $writeInfo = $userData[$i]['user_id'].'#'.trim($userData[$i]['user_email']);
                    //将用户名及邮箱写入list
                    $this->redis->lPush($listName,$writeInfo);
                    //判断用户是否填写邮箱,如果未填写则发送失败
                        if(empty($userData[$i]['user_email'])){
                            $this->redis->SADD('failSendKey'.$salt,$userData[$i]['user_id']);
                        }
                }
                //统计list中用户邮箱数量
                $lLen = $this->redis->Llen($listName);
                //发送邮件
               for ( $i=1; $i<=$lLen;$i++){
                   $mailInfo = $this->redis->lPop($listName);
                   $sendInfo=explode('#',$mailInfo);//array[0]//array[1]
                    $url= $extInfo['ext_url'];
                   $msghtml="<a href='$url'>".$extInfo['ext_introduce']."</a>";
                   //判断用户是否设置邮箱
                   if (!empty($sendInfo[1])){
                       $sendState =  sendMail($extInfo['ext_title'],$msghtml,$sendInfo[1]);
                       if ($sendState){
                           $this->redis->SADD('successSendKey'.$salt,$sendInfo[0]);
                       }else{
                           $this->redis->SADD('failSendKey'.$salt,$sendInfo[0]);
                       }
                       usleep(80000); //1:1000000
                   }
                   //当队列最后一个userid与之前存入的第一位用户id相同时调用
                   if ($sendInfo[0] == $userData[0]['user_id']){
                       if ($result = $this->getSetInfo($ext_id,$salt)){
                           //为数据设置12小时生命周期
                       $this->redis->set($extInfo['ext_title'],$salt);
                       $this->redis->expire($extInfo['ext_title'],(3600*12));
                       $this->redis->expire('successSendKey'.$salt,(3600*12));
                       $this->redis->expire('failSendKey'.$salt,(3600*12));
                           exit(json_encode(['state'=>200,'message'=>'推广信息发送完毕,成功'.$result[success_number].'条,失败'.$result[fail_number].'条']));
                       }else{
                           exit(json_encode(['state'=>202,'message'=>'发送结果异常,请在12小时内与开发人员联系,避免数据丢失']));
                       }
                   }
                }
        }
    }
                //获取集合中数据 写入数据库
                private  function getSetInfo($ext_id,$salt){
                        $data['id']=$ext_id;
                        $data['success_number'] = $this->redis->Scard('successSendKey'.$salt);
                        $data['fail_number'] = $this->redis->Scard('failSendKey'.$salt);
                        $data['flag'] = 1;
                        if (D('extension')->save($data)){
                            return $data;
                        }
                        return false;
                }

    /**
     * @showlist 推广记录列表
     * @author : Terry
     * @return
     */
    public function  showlist(){
        $extData = D('extension')->search();
        $this->assign('extData',$extData);
        $this->display();
    }

    /**
     * @addExtension 添加推广信息
     * @author : Terry
     * @return
     */
    public  function addExtension(){
          $extension=D('extension');
        if (IS_POST){
            if($extension->create()){
                if ($extension->add()){
                    $this->success('添加成功',U('showlist'),2);
                }
                $this->error('添加失败,请与管理员联系');
            }else{
                $this->assign('errorInfo',$extension->getError());
            }
        }
            $this->display();
    }

    /**
     * @delExtension
     * @author : Terry
     * @return
     */
    public function delExtension(){

        if (D('Extension')->delExt(I('post.ext_id'))){
            exit(json_encode(['state'=>200,'message'=>'删除成功 ']));
        }
        exit(json_encode(['state'=>200,'message'=>'删除失败 ']));

    }

    /**
     * @updExtension 修改推广信息
     * @author : Terry
     * @return
     */
    public function updExtension($ext_id){
       $extension =  D('Extension');
        if (IS_POST){
            $extData = I('post.');
            if (session('ext_id') ==$extData['id']){
                if($extension->save($extData)){
                    $this->success('修改成功',U('showlist'),2);
                }
                $this->error('修改失败',U('showlist'),2);
            }


        }else{
            session('ext_id',$ext_id);
           $extData =$extension->getOneData($ext_id);
           if ($extData['flag']==1){
               $this->error('该推广已结束,禁止修改',U('showlist'),2);
           }
           $this->assign('extData',$extData);
            $this->display();
        }

    }
}