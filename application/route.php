<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
//    Route::get(':current/trainList','index/index/trainList'),
    'index/trainList'=>'index/index/trainList',
    'train/trainList/trainNum/:trainNum'=>'index/train/trainList',
    'station/trainList/trainName/:trainName'=>'index/station/trainList',

    'index'=>'index/index/index',
    'index/trainList/details/id/:id'=>'index/details/details',//车次详细信息
    'order/advanceOrder'=>'index/details/advanceOrder',//预订
    'order/advanceOrder/addPayTricket'=>'index/details/addPayTricket',//

    'order/advanceOrder/addNewAdultInfo'=>'index/details/addNewAdultInfo',//添加成人乘客信息

    'login'=>'index/index/login',
    'register'=>'index/index/register',

    "order/pry"=>"index/pay/pay",//支付订单
    "order/redirect"=>"index/pay/orderRedirect",//支付订单
    "order/mobeilePay"=>"index/pay/mobeilePay",
    "order/PCPay"=>"index/pay/PCMobile",
    "pay/user/out_trade_no/:out_trade_no"=>'index/pay/returnurl',


    'service'=>'index/other/service',


    'order'=>'index/order/order',

    'user'=>'index/user/user',
    'user/userinfo'=>'index/user/userInfo',
    'user/currentUser'=>'index/user/currentUser',


    'station'=>'index/station/station',
    'sstation'=>'index/sstation/sstation',
    'train'=>'index/train/train',
    'setting'=>'index/setting/setting',
];
