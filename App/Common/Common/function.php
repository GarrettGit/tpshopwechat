<?php

//对$string内容进行防止xss攻击处理
function PreventXSS($string)
{
//    require_once './App/Common/Plugin/htmlpurifier/HTMLPurifier.auto.php';
    Vendor('htmlpurifier.HTMLPurifier#auto');
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg->set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg->set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj->purify($string);
}


//递归
function generateTree($data){
    $items = array();
    foreach ($data as  $val) {
        $items[$val['auth_id']] = $val;
    }
    $tree =array();
    foreach ($items as $k => $item ){
        if(isset($items[$item ['auth_pid']])){
            $items[$item['auth_pid']]['son'][]=&$items[$k];
        }else{
            $tree[] =&$items[$k];
        }
    }
    return getTreeData($tree);

}

function getTreeData($tree,$level=0){
    static $arr=array();
    foreach ($tree as $t){
        $tmp =$t;
        unset($tmp['son']);
        $tmp['level'] =$level;
        $arr[] = $tmp;
        if (isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}

/**
 * 发送模板短信
 * @param to 手机号码集合,用英文逗号分开
 * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
 * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
 */
//sendSms()
function sendTemplateSMS($to,$datas,$tempId)
{


    //要生成手机验证码，并且存储到session里面
    session_start();
    //随机验证码
    $mesNum = C('SHORTMES_NEM');
    $code = rand($mesNum['BEGIN'],$mesNum['END']);

    //主帐号,对应开官网发者主账号下的 ACCOUNT SID
    $accountSid= C('ACCOUNT_SID');
    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    $accountToken= C('AUTH_TOKEN');
    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    $appId=C('APP_ID');
    //请求地址
    //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
    //生产环境（用户应用上线使用）：app.cloopen.com
    $serverIP='sandboxapp.cloopen.com';
    //请求端口，生产环境和沙盒环境一致
    $serverPort='8883';
    //REST版本号，在官网文档REST介绍中获得。
    $softVersion='2013-12-26';
    vendor('SendShortMes.CCPRestSmsSDK');
    // 初始化REST SDK
    $rest = new REST($serverIP,$serverPort,$softVersion);
    $rest->setAccount($accountSid,$accountToken);
    $rest->setAppId($appId);
    // 发送模板短信
    //aram to 手机号码集合,用英文逗号分开
    //param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
    //param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
    $result = $rest->sendTemplateSMS($to,array($code,3),$tempId);
    if($result == NULL ) {
        return false;
    }
    if($result->statusCode!=0) {
        return false;

    }else{
        session($to.'code',$code);
        return true;

    }

}

//curl类
function request($url, $https = true, $method = 'get', $data = null,$heard=false) {
    //①初始化url
    //url 目标地址
    $ch = curl_init($url);
//    ②设置相关参数
    //字符串不直接输出,进行一个变量储存
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //判断是不是https请求 443
    if ($https === true) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    //判断是不是post请求
    if ($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    }
    if ($heard==true){
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type:application/json',
                'Content-Length:'.strlen($data))
        );

    }
    //③发送请求
    $str = curl_exec($ch);
    //④关闭资源
    curl_close($ch);
    return $str;

}
//mail发送方法
function sendMail($title, $msghtml, $sendAddress) {
    //引入发送类phpmailer.php
    vendor('PHPMailer.phpmailer');
    //实列化对象
    $mail = new PHPMailer();
    /*服务器相关信息*/
    $mail->IsSMTP(); //设置使用SMTP服务器发送
    $mail->SMTPAuth = true; //开启SMTP认证
    $mail->Host = 'smtp.163.com'; //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Username = 'phpztrtest'; //发信人的邮箱用户名
    $mail->Password = 'ztr2012dl'; //发信人的邮箱密码
    /*内容信息*/
    $mail->IsHTML(true); //指定邮件内容格式为：html
    $mail->CharSet = "UTF-8"; //编码
    $mail->From = 'phpztrtest@163.com'; //发件人完整的邮箱名称
    $mail->FromName = "php_ztr"; //发信人署名
    $mail->Subject = $title; //信的标题
    $mail->MsgHTML($msghtml); //发信主体内容
    // $mail->AddAttachment("fish.jpg");      //附件
    /*发送邮件*/
    $mail->AddAddress($sendAddress); //收件人地址
    //使用send函数进行发送
    if ($mail->Send()) {
        //发送成功返回真
        return true;
        // echo '您的邮件已经发送成功！！！';
    } else {
        return $mail->ErrorInfo; //如果发送失败，则返回错误提示
    }


}
