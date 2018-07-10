<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Details extends Model{

    public function addNewAdultInfo($arr)
    {//新增成人信息（姓名、身份证件号）
        $data = Db::table("lyt_customerinfo")
            ->insert($arr);

        $userId = Db::name('lyt_customerinfo')->getLastInsID();
        return $userId;
    }

    public function getBuyInfo($id){//购票人信息（姓名、身份证号）
        $data = Db::table("lyt_customerinfo")
                ->where("uid",$id)
                ->field("id,uidCard,uidName")
                ->select();
            return $data;

    }
}