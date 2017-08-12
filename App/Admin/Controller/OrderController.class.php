<?php
namespace Admin\Controller;

use Admin\Common\AdminController;

/**
 * Class OrderController 订单控制器
 *
 * @package Admin\Controller
 * @anthor  Terry
 *
 */
class OrderController extends AdminController{
    /**
     * @showlist 显示订单列表
     * @author : Terry
     * @return
     */
    public function showlist(){
        $orderData = D('order')->getOrderData();
        $this->assign('orderData',$orderData);
        $this->display();

    }
    /**
     * @getOrderDetail 获取订单详情
     * @author : Terry
     * @return
     */
    public function  detail($order_id){
        $orderDetail = D('order')->getOrderDetail($order_id);
        $this->assign('orderDetail',$orderDetail);
        $this->display();
    }

    /**
     * @packageNumber 绑定快递单号
     * @author : Terry
     * @return bool|error
     */
    public function packageNumber(){
        $package = I('post.package_id');
        $orderId = I('post.order_id');
        //取出快递类型
         preg_match_all('/[\x{4e00}-\x{9fa5}a-zA-Z]/u' , $package, $result);
         var_dump($result);
         //array([0]=>汉字,[1]=>运单号)
/*
        array(0 =>
                    array(
                    0 => string '圆' (length=3)
                    1 => string '通' (length=3)
))*/
        $packageType =implode('', $result[0]);
        //引入汉字转拼音类
        import("ORG.Util.Pinyin");
        $pinyin = new \PinYin();
        $packageTypePinyin =  $pinyin->getAllPY($packageType); //汉字转为拼音
        //                                                                         将左侧的汉字删除
        $uri='http://www.kuaidi100.com/query?type='.$packageTypePinyin.'&postid='.ltrim($package, $packageType);
        //url==>http://www.kuaidi100.com/query?type=yuantong&postid=885521950005566378
        $backageInfo = request($uri);//curl

        $backage=D('backage');
        $state = $backage->postBackageInfo($orderId,json_decode($backageInfo,true));
        if ($state){
            exit(json_encode(['state'=>200,'message'=>$backage->getError()]));
        }
        exit(json_encode(['state'=>202,'message'=>$backage->getError()]));

    }
}