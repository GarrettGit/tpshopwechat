<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script type="text/javascript" src="/Public/resources/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/Public/resources/layer/layer.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>商品属性列表</title>
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
                <td width="94%" valign="bottom"><span class="STYLE1"> 商品管理 -> 属性列表</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo U('addAttr');?>"><img src="/Public/resources/admin/images/add.gif" width="10" height="10" /> 添加属性</a>   &nbsp;
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
          
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="attr_show">
        <tr>
            <td width="10%" height="20"  class="STYLE6" colspan="2">
            按属性类型显示:
              <select id="type_id" >
                <option value="0">--请选择--</option>
                <?php if(is_array($typeInfo)): foreach($typeInfo as $key=>$info): ?><option value="<?php echo ($info["type_id"]); ?>" id="selector"><?php echo ($info["type_name"]); ?></option><?php endforeach; endif; ?>
              </select>
            </td>
        </tr>
     </td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">属性ID</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">属性名称</span></div></td>
      <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">商品类型</span></div></td>
      <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">是否可选</span></div>
      </td><td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">录入方式</span></div></td>
      </td><td width="30%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">可选值列表</span></div></td>
      
        <td width="30%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div></td>
      </tr>
      <input type="hidden" name="get_type_id" id='get_type_id' value="<?php echo ($_GET['type_id']); ?>">
      <?php if(is_array($attrList)): foreach($attrList as $key=>$attr): ?><tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19" id="id"><?php echo ($attr["attr_id"]); ?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($attr["attr_name"]); ?></div>
        </td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($attr["type_name"]); ?></div>
        </td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($attr['attr_sel'] =='onlu' ?'唯一属性':'单选属性'); ?></div>
        </td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($attr['attr_write']=='manual'?'手工录入':'列表选择'); ?></div>
        </td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($attr["attr_vals"]); ?></div>
        </td>
           <td height="20" bgcolor="#FFFFFF">
        <div align="center" class="STYLE21">
          <a > 删除</a>  | <a href="<?php echo U('updAuth',[auth_id=>$auth['auth_id']]);?>">修改</a></div></td>
      </tr><?php endforeach; endif; ?>
    </table></td>
  </tr>
<!--  <tr>
    <td height="30">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="33%"><div align="left"><span class="STYLE22">&nbsp;&nbsp;&nbsp;&nbsp;共有<strong> 243</strong> 条记录，当前第<strong> 1</strong> 页，共 <strong>10</strong> 页</span></div></td>
        <td width="67%"><table width="312" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="49"><div align="center"><img src="/Public/resources/admin/images/main_54.gif" width="40" height="15" /></div></td>
            <td width="49"><div align="center"><img src="/Public/resources/admin/images/main_56.gif" width="45" height="15" /></div></td>
            <td width="49"><div align="center"><img src="/Public/resources/admin/images/main_58.gif" width="45" height="15" /></div></td>
            <td width="49"><div align="center"><img src="/Public/resources/admin/images/main_60.gif" width="40" height="15" /></div></td>
            <td width="37" class="STYLE22"><div align="center">转到</div></td>
            <td width="22"><div align="center">
              <input type="text" name="textfield" id="textfield"  style="width:20px; height:12px; font-size:12px; border:solid 1px #7aaebd;"/>
            </div></td>
            <td width="22" class="STYLE22"><div align="center">页</div></td>
            <td width="35"><img src="/Public/resources/admin/images/main_62.gif" width="26" height="15" /></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>-->
</table>
</body>
<script type="text/javascript">
  $(function () {
      var all_attr_list_cache = new Array();
      var get_type_id = $('#get_type_id').val();
      if(get_type_id!==''){
          $('#type_id').val(get_type_id);
          $("#selector").find("option[value='"+get_type_id+"']").attr("selected",true);
          getAttrList();
      }
 
      $('#type_id').change(function(){
          getAttrList();
      });
      
      function getAttrList(){
          var type_id =  $('#type_id').val();
          if(typeof all_attr_list_cache[type_id] === 'undefined'){
              $.ajax({
                  url:'/index.php/Admin/Attribute/getAttrByTypeInfo',
                  data:{'type_id':type_id},
                  dataType:'json',
                  type:'post',
                  async:false,
                  success:function(msg){
//                  console.log(msg);
                      var s = "";
                      $.each(msg,function(n,v){
                          s += '<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">';
                          s += v.attr_id;
                          s += '</span></div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
                          s += v.attr_name;
                          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
                          s += v.type_name;
                          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
                          s += v.attr_sel=='only'?'唯一属性':'单选属性';
                          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
                          s += v.attr_write=='manual'?'手工':'列表选取';
                          s += '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">'
                          s += v.attr_vals;
                          s += '</div></td> <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"><a href="/index.php/Admin/Attribute/delAttr/attr_id/'+v.attr_id+'.html" style="color:rgb(59,99,117)"> <img src="/Public/Admin/images/del.gif" width="10" height="10" /> 删除 </a>| 查看 | <a href="/index.php/Admin/Attribute/updAttr/attr_id/'+v.attr_id+'.html" style="color:rgb(59,99,117)"><img src="/Public/Admin/images/edit.gif" width="10" height="10" /> 编辑</a> </div></td> </tr>';
                      });

                      all_attr_list_cache[type_id]=s;
                  }
              });
          }

          //把页面已经显示的属性列表信息删除
          $('#attr_show tr:gt(1)').remove();
          //把上边设置好的s字符串追加给页面
          $('#attr_show').append(all_attr_list_cache[type_id]);
          
      }

   
      
      
  })
</script>
</html>