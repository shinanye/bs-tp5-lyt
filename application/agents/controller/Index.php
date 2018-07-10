<?php
namespace app\agents\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
       return view("index");
    }

    public function welcome(){
        return $this->fetch("welcome");
    }

    public function login()
    {
        return view("login");
    }
}
