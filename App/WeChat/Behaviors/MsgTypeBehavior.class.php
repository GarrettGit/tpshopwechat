<?php
/**
 * Created by PhpStorm.
 * msgTypeController.class.php
 * author: Terry
 * Date: 2017/8/2
 * Time: 9:31
 * description:
 */
 namespace WeChat\Behaviors;
 use Think\Behavior;

 class MsgTypeBehavior extends Behavior {

     /**
      * @responseMsg 消息类型判断
      * @author : Terry
      * @return
      */
     public function run(&$param)
     {
         //get post data, May be due to the different environments
         // 部分环境禁用了$GLOBALS 可用 $postStr = file_get_contents("php://input");代替
        // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
         $postStr = file_get_contents("php://input");
//         file_put_contents('./App/WeChat/Controller/wechat.log', $postStr, FILE_APPEND);
         //extract post data
         if (!empty($postStr)){
             /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                the best way is to check the validity of xml by yourself */
             libxml_disable_entity_loader(true);
             $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
             $fromUsername = $postObj->FromUserName;
             $toUsername = $postObj->ToUserName;
             $keyword = trim($postObj->Content);
             $time = time();
             switch($postObj->MsgType) {
                 case 'text':
                     if($keyword == '图片') {
                         //定义相关变量
                         $msgType = "image";
                         $msgTypeTemp = $this->checkMsgType($msgType);
                         //定义mediaid
                         $mediaid = 'QSr4OC7U1zt7zvpe7e_6Od_HRNzJ9DcNadZvNhK3cCSqDYtYbgZlr5p8Eslso61a';
                         //使用sprintf函数格式化XML文档
                         $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $mediaid);
                         //返回格式化后的XML数据
                         echo $resultStr;
                     } elseif($keyword == '音乐') {
                         $this->music($fromUsername, $toUsername, $time);
                     } elseif($keyword == '秒杀') {
                         //秒杀单文本
                         $this->seckillNwe($fromUsername, $toUsername, $time);
                     } elseif($keyword == '多图文') {
                         //定义相关变量
                         $msgType = "news";
                         $msgTypeTemp = $this->checkMsgType($msgType);
                         //定义图文数量
                         $count = 2;
                         //定制$str(item选项）
                         $str = '<item>
                                    <Title><![CDATA[最实用的47个让你拍照好看的方法]]></Title> 
                                    <Description><![CDATA[怎样拍照好看?有个会拍照的男朋友是怎么样的体验?怎么样把女朋友拍得漂亮...]]></Description>
                                    <PicUrl><![CDATA[http://www.58bug.com/images/1.jpg]]></PicUrl>
                                    <Url><![CDATA[http://www.58bug.com/]]></Url>
                                    </item>
				                    <item>
                                    <Title><![CDATA[台湾水果种类大全有哪些是你不容错过的？]]></Title> 
                                    <Description><![CDATA[台湾一直被称为“水果王国”，这里冬季温暖，夏季炎热，光照充足...]]></Description>
                                    <PicUrl><![CDATA[http://www.58bug.com/images/2.jpg]]></PicUrl>
                                    <Url><![CDATA[http://www.58bug.com/]]></Url>
                                    </item>
				                   ';
                         //使用sprintf函数对XML模板进行格式化
                         $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $count, $str);
                         //返回格式化后的XML数据到客户端
                         echo $resultStr;
                     }else{
                         $msgType = "text";
                         $msgTypeTemp = $this->checkMsgType($msgType);
                         $contentStr = "https://www.wosign.com/Root/index.htm";
                         $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                         echo $resultStr;
                         break;
                     }
                     break;
                 case 'image':
                     $msgType = "text";
                     $msgTypeTemp = $this->checkMsgType($msgType);
                     $contentStr = "您发送的是图片消息！";
                     $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                     echo $resultStr;
                     break;
                 case 'voice':
                    $this->sendVoice($fromUsername, $toUsername, $time,$postObj->Recognition);
                     break;
                 case 'event':
                     if($postObj->Event == 'subscribe') {
                         $msgType = "text";
                         $msgTypeTemp = $this->checkMsgType($msgType);
                         $contentStr = "Terry测试号！";
                         $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                         //日志
                         file_put_contents('./App/WeChat/Controller/wechat.log', $resultStr, FILE_APPEND);
                         echo $resultStr;
                     }
                     //判断单击按钮的事件推送
                     if($postObj->Event == 'CLICK' && $postObj->EventKey == 'V1001_TODAY_MUSIC') {
                         $this->music($fromUsername, $toUsername, $time);
                     }


                     break;
             }
         }else {
             echo "";
         }
     }

     /**
      * @checkMsgType 判断数据类型返回模板信息
      *
      * @param $param 数据类型
      *
      * @author : Terry
      * @return 模板string
      */
    protected  function  checkMsgType($param){
        S(['type'=>'redis','host'=>C('REDIS_HOST'),'port'=>C('REDIS_PORT')]);
         if (empty(S($param))){
             $msgType= M('WechatMsgtype')->where(['msg_type'=>"$param"])->find();
             S($msgType['msg_type'],$msgType['content']);
             return $msgType['content'];
             }
            return S($param);

    }

     /**
      * @seckillNwe 秒杀单文本
      * @author : Terry`
      * @return
      */
     protected function  seckillNwe($fromUsername, $toUsername, $time){
        //定义相关的变量
        $msgType = "news";
        $msgTypeTemp = $this->checkMsgType($msgType);
        $count = 1;
        $goods =  M('WechatSeckill')->order('id desc')->find();
         $str = "<item>
        <Title><![CDATA[{$goods['title']}]]></Title>
        <Description><![CDATA[{$goods['description']}]]></Description>
        <PicUrl><![CDATA[{$goods['pic_uri']}]]></PicUrl>
        <Url><![CDATA[{$goods['goods_uri']}]]></Url>
        </item>";
        //使用sprintf函数对XML模板进行格式化
        $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $count, $str);
        //返回格式化后的XML数据到客户端
        echo $resultStr;
    }

     /**
      * @music 音乐
      *
      * @param $fromUsername
      * @param $toUsername
      * @param $time
      *
      * @author : Terry
      * @return
      */
    private  function  music($fromUsername, $toUsername, $time){
        //定义相关的变量
        $msgType = "music";
        $msgTypeTemp = $this->checkMsgType($msgType);
        //定义与音乐相关的变量信息
        $title = 'The truth that you leave';
        $description = 'The truth that you leave';
        $url = C('SITE').'/Public/Pianoboy-TheTruthThatYouLeave.mp3';
        $hqurl = C('SITE').'/Public/Pianoboy-TheTruthThatYouLeave.mp3';
        //使用sprintf函数对music模板进行格式化
        $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $title, $description, $url, $hqurl);
        //返回格式化后的XML数据到客户端
        echo $resultStr;

    }

    private  function  sendVoice($fromUsername, $toUsername, $time,$voiceInfo){
        $tulingUrl = "http://www.tuling123.com/openapi/api";
        $tulingData=json_encode(['key'=>'a6382e6f708a9480a594d8a178b5be58',
                     'info'=>$voiceInfo,
                     'userid'=>'1234567'
                    ]);
       $voiceResult =  json_decode(request($tulingUrl,false,'post',$tulingData,true),true);
        $msgType = "text";
        $msgTypeTemp = $this->checkMsgType($msgType);
        $contentStr = $voiceResult['text'];
        $resultStr = sprintf($msgTypeTemp, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;


    }




 }