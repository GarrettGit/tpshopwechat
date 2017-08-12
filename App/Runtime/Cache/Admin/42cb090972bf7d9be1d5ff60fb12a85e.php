<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/Public/resources/layer/layer.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>订单列表</title>
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
                <td width="94%" valign="bottom"><span class="STYLE1"> 订单管理 -> 订单列表</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
             <input type="button" id="exportUser" value="导出">   &nbsp;
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
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">订单ID</span></div></td>
        <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">订单编号</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">订单金额</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">订单状态</span></div></td>
      <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">是否发货</span></div></td>
      <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">下单时间</span></div></td>
        <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div></td>
      </tr>
      <?php if(is_array($orderData['list'])): foreach($orderData['list'] as $key=>$order): ?><tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19" id="id"><?php echo ($order["order_id"]); ?></span></div></td>
        
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($order["order_number"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">￥<?php echo ($order["order_price"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($order["order_status"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($order["is_send"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo (date("Y-m-d H:i:s",$order["add_time"])); ?></div></td>
        <td height="20" bgcolor="#FFFFFF">
          <div align="center" class="STYLE21">

          <a class="delAuth"> <img src="/Public/resources/admin/images/del.gif" width="10" height="10" />删除</a>  | <a class="blocked">绑定快递</a>|<a href="<?php echo U('detail',['order_id'=>$order['order_id']]);?>">查看详情</a></div></td>
      </tr><?php endforeach; endif; ?>
    </table></td>
  </tr>
  <tr>
    <td><div class="Pagination"><?php echo ($orderData['page']); ?></div></td>
      </tr>
  </tr>
</table>
</body>
<script type="text/javascript">
  $(function () {
    $('.delAuth').click(function () {
      var authId = $(this).parent().parent().parent().find("td:first span").html();
      layer.confirm('确定要删除该权限吗？', {
        btn: ['确定删除','容我想想'] //按钮
      }, function(){
          $.ajax({
              url:"<?php echo U('delAuth');?>",
              data:{'auth_id':authId},
              dataType:'json',
              type:'post',
              success:function (msg) {
              if(msg.status == 200){
                layer.msg('删除成功');
                location.reload();
              }else if(msg.status == 202){
                layer.msg('删除失败');
            }
          }
        })

      }, function(){
        layer.msg( {
          time: 1000,
        });
      });
    })
      
      //快递绑定
      $('.blocked').click(function (){
          var orderId = $(this).parent().parent().parent().find("td:first span").html();
          layer.confirm('确定快递绑定？', {
              btn: ['确定绑定','稍候绑定'] //按钮
          }, function(index){
                  layer.prompt({title: '请输入快递名称与单号,如:韵达12345'},function(val, index){
                      layer.close(index);
                      //绑定快递
                      $.ajax({
                          url:"<?php echo U('packageNumber');?>",
                          data:{'order_id':orderId,'package_id':val},
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
                     
                  });
                  layer.close(index);
                  
              },function () {
              })
      })
      
              
              
              
              
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