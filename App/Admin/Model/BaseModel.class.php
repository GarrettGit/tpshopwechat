<?php
namespace Admin\Model;
use Think\Model;
class  BaseModel extends  Model{
    /**
     * @getOneData 获取一条数据公共方法
     *
     * @param $param
     *
     * @author : Terry
     * @return
     */
    protected function getOneData($param){
        if (!is_array($param)){
            return $this->find($param);
        }else{
            return $this->where($param)->find();
        }

    }
}




