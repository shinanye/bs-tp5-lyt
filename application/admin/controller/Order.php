<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Order as orderModel;
class Order extends Controller
{
    public function orderDel()
    {
        $outList = array();
        $innList = array();
        $arr =array();
        $orderModel = new orderModel();

        if(empty($_POST)){//无参数时
            $result = $orderModel->delOrderList();
            foreach($result as $items){
                foreach($items as $key=>$value){
                    if($key=='payTime'){
                        $time = date('Y-m-d H:i:m',$value);
                        $innList[$key] = $time;
                    }else{
                        $innList[$key] = $value;
                    }
                }
                array_push($outList,$innList);
            }

//            for($i=0;$i<count($outList);$i++){//数组去重
//                $j=$i+1;
//                if($j<count($outList)){
//                    if($outList[$i]['oid']==$outList[$j]['oid']){
//                        unset($outList[$j]);
//                    }
//                }
//            }

            $this->assign('count',count($outList));
            $this->assign('info',$outList);
            return view("order-del");
        }else{//修改订单删除状态
            $oid = $_POST['oid'];
            $result = $orderModel->alterOrderDelStatus($oid);

            if($result>0){
                $arr =returnData(1,'已删除');
            }else{
                $arr =returnData(0,'删除失败');
            }

            return json_encode($arr);
        }
    }
    public function orderList()
    {
        $outList = array();
        $innList = array();
        if(empty(request()->param())){//无参数时
            $orderModel = new orderModel();
            $result = $orderModel->orderAll();
            foreach($result as $items){
                foreach($items as $key=>$value){
                    if($key=='payTime'){
                        $time = date('Y-m-d H:i:m',$value);
                        $innList[$key] = $time;
                    }else{
                        $innList[$key] = $value;
                    }
                }
                array_push($outList,$innList);
            }

//            for($i=0;$i<count($outList);$i++){//数组去重
//                $j=$i+1;
//                if($j<count($outList)){
//                    if($outList[$i]['oid']==$outList[$j]['oid']){
//                        unset($outList[$j]);
//                    }
//                }
//            }

            $this->assign('count',count($outList));
            $this->assign('info',$outList);
            return view("order-list");
        }

    }

    public function orderHandle()
    {
        $outList = array();
        $innList = array();
        if(empty(request()->param())){//无参数时
            $orderModel = new orderModel();
            $result = $orderModel->orderFinish(1);
            foreach($result as $items){
                foreach($items as $key=>$value){
                    if($key=='payTime'){
                        $time = date('Y-m-d H:i:m',$value);
                        $innList[$key] = $time;
                    }else{
                        $innList[$key] = $value;
                    }
                }
                array_push($outList,$innList);
            }

//            for($i=0;$i<count($outList);$i++){
//                $j=$i+1;
//               if($j<count($outList)){
//                   if($outList[$i]['oid']==$outList[$j]['oid']){
//                       unset($outList[$j]);
//                   }
//               }
//            }
            $this->assign('count',count($outList));
            $this->assign('info',$outList);
            return view("order-handle");
        }

    }

    public function orderFinish()
    {
        $outList = array();
        $innList = array();
        if(empty(request()->param())){//无参数时
            $orderModel = new orderModel();
            $result = $orderModel->orderFinish(2);
            foreach($result as $items){
                foreach($items as $key=>$value){
                    if($key=='payTime'){
                        $time = date('Y-m-d H:i:m',$value);
                        $innList[$key] = $time;
                    }else{
                        $innList[$key] = $value;
                    }
                }
                array_push($outList,$innList);
            }

//           for($i=0;$i<count($outList);$i++){
//               $j=$i+1;
//               if($j<count($outList)){
//                   if($outList[$i]['oid']==$outList[$j]['oid']){
//                       unset($outList[$i]);
//                   }
//               }
//           }

            $this->assign('count',count($outList));
            $this->assign('info',$outList);
            return view("order-finish");
        }
    }

    public function orderLook()
    {
//        var_dump();
      if(!empty(request()->param())){
          $oid = request()->param("oid");
          $orderModel = new orderModel();

          $tricksInfo = $orderModel->orderInfo($oid);
          $info = $orderModel->orderTrickInfo($oid);
          $tricksInfo[0]['count'] = count($info);

          $tricksInfo[0]['payTime'] = date('Y-m-d H:i:s',$tricksInfo[0]['payTime']);

//          for($i=0;$i<count($tricksInfo);$i++){
//              $j=$i+1;
//              if($j<count($tricksInfo)){
//                  if($tricksInfo[$i]['oid']==$tricksInfo[$j]['oid']){
//                      unset($tricksInfo[$j]);
//                  }
//              }
//          }

          $this->assign("info",$tricksInfo);
          $this->assign('tricks',$info);

          return view("order-look");
      }
    }
}
