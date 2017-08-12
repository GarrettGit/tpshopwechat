<?php

namespace  Home\Controller;
use Think\Controller;
use Home\Common\Cart;

class ShopController extends  Controller{



    /**
     * @addCart添加商品到购物车
     * @author : Terry
     * @return
     */
    public function addCart(){
        if (IS_AJAX){
            $goodsId=I('post.goods_id');
            $goodsNumber = I('post.goods_num');
           $goodsInfo =  M('goods')->find($goodsId);
           //获取会员商品价格
           $memberPrice =  D('goods')->getMemberPrice($goodsId);
           $cartGoods['goods_id'] = $goodsInfo['goods_id'];
           $cartGoods['goods_name'] = $goodsInfo['goods_name'];
           $cartGoods['goods_price'] = $memberPrice;
           $cartGoods['goods_buy_number'] = $goodsNumber;
           $cartGoods['goods_total_price'] = ($memberPrice*$goodsNumber);
           $cart = new Cart();
           $cart -> add($cartGoods);
           $number_price  = $cart->getNumberPrice();
           exit(json_encode($number_price ));

        }

    }


    /**
     * @viewCart查看购物车
     * @author : Terry
     * @return
     */
    public  function viewCart(){
        $cart = D('Goods')->getCartData();
        $this->assign('number_price',$cart['number_price']);
        $this->assign('cartInfo',$cart['cartInfo']);
        $this->display();
    }


    /**
     * @changeNumber修改商品数量
     * @author : Terry
     * @return
     */
        public function changeNumber(){
            if (IS_AJAX){
                $goods_id = I('post.goods_id');
                $num =  I('post.num');
                $cart = new cart();
                $totalPrice = $cart->changeNumber($num,$goods_id);
                $number_price = $cart->getNumberPrice();

                exit(json_encode([
                    'total_price'=>$number_price['price'],
                    'xiaoji_price'=>$totalPrice
                ]));
            }
        }


    /**
     * @delCartGoods删除购物车商品
     * @author : Terry
     * @return
     */
    public  function delCartGoods(){
            $cart = new cart();
            $cart->del(I('post.goods_id'));
            $number_price =$cart->getNumberPrice();
            exit(json_encode($number_price));
    }

    /**
     * @goodsOrder 商品订单
     * @author : Terry
     * @return
     */
    public  function  goodsOrder(){
        if (IS_POST){
            //判断今日是否有秒杀
            $seckillId = I('post.seckill_id');
            if ($seckillId){
                $uid=session('userId');
                $seckillInfo =M('seckillGoods')->find($seckillId);
                $befor_time =strtotime(date('Y-m-d 00:00:00'));
                $end_time =strtotime(date('Y-m-d 23:59:59'));
                if ($befor_time<$seckillInfo['etime'] && $seckillInfo['etime']<$end_time){
                    //实例化redis
                    $this->redis = new \Redis();
                    $this->redis->connect(C('REDIS_HOST'),C('REDIS_PORT'));
                    //查看用户集合是否存在该用户
                    $seckillUserStatus =$this->redis->SISMEMBER('successSeckillGoods_'.$seckillInfo['goods_id'],$uid);
                    //存在生成订单
                    if ($seckillUserStatus){
                        D('Order')->createOrder(I('post.'));
                    }
                }
            }

           $orderState =  D('Order')->createOrder(I('post.'));
           if ($orderState){
               $this->display('orderDetail');
           }
        }else{

            //如果未登录 则跳转登录
            if (empty(session('userName'))){
                session('callBack','Shop/GoodsOrder');
                $this->redirect('User/login');
            }

            //获取购物车信息
            $cart = D('Goods')->getCartData();
            //判断用户是否购买商品
            if (empty($cart['cartInfo'])){
                $this->error('您还未购买任何商品,请先购买',U('Goods/showlist'),2);
            }
            $this->assign('number_price',$cart['number_price']);
            $this->assign('cartInfo',$cart['cartInfo']);
            $this->display();
        }




    }



}
