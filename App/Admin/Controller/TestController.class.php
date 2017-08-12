<?php
/**
 * Created by PhpStorm.
 * TestController.class.php
 * author: Terry
 * Date: 2017/7/22
 * Time: 7:54
 * description:
 */
namespace Admin\Controller;

use Think\Controller;

class TestController extends Controller{
    public function __construct()
    {
        parent::__construct();
        S(array('type'=>'memcache','host'=>'localhost','port'=>9880));
    }

    public  function test(){
//        S(array('type'=>'memcache','host'=>'localhost','port'=>9880));
      S('test',array('username'=>'terry','age'=>18));
      session('user','terry');
      echo session_id();
        echo 'ok';

    }
}