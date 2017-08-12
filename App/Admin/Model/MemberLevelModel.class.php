<?php
namespace Admin\Model;
use Think\Model;

/**
 * Class MemberLevelModel 会员级别模型
 *
 * @package Admin\Model
 * @anthor  Terry
 *
 */
class MemberLevelModel extends Model 
{
	protected $insertFields = array('level_name','jifen_bottom','jifen_top','level_rate');
	protected $updateFields = array('id','level_name','jifen_bottom','jifen_top','level_rate');
	protected $_validate = array(
		array('level_name', 'require', '级别名称不能为空！'),
		array('level_rate', 'require', '折扣率不能为空！'),
		array('jf_bottom', 'require', '积分下限不能为空！'),
		array('jf_top', 'require', '积分下限不能为空！'),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($level_name = I('get.level_name'))
			$where['level_name'] = array('like', "%$level_name%");
		if($jf_bottom = I('get.jf_bottom'))
			$where['jf_bottom'] = array('eq', $jf_bottom);
		if($jf_top = I('get.jf_top'))
			$where['jf_top'] = array('eq', $jf_top);
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







	// 添加前 add()
	protected function _before_insert(&$data, $option)
	{


//        table' => string 'sp_member_level' (length=15)
//                  'model' => string 'memberLevel' (length=11)
	}
	protected function _after_insert($data, $option)
	{


//        table' => string 'sp_member_level' (length=15)
//                  'model' => string 'memberLevel' (length=11)
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{

	    /*var_dump($option);
        'table' => string 'sp_member_level' (length=15)
                  'model' => string 'memberLevel' (length=11)
                  'where' =>
                        array (size=1)
                             'id' => int 8*/
	}
	// 修改前
	protected function _after_update($data, $option)
	{


	    /*var_dump($option);
        'table' => string 'sp_member_level' (length=15)
                  'model' => string 'memberLevel' (length=11)
                  'where' =>
                        array (size=1)
                             'id' => int 8*/
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
//		    'id' => int 8
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}