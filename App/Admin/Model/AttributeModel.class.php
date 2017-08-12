<?php
namespace Admin\Model;
//use Think\Model;
class AttributeModel extends BaseModel {
    protected $patchValidate = true;
    protected  $_validate = [
        ['attr_name','require','属性名称必须设置'],
        ['type_id','0','商品类型必须选取',0,'notequal'],
    ];


    /**
     * @getAttrList获取属性列表
     *
     * @param string $id typeId
     *
     * @author : Terry
     * @return array
     */
    public  function getAttrList($id=''){
        $where['flag']=0;
        if (!empty($id)){
            $where['type.type_id']=$id;
        }
      return   $this->alias('attr')
           ->join('sp_type as type on attr.type_id=type.type_id')
            ->field('attr.*,type.type_name')
            ->where($where)
            ->select();

    }
    //获取一条数据
    public function getOneData($param)
    {

        return parent::getOneData($param);
    }


    /**
     * @updOneAttr修改属性
     *
     * @param $param 单选属性信息
     *
     * @author : Terry
     * @return bool
     */
    public function updOneAttr($param){
//        var_dump($param);exit();
        if (!empty($param['attr_vals'])){
            $param['attr_vals'] =  str_replace('|',',',$param['attr_vals']);
        }
       if(!$this->save($param)){
           $this->error='属性修改失败,请与管理员联系';
           return false;
       }
       return true;

    }

}