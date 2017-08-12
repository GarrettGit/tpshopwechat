<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    /**商品列表
     * author Fox
     */
    public  function  showlist(){

      $goodsInfo =  D('goods')->getAllGoods();
      $this->assign('goodsInfo',$goodsInfo);
        $this->display();
    }

    /**商品详情
     * @param $goods_id 商品id
     * author Fox 58  59 60 lrange 0 4   ....... 30个
     */
    public  function  detail($goods_id){


        //用用户id 当作list连表的key  将商品信息写入list 商品名称 商品价格  商品图片url

       $goodsDetail =  D('goods')->getGoodsDetail($goods_id);
       $this->assign('goodsInfo',$goodsDetail['goodsdetail']);
        $this->assign('attrInfo',$goodsDetail['attrInfo']);
       $this->display();
//        $goodsInfo =M('goods')->find($goods_id);
//        $this->show($goodsInfo['static_url']);
    }

    /**
     * @getMemberPrice 获取会员价格
     * @author : Terry
     * @return
     */
    public function getMemberPrice($goods_id=0){
        if (empty($goods_id)){
            $goods_id =   I('post.goods_id');
        }
        $memberPriceInfo['memberPrice'] = D('goods')->getMemberPrice($goods_id);
        $memberPriceInfo['status']=200;
        $this->ajaxReturn($memberPriceInfo);
    }
}