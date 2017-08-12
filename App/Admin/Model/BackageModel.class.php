<?php

namespace Admin\Model;

class BackageModel extends BaseModel {
    /**
     * 快递信息入库
     * @param $data
     * author Fox
     */
    public function postBackageInfo($order_id,$data){
        $backageState ='';
        foreach ($data['data'] as $k=>$val){
            $backageState.=$val['time'].'++'.$val['context'].'#';
        }
        $info['backage_state']=$backageState;
        $info['backage_number']=$data['nu'];
        //若之前绑定,则进行修改
        if ($this->find($order_id)){
            if($this->where(['order_id'=>$order_id])->save($info)){
                M('order')->where(['order_id'=>$order_id])->save(['is_send'=>'是']);
                $this->error='快递绑定成功';
                return true;
            }
        }else{
            $info['order_id']=$order_id;
            //若没绑定直接添加
            if ($this->add($info)){
                if(M('order')->where(['order_id'=>$order_id])->save(['is_send'=>'是'])){
                    $this->error='快递绑定成功';
                    return true;
                }
            }
        }

        $this->error='快递绑定失败';
        return false;
    }
}