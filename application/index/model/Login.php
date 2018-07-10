<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Login extends Model{
    public function getUserId($info){
        $data = Db::table("lyt_user")
            ->where($info)
            ->field("uid")
            ->select();
        return $data;
    }

    public function searchUname($uname){
        $data = Db::table("lyt_user")
            ->where("lname",$uname)
            ->select();

        return $data;
    }

    public function searchPWD($pwd){
        $data = Db::table("lyt_user")
            ->where("upwd",$pwd)
            ->select();

        return $data;
    }
}

