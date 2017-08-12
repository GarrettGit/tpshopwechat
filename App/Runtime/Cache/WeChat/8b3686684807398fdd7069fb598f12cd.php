<?php if (!defined('THINK_PATH')) exit();?>﻿<?php
 if(isset($_GET['code'])) { echo $_GET['code']; } else { echo 'No Code'; } exit; ?>
<!doctype html>
<html lang="en">
<head>
<title>微信账号绑定</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="wx_css/css/yinxiao.css" rel="stylesheet" type="text/css" />
<script src="wx_css/js/jquery.min.js"></script>
</head>
<body>
<link href="wx_css/index/css/head.css" rel="stylesheet" type="text/css">
<div id="ui-header">
  <div class="fixed top-bghead1"> <a class="ui-title" id="popmenu1">微信账号绑定</a> <a class="ui-btn-left_pre" href="javascript:;" onclick="history.go('-1');"></a> <a class="ui-btn-right" href="javascript:;" onclick="location.reload();"></a> </div>
</div>
<div style="height:46px;"></div>
<div data-role="page" >
  <div data-role="content">
    <div class="wtg">
      <div class="ddxx">用户信息</div>
      <form id="appTuanForm">
        <div class="ddxxxq">
          <div class="bdbm">
            <div class="ddnm">昵称：</div>
            <div class="srk">
              <input type="text" name="nickname" value="" />
            </div>
          </div>
          <div class="bdbm">
            <div class="ddnm">性别：</div>
            <div class="srk">
              <input type="text" name="sex" value="" />
            </div>
          </div>
          <div class="bdbm">
            <div class="ddnm">地址：</div>
            <div class="srk">
              <input type="text" name="address" value="" />
            </div>
          </div>
          <div class="bdbm">
            <div class="ddnm">签名：</div>
            <div class="srk">
              <input type="text" name="signature" value="这家伙很懒，啥都没有留下..." />
            </div>
          </div>
        </div>
      </form>
      <div class="fhtj">
        <div class="submit"><a href="javascript:;">绑定账号</a></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>