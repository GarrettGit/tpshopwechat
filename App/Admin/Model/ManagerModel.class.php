<?php
/**
 * Created by PhpStorm.
 * ManagerModel.class.php
 * author: Terry
 * Date: 2017/7/4
 * Time: 00:28
 * description:
 */
namespace Admin\Model;

class ManagerModel extends  BaseModel{
    // 开启批量验证
    protected $patchValidate = true;
    // 验证规则
    protected $_validate = [
        // 补充验证规则
        array('mg_name', 'require', '管理员不能为空！', 1, 'regex', 3),
        array('mg_pwd', 'require', '密码不能为空！', 1, 'regex', 1),

    ];
    // 自动填充 必须开启自动验证
    protected $_auto = [
        ['created_at', 'time', self::MODEL_INSERT, 'function'],
        ['updated_at', 'time', self::MODEL_BOTH, 'function'],
        // 补充填充规则
    ];
}