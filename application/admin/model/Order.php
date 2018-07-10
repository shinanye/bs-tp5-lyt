<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Order extends Model
{
    public function alterOrderDelStatus($oid)//订单删除状态修改（订单进行物理删除）
    {
        $data = Db::table('lyt_order')
                ->where("oid",$oid)
                ->update(['delStatus'=>0]);
        return $data;
    }

    public function orderAll()
    {
        $data = Db::table('lyt_user')
                    ->alias('u')
                    ->join('lyt_order o','u.uid=o.uid')
                    ->join('lyt_trains t','o.oid=t.oid')
                    ->where('delStatus',1)
                    ->field('u.uname,o.oid,o.payTime,t.trainNum,t.startStation,t.endStation,o.cashTotal,o.orderStatus')
                    ->select();
        return $data;
    }

    public function orderFinish($status)
    {
        $data = Db::table('lyt_user')
            ->alias('u')
            ->join('lyt_order o','u.uid=o.uid')
            ->join('lyt_trains t','o.oid=t.oid')
            ->where(['o.orderStatus'=>$status,'delStatus'=>1])
            ->field('u.uname,o.oid,o.payTime,t.trainNum,t.startStation,t.endStation,o.cashTotal,o.orderStatus')
            ->select();
        return $data;
    }

    public function orderInfo($oid){
        $data = Db::table('lyt_user')
                    ->alias('u')
                    ->join('lyt_order o','u.uid=o.uid')
                    ->join('lyt_trains t','o.oid=t.oid')
                    ->where('o.oid',$oid)
                    ->field('u.uname,o.oid,o.payTime,t.trainNum,t.startStation,t.endStation,o.cashTotal,o.orderStatus')
                    ->select();
        return $data;
    }

    public function orderTrickInfo($oid){
        $data = Db::table('lyt_trains')
                ->where('oid',$oid)
                ->field('uidName,uidCard,outTrickType,seatType')
                ->select();
        return $data;
    }

    public function delOrderList(){//删除订单列表信息
        $data = Db::table('lyt_user')
            ->alias('u')
            ->join('lyt_order o','u.uid=o.uid')
            ->join('lyt_trains t','o.oid=t.oid')
            ->where(['orderStatus'=>2,'delStatus'=>0])
            ->field('u.uname,o.oid,o.payTime,t.trainNum,t.startStation,t.endStation,o.cashTotal,o.orderStatus')
            ->select();
        return $data;
    }
}