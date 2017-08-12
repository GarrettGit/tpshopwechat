<?php
/**
 * Created by PhpStorm.
 * SeckillController.class.php 秒杀/抢购
 * author: Terry
 * Date: 2017/7/25
 * Time: 19:15
 * description:
 */
namespace Home\Controller;
use Think\Controller;

class SeckillController extends  Controller{
    public  $redis;
    public  $seckill;
    public  function __construct()
    {
        parent::__construct();
        $this->redis = new \Redis();
        $this->redis->connect(C('REDIS_HOST'),C('REDIS_PORT'));
    }

    /**
     * @seckillGoods秒杀控制器
     * @author : Terry
     * @return
     */
    public function  seckillGoods(){
        if (IS_AJAX){
            //如果未登录 则跳转登录
            if (empty(session('userName'))){
                session('callBack','Seckill/seckillList');
                $this->ajaxReturn(['status'=>202,'message'=>'请登录后参加秒杀,即将跳转','callBack'=>'User/login']);
                exit();
            }
            $goodsId = I('post.goods_id');
            $sckillGoods= M('SeckillGoods');
            //根据id查出秒杀信息
            $seckillgoodsInfo =  $sckillGoods->find(10);
            if ($seckillgoodsInfo['flag'] ==1){
                $this->ajaxReturn(['status'=>205,'message'=>'您下手晚了秒杀已结束']);
            }
            //判断的当前时间是否大于秒杀开始时间
            if (time()>=$seckillgoodsInfo['btime']){
                $uid = session('userId');
                //若该用户参与过秒杀 则不允许第二次参加
                if (!$this->redis->SISMEMBER ('successSeckillGoods_'.$goodsId,$uid)){
                    //若没参与秒杀 允许参加
                    if ($this->redis->lpop($seckillgoodsInfo['seckill_key'])){
                        //将获取秒杀资格的用户写入集合
                        $this->redis->SADD('successSeckillGoods_'.$goodsId,$uid);
                        $seckillStatus['flag']=1;
                        $seckillStatus['id']=$seckillgoodsInfo['goods_is'];
                        $sckillGoods->save($seckillStatus);
                        $this->ajaxReturn(['status'=>200,'message'=>'恭喜你秒杀成功','seckill_id'=>$seckillgoodsInfo['id']]);
                    }else{
                        $this->ajaxReturn(['status'=>205,'message'=>'您下手晚了秒杀已结束']);
                    }
                }else{
                    $this->ajaxReturn(['status'=>205,'message'=>'您参加过秒杀活动,请留给其他朋友吧']);
                }

            }else{
                $this->ajaxReturn(['status'=>205,'message'=>'秒杀还未开始,请耐心等待']);
            }


        }


    }

    /**
     * @seckillList 秒杀商品
     * @author : Terry
     * @return
     */
    public function seckillList(){
       $seckillInfo =  M('seckillGoods')->find(10);

       //距离开始时间
        $seckillInfo['count_down']=$this->time2second(($seckillInfo['btime']-time()));
        $goodsDetail =  D('goods')->getGoodsDetail($seckillInfo['goods_id']);
        $this->assign('goodsInfo',$goodsDetail['goodsdetail']);
        $this->assign('attrInfo',$goodsDetail['attrInfo']);
        $this->assign('seckillInfo',$seckillInfo);

        $this->display('seckillList');
    }
    //时间计算函数
   private function time2second($seconds){
        //时间转为int
        $seconds = (int)$seconds;
        if( $seconds<86400 ){//如果不到一天
            $format_time = gmstrftime('%H 时 %M 分 %S 秒', $seconds);
        }else{
            $time = explode(' ', gmstrftime('%j %H %M %S', $seconds));
            $format_time = ($time[0]-1).'天'.$time[1].'时'.$time[2].'分'.$time[3].'秒';
        }
        return $format_time;
    }
}