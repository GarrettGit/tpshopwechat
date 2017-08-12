<?php
namespace  Admin\Model;
use Think\Model;

class RoleModel extends Model{
    /** 分配权限
     * @param $role_id 角色id
     * @param $auth_ids 修改权限id
     *
     * @return bool
     * author  rui
     */
    public  function saveAuth($role_id,$auth_ids){
        //获取现有角色信息
        $roleInfo = $this->find($role_id);
        $authIds = implode(',',$auth_ids);
        if ($roleInfo['role_auth_ids'] ===$authIds ){
            $this->error='权限未改动';
            return false;
        }
        $authInfo = M('Auth')->where([
                    'auth_level'=>['gt',0],
                     'auth_id'=>['in',$authIds]
        ])->select();
        $newAuth =array();
        foreach ($authInfo as $val){
            if (0 !=$val['auth_level']){
                $newAuth[] = $val['auth_c'].'-'.$val['auth_a'];
            }

        }
        $authAC = implode(',',$newAuth);
        $authData = array(
            'role_id'       =>  $role_id,
            'role_auth_ids' =>  $authIds,
            'role_auth_ac'  =>  $authAC
        );
        if ($this->save($authData)){
           return true;
        }
        $this->error=' 分配失败,请与管理员联系';

    }
}