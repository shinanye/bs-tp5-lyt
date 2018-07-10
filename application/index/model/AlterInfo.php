<?php
namespace app\index\model;

use think\Db;
use think\Model;

class AlterInfo extends Model{
    public function getAllUserInfo($id){//用户所有信息
        $data = Db::table("lyt_user")
            ->where("uid",$id)
            ->select();
        return $data;
    }

    public function getUserInfo($id){
        $data = Db::table("lyt_user")
            ->where("uid",$id)
            ->field("lname,upwd,utel,usex")
            ->select();
        return $data;
    }

    public function alterName($id,$uname){
        $data = Db::table('lyt_user')
                    ->where('uid', $id)
                    ->update(['uname' => $uname]);
        return $data;
    }

    public function alterPwd($id,$pwd){
        $data = Db::table('lyt_user')
                    ->where('uid', $id)
                    ->update(['upwd' => $pwd]);
        return $data;
    }

    public function alterSex($id,$sex){
        $data = Db::table('lyt_user')
                    ->where('uid', $id)
                    ->update(['usex' => $sex]);
        return $data;
    }

    public function alterTel($id,$tel){
        $data = Db::table('lyt_user')
                    ->where('uid', $id)
                    ->update(['utel' => $tel]);
        return $data;
    }
   
}

