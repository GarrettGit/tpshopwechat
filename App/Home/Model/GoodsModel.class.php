<?php

namespace  Home\Model;

use Think\Model;
use Home\Common\Cart;
class GoodsModel extends Model{
    /**
     * @getAllGoods 获取所有商品 商品列表
     * @author : Terry
     * @return
     */
        public function  getAllGoods(){

            $count      = $this->where('flag=1')->count();// 查询满足要求的总记录数
            $Page       = new \Think\Page($count,24);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show       = $Page->show();
            $list = $this->where('flag=1')->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
            return ['list'=>$list,'show'=>$show];
        }

    /**获取商品详情
     * author Fox
     */
        public function  getGoodsDetail($goods_id){
            $goodsdetail=array();
            //获取商品基本信息
             $goodsdetail['goodsInfo'] = $this->find($goods_id);
             //商品单选属性获取及处理
             $attrInfo['many'] =  M('GoodsAttr')->alias('attr')
                           ->join('__ATTRIBUTE__ as attri  on attr.attr_id = attri.attr_id'  )
                           ->field('attri.attr_id,attri.attr_name,attr.attr_value,group_concat(attr.attr_value) attr_values')
                            ->where(['attr.goods_id'=>$goods_id,'attri.attr_sel'=>'many'])
                            ->group('attri.attr_id')
                           ->select();

             //商品唯一属性
            $attrInfo['only'] =  M('GoodsAttr')->alias('attr')
                        ->join('__ATTRIBUTE__ as attri  on attr.attr_id = attri.attr_id'  )
                        ->field('attri.attr_id,attri.attr_name,attr.attr_value')
                        ->where(['attr.goods_id'=>$goods_id,'attri.attr_sel'=>'only'])

                        ->select();

        foreach ($attrInfo['many'] as $k =>$v){
            $attrInfo['many'][$k]['values']=explode(',',$v['attr_values']);

        }
            $goodsdetail['pics'] =M('GoodsPics')->where(['goods_id'=>$goods_id])->select();

            //获取会员价格()
            $goodsdetail['memberPrice'] =   $this->getMemberPrice($goods_id);
            return  ['goodsdetail'=>$goodsdetail,'attrInfo'=>$attrInfo];
        }

    /**
     * @getMemberPrice 处理会员价格
     *
     * @param $goodsId 商品id
     *
     * @author : Terry
     * @return 商品价格
     */
    public function getMemberPrice($goodsId)
    {
        // 先取出基本价格和促销价格
        $price = $this->field('goods_price,goods_members_price')->find($goodsId);
        // 计算会员级别
        $id = session('userId');
        // 已经登录 计算会员 价
        if($id)
        {
            // 从用户表中取出积分值
            $jifen = M('user')->field('jifen')->find($id);
            // 计算会员级别
            $mlModel = D('member_level');
            $levelId = $mlModel->field('id,level_rate')->where(array(
            'jifen_bottom' => array('elt', $jifen['jifen']),
            'jifen_top' => array('egt', $jifen['jifen']),
        ))->find();
            // 查询是否为这个级别设置了会员价格
            $mpModel = D('member_price');
            $memberPrice = $mpModel->field('price')->where(array(
                'goods_id' => array('eq', $goodsId),      // 商品的ID
                'level_id' => array('eq', $levelId['id'])  // 会员级别ID
            ))->find();
            // 如果设置了会员价格就直接使用这个价格
            if($memberPrice){
                $mprice = $memberPrice['price'];
            } else{
                // 使用折扣率
                $mprice = $price['shop_price'] * ($levelId['level_rate'] / 100);
            }
            return $mprice;
        } else {
            // 未登录显示促销价
                return $price['goods_members_price'];
        }
    }



    /**
     * 获取购物车信息
     * author Fox
     */

    public function getCartData(){
        $cart = new Cart();
        //获取购物车里的商品信息
        $cartInfo = $cart->getCartInfo();
        //处理商品logo
        $goodsIds = implode(',',array_keys($cartInfo));
        //根据ids查询出logo信息
        $goodsLogos = M('Goods')->field('goods_id,goods_small_logo')->select($goodsIds);

        foreach ($cartInfo as $k=>$v){
            foreach ($goodsLogos as $vv){
                if ($k==$vv['goods_id']){
                    $cartInfo[$k]['logo'] = $vv['goods_small_logo'];
                }
            }
        }
        //判断用户是否登录,若未登录按促销价格 若登录重新计算商品价格
        if (session('userId')){
            //调用会员价格方法,重新计算会员价格
            foreach ($cartInfo as $k =>$val){
                    //之前的是促销价格   经过getMemberPrice方法处理 就是新的会员价格  100 *3
                $cartInfo[$k]['goods_price'] =  $this->getMemberPrice($val['goods_id']);
                //重新计算单间商品总价
                $cartInfo[$val['goods_id']]['goods_total_price']=($val['goods_buy_number']*$cartInfo[$k]['goods_price']);
                //重新计算商品总价与总数量
                $number_price['number']+=$val['goods_buy_number'];
                $number_price['price']+=($val['goods_buy_number']*$cartInfo[$k]['goods_price']);
            }

        }else{
            //获取商品总金额
            $number_price = $cart->getNumberPrice();
        }
        return ['cartInfo'=>$cartInfo,'number_price'=>$number_price];

    }

}
