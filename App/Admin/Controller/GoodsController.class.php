<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

/**
 * Class GoodsController  商品控制器
 *
 * @package Admin\Controller
 * @author Terry
 */
class GoodsController extends AdminController {
    /**
     * @showlist 显示列表
     * @author : Terry
     * @return
     */
    public function showlist(){
        $info = D(goods)->getAllGoods();
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * @tianjia 添加商品
     * @author : Terry
     * @return
     */
    public function tianjia(){
      $goods =   D('goods');
      if (IS_POST && !empty($_POST)){


          //调用logo处理类
          $this->dealLogo();
          $goodsData = I('post.');
          $goodsData['add_time'] =time();
          $goodsData['upd_time'] =time();
          $goodsData['goods_introduce']= \PreventXSS($_POST['goods_introduce']);
          $newId =  $goods->add($goodsData);
          if($newId){
              $this->dealGoodsAttr($newId,$goodsData['attr_info']);
              $this->dealPics($newId);
              $this->success('添加成功','showlist',2);

          }else{
              $this->error('添加失败','tianjia',2);

          }
      }else{
          $typeInfo  = M('type')->select();
          //会员级别
          $memberInfo = M('memberLevel')->where(['flag'=>1])->select();
          $this->assign('typeInfo',$typeInfo);
          $this->assign('memberInfo',$memberInfo);
          $this->display();
      }

    }


    /**
     * @xiugai商品修改
     *
     * @param $goods_id 商品id
     *
     * @author : Terry
     * @return
     */
    public function xiugai($goods_id){
        $goods = D('goods');
        if (IS_POST && !empty($_POST)){
            if ($goods_id === session('goods_upd_id')){
                session('goods_upd_id',null);
                $this->dealLogo($goods_id);
                $this->dealPics($goods_id);
                $updGoodsInfo = I('post.');
                $updGoodsInfo['goods_id']=$goods_id;
                $updGoodsInfo['goods_introduce']= \PreventXSS($_POST['goods_introduce']);
                $updGoodsInfo['upd_time']=time();
                if($goods->save($updGoodsInfo)){
                    $this->success('修改成功',U('showlist'),2);
                } else {
                    $this->error('修改失败',U('xiugai',['goods_id'=>$goods_id]),2);
                }
            }else{
                $this->error('参数有问,请与管理员联系',U('xiugai'),2);
            }

        }else {
            session('goods_upd_id',$goods_id);
            $data=$goods->getOneData($goods_id);
            $this->assign('info', $data['goodsData']);
            $this->assign('picsInfo', $data['goodsPics']);
            $this->display();
        }
    }


    /**
     * @delPics删除相册图片
     * @author : Terry
     * @return
     */
    public function  delPics(){
        if (IS_AJAX){
            $picId=I('post.goods_id');
            $pic = M('goodsPics');
            $picInfo =  $pic->find($picId);
            if (file_exists('.'.$picInfo['pics_big'])){ unlink('.'.$picInfo['pics_big']);}
            if (file_exists('.'.$picInfo['pics_mid'])){ unlink('.'.$picInfo['pics_mid']);}
            if (file_exists('.'.$picInfo['pics_sma'])){ unlink('.'.$picInfo['pics_sma']);}
            if($pic->delete($picId)){
                exit(json_encode(['message'=>'删除成功','status'=>'200']));
            }else{
                exit(json_encode(['message'=>'删除失败','status'=>'202']));
            }
        }

    }


    /**
     * @dealLogo 处理logo
     *
     * @param int $goods_id 商品id
     *
     * @author : Terry
     * @return
     */
    private  function dealLogo($goods_id=0){

            if ($_FILES['goods_logo']['error'] ===0) {
                if ($goods_id!==0){
                $logoInfo = M(goods)->find($goods_id);
                    if (file_exists('.'.$logoInfo['goods_big_logo'])||file_exists('.'.$logoInfo['goods_small_logo'])){
                    unlink('.'.$logoInfo['goods_big_logo']);
                    unlink('.'.$logoInfo['goods_small_logo']);
                    }
                }
            }
        if ($_FILES && $_FILES['goods_logo']['error'] ===0){
            //设置logo存放路径
            $logoPath = [
                'rootPath'=>'./Public/upload/logo/'
            ];
            //实例化upload类
            $upload =    new \Think\Upload($logoPath);
            $result = $upload->uploadOne($_FILES['goods_logo']);
            //拼接logo存放路径
            $bigLogoPath= $upload->rootPath.$result['savepath'].$result['savename'];
            //实例化img类 制作缩略图
            $img = new \Think\Image();
            $img->open($bigLogoPath);
            $img->thumb(130,130,6);
            $smallPath = $upload->rootPath.$result['savepath'].'small_'.$result['savename'];
            $img->save($smallPath);
            $_POST['goods_big_logo'] =ltrim($bigLogoPath,'.');
            $_POST['goods_small_logo'] = ltrim($smallPath,'.');
        }
    }

    /**
     * @dealPics 商品相册上传
     *
     * @param int $goos_id 商品id
     *
     * @author : Terry
     * @return
     */
    private function dealPics($goos_id=0){
        //定义图片存放路径
        $picsPath = ['rootPath'=>'./Public/upload/pics/'];
        //默认状态false
        $picsState = false;

        foreach( $_FILES['goods_pics']['error'] as $val){
            if ($val ===0){
                $picsState=ture;
                break;
            }
        }
        if ($picsState){
            $upload = new  \Think\Upload($picsPath);
            $picsResult = $upload->upload([$_FILES['goods_pics']]);
            //制作缩略图
            $img = new  \Think\Image();
            foreach ($picsResult as $k => $v){
                //大图
                $picPath = $upload->rootPath.$v['savepath'].$v['savename'];
                $img    ->  open($picPath);
                $img    ->  thumb(800,800,6);
                $bigPic =$upload->rootPath.$v['savepath'].'big'.$v['savename'];
                $img    ->  save($bigPic);
                //中图
                $img    ->  open($bigPic);
                $img    ->  thumb(150,150,6);
                $midPic =   $upload->rootPath.$v['savepath'].'mid'.$v['savename'];
                $img    ->  save($midPic);
                //小图
                $img    ->  open($midPic);
                $img    ->  thumb(50,50,6);
                $smaPic =   $upload->rootPath.$v['savepath'].'sma'.$v['savename'];
                $img    ->  save($smaPic);
                unlink($picPath);
                $pics = [
                    'goods_id'  =>  $goos_id,
                    'pics_big'  => ltrim($bigPic,'.'),
                    'pics_mid'  => ltrim($midPic,'.'),
                    'pics_sma'  => ltrim($smaPic,'.'),
                ];
                M('goodsPics')->add($pics);
            }
        }
    }


    /**
     * @delGoods 删除商品
     * @author : Terry
     * @return
     */
    public  function  delGoods(){

    }



    /**
     * @dealGoodsAttr 处理商品属性
     *
     * @param $id 商品id
     * @param $data 属性
     *
     * @author : Terry
     * @return
     */
    private function dealGoodsAttr($id,$data){

        foreach ( $data as $k =>$v){
            if (is_array($v) ){
                foreach ( $v as $vv)
                    if (!empty($vv)){
                        $attr['goods_id'] =$id;
                        $attr['attr_id'] = $k;
                        $attr['attr_value'] = $vv;
                        M('GoodsAttr')->add($attr);
                    }
            }
        }

    }

    /**
     * @createStaticHtml 页面静态化
     * @author : Terry
     * @return
     * ① 不应该写在后台
     * ② 单选属性,价格,库存都是变动的 不应该静态化
     * ③ 页面布局 layout
     * ④ 商品添加 可以自动静态化 或 用户点击商品 判断有没有静态化 若没有就静态化 若有直接访问
     * ⑤ 后台修改商品信息,应先删除原有静态化文件 从新生成
     */
    public function createStaticHtml(){
        $goods_id = I('post.goods_id');
        $path = './goodsHTML/' . date('Ym') . '/';
        if (!is_dir($path)) {
            mkdir ($path);
        }
        $fileUri =$path.'goods_'.$goods_id.'.html';
        if (!is_file($fileUri)){
            //大大的bug
            $goodsDetail =  D('Home/goods')->getGoodsDetail($goods_id);
            $this->assign('goodsInfo',$goodsDetail['goodsdetail']);
            $this->assign('attrInfo',$goodsDetail['attrInfo']);

            $result = file_put_contents($fileUri,$this->fetch('Home@goods:detail'));
                if ($result){
                    if (M('goods')->save(['goods_id'=>$goods_id,'static_url'=>$fileUri])){
                        $this->ajaxReturn(['status'=>200,'message'=>'静态页面生成成功']);
                    }
                    $this->ajaxReturn(['status'=>202,'message'=>'静态页面路由写入失败']);
                }else{
                    $this->ajaxReturn(['status'=>202,'message'=>'静态页面生成失败']);
                }
        }else{
            $this->ajaxReturn(['status'=>202,'message'=>'静态页面已存在']);
        }
    }




}