<?php
/**
 * Created by PhpStorm.
 * WechatBaseController.class.php 微信平台手机端基础控制器
 * author: Terry
 * Date: 2017/8/5
 * Time: 00:40
 * description:
 */

namespace WeChat\Controller;
use Think\Controller;

class  WechatBaseApiController extends Controller{
    public function  __construct()
    {
        parent::__construct();
        //初始化缓存
        S(['type'=>'redis','host'=>C('REDIS_HOST'),'port'=>C('REDIS_PORT')]);
        //获取access_token
        //若token失效则从新获取
        if (!S('access_token')){
            $accessTokenInfo = $this->getAccessToken();
            $accessTokenInfo = json_decode($accessTokenInfo,true);
            S('access_token',$accessTokenInfo['access_token'],(int)$accessTokenInfo['expires_in']);
        }
//        //获取回复信息
//        //Thinkphp行为监听
//        //注册行为                  key         wenjian
        \Think\Hook::add('wechat_msgType','WeChat\\Behaviors\\MsgTypeBehavior');
        //监听行为
        \Think\Hook::listen('wechat_msgType');




    }


    /**
     * @getAccessToken 获取微信唯一票据accessToken
     * @author : Terry
     * @return
     */
    private function  getAccessToken(){
        $tokenUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.C('APPID').'&secret='.C('APPSECRET');
        return request($tokenUrl,ture);
    }
}