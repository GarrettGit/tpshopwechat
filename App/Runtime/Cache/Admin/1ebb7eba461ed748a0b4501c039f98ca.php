<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/Public/resources/layer/layer.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>会员列表</title>
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
    /*分页样式*/
    .Pagination a:hover,.current{background-color: #f54281;border: 1px solid #f54281;color: #ffffff; }
    .Pagination{float: right;height: auto;_height: 45px; line-height: 20px;margin-right: 15px;_margin-right: 5px; color:#565656;margin-top: 10px;_margin-top: 20px; clear:both;}
    .Pagination a,.Pagination span{ font-size: 14px;text-decoration: none;display: block;float: left;color: #565656;border: 1px solid #ccc;height: 34px;line-height: 34px;margin: 0 2px;width: 34px;text-align: center;}
  </style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="/Public/resources/admin/images/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 用户管理 -> 用户列表</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
            <a href="<?php echo U('exportUser');?>"> <input type="button" value="导出"> </a>
            
            <a href="/index.php/Admin/user/exportUser/page/<?php echo ($_GET['p']); ?>"> <input type="button" value="导出当前页"> </a>  &nbsp;
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
     </td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户ID</span></div></td>
        <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户名</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户邮箱</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">激活状态</span></div></td>
      <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">账户状态</span></div></td>
      <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">手机号</span></div></td>
        <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div></td>
      </tr>
      <?php if(is_array($userInfo)): foreach($userInfo as $key=>$user): ?><tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19" id="id"><?php echo ($user["user_id"]); ?></span></div></td>
        
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($user["username"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($user["user_email"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($user["is_active"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($user["flag"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($user["user_tel"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF">
          <div align="center" class="STYLE21">

          <a class="delAuth"> <img src="/Public/resources/admin/images/del.gif" width="10" height="10" />删除</a>  | <a class="blocked">冻结</a></div></td>
      </tr><?php endforeach; endif; ?>
    </table></td>
  </tr>
  <tr>
    <td><div class="Pagination"><?php echo ($page); ?></div></td>
      </tr>
  </tr>
</table>
</body>
<script type="text/javascript">
  $(function () {
    $('.delAuth').click(function () {
      var user_id = $(this).parent().parent().parent().find("td:first span").html();
      layer.confirm('确定要删除该会员吗？', {
        btn: ['确定删除','容我想想'] //按钮
      }, function(){
          $.ajax({
              url:"<?php echo U('delUser');?>",
              data:{'user_id':user_id},
              dataType:'json',
              type:'post',
              success:function (msg) {
              if(msg.status == 200){
                layer.msg(msg.message);
                location.reload();
              }else if(msg.status == 202){
                layer.msg(msg.message);
            }
          }
        })

      }, function(){
        layer.msg( {
          time: 1000,
        });
      });
    })
      
      //冻结账户
      $('.blocked').click(function (){
          //获取id
          var authId = $(this).parent().parent().parent().find("td:first span").html();
          //
          layer.confirm('确定要冻结该账户吗？', {
              btn: ['确定冻结','容我想想'] //按钮
              //外1
          }, function(){
              layer.confirm('请选择冻结状态？', {
                      btn: ['自定义冻结','永久冻结']
                  //按钮
                  //内层1
                  },function(index){
                  layer.prompt({title: '请输入冻结天数'},function(val, index){
//                      layer.msg("该账户将冻结"+val+"天");
                      layer.close(index);
                      blocked(authId,val);
                  });
                  layer.close(index);
                  
                  //内层2
              },function () {
                  blocked(authId);
              })
             // 外2
          }, function(){
              layer.msg( {
                  time: 1000,
              });
          });
      })
      
          //冻结函数
           function   blocked( user_id,time='long'){
                $.ajax({
                    url:"<?php echo U('blocked');?>",
                    data:{'user_id':user_id,'time':time},
                    dataType:'json',
                    type:'post',
                    success:function (msg) {
                        if(msg.state == 200){
                            layer.msg(msg.message);
                            location.reload();
                        }else if(msg.state == 202){
                            layer.msg(msg.message);
                        }
                    }
                })
              }
              
              
      //用户导出
      $('#exportUser').click(function (){
          console.log(111);
          $.ajax({
              url:"<?php echo U('exportUser');?>",
              data:'',
              type:'post',
              dataType:'json',
              success:function(msg){
                  if(msg.state==200){
                      layer.msg(msg.message);
                  }else if(msg.state == 202){
                      layer.msg(msg.message);
                  }
              }
          })
      })
           
     
      
      
      
  })
</script>
</html>