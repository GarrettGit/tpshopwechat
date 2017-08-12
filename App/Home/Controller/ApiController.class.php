<?php
namespace Home\Controller;

use Think\Controller;
/**
 * Created by PhpStorm.
 * ApiController.class.php
 * author: Terry
 * Date: 2017/7/15
 * Time: 14:16
 * description:
 */

class  ApiController extends  Controller {


    public function  getWeather($city){
        $url = 'http://api.map.baidu.com/telematics/v2/weather?location='.$city.'&ak=B8aced94da0b345579f481a1294c9094';
        $weatherInfo = request($url);
//        $weather =  simplexml_load_string($weatherInfo);
        var_dump($weatherInfo);
    }



    public  function  getPhone($phone){
        $url='http://cx.shouji.360.cn/phonearea.php?number='.$phone;
        $phoneInfo = request($url);
        $Info=json_decode($phoneInfo,true);

       echo  "手机号号码:$phone<br/>";
        echo " 归属地:".$Info['data']['province']. $Info['data']['city']."<br/>";
         echo "运营商:".$Info['data']['sp']."<br/>";


    }

    /**
     * @getUser 获取用户信息
     *
     * @param string $uid 用户id
     * @param string $username 用户名
     * @param string $user_email 用户邮箱
     * @param        $user_tel 用户手机号
     *
     * @author : Terry
     * @return
     */
    public  function  getUser(){

        $uid= I('get.uid');
        $username= I('get.username');
        $user =   D('User');
        //判断参数是否为空
        if (empty($uid) && empty($username)){
            $this->ajaxReturn(['code'=>202,'message'=>"缺少必要参数"]);
        }
        //如果用户id不为空
        if (!empty($uid)){
           $userInfo =  $user->where(['user_id'=>$uid])->find();
            $this->ajaxReturn(['code'=>200,'message'=>$userInfo]);
        }
        //如果用户id不为空
        if (!empty($username)){
            $userInfo =  $user->where(['username'=>$username])->find();
            $this->ajaxReturn(['code'=>200,'message'=>$userInfo]);
        }


    }

}