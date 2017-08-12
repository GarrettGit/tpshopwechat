<?php
/**
 * Created by PhpStorm.
 * WechatSeckillController.class.php 微信平台每日秒杀
 * author: Terry
 * Date: 2017/8/5
 * Time: 0:28
 * description:
 */
namespace  WeChat\Controller;
use Think\Controller;

class WechatSeckillController extends Controller{

    /**
     * @addSeckill 添加秒杀推荐
     * @author : Terry
     * @return
     */
    public  function  addSeckill(){
        if (IS_POST){
            $seckillInfo = I('post.');
            $WechatSeckill=D('WechatSeckill');
            $addStatus = $WechatSeckill->addSeckillGoods($seckillInfo);
            if ($addStatus){
                $this->success($WechatSeckill->getError(),U('showlist'),'2');
            }
            $this->error($WechatSeckill->getError(),U('showlist'),'2');
        }
        $this->display();
    }
}

