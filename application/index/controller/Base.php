<?php
namespace app\index\controller;

use think\Controller;

class Base extends Controller{
    public function  __construct()
    {
        parent::__construct();
        if(!defined('APP_PATH')){
            header('Location:error.php');
            exit;
        }
    }


}