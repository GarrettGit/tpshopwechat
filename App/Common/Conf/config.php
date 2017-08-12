<?php
return array(
	//'配置项'=>'配置值'

    //在页面底部显示跟踪信息
//    'SHOW_PAGE_TRACE'=>true,
    'PLUGIN_URL'=>'/App/Common/Plugin',
    //数据库配置
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '101.200.160.169', // 服务器地址
//    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'tpshop',          // 数据库名
    'DB_USER'               =>  'study',      // 用户名
    'DB_PWD'                =>  'zhangxiaorui',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8


    //短信验证码
    'SHORTMES_NEM' => [
        'BEGIN'  => '1000',
        'END' => '9999',
    ],
    //短信主帐号,对应开官网发者主账号下的 ACCOUNT SID
    'ACCOUNT_SID'=> '8aaf070857acf7a70157cb0a1a1a1b5d',
    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    'AUTH_TOKEN'=> 'e94e91fc0da1445a9b79cb110d298679',
    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    'APP_ID'=>'8aaf070857acf7a70157cb0a1c791b64',
    //redis
//    'REDIS_HOST'=>'192.168.91.132',
    'REDIS_HOST'=>'101.200.160.169',
    'REDIS_PORT'=>6379,
    //微博appkey
    'WB_AKEY'=>'819555918',
    'SITE'=>'http://www.ihelp365.com',
    'WB_SKEY'=>'b0807626ece3798b4c8ff778fbb67241',




);
