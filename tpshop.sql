CREATE TABLE `sp_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `telephone` varchar(16) NOT NULL DEFAULT '' COMMENT '手机',
  `company` varchar(32) NOT NULL DEFAULT '' COMMENT '公司',
  `level_0_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0级地区',
  `level_1_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级地区',
  `level_2_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级地区',
  `level_3_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '三级地区',
  `level_4_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '4级地区',
  `level_5_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '5级地区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `postcode` varchar(12) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为默认',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `level_1_id` (`level_1_id`),
  KEY `level_2_id` (`level_2_id`),
  KEY `level_3_id` (`level_3_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='送货地址';

CREATE TABLE `sp_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `attr_name` varchar(32) NOT NULL COMMENT '属性名称',
  `type_id` smallint(5) unsigned NOT NULL COMMENT '外键，类型id',
  `attr_sel` enum('only','many') NOT NULL DEFAULT 'only' COMMENT 'only:输入框(唯一)  many:后台下拉列表/前台单选框',
  `attr_write` enum('manual','list') NOT NULL DEFAULT 'manual' COMMENT 'manual:手工录入  list:从列表选择',
  `attr_vals` varchar(256) NOT NULL DEFAULT '' COMMENT '可选值列表信息,例如颜色：白色,红色,绿色,多个可选值通过逗号分隔',
  `flag` int(1) NOT NULL DEFAULT '0' COMMENT '属性状态 1删除 0正常',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='属性表';

CREATE TABLE `sp_auth` (
  `auth_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(20) NOT NULL COMMENT '权限名称',
  `auth_pid` smallint(6) unsigned NOT NULL COMMENT '父id',
  `auth_c` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `auth_a` varchar(32) NOT NULL DEFAULT '' COMMENT '操作方法',
  `auth_level` enum('0','1') NOT NULL DEFAULT '0' COMMENT '权限等级',
  `level` int(1) NOT NULL,
  `falg` int(1) NOT NULL DEFAULT '1' COMMENT '权限状态 1正常 0删除',
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 COMMENT='权限表';

CREATE TABLE `sp_backage` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单',
  `backage_state` text NOT NULL COMMENT '快递信息',
  `backage_number` varchar(32) NOT NULL COMMENT '运单号',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='包裹快递';

CREATE TABLE `sp_consignee` (
  `cgn_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '会员id',
  `cgn_name` varchar(32) NOT NULL COMMENT '收货人名称',
  `cgn_address` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人地址',
  `cgn_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `cgn_code` char(6) NOT NULL DEFAULT '' COMMENT '邮编',
  PRIMARY KEY (`cgn_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='收货人表';

CREATE TABLE `sp_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_name` varchar(128) NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `goods_weight` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品重量',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类型id',
  `goods_introduce` text COMMENT '商品详情介绍',
  `goods_big_logo` char(100) NOT NULL DEFAULT '' COMMENT '图片logo大图',
  `goods_small_logo` char(100) NOT NULL DEFAULT '' COMMENT '图片logo小图',
  `is_del` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:正常  1:删除',
  `add_time` int(11) NOT NULL COMMENT '添加商品时间',
  `upd_time` int(11) NOT NULL COMMENT '修改商品时间',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '商品状态 1正常 0删除',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_name` (`goods_name`),
  KEY `goods_price` (`goods_price`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='商品表';

CREATE TABLE `sp_goods_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `attr_id` smallint(5) unsigned NOT NULL COMMENT '属性id',
  `attr_value` varchar(32) NOT NULL COMMENT '商品对应属性的值',
  PRIMARY KEY (`id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='商品-属性关联表';


CREATE TABLE `sp_goods_pics` (
  `pics_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `pics_big` char(128) NOT NULL DEFAULT '' COMMENT '相册大图800*800',
  `pics_mid` char(128) NOT NULL DEFAULT '' COMMENT '相册中图350*350',
  `pics_sma` char(128) NOT NULL DEFAULT '' COMMENT '相册小图50*50',
  PRIMARY KEY (`pics_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='商品-相册关联表';

CREATE TABLE `sp_manager` (
  `mg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `mg_name` varchar(32) NOT NULL COMMENT '名称',
  `mg_pwd` varchar(32) NOT NULL COMMENT '密码',
  `mg_time` int(10) unsigned NOT NULL COMMENT '注册时间',
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '管理员状态 1正常 0删除',
  PRIMARY KEY (`mg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=510 DEFAULT CHARSET=utf8 COMMENT='管理员表';

CREATE TABLE `sp_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '下订单会员id',
  `order_number` varchar(32) NOT NULL COMMENT '订单编号',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `order_pay` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '支付方式 0支付宝 1微信  2银行卡',
  `is_send` enum('是','否') NOT NULL DEFAULT '否' COMMENT '订单是否已经发货',
  `order_fapiao_title` enum('0','1') NOT NULL DEFAULT '0' COMMENT '发票抬头 0个人 1公司',
  `order_fapiao_company` varchar(32) NOT NULL DEFAULT '' COMMENT '公司名称',
  `order_fapiao_content` varchar(32) NOT NULL DEFAULT '' COMMENT '发票内容',
  `cgn_id` int(10) unsigned NOT NULL COMMENT 'consignee收货人地址-外键',
  `order_status` enum('0','2','1') NOT NULL DEFAULT '0' COMMENT '订单状态： 0未付款、1已付款 2取消',
  `add_time` int(10) unsigned NOT NULL COMMENT '记录生成时间',
  `upd_time` int(10) unsigned NOT NULL COMMENT '记录修改时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `cgn_id` (`cgn_id`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='订单表';

CREATE TABLE `sp_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `order_goods_number` tinyint(4) NOT NULL DEFAULT '1' COMMENT '购买单个商品数量',
  `goods_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品小计价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='商品订单关联表';

CREATE TABLE `sp_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `role_auth_ids` varchar(128) NOT NULL DEFAULT '' COMMENT '权限ids,1,2,5',
  `role_auth_ac` text COMMENT '控制器-操作,控制器-操作,控制器-操作',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;

CREATE TABLE `sp_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type_name` varchar(32) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='类型表';

CREATE TABLE `sp_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(128) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `user_email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_active` enum('激活','未激活') NOT NULL DEFAULT '未激活' COMMENT '账号是否激活',
  `active_code` char(15) NOT NULL DEFAULT '' COMMENT '激活校验码',
  `user_sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别',
  `openid` char(32) NOT NULL DEFAULT '' COMMENT 'qq登录的openid信息',
  `user_qq` varchar(32) NOT NULL DEFAULT '' COMMENT 'qq',
  `user_tel` varchar(32) NOT NULL DEFAULT '' COMMENT '手机',
  `wb_id` int(11) NOT NULL COMMENT '微博id',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '用户状态 0删除 1 正常 2冻结   3永久冻结',
  `user_introduce` text COMMENT '简介',
  `user_time` int(11) DEFAULT NULL,
  `last_time` int(11) NOT NULL DEFAULT '0',
  `blocked_time` int(11) DEFAULT NULL COMMENT '冻结时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57427 DEFAULT CHARSET=utf8 COMMENT='会员表';

CREATE TABLE `sp_user_active` (
  `user_id` int(11) NOT NULL,
  `active_code` varchar(255) NOT NULL,
  `rig_time` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

