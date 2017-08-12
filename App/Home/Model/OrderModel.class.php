<?php
namespace Home\Model;

use Home\Common\Cart;
use Think\Model;
class OrderModel extends Model{

    /**
     * @showlist显示订单
     * @author : Terry
     * @return
     */
    public  function showlist(){
        $orderInfo = M('Order')->order('order_id desc')->select();
        $this->assign('orderInfo',$orderInfo);
        $this->display();
    }

    /**
     * @createOrder 创建用户订单
     *
     * @param array $data 商品信息
     *
     * @author : Terry
     * @return
     */
    public  function createOrder(array $data){
        $goods =D('goods');
        $cart = $goods->getCartData();
        $data['user_id'] =session('userId');
        $data['order_number'] ='tpshop'.$cart['goods_name'].substr(md5(time()),10,16);
        $data['order_price'] =$cart['number_price']['price'];
        $data['add_time'] = $data['upd_time']=time();
        //信息写入订单表
        $orderId = $this->add($data);
        if ($orderId){
            $info=[];
            //计算购物车商品种类数量
            $goodsNumber =  count($cart['cartInfo']);
            //设置默认数量
            $writeGoodsInfo=0;
            foreach ($cart['cartInfo'] as $k =>$v){
                $info['order_id'] = $orderId;
                $info['goods_id'] = $k;
                $info['goods_price'] = $v['goods_price'];
                $info['order_goods_number'] = $v['goods_buy_number'];
                $info['goods_total_price'] = $v['goods_total_price'];
                //若商品订单关联表写入成功 减少对应商品库存
                if (M('OrderGoods')->add($info)){
                    $goodsData =  $goods->find($k);
                    $goodsKu =   $goodsData['goods_number']- $info['goods_number'];
                    $goods->where(['goods_id'=>$k])->save(['goods_number'=>$goodsKu]);
                }
                //每次写入用户数量+1
                $writeGoodsInfo+=1;
            }
            //当默认数与购物车内数量相等时,商品信息入库完成,返回true
            //注意:需改购物车底层代码
            if ($goodsNumber ==$writeGoodsInfo && (new Cart())->delAll()){
//                    //调用添加用户积分方法
                    $this->addUserJifen($orderId);
                    return true;

            }
        }


    }

    /**添加用户积分
     * @addUserJifen
     * @author : Terry
     * @return
     */
    public  function  addUserJifen($orderId){
        //获取用户id
        $userId = session('userId');
//        通过用户id查询用户信息
        $userInfo = M('user')->find($userId);
        if ($userInfo ){
            //查询订单信息
            $orderData = $this->find($orderId);
                                //获取商品总价 转化为积分 假设100元==>100积分
            $UserData['jifen']= (int)$orderData['order_price']+$userInfo['jifen'];
            $UserData['user_id']=$userId;
        }
        if (M('User')->save($UserData)){
            return true;
        }
        $this->error='积分添加失败,请与管理员联系';
        return false;
    }


    /**
     * 获取用户订单
     * author Fox
     */
    public function getUserOrder($uid){

        //商品订单
        $orderData =  $this ->where(['user_id'=>$uid])->order('add_time DESC')
                    ->select();
        //获取数组中指定key的value值,然后拼接成数组
        $orderIds=implode(',',array_column($orderData,'order_id'));
        $orderDetail =M('orderGoods')
                    ->alias('og')
                    ->where("og.order_id IN($orderIds)")
                    ->join('sp_goods as goods on og.goods_id = goods.goods_id')
                    ->select();

        foreach ($orderDetail as $val){
            $orderDetails[$val['order_id']][]=$val;
        }
        foreach ($orderData as $k => $val){
            //订单状态
            if ($val['order_status']=='0'){
                $orderData[$k]['order_status']='未付款';
                unset($orderData[$k]['order_pay']);
            }else if($val['order_status']=='1') {
                $orderData[$k]['order_status']='已付款';
                //支付方式
                if ($val['order_pay']=='0'){
                    $orderData[$k]['order_pay']='支付宝';
                }else if($val['order_pay']=='1') {
                    $orderData[$k]['order_pay']='微信';
                }else if ($val['order_pay']=='2'){
                    $orderData[$k]['order_pay']='银联';
                }
            }else if ($val['order_status']=='2'){
                $orderData[$k]['order_status']='已取消';
                unset($orderData[$k]['order_pay']);
            }
            $orderData[$k]['orderDetails']=$orderDetails[$val['order_id']];
        }
            return $orderData;

    }

    /***
     * @param $order_id
     * author Fox
     */
    /**
     * @getorderDeatil获取订单详情
     *
     * @param $order_id 订单id
     *
     * @author : Terry
     * @return
     */
    public function  getorderDeatil($order_id){
          $orderData=[];
            //查看快递信息
          $backage = M('backage')->where(['order_id'=>$order_id])
           ->find();
          if ($backage ){
              $orderData['backage']['backageInfo']=  explode('#', str_replace('++','&nbsp;&nbsp;',$backage['backage_state']));
          }
          //获取订单信息
          $orderData['order'] =  $this->where(['order_id'=>$order_id])
            ->find();
        //订单状态
        if ($orderData['order']['order_status']=='0'){
            $orderData['order']['order_status']='未付款';
            unset($orderData['order']['order_pay']);
        }else if($orderData['order']['order_status']=='1') {
            $orderData['order']['order_status']='已付款';
            //支付方式
            if ($orderData['order']['order_pay']=='0'){
                $orderData['order']['order_pay']='支付宝';
            }else if($orderData['order']['order_pay']=='1') {
                $orderData['order']['order_pay']='微信';
            }else if ($orderData['order']['order_pay']=='2'){
                $orderData['order']['order_pay']='银联';
            }
        }else if ($orderData['order']['order_status']=='2'){
            $orderData['order']['order_status']='已取消';
            unset($orderData['order']['order_pay']);
        }
            //商品详情
          $orderData['detail'] =M('orderGoods')
            ->alias('og')
            ->where(["og.order_id"=>$order_id])
            ->join('sp_goods as goods on og.goods_id = goods.goods_id')
            ->select();
    //bug
//        $orderData['memberPrice'] =  D('goods')->getMemberPrice($orderData['detail'][0]['goods_id']);
         return $orderData;


    }
}