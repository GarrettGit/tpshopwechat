<?php
namespace WeChat\Controller;
use Common\Common\oAuth;
use Think\Controller;

class WechatApiController extends WechatBaseApiController {
    private  $create_menuUrl   = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=";
    private  $delete_menuUrl   = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=";
    private  $send_group_message_url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=";
    private  $send_message_url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=";
    private  $get_users_url    = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=";
    private  $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=";
    private  $wechat_oauth_callback ='/index.php/WeChat/WechatApi/wechatOauthCallback';
    private  $wecha_oauth_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
    private $authorization_code_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
    private  $ger_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=%&openid=%s&lang=zh_CN ";

    /**
     * @WechatServerConnect 微信接入
     * @author : Terry
     * @return
     */
    public function WechatServerConnect()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }

    }

    /**
     * @checkSignature 微信接入
     * @author : Terry
     * @return
     */
    private function checkSignature()
    {

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = C('TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @CustomizeMenu 自定义菜单
      * @author : Terry
     * @return
     */
    public function customizeMenu(){
//        $menuUrl= "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".S('access_token');

//      $data=' {
//     "button":[
//     {
//          "type":"click",
//          "name":"今日歌曲",
//          "key":"V1001_TODAY_MUSIC"
//      },
//      {
//           "name":"菜单",
//           "sub_button":[
//           {
//               "type":"view",
//               "name":"搜索",
//               "url":"http://www.soso.com/"
//            },
//            {
//                 "type":"miniprogram",
//                 "name":"wxa",
//                 "url":"http://mp.weixin.qq.com",
//                 "appid":'.C('APPID').',
//                 "pagepath":"pages/lunar/index"
//             },
//            {
//               "type":"click",
//               "name":"赞一下我们",
//               "key":"V1001_GOOD"
//            }]
//       }]
// }';


  $data =  '{
            "button":[{
            "name":"京西商城",
            "sub_button":[
                {
                    "type":"view",
                    "name":"商品列表",
                    "url":"http://ihelp365.com/index.php/Home/Goods/showlist"
                },{
                    "type":"view",
                    "name":"今日秒杀",
                    "url":"http://ihelp365.com/index.php/Home/Seckill/SeckillList"
                }]
            },{
            "type":"click",
            "name":"轻松一下",
            "key" :"V1001_TODAY_MUSIC"
            }
            ]}';
        $menuStatus =  json_decode(request($this->create_menuUrl.S('access_token'),true,'',$data),true);
        if ($menuStatus['errmsg'] =='ok'){
            $this->ajaxReturn(['status'=>200,'message'=>'生成菜单成功']);
        }elseif ($menuStatus['errmsg'] !='ok'){
            $this->ajaxReturn(['status'=>200,'message'=>'生成菜单失败,错误原因:'.$menuStatus['errmsg']]);
        }

    }

        /**
         * @delmenu 删除自定义接口
         * @author : Terry
         * @return
         */
    public function  delmenu()
        {
//            $menuUrl    = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . S('access_token');
            $menuStatus = json_decode(request($this->delete_menuUrl, false), true);
            if ($menuStatus['errmsg'] == 'ok') {
                $this->ajaxReturn(['status' => 200, 'message' => '删除菜单成功']);
            } elseif ($menuStatus['errmsg'] != 'ok') {
                $this->ajaxReturn(['status' => 200, 'message' => '删除菜单失败,错误原因:' . $menuStatus['errmsg']]);
            }
        }

    /**
     * @sendMessage     群发消息 同意内容消息只能发一次 第二次报错
     * @author : Terry
     * @return
     */
    public function  sendGroupMessage($openid='',$msgContent){
          $userOpenIds  = M('WechatUsers')->field('openid')->select();
          $openIds = array_column($userOpenIds,'openid');
          $sendInfo['touser']   =  array($openIds);
          $sendInfo['msgtype']  =   'text';
          $sendInfo['text']     =   ['content'=>urlencode($msgContent)];
          $sendInfo             =   json_encode($sendInfo);
//        $sendInfo             =   urldecode(json_encode($sendInfo));
        file_put_contents('./App/WeChat/Controller/wechat.log', '客服消息:'.date('Y-m-d H:i:s').$sendInfo, FILE_APPEND);
          $sendResult           =   json_decode(request($this->send_group_message_url.S('access_token'),true,'post',$sendInfo),true);
                if ($sendResult['errcode'] == 0){
                    $this->ajaxReturn(['status'=>200,'message'=>'发送消息成功!']);
                }else{
                //日志
                file_put_contents('./App/WeChat/Controller/wechat.log', '客服消息:'.date('Y-m-d H:i:s').json_encode($sendResult), FILE_APPEND);
            $this->ajaxReturn(['status'=>202,'message'=>'发送消息失败!']);
        }
    }

    /**
     * @sendMessage 客服消息
     *
     * @param string $openid
     * @param        $msgContent
     *
     * @author : Terry
     * @return
     */
    public function  sendMessage($openid,$msgContent){
        $sendInfo['touser']   =  $openid;
        $sendInfo['msgtype']  =   'text';
        $sendInfo['text']     =   ['content'=>urlencode($msgContent)];
        $sendInfo             =   urldecode(json_encode($sendInfo));
        $sendResult           =   json_decode(request($this->send_message_url.S('access_token'),true,'post',$sendInfo),true);
        if ($sendResult['errcode'] == 0){
            $this->ajaxReturn(['status'=>200,'message'=>'发送消息成功!']);
        }else{
            //日志
            file_put_contents('./App/WeChat/Controller/wechat.log', '客服消息:'.date('Y-m-d H:i:s').json_encode($sendResult), FILE_APPEND);
            $this->ajaxReturn(['status'=>202,'message'=>'发送消息失败!']);
        }
    }
    /**
     * @getWechatUsers 获取关注用户
     * @author : Terry
     * @return
     */
    public function getWechatUsers()
    {
        $wechatUsers = M('WechatUsers');
        $next_openid = '';
        $lastOpenid  = $wechatUsers->order('id desc')->find();
        if ($lastOpenid) {
            $next_openid = '&next_openid=' .$lastOpenid['openid'];
        }
        $get_users_url = $this->get_users_url . S('access_token') . $next_openid;
        $wechatUsersList   = json_decode(request($get_users_url, false), true);
        if ($wechatUsersList) {
            foreach ($wechatUsersList['data']['openid'] as $k => $openid) {
                $get_user_info_url = $this->get_user_info_url . S('access_token') . '&openid=' . $openid . '&lang=zh_CN';
                $wechatUserInfo    = json_decode(request($get_user_info_url, false), true);
                $data['openid']    = $openid;
                $data['username']  = $wechatUserInfo['nickname'];
                $data['user_pic']  = $wechatUserInfo['headimgurl'];
                $wechatUsers->add($data);


            }

        }
    }

    /**
     * @wechatOauthCallback 微信oauth回调函数
     * @author : Terry
     * @return
     */
    public function wechatOauthCallback(){
        $code = I('get.code');
        if (isset($code)){
            //替换appid secret
            $authorization_code_url =   sprintf($this->authorization_code_url, C('APPID'),C('APPSECRET'),$code);
            var_dump($authorization_code_url);
            //获取授权token
            $oAuthAccessToken=json_decode(request($authorization_code_url,false));
            var_dump($oAuthAccessToken);
            //替换openid oAuthAccessToken
            $ger_user_info_url =   sprintf($this->ger_user_info_url, $oAuthAccessToken->access_token,$oAuthAccessToken->openid);
            $userInfo=request($ger_user_info_url,false);

    var_dump($userInfo);
        }


        $this->display();
    }

    public function testOauth(){
        $wecha_oauth_url = sprintf($this->wecha_oauth_url, C('APPID'),C('APPSECRET').$this->wechat_oauth_callback);
        $this->sendMessage('oA6UWw8KX9gttuVYY_RpoCRr1K1s',$wecha_oauth_url );
//        var_dump($wecha_oauth_url);exit();
        $this->sendMessage();
    }














}
