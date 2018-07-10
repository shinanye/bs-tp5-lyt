<?php
namespace app\agents\controller;

use think\Controller;

class Member extends Controller
{
    public function memberList()
    {
        return view("member-list");
    }


    public function memberAdd()
    {
        return view("member-add");
    }

    public function memberDel()
    {
        return view("member-del");
    }

    public function changePwd()
    {
        return view("member-change-pwd");
    }

    public function memberEdit()
    {
        return view("member-edit");
    }
}
