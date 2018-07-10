<?php
namespace app\agents\controller;

use think\Controller;

class Picture extends Controller
{
    public function pictureList()
    {
        return view("picture-list");
    }
    public function pictureAlter()
    {
        return view("picture-alter");
    }
}
