<?php
return array(
	'tableName' => 'sp_member_level',    // 表名
	'tableCnName' => '',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('level_name','jf_bottom','jf_top')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','level_name','jf_bottom','jf_top')",
	'validate' => "
		array('level_name', 'require', '级别名称不能为空！', 1, 'regex', 3),
		array('level_name', '1,30', '级别名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('jf_bottom', 'require', '积分下限不能为空！', 1, 'regex', 3),
		array('jf_bottom', 'number', '积分下限必须是一个整数！', 1, 'regex', 3),
		array('jf_top', 'require', '积分下限不能为空！', 1, 'regex', 3),
		array('jf_top', 'number', '积分下限必须是一个整数！', 1, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'level_name' => array(
			'text' => '级别名称',
			'type' => 'text',
			'default' => '',
		),
		'jf_bottom' => array(
			'text' => '积分下限',
			'type' => 'text',
			'default' => '',
		),
		'jf_top' => array(
			'text' => '积分下限',
			'type' => 'text',
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('level_name', 'normal', '', 'like', '级别名称'),
		array('jf_bottom', 'normal', '', 'eq', '积分下限'),
		array('jf_top', 'normal', '', 'eq', '积分下限'),
	),
);