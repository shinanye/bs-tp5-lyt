<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Index extends Model
{
    public function login($uname)
    {
        $data = Db::name("admin")
            ->where("admin_name",$uname)
            ->field("Id,admin_pwd")
            ->select();
        return  $data;
    }

    public function registerNameQuery($uname){//register
        $data = Db::name("admin")
            ->where("admin_name",$uname)
            ->select();
        return  $data;
    }

    public function registerPwdQuery($upwd){
        $data = Db::name("admin")
            ->where("admin_pwd",$upwd)
            ->select();
        return  $data;
    }

    public function registerTelQuery($utel){
        $data = Db::name("admin")
            ->where("admin_tel",$utel)
            ->select();
        return  $data;
    }

    public function registerEmailQuery($uEmail){
        $data = Db::name("admin")
            ->where("admin_email",$uEmail)
            ->select();
        return  $data;
    }

    public function getRegisterId($info){
        $data = Db::table("lyt_admin")
            ->insert($info);
        $addId = Db::name('admin')->getLastInsID();
        return $addId;
    }
    //register---end
}
