<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Skiyo 后台管理工作平台 by Jessica</title>
<link rel="stylesheet" type="text/css" href="/Public/resources/admin/css/style.css"/>
<script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/Public/resources/admin/js/js.js"></script>

</head>
<body>
<div id="top">  </div>
<form id="login" name="login" action="" method="post">
  <div id="center">
    <div id="center_left"></div>
    <div id="center_middle">
      <div class="user">
        <label>用户名：
        <input type="text" name="manager_name" id="user" />
        </label>
      </div>
      <div class="user">
        <label>密　码：
        <input type="password" name="manager_pwd" id="pwd" />
        </label>
      </div>
      <div class="chknumber">
        <label>验证码：
        <input name="manager_code" type="text" id="manager_code" maxlength="4"  style="vertical-align: middle" class="chknumber_input" />
        </label>
        <img src="<?php echo U('verifyImg');?>" id="safecode" width="57" height="20" onclick="this.src='/index.php/Admin/Manager/verifyImg/'+Math.random()" style="vertical-align: middle"/>
      </div>
    </div>
    <div id="center_middle_right"></div>
    <div id="center_submit">
      <div class="button"> <img src="/Public/resources/admin/images/dl.gif" width="57" height="20" onclick="form_submit()" > </div>
      <div class="button"> <img src="/Public/resources/admin/images/cz.gif" width="57" height="20" onclick="form_reset()"> </div>
    </div>
    <div id="center_right" style="color:red"><?php echo ((isset($errorLogin) && ($errorLogin !== ""))?($errorLogin):''); ?></div>
  </div>
</form>
<div id="footer"></div>
</body>

<script type="text/javascript">
$(function () {
    $('#manager_code').blur(function () {
        var manager_code = $('#manager_code').val();
            $.ajax({
                url:"<?php echo U('checkVerifyCode');?>",
                type:'post',
                data:{'manager_code':manager_code},
                dataType:'json',
                success:function(msg) {
                    if(msg.status == 200){
                        $('#manager_code').css({"border":"solid" ,'color':'#153966'});
                    }else if(msg.status == 202){
                        $('#manager_code').css({"border":"solid" ,"color":"#ff0000"});
                        $('#safecode').attr('src',"/index.php/Admin/Manager/verifyImg/"+Math.random());
                    }
                }

            })
        
    })
    
})
  
</script>
</html>