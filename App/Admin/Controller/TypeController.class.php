<?php
namespace Admin\Controller;

use Admin\Common\AdminController;

class TypeController extends AdminController {
    /**
     * @showlist类型列表
     * @author : Terry
     * @return
     */
    public function  showlist(){
       $typeInfo =  M('Type')->where(['falg'=>0])->select();
//       var_dump($typeInfo);exit;
       $this->assign('typeInfo',$typeInfo);
        $this->display();

    }
    /**
     * 添加类型
     * author Fox
     */
    public function  addType(){
        if (IS_AJAX && !empty(I('post.type_name'))){
            $type =  M('Type');
            $typeName =trim(I('post.type_name'));
            $typeFlag =   $type->where(['type_name'=>$typeName])->find();
            if ( $typeFlag){
                exit(json_encode(['status'=>202,'message'=>'该商品类型已存在']));
            }
            if($type->add(['type_name'=>$typeName])){
                 exit(json_encode(['status'=>200,'message'=>'类型添加成功']));
               } else {
                exit(json_encode(['status'=>202,'message'=>'类型添加失败,请重新尝试']));
            }
        }
        $this->display();

    }
    /**
     * 修改类型
     * author Fox
     */
    public function  updType($type_id){
        if (empty($type_id)){
            $this->error('参数丢失',U('showlist'),2);
        }
       $type =  D('Type');
        if (IS_POST){
            if ($type ->uppType(I('post.'))){
                $this->success('修改成功',U('showlist'),2);
            }else{
                $this->error($type->getError(),U('updType',['type_id'=>$type_id]),2);
            }

        }else{
            $result =$type ->getOneData($type_id);
            $this->assign('type', $result);
            $this->display();

        }
    }

    /**
     * @deltype 删除type
     *
     * @param $type_id type_id
     *
     * @author : Terry
     * @return
     */
    public  function  deltype($type_id){
        $type=D('Type');
        if ($type->deltypeAttr($type_id)){
            $this->success('删除成功',U('showlist'),2);
        }
        $this->error($type->getError(),U('showlist'),2);

    }

}