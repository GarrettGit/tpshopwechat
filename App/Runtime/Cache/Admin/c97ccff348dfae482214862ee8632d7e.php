<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/Public/resources/layer/layer.js"></script>
<title>无标题文档</title>
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
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="/Public/resources/admin/images/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 商品管理 -> 商品列表</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo U('tianjia');?>"><img src="/Public/resources/admin/images/add.gif" width="10" height="10" /> 添加</a>   &nbsp;
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
          
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品ID</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品名称</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品价格</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品重量</span></div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品数量</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品logo</span></div></td>
        <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品详情</span></div></td>
        <td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
      </tr> <?php if(is_array($info['list'])): foreach($info['list'] as $key=>$goods): ?><tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><?php echo ($goods["goods_id"]); ?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($goods["goods_name"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($goods["goods_price"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($goods["goods_weight"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($goods["goods_number"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><img src=" <?php echo ($goods["goods_small_logo"]); ?>"></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($goods["goods_introduce"]); ?></div></td>
        <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21">
        
          <img src="/Public/resources/admin/images/del.gif" width="10" height="10" /> 删除 |<a class="createStaticHtml"> 静态化</a> |<a href="<?php echo U('seckill/addseckill',[goods_id=>$goods['goods_id']]);?>"> 参加秒杀</a> | <a  href="<?php echo U('xiugai',[goods_id=>$goods['goods_id']]);?>">  <img src="/Public/resources/admin/images/edit.gif" width="10" height="10" /> 编辑</a></div></td>
      </tr><?php endforeach; endif; ?>
    </table></td>
  </tr>
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        
        <?php echo ($info['page']); ?>
        <!--<td width="33%"><div align="left"><span class="STYLE22">&nbsp;&nbsp;&nbsp;&nbsp;共有<strong> 243</strong> 条记录，当前第<strong> 1</strong> 页，共 <strong>10</strong> 页</span></div></td>-->
        <!--<td width="67%"><table width="312" border="0" align="right" cellpadding="0" cellspacing="0">-->
          <!--<tr>-->
            <!--<td width="49"><div align="center"><img src="/Public/resources/admin/images/main_54.gif" width="40" height="15" /></div></td>-->
            <!--<td width="49"><div align="center"><img src="/Public/resources/admin/images/main_56.gif" width="45" height="15" /></div></td>-->
            <!--<td width="49"><div align="center"><img src="/Public/resources/admin/images/main_58.gif" width="45" height="15" /></div></td>-->
            <!--<td width="49"><div align="center"><img src="/Public/resources/admin/images/main_60.gif" width="40" height="15" /></div></td>-->
            <!--<td width="37" class="STYLE22"><div align="center">转到</div></td>-->
            <!--<td width="22"><div align="center">-->
              <!--<input type="text" name="textfield" id="textfield"  style="width:20px; height:12px; font-size:12px; border:solid 1px #7aaebd;"/>-->
            <!--</div></td>-->
            <!--<td width="22" class="STYLE22"><div align="center">页</div></td>-->
            <!--<td width="35"><img src="/Public/resources/admin/images/main_62.gif" width="26" height="15" /></td>-->
          <!--</tr>-->
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
  $(function () {
      $('.createStaticHtml').click(function () {
              var goodsId = $(this).parent().parent().parent().find("td:first span").html();
              layer.confirm('确定要生成静态页面吗？', {
                  btn: ['确定生成','容我想想'] //按钮
              }, function(){
                  $.ajax({
                      url:"<?php echo U('createStaticHtml');?>",
                      data:{'goods_id':goodsId},
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
          
      
  })
 
</script>
</body>
</html>