<?php
/**
 * Created by PhpStorm.
 * WechatSeckillModel.class.php 微信平台每日秒杀
 * author: Terry
 * Date: 2017/8/5
 * Time: 0:52
 * description:
 */
namespace  WeChat\Model;
use Think\Model;

class WechatSeckillModel extends Model{

    /**
     * @addSeckillGoods 添加秒杀推荐
     *
     * @param $godosData
     *
     * @author : Terry
     * @return
     */
    public function addSeckillGoods($godosData){

        $dataInfo['title'] = $godosData['goods_name'];
        $dataInfo['description'] = $godosData['goods_introduce'];
        $dataInfo['goods_uri'] = $godosData['goods_uri'];
        $dataInfo['create_time'] = time();
        $dataInfo['show_time'] = $godosData['show_time'];
        if ($this->add($dataInfo)){
            $this->error='添加成功';
            return true;
        }
        $this->error='添加失败';
        return false;
    }

    public  function _after_insert($data,$option){
        if ($_FILES && $_FILES['goods_pics']['error'] ===0){
            //设置logo存放路径
            $logoPath = [
                'rootPath'=>'./Public/upload/wechat/'
            ];
            //实例化upload类
            $upload =    new \Think\Upload($logoPath);
            $result = $upload->uploadOne($_FILES['goods_pics']);
            //拼接logo存放路径
            $bigLogoPath= $upload->rootPath.$result['savepath'].$result['savename'];
            $info['pic_uri'] = C('SITE').ltrim($bigLogoPath,'.');
            $info['id'] = $data['id'];
            $this->save($info);
        }

    }

}