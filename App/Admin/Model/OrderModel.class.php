<?php
namespace Admin\Model;
use Think\Model;

class OrderModel extends Model{

    /**获取订单信息
     * author Fox
     */
    public  function  getOrderData(){
        $count      = $this->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $this->order('add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach ($list as $k=>$val){
            //订单状态
            if ($val['order_status']=='0'){
                $list[$k]['order_status']='未付款';
            }else if($val['order_status']=='1') {
                $list[$k]['order_status']='已付款';
            }else if ($val['order_status']=='2'){
                $list[$k]['order_status']='已取消';
            }
        }
        return ['list'=>$list,'page'=>$show];

    }

    /**
     * @getOrderDetail 获取订单详情
     * @author : Terry
     * @return
     */
    public function  getOrderDetail($order_id){
        //连表获取订单信息
        $detail['orderInfo'] = $this
            ->alias('ord')
            ->join('__USER__ us on ord.user_id=us.user_id')
            ->join('__CONSIGNEE__ con on ord.cgn_id=con.cgn_id')
            ->field('ord.*,us.username,con.*')
            ->find($order_id);

        //获得订单关联的商品信息
        $detail['goodsInfo'] = D('OrderGoods')
            ->alias('og')
            ->join('__GOODS__ g on og.goods_id=g.goods_id')
            ->field('og.*,g.goods_name')
            ->where(array('og.order_id'=>$order_id))
            ->select();
        return $detail;
    }
}

