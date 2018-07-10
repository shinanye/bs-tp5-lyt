<?php
namespace app\agents\controller;

use think\Controller;

class Order extends Controller
{
    public function orderList()
    {
        return view("order-list");
    }

    public function orderHandle()
    {
        return view("order-handle");
    }

    public function orderFinish()
    {
        return view("order-finish");
    }

    public function orderLook()
    {
        return view("order-look");
    }
}
