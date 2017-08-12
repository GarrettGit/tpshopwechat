<?php
namespace  Admin\Model;

class TypeModel extends  BaseModel{
    //返回一条数据
    public function getOneData($id){
     return  parent::getOneData($id);
    }

    /**
     * @uppType 修改类型
     *
     * @param $param
     *
     * @author : Terry
     * @return
     */
    public function uppType($param){
        if($this->save($param)){
           return true;
        }else{

            $this->error='修改失败,请与管理员联系!';
            return false;
        }
    }

    /**
     * @deltypeAttr 删除商品属性
     * @author : Terry
     * @return
     */
    public  function  deltypeAttr($id){

        $Mattribute=M('attribute');
        if ($Mattribute->where(['type_id'=>$id])->find()){
            if( $Mattribute->where(['type_id'=>$id])->save(['falg'=>1])){
                if($this->where(['type_id'=>$id])->save(['falg'=>1])){
                    return true;
                }
                $this->error='类型删除失败,请与管理员联系';
                return false;
            }else{
                $this->error='类型属性删除失败,请与管理员联系';
                return false;
            }
        }else{
            if($this->where(['type_id'=>$id])->save(['falg'=>1])){
                return true;
            }
            $this->error='类型删除失败,请与管理员联系';
            return false;
        }


    }
}