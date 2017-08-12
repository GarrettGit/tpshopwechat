<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员</title>
  <script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/Public/resources/layer/layer.js"></script>
<style type="text/css">
<!--
body {
  margin-left: 3px;
  margin-top: 0px;
  margin-right: 3px;
  margin-bottom: 0px;
}
.STYLE1 {
  color: #e1e2e3;
  font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
  color: #344b50;
  font-size: 12px;
}
.STYLE21 {
  font-size: 12px;
  color: #3b6375;
}
.STYLE22 {
  font-size: 12px;
  color: #295568;
}
a:link{
  color:#e1e2e3; text-decoration:none;
}
a:visited{
  color:#e1e2e3; text-decoration:none;
}
-->
</style>
<script type="text/javascript"  src="/Public/resources/jquery-1.8.2.min.js"></script>
</head>

<body>
  <style type="text/css">
    #tabbar-div {
      background: #80bdcb none repeat scroll 0 0;
      height: 22px;
      padding-left: 10px;
      padding-top: 1px;
      margin-bottom: 3px;
    }
    #tabbar-div p { margin: 2px 0 0;font-size:12px;
    }
    .tab-front {
      background: #bbdde5 none repeat scroll 0 0;
      border-right: 2px solid #278296;
      cursor: pointer;
      font-weight: bold;
      line-height: 20px;
      padding: 4px 15px 4px 18px;
    }
    .tab-back {
      border-right: 1px solid #fff;
      color: #fff; cursor: pointer;line-height: 20px;
      padding: 4px 15px 4px 18px;
    }
  </style>
  <script type="text/javascript">
  </script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo C('AD_IMG_URL');?>tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 管理员管理 -> 修改管理员</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
            <a href="<?php echo U('showlist');?>">返回</a>   &nbsp; </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td>
      <form action="" method="post" enctype="multipart/form-data">
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="general-tab-show" >
        <tr>
          <input type="hidden" name="mg_id" value="<?php echo ($manInfo["mg_id"]); ?>" id='mg_id'>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
          <div align="right">
          <span class="STYLE19">管理员名称：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="mg_name" id="mg_name"  value="<?php echo ($manInfo["mg_name"]); ?>"/>
        </div></td>
        </tr>
        <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right">
          <span class="STYLE19">管理员密码：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="password" name="mg_pwd" id="mg_pwd" value=""/>
        </div></td></tr>
        <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right">
          <span class="STYLE19">确认密码：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="password" name="mg_passwd" id="mg_passwd" value=""/>
        </div></td
      </tr>
        <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
          <div align="right">
            <span class="STYLE19">职位：</span>
          </div>
        </td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <select name="role_id" id="role_id" >
          <?php if(is_array($roleInfo)): foreach($roleInfo as $key=>$role): if($role['role_id'] == $manInfo['role_id']): ?><option value="<?php echo ($role["role_id"]); ?>" selected="selected" ><?php echo ($role["role_name"]); ?></option>
              <?php else: ?>
              <option value="<?php echo ($role["role_id"]); ?>" ><?php echo ($role["role_name"]); ?></option><?php endif; endforeach; endif; ?>
        </select>
        </div>
        </td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce"
      <tr>
        <td colspan='100'  bgcolor="#FFFFFF"  class="STYLE6" style="text-align:center;">
        <input type="button" value="修改" id="man" />
        </td>
      </tr>
  
    </table>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
  $(function () {
      $('#man').click(function () {
          var manInfo = {
              mg_name :$('#mg_name').val(),
              mg_pwd  :$('#mg_pwd').val(),
              role_id :$('#role_id').val(),
              mg_id :$('#mg_id').val(),
          }
          console.log(manInfo);
          $.ajax({
              url:"<?php echo U('updMan');?>",
              data:manInfo,
             dataType:'json',
             type:'post',
             success:function (msg) {
                 if(msg.status ==200){
                    layer.msg(msg.message);
                    setTimeout( 'window.location.href="<?php echo U('showlist');?>"',3000);
                 }else if(msg.status ==202){
                     layer.msg(msg.message);
                 }
             }
          })
      })

      //密码校验
      $('#mg_passwd').blur(function () {
          var pwd    =  $('#mg_pwd').val();
          var passwd =  $('#mg_passwd').val();
          if(pwd!='' || passwd!='' ){
              if(pwd !==passwd){
                  layer.msg('两次密码不一致！');
                  $('#man').attr('disabled',"true");
              }else{
                  $('#man').removeAttr("disabled")
              }
          }
          
      })
     
  })
</script>