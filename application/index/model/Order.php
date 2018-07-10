<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Order extends Model{
    public function orderJoinTrains($uid){
        $data = Db::table("lyt_order")
                    ->alias('o')
                    ->join('lyt_trains t','t.uid = o.uid',"left")
                    ->where(['t.uid'=>$uid])
                    ->select();
        return $data;
    }

   public function order($uid){//order表中数据信息
        $data = Db::table('lyt_order')
                    ->where("uid",$uid)
                    ->select();
       return $data;
   }

    public function trains($uid){//trains表中数据信息
        $data = Db::table('lyt_trains')
            ->where("uid",$uid)
            ->select();
        return $data;
    }


}