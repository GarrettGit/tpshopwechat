<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/Public/resources/layer/layer.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>角色列表</title>
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
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30">
            <form action="" method="" enctype="multipart/form-data">
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="general-tab-show">
      <tr>
       <input type="hidden" name=""  id ='role_id' value="<?php echo ($roleInfo["role_id"]); ?>">
        <td height="20" bgcolor="#FFFFFF" class="STYLE6" width="15%" colspan='2'><div align="left">当前正在给<span style="font-size:25px; color:blue;">【<?php echo ($roleInfo["role_name"]); ?>】</span>角色分配权限</div></td></tr>
      <?php if(is_array($authInfoP)): foreach($authInfoP as $key=>$p): ?><tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6" width="15%"><div align="right"><span class="STYLE19">
          <input type="checkbox" name="auth_id" value="<?php echo ($p["auth_id"]); ?>"   <?php if(in_array(($p["auth_id"]), is_array($roleInfo["role_auth_ids"])?$roleInfo["role_auth_ids"]:explode(',',$roleInfo["role_auth_ids"]))): ?>checked='checked'<?php endif; ?>/><?php echo ($p["auth_name"]); ?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
          <?php if(is_array($authInfoS)): foreach($authInfoS as $key=>$s): if(($s["auth_pid"]) == $p["auth_id"]): ?><div style='width:200px;float:left;'>
              <input type="checkbox" name="auth_id"  value="<?php echo ($s["auth_id"]); ?>"  <?php if(in_array(($s["auth_id"]), is_array($roleInfo["role_auth_ids"])?$roleInfo["role_auth_ids"]:explode(',',$roleInfo["role_auth_ids"]))): ?>checked='checked'<?php endif; ?> /><?php echo ($s["auth_name"]); ?></div><?php endif; endforeach; endif; ?>
        </div></td>
      </tr><?php endforeach; endif; ?>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td colspan='100'  bgcolor="#FFFFFF"  class="STYLE6" style="text-align:center;">
        <input type="button" value="分配权限" id="distribute"/>
        </td>
      </tr>
    </table>
      </form></td>
  </tr>
</table>
</body>
<script type="text/javascript">
  $(function () {
      $('#distribute').click(function () {
          //定义数组authId
         var  authId =  new Array()
          //foreach循环所有checkbox
          $('input:checkbox').each(function() {
              //如果选中
              if ($(this).attr('checked')) {
                  //把选中的checkbox追加到数组中
                  authId.push($(this).val());
              }
          })
          //发起ajax请求
         $.ajax({
              url:"<?php echo U('distribute');?>",
             //角色id 和 选择的权限ids
              data:{'roleId':$('#role_id').val(),'authId':authId},
              dataType:'json',
              type:'post',
             success:function (msg) {
                  //如果分配成功 跳回列表页
                  if(msg.status ==200){
                      layer.msg(msg.msg);
                      setTimeout('window.location.href ="<?php echo U('Role/showlist');?>"',2000);
                  }else if(msg.status ==202){
                      layer.msg(msg.msg);
                      setTimeout('window.location.href ="<?php echo U('Role/showlist');?>"',2000);
                  }
             }
          })
      })
  })
</script>
</html>