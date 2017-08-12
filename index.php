<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./App/');
//设置session 存入memcache
//ini_set("session.save_handler","memcache");
//ini_set("session.save_path","tcp://localhost:9880");
//初始化缓存



// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单

//设置session过期时间
//session.cookie_lifetime：SessionID在客户端Cookie储存的时间，默认是0，代表浏览器一关闭SessionID就作废;
//ini_set ( 'session.cookie_lifetime', 7200 );
//session.gc_maxlifetime：Session数据在服务器端储存的时间，如果超过这个时间，那么Session数据就自动删除,默认1440 24分钟;
//ini_set ( 'session.gc_maxlifetime', 7200 );