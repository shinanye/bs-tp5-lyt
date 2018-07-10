<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Order as orderModel;
class Order extends Base
{
    public function order()//显示所有订单
    {


        $orderModel = new orderModel();
        if(isset($_COOKIE['uppp'])){
            $uid = $_COOKIE['uppp'];
            $orderTableInfo = $orderModel->order($uid);
            $trainsTableInfo = $orderModel->trains($uid);
            $orderInfo = array();
            $trainsInfo = array();

            foreach($orderTableInfo as $outItems){
                if($uid==$outItems['uid']){
                    foreach($trainsTableInfo as $innItems){
                        if($outItems['oid']==$innItems['oid']){
//                            var_dump($innItems);
                            $innItems['orderStatus'] = $outItems['orderStatus'];//车次详细信息表
                            $innItems['cashTotal'] = $outItems['cashTotal'];
                            $innItems['payTime'] = $outItems['payTime'];
                            $innItems['operation'] = $outItems['operation'];
                            $innItems['reTrickRecord'] = $outItems['reTrickRecord'];
                            $innItems['alterTrickRecord'] = $outItems['alterTrickRecord'];

                            $outItems['startStation'] = $innItems['startStation'];
                            $outItems['endStation'] = $innItems['endStation'];
                            $outItems['trainNum'] = $innItems['trainNum'];
                            $outItems['trainType'] = $innItems['trainType'];
                            $outItems['time'] = $innItems['time'];
                            $outItems['startTime'] = $innItems['startTime'];

                            array_push($trainsInfo,$innItems);//车次详细信息
                            array_push($orderInfo,$outItems);//订单相关信息
                        }
                    }
                }
            }


//           for($i=0,$j=0;$i<count($orderInfo);$i++){
//              if($j<count($orderInfo)){
//                  $j = $i+1;
//                  if($orderInfo[$i]['oid']==$orderInfo[$j]['oid']){
//                      unset($orderInfo[$j]);
//                  }
//              }
//
//           }
//            var_dump($orderInfo);
            $this->assign('orderInfo',$orderInfo);
            return view("order");
        }else{
            $this->redirect("index/index/login");
        }

    }

}
