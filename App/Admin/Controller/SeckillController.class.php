<?php
/**
 * Created by PhpStorm.
 * SeckillController.class.php
 * author: Terry
 * Date: 2017/7/25
 * Time: 21:52
 * description:
 */
namespace Admin\Controller;

use Admin\Common\AdminController;

class SeckillController extends AdminController{

    public  $redis;
    public  $seckill;
    public  function __construct()
    {   //初始化redis
        parent::__construct();
        $this->redis = new \Redis();
        $this->redis->connect(C('REDIS_HOST'),C('REDIS_PORT'));
    }
    /**
     * @addSeckill 添加秒杀商品
     * @author : Terry
     * @return
     */
    public  function  addSeckill($goods_id){
        if (IS_POST){;
            $seckillGoods = M('SeckillGoods');
            $seckillInfo = I('post.');
            $seckillInfo['btime']=strtotime($seckillInfo['befor_date']);
            $seckillInfo['etime']=strtotime($seckillInfo['end_date']);
             $listKey  =substr(md5($seckillInfo['end_date']),8,16).$seckillInfo['goods_id'];
             //查看商品是否参加了该时间段的秒杀活动
            $getSeckllInfo =   $seckillGoods->where(['goods_id'=>$seckillInfo['goods_id'],'seckill_key'=>$listKey])->find();
            if ($getSeckllInfo){
              $this->error('该商品已参加了'.date('Y-m-d h:i:s',$getSeckllInfo['btime']).'至'.date('Y-m-d h:i:s',$getSeckllInfo['etime']).'的秒杀活动',U('goods/showlist'),5);
          }
            $seckillInfo['seckill_key']=$listKey;
            if ($seckillGoods->add($seckillInfo)){
                //设置秒杀库存
                for ($i=1;$i<=$seckillInfo['goods_num'];$i++){
                    $this->redis->lPush($listKey,$seckillInfo['goods_id']);
                }
                //获取队列内容个数
                $llen =  $this->redis->lLen($listKey);
                //队列内容个数等于秒杀商品数量
                if ($llen == $seckillInfo['goods_num']){
                    //计算秒杀队列声明周期
                    $lifeTime = strtotime($seckillInfo['end_date']) -time();
                    //设置秒杀队列声明周期
                    $this->redis->expire($seckillInfo['seckill_key'],$lifeTime);
                }

                $this->success('设置成功',U('goods/showlist'),3);
            }else{
                $this->error('设置失败,请与管理员联系');
            }


        }else{
//            session('goodsId',$goods_id);
            $goodsInfo = D('goods')->getOneData($goods_id);
            $this->assign('goodsInfo',$goodsInfo);
            $this->display();
        }
    }
}