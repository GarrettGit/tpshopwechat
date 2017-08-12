<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Mongo' instanceof Think\Model\MongoModel,
			'View' instanceof Think\Model\ViewModel,
			'Role' instanceof Admin\Model\RoleModel,
			'Base' instanceof Admin\Model\BaseModel,
			'MemberLevel' instanceof Admin\Model\MemberLevelModel,
			'Extension' instanceof Admin\Model\ExtensionModel,
			'Order' instanceof Home\Model\OrderModel,
			'Adv' instanceof Think\Model\AdvModel,
			'Type' instanceof Admin\Model\TypeModel,
			'WechatSeckill' instanceof WeChat\Model\WechatSeckillModel,
			'Relation' instanceof Think\Model\RelationModel,
			'Attribute' instanceof Admin\Model\AttributeModel,
			'Manager' instanceof Admin\Model\ManagerModel,
			'User' instanceof Home\Model\UserModel,
			'Backage' instanceof Admin\Model\BackageModel,
			'Goods' instanceof Home\Model\GoodsModel,
			'Merge' instanceof Think\Model\MergeModel,
		],
	];
}