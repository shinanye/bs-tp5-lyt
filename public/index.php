<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
include_once "./judgeMobile.php";
define("isMobile",isMobile());
//requireAlipayFile();
if(isMobile){
//        echo "移动端";
    require_once("../extend/alipay/mobile/alipay.config.php");
    require_once("../extend/alipay/mobile/lib/alipay_submit.class.php");
    require_once("../extend/alipay/mobile/lib/alipay_notify.class.php");
}else{
//        echo "PC端";
    require_once("../extend/alipay/pc/alipay.config.php");
    require_once("../extend/alipay/pc/lib/alipay_submit.class.php");
    require_once("../extend/alipay/pc/lib/alipay_notify.class.php");
}

define('APP_PATH', __DIR__ . '/../application/');

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
