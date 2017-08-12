<?php
return array(
	'tableName' => 'sp_extension_log',    // 表名
	'tableCnName' => '',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('title','url','number','flag','add_time','content')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','title','url','number','flag','add_time','content')",
	'validate' => "
		array('title', 'require', '推广主题不能为空！', 1, 'regex', 3),
		array('title', '1,120', '推广主题的值最长不能超过 120 个字符！', 1, 'length', 3),
		array('url', 'require', '推广地址不能为空！', 1, 'regex', 3),
		array('url', '1,120', '推广地址的值最长不能超过 120 个字符！', 1, 'length', 3),
		array('number', 'number', '推广基数必须是一个整数！', 2, 'regex', 3),
		array('flag', 'number', '推广状态 1结束 2进行 3失败必须是一个整数！', 2, 'regex', 3),
		array('add_time', 'require', '推广时间不能为空！', 1, 'regex', 3),
		array('add_time', 'number', '推广时间必须是一个整数！', 1, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'title' => array(
			'text' => '推广主题',
			'type' => 'text',
			'default' => '',
		),
		'url' => array(
			'text' => '推广地址',
			'type' => 'text',
			'default' => '',
		),
		'number' => array(
			'text' => '推广基数',
			'type' => 'text',
			'default' => '0',
		),
		'flag' => array(
			'text' => '推广状态 1结束 2进行 3失败',
			'type' => 'text',
			'default' => '1',
		),
		'add_time' => array(
			'text' => '推广时间',
			'type' => 'text',
			'default' => '',
		),
		'content' => array(
			'text' => '推广内容',
			'type' => 'html',
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('title', 'normal', '', 'like', '推广主题'),
		array('url', 'normal', '', 'like', '推广地址'),
		array('number', 'normal', '', 'eq', '推广基数'),
		array('flag', 'normal', '', 'eq', '推广状态 1结束 2进行 3失败'),
		array('add_time', 'normal', '', 'eq', '推广时间'),
		array('content', 'normal', '', 'eq', '推广内容'),
	),
);