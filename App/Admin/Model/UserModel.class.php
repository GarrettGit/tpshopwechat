<?php
namespace  Admin\Model;

class UserModel extends BaseModel{
    /**返回多条数据
     * @param row 每页显示条数
     * @return mixed
     * author Fox
     */
    public function getAllData($param=[]){

        $count      = $this->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $this->order('user_id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($list as  $k=>$v){
            if ($v['flag'] == 0){
                $list[$k]['flag']='删除';
            }elseif($v['flag'] == 1){
                $list[$k]['flag']='正常';
            }elseif($v['flag'] == 2){
                $list[$k]['flag']='冻结';
            }else{
                $list[$k]['flag']='永久冻结';
            }
        }

        return ['list'=>$list,'page'=>$show];
    }

    /**
     * 用户冻结
     * author Fox
     */
    public function  userBlocked(array $param){
        if ($param['time'] == 'long'){
            $blackedState = $this->where(['user_id'=>$param['user_id']])->save(['flag'=>3]);
            if ($blackedState){
                return json_encode(['state'=>200,'message'=>'冻结成功']);
            }
        }else{
            $user =  parent::getOneData($param['user_id']);
            //如果之前处于冻结状态,加上新的冻结时间
            if ($user['flag'] ==2){
                $user['blocked_time'] = $user['blocked_time']+(86400*$param['time']);
            }else{
                $user['blocked_time']=time()+(86400*$param['time']);
            }
            $blackedState = $this->where(['user_id'=>$param['user_id']])->save(['flag'=>2,'blocked_time'=>$user['blocked_time']]);
            if ($blackedState){
                return json_encode(['state'=>200,'message'=>'冻结成功']);
            }else{
                return json_encode(['state'=>202,'message'=>'冻结失败']);
            }

        }


    }

    /**
     * @getUser
     *
     * @param int $number 推广基数
     *
     * @author : Terry
     * @return array
     */
    public  function getUser(int $number){
        $limit;
        if (isset($number)){
            $limit=$number;

        }
      return   $this->field('user_id,username,user_email')->order('user_id DESC')->limit($limit)->select();


    }

    /**
     * @export_execl 用户导出
     *
     * @param int $page
     *
     * @author : Terry
     * @return
     */
    public function export_execl($page=0){
         $data =    $this->limit('200','20000')->select();
        $this->PHPexecl($data);
    }



    /**
     * @export_execl 数据导出类
     *
     * @param $data
     *
     * @author : Terry
     * @return
     */
    private function PHPexecl($data){

        //设置php运行时间
        set_time_limit(0);
        /**
         * 大数据导出①
         * 设置php可使用内存
         * ini_set("memory_limit", "1024M");
         */

        Vendor('PHPExcel.PHPExcel');
        Vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel  = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel2007($objExcel);
        $objProps  = $objExcel->getProperties();
        $objProps->setCreator("tpshop");
        $objProps->setTitle("tpshop用户表");
        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(20);
        $objActSheet->getColumnDimension('D')->setWidth(20);
        $objActSheet->getColumnDimension('E')->setWidth(20);
        $objActSheet->getColumnDimension('F')->setWidth(20);
        $objActSheet->getColumnDimension('G')->setWidth(20);
        $objActSheet->setCellValue('A1', '用户ID');
        $objActSheet->setCellValue('B1', '用户名');
        $objActSheet->setCellValue('C1', '邮箱');
        $objActSheet->setCellValue('D1', '性别');
        $objActSheet->setCellValue('E1', 'QQ');
        $objActSheet->setCellValue('F1', '手机号');
        $objActSheet->setCellValue('G1', '年齡');
        foreach ($data as $key => $value) {
            $i = $key + 2;
            $objActSheet->setCellValue('A' . $i, $value['user_id']);
            $objActSheet->setCellValue('B' . $i, $value['username']);
            $objActSheet->setCellValue('C' . $i, $value['user_email']);
            $objActSheet->setCellValue('D' . $i, $value['user_sex'] == '1' ? '男' : '女');
            $objActSheet->setCellValue('E' . $i, $value['user_qq']);
            $objActSheet->setCellValue('F' . $i, $value['user_tel']);
        }
        //保存到服务器
        $dir = './Public/upload/execl/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $fileName = $dir . date("Y-m", time()) . '_tpshop用户表.xlsx';
        $objWriter->save($fileName);

        //保存到本地
//        $fileName = date("Y-m-d", time()) . '_tpshop用户表.xlsx';
//        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        //设置文件名
//        header('Content-Disposition:attachment;filename="'.$fileName.'"');
//        //禁止缓存
//        header('Cache-Control:max-age=0');
//        $objWriter->save("php://output");

    }

    public function getOneData($param)
    {
        return parent::getOneData($param);
    }

}