<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
  
  <!--引入富文本编辑器的3个js文件-->
<script type="text/javascript" charset="utf-8" src="<?php echo C('PLUGIN_URL');?>/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo C('PLUGIN_URL');?>/Ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo C('PLUGIN_URL');?>/Ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"  src="/Public/resources/jquery-1.8.2.min.js"></script>
<script type="text/javascript"  src="/Public/resources/layer/layer.js"></script>
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
    //导航栏切换
    $(function () {
          $('#tabbar-div span').click(function () {
             $(this).attr('class','tab-front').siblings().attr('class','tab-back');
             var table_id =$(this).attr('id');
             $('[id$=-tab-show]').hide();
             $('#'+table_id+'-show').show();
//             console.log(table_id);
          })
    })
    //商品相册栏
    function add_pics_item(obj){
        var addtr  = $(obj).parent().parent().parent();
        var trTags = addtr.clone();
        
        var newSpanTag = "<span class='STYLE19' onclick='$(this).parent().parent().parent().remove()'> [-]商品相册：</span>";
          trTags.find('span').remove();
          trTags.find("div[align=right]").append(newSpanTag);
        $('#gallery-tab-show').append(trTags);
        console.log(addtr);
    }
    //ajax删除图片
    
    function del_pic(id) {
        layer.confirm('确定要删除？', {
            btn: ['确认删除','容我想想'] //按钮
        }, function(){
            $.ajax({
                url:'<?php echo U(delPics);?>',
                data:{'goods_id':id},
                dataType:'json',
                type:'post',
                success:function(msg){
                    if(msg.status == 200){
                        layer.msg(msg.message, {icon:6});
                        $('#pic_'+id).parent().remove();
                    }else if(msg.status == 202){
                        layer.msg(msg.message, {icon:5});
                    }

                }
            })
        });





    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        
    }
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
                <td width="94%" valign="bottom"><span class="STYLE1"> 商品管理 -> 修改商品</span></td>
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
    <td colspan="100">
    <div id="tabbar-div">
      <p>
        <span class="tab-front" id="general-tab">通用信息</span>
        <span class="tab-back" id="detail-tab">详细描述</span>
        <span class="tab-back" id="mix-tab">其他信息</span>
        <span class="tab-back" id="properties-tab">商品属性</span>
        <span class="tab-back" id="gallery-tab">商品相册</span>
        <span class="tab-back" id="linkgoods-tab">关联商品</span>
        <span class="tab-back" id="groupgoods-tab">配件</span>
        <span class="tab-back" id="article-tab">关联文章</span>
      </p>
    </div>
    </td>
  </tr>
  <tr>
    <td>
      <form action="" method="post" enctype="multipart/form-data">
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="general-tab-show" >
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品名称：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_name" value="<?php echo ($info["goods_name"]); ?>" />
        </div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">价格：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_price" value="<?php echo ($info["goods_price"]); ?>"/></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">数量：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_number" value="<?php echo ($info["goods_number"]); ?>"/></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">重量：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_weight"  value="<?php echo ($info["goods_weight"]); ?>"/></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品logo：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
          <input type="file" name="goods_logo" /><img src="<?php echo ($info["goods_small_logo"]); ?>"></div></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id='detail-tab-show' style="display:none">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">详情描述：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <textarea style="width:620px; height:200px;" id="goods_introduce" name="goods_introduce"><?php echo ($info["goods_introduce"]); ?></textarea>
        </div></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="mix-tab-show" style="display:none">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">其他信息：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_qita" />
        </div></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="properties-tab-show" style="display:none">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品属性：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_attr" />
        </div></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="gallery-tab-show" style="display:none">
        <tr>
          <td>
            <ul>
              <?php if(is_array($picsInfo)): foreach($picsInfo as $key=>$pic): ?><li style="list-style: none;float: left">
                  <img src="<?php echo ($pic["pics_mid"]); ?>">
                <span style="color: red;cursor:pointer" onclick="del_pic(<?php echo ($pic["pics_id"]); ?>)" id="pic_<?php echo ($pic["pics_id"]); ?>">[-]</span>
              </li><?php endforeach; endif; ?>
            </ul>
          </td>
        </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right" >
          <span class="STYLE19" onclick="add_pics_item(this)"> [+]商品相册：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="file" name="goods_pics[]" />
        </div></td>
      </tr>
     
    </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="linkgoods-tab-show" style="display:none">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">关联商品：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_name1" />
        </div></td>
      </tr>
      
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="groupgoods-tab-show" style="display:none">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">配件：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_name2" />
        </div></td>
      </tr>
     
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="article-tab-show" style="display:none">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">关联文章：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_wen" />
        </div></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce"
      <tr>
        <td colspan='100'  bgcolor="#FFFFFF"  class="STYLE6" style="text-align:center;">
        <input type="submit" value="修改" />
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
var ue = UE.getEditor('goods_introduce',{toolbars: [[
    'fullscreen', 'source', '|', 'undo', 'redo', '|',
    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
    'directionalityltr', 'directionalityrtl', 'indent', '|',
    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
    'horizontal'
]]});
</script>