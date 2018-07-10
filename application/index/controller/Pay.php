<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Pay as payModel;
class Pay extends Base
{
    public function orderRedirect(){
        $payModel  = new payModel();
        $info = array();
        if(empty(request()->param())){
//            if(isset($_COOKIE['uppp'])){
//                $uid = $_COOKIE['uppp'];
//            }
            session_start();
            $oid = $_SESSION['ordernum'];


            $info['goods_name'] = '路友通火车票';
            $info['des'] = '火车票购票通道';

            $this->assign('ordernum',$oid);
            $this->assign('info',$info);

            if(isMobile){
                return view("mobile-pay");
            }else{
                return view("pc-pay");
            }
        }else{
            if(isMobile){
                $payModel->alipayphone();
            }else{
                $payModel->alipaypc();
            }
        }
    }

    public function mobeilePay(){
        return view('order/mobeilePay');
    }
    public function PCMobile(){
        return view('order/PCPay');
    }

    public function pay()//点击付款将付款信息存入数据库
    {
//        echo date("Ymd",time());
        $arr = array();
        if(!empty(request()->param())){
            $param = request()->param();
            $info = $param["data"];//购票人相关信息
            $price = $param["price"];//票价

            $oid = date("Ymd",time()).randStr(5);
            $uid = $_COOKIE["uppp"];
            $orderStatus = 1;
            $totalPrice = $param["totalPrice"];//交易金额
            $payTime = time();//付款时间  s  时间戳

            $orderTable['oid']=$oid;//订单需要添加的数据（数组）
            $orderTable['uid'] = $uid;
            $orderTable['orderStatus']=$orderStatus;
            $orderTable['cashTotal']=$totalPrice;
            $orderTable['payTime']=$payTime;

            $trainInfo = $_COOKIE['info'];//车次相关信息
            $trainInfo = json_decode($trainInfo,true);

            $trainNum = $trainInfo['train_no'];
            $trainType = $trainInfo['train_type'];
            $startStation = $trainInfo['start_station'];
            $endStation = $trainInfo['end_station'];
            $startTime = $trainInfo['start_time'];
            $endTime = $trainInfo['end_time'];
            $longTime = $trainInfo['run_time'];
            $seatType = $_COOKIE['type'];
            $outTrickType = '成人';
            $tStatus = 1;
            $cash = $price;

            $userIdList = array();
            $buyCustomerInfo = array();

            foreach($info as $items){
               $buyCustomerInfo['uid'] = intval($uid);
               $buyCustomerInfo['oid'] = $oid;//车次详细信息表数据
               $buyCustomerInfo['trainNum'] = $trainNum;
               $buyCustomerInfo['trainType'] = $trainType;
               $buyCustomerInfo['startStation'] = $startStation;
               $buyCustomerInfo['endStation'] = $endStation;
               $buyCustomerInfo['uidCard'] = $items['idcard'];//idcard
               $buyCustomerInfo['uidName'] = $items['gname'];//gname
               $buyCustomerInfo['oStatus'] = $tStatus;
               $buyCustomerInfo['longTime'] = $longTime;
               $buyCustomerInfo['time']= date('Y-m-d',$_COOKIE['sstime']);
               $buyCustomerInfo['startTime'] = $startTime;
               $buyCustomerInfo['endTime'] = $endTime;
               $buyCustomerInfo['seatType'] = $seatType;
               $buyCustomerInfo['outTrickType'] = $outTrickType;
               $buyCustomerInfo['cash'] = floatval($cash);
               array_push($userIdList,$buyCustomerInfo);
            }//
            //对于多个表的操作开启事务操作

            $payModel  = new payModel();
            $result = $payModel->pay($orderTable,$userIdList);
            if($result==1){
                session_start();
                $_SESSION['ordernum']=$oid;
                $arr = returnData(1,"");
            }else{
                $arr = returnData(0,"");
            }
        }

        return json_encode($arr);
    }

    public function returnurl(){
        $payModel  = new payModel();
        $result = $payModel->returnurl();

        if($result==1){
            echo '<script>alert("支付成功");</script>';
            sleep(3);
           return $this->redirect("http://192.168.191.1/lyt/public/index");
        }else{
            echo '<script>alert("支付失败");</script>';
            sleep(3);
            return $this->redirect("http://192.168.191.1/lyt/public/index");
        }
    }
}