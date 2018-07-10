<?php
namespace app\index\controller;

use think\Controller;

class Other extends Base
{
    public function about()
    {
        return view("about");
    }

    public function service()//生活服务
    {
        return view("service");
    }

    public function share()
    {
        return view("share");
    }

    public function help()
    {
        return view("help");
    }

    public function finishOrder()//已完成订单
    {
        return view("finishOrder");
    }
}
