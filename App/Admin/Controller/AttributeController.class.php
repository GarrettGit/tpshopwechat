<?php
namespace Admin\Controller;

use Admin\Common\AdminController;

/**
 * Class AttributeController 商品属性控制器
 *
 * @package Admin\Controller
 * @anthor  Terry
 *
 */
class AttributeController extends  AdminController{
    public function showlist(){
        $typeInfo = M('Type')->select();
        $this->assign('typeInfo',$typeInfo);
        $this->display();
    }


    /**
     * @addAttr添加属性
     * @author : Terry
     * @return
     */
    public  function addAttr(){
        $attr = D('Attribute');
        if (IS_POST && !empty($_POST)){
            $info=$attr->create();
            if( $info!==false){
                $info['attr_vals']=  rtrim(str_replace('|',',',I("post.attr_vals")),',');
                if ($attr->add($info)){
                    $this->success('属性添加成功',U('showlist'),2);
                }else{
                    $this->success('属性添加失败','',2);
                }
            }else{
//                dump($attr->getError());exit();
                $this->assign('errorInfo', $attr->getError());
            }
        }else{
            $typeInfo =  D('Type')->select();
            $this->assign('typeInfo',$typeInfo);
            $this->display();
        }


    }


    /**
     * @getAttrByTypeInfo根据类型获取属性
     * @author : Terry
     * @return
     */
    public function getAttrByTypeInfo(){
        if (IS_AJAX){
            $attrInfo = D('Attribute')->getAttrList(I('post.type_id'));
            exit(json_encode($attrInfo));
        }


    }

    /**
     * @updAttr修改属性
     *
     * @param $attr_id 属性id
     *
     * @author : Terry
     * @return
     */
    public function updAttr($attr_id){
        $attr = D('Attribute');
        $type_id = I('post.type_id');
        if (IS_POST){
           if ($attr->updOneAttr(I('post.'))){
               $this->success('属性修改成功',U('showlist',['type_id'=>$type_id]),2);
           }else{
               $this->error($attr->getError(),'',2);
           }

        }else{
            $attrInfo =    $attr->getOneData($attr_id);
            $attrInfo['attr_vals'] =str_replace(',','|',$attrInfo['attr_vals']);
            $typeInfo = M('Type')->select();
            $this->assign('attrInfo', $attrInfo);
            $this->assign('typeInfo', $typeInfo);
            $this->display();
        }

    }

    /**
     * @delAttr删除属性
     *
     * @param $attr_id 属性id
     *
     * @author : Terry
     * @return
     */
    public function delAttr($attr_id){
        $delState = M('Attribute')->where(['attr_id'=>$attr_id])->save(['flag'=>1]);
        if ($delState){
            $this->success('删除成功','',2);
        }else{
            $this->error('删除失败','',2);
        }
    }


}

