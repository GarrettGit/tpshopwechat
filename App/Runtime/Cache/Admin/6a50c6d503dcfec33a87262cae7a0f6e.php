<?php if (!defined('THINK_PATH')) exit();?>﻿<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src="/Public/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/resources/admin/js/chili-1.7.pack.js"></script>
<script type="text/javascript" src="/Public/resources/admin/js/jquery.easing.js"></script>
<script type="text/javascript" src="/Public/resources/admin/js/jquery.dimensions.js"></script>
<script type="text/javascript" src="/Public/resources/admin/js/jquery.accordion.js"></script>
<script language="javascript">
	jQuery().ready(function(){ 
		jQuery('#navigation').accordion({
			header: '.head',
			navigation1: true, 
			event: 'click',
			fillSpace: true,
			animated: 'bounceslide'
		});
	});
</script>
<style type="text/css">
<!--
body {
	margin:0px;
	padding:0px;
	font-size: 12px;
}
#navigation {
	margin:0px;
	padding:0px;
	width:147px;
}
#navigation a.head {
	cursor:pointer;
	background:url(/Public/resources/admin/images/main_34.gif) no-repeat scroll;
	display:block;
	font-weight:bold;
	margin:0px;
	padding:5px 0 5px;
	text-align:center;
	font-size:12px;
	text-decoration:none;
}
#navigation ul {
	border-width:0px;
	margin:0px;
	padding:0px;
	text-indent:0px;
}
#navigation li {
	list-style:none; display:inline;
}
#navigation li li a {
	display:block;
	font-size:12px;
	text-decoration: none;
	text-align:center;
	padding:3px;
}
#navigation li li a:hover {
	background:url(/Public/resources/admin/images/tab_bg.gif) repeat-x;
		border:solid 1px #adb9c2;
}
a:link{
    color:#036;
}
-->
</style>
</head>
<body>
<div  style="height:100%;">
  <ul id="navigation">
    <?php if(is_array($authInfoP)): foreach($authInfoP as $key=>$p): ?><li> <a class="head"><?php echo ($p["auth_name"]); ?></a>
      <ul>
          <?php if(is_array($authInfoS)): foreach($authInfoS as $key=>$s): if(($s["auth_pid"]) == $p["auth_id"]): ?><li>
            <a href="/index.php/Admin/<?php echo ($s["auth_c"]); ?>/<?php echo ($s["auth_a"]); ?>" target="rightFrame"><?php echo ($s["auth_name"]); ?></a>
          </li><?php endif; endforeach; endif; ?>
      </ul>
    </li><?php endforeach; endif; ?>
  </ul>
</div>
</body>
</html>