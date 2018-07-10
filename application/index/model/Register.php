<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Register extends Model{
    public function addUser($info){
        $data = Db::table("lyt_user")
            ->insert($info);

        $userId = Db::name('lyt_user')->getLastInsID();
        return $userId;
    }

    public function searchUname($uname){
        $data = Db::table("lyt_user")
            ->where("lname",$uname)
            ->select();
        return $data;
    }

    public function searchPWD($upwd){
        $data = Db::table("lyt_user")
            ->where("upwd",$upwd)
            ->select();
        return $data;
    }

    public function searchTel($utel){
        $data = Db::table("lyt_user")
            ->where("utel",$utel)
            ->select();
        return $data;
    }
}

