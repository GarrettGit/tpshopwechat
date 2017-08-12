<?php
namespace  Admin\Model;
use Think\Model;

class GoodsModel extends BaseModel {
    /**
     * @getAllGoods 获取所有数据
     * @author : Terry
     * @return array
     *
     */
    public  function getAllGoods(){

        $count      = $this->where('flag=1')->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $this->where('flag=1')->order('goods_id  DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        return ['page'=>$show,'list'=>$list];


    }

    /**
     * @getOneData 查询一条商品信息
     *
     * @param $goods_id 商品id
     *
     * @author : Terry
     * @return
     */
    public  function  getOneData($goods_id){
        $goodsData = parent::getOneData($goods_id);
        $goodsPics = M('goodsPics')->where(['goods_id' => $goods_id])->select();
        return ['goodsData'=>$goodsData,'goodsPics'=>$goodsPics];
    }





    //调用添加后置钩子函数
     public  function _after_insert($data, $options)
     {

         //获取到会员价格数组
         $menberData = I('post.member_price');
         if($menberData)
         {  //实例化会员价格模型
             $mpModel = M('memberPrice');
             //循环将会员价格写入会员表
             foreach ($menberData as $k => $v)
             {
                 $_price = (float)$v;
                 if($_price == 0)
                     continue ;
                 $mpModel->add(array(
                     'goods_id' => $data['goods_id'],
                     'price' => $v,
                     'level_id' => $k
                 ));
             }
         }
     }





}