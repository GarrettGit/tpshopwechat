<?php
/**
 * Created by PhpStorm.
 * ExtensionModel.class.php
 * author: Terry
 * Date: 2017/7/7
 * Time: 8:27
 * description:
 */
namespace Admin\Model;



class ExtensionModel extends  BaseModel {

        protected $patchValidate = true;
        protected  $_auto=[
            ['created_at','time',self::MODEL_INSERT,'function'],
            ['updated_at','time',self::MODEL_BOTH,'function'],
        ];
        protected $insertFields = array('ext_title','ext_url','ext_number','flag','created_at','ext_introduce','updated_at');
        protected $updateFields = array('id','ext_title','ext_url','ext_number','flag','created_at','ext_introduce','updated_at');
        protected $_validate = array(
            array('ext_title', 'require', '推广主题不能为空！', 1, 'regex', 3),
            array('ext_title', '1,120', '推广主题的值最长不能超过 120 个字符！', 1, 'length', 3),
            array('ext_url', 'require', '推广地址不能为空！', 1, 'regex', 3),
            array('ext_url', '1,120', '推广地址的值最长不能超过 120 个字符！', 1, 'length', 3),
            array('ext_number', 'number', '推广基数必须是一个整数！', 2, 'regex', 3),
            array('ext_introduce', 'require', '推广内容不能为空！', 1, 'regex', 3),
        );
    public function search($pageSize = 20)
    {
        /**************************************** 搜索 ****************************************/
        $where['is_del']=0;
        if($ext_title = I('get.ext_title'))
            $where['ext_title'] = array('like', "%$ext_title%");
        if($ext_url = I('get.ext_url'))
            $where['ext_url'] = array('like', "%$ext_url%");
        if($ext_number = I('get.ext_number'))
            $where['ext_number'] = array('eq', $ext_number);
        if($flag = I('get.flag'))
            $where['flag'] = array('eq', $flag);
        if($created_at = I('get.created_at'))
            $where['created_at'] = array('eq', $created_at);
        if($ext_introduce = I('get.ext_introduce'))
            $where['ext_introduce'] = array('eq', $ext_introduce);
        if($updated_at = I('get.updated_at'))
            $where['updated_at'] = array('eq', $updated_at);
        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new \Think\Page($count, $pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $data['page'] = $page->show();
        /************************************** 取数据 ******************************************/
        $data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
        return $data;
    }

    /**
     * @getOneData 返回一条数据
     *
     * @param $id 推广id
     *
     * @author : Terry
     * @return
     */
    public  function getOneData($id)
    {
        return parent::getOneData($id);
    }

    /**
     * @delExt 删除
     * @author : Terry
     * @return
     */
    public function delExt($ext_id){
        $data['id']=$ext_id;
        $data['is_del']=1;
        if($this->save($data)){
            return true;
        }
        $this->error='删除失败';
        return false;
    }

}

