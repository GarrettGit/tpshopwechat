<?php
namespace Home\Controller;

use Think\Controller;

class OrderController extends Controller{
    /**
     * 订单列表
     * author Fox
     */
    public function showlist(){
        //如果未登录 则跳转登录
        if (empty(session('userName'))){
            session('callBack','Order/showlist');
            $this->redirect('User/login');
        }
        $orderData= D('order')->getUserOrder(session(userId));
       $this->assign('orderData',$orderData);
       $this->display();
    }

    /**
     * 订单详情
     * author Fox
     */
    public function OrderDetail($order_id){
       $orderData =  D('order')->getorderDeatil($order_id);
       $this->assign('orderData',$orderData);
       $this->assign('backageInfo',$orderData['backage']);
       $this->display();

    }
}