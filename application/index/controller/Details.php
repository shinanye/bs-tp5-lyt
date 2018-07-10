<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Details as DetailsModel;

class Details extends Base
{
    public function details()//火车详细信息
    {
        $this->assign("current","index");
        $id = request()->param("id");
        $arrlist = file_get_contents("trainInfo.txt");
        $info = array();
        $listTrains = array();
        $arrlist = json_decode($arrlist,true);
        $result = $arrlist["result"];
        $list = $result["list"];
        foreach($list as $items){
            if($items["train_no"]===$id){
                array_push($info,$items);
            }
        }

        foreach($info[0] as $key=>$value){
            if(is_string($value)){
                $listTrains[$key] = $value;
            }
        }
        $listTrains = json_encode($listTrains);
        $this->assign("info",$info);
        $this->assign("listTrains",$listTrains);
        return view("train-details");
    }

    public function advanceOrder(){
        $arr = array();

        if(!empty(request()->param())){
            $zuoNumtype = request()->param("txt");
            $info = request()->param("options");
            $price = request()->param("price");
            setcookie("info",$info,time()+24*3600,"/");
            setcookie("pricess",$price,time()+24*3600,"/");
            setcookie("type",$zuoNumtype,time()+24**2*1800,"/");
//            var_dump(isset($_COOKIE["uppp"]));
           if(isset($_COOKIE["uppp"])){
               $arr = returnData(0,"");
           }else{
              $arr = returnData(2,"");

           }
            return json_encode($arr,true);
        }
    }

    public function addPayTricket(){

        $arr = array();

        $info = $_COOKIE["info"];
        $zuoType = $_COOKIE["type"];
        $sstime = $_COOKIE["sstime"];
        $price = $_COOKIE["pricess"];
        $id = $_COOKIE["uppp"];
        $info = json_decode($info,true);

        $detailsModel = new DetailsModel();
        $result = $detailsModel->getBuyInfo($id);

        $sstime = date("Y-m-d",$sstime);
        $this->assign("item",$info);//查询车次信息
        $this->assign("time",$sstime);//查询车次时间戳
        $this->assign("zuoType",$zuoType);//座次
        $this->assign("price",$price);
        $this->assign("info",$result);

        if(!empty(request()->param())){

        }else{
            return view("add-tricket-info");
        }
    }

    public  function addNewAdultInfo(){//新增成人信息（姓名、身份证件号）
        $arr = array();
        $cookie = "";
        if(isset($_COOKIE["uppp"])){
            $cookie = $_COOKIE["uppp"];
        }

        if(!empty(request()->param())){
            $userName = request()->param("names");//新增乘车人姓名
            $idCard = request()->param("IDCard");//新增乘车人身份证号
        }
        $info =array();
        $info["uid"] = $cookie;
        $info["uidName"] = $userName;
        $info["uidCard"] = $idCard;


        $detailsModel = new DetailsModel();
        $result = $detailsModel->addNewAdultInfo($info);

        if($result>0){
            $arr = returnData(1,"",$result);
        }else{
            $arr = returnData(0,"");
        }

        return json_encode($arr);
    }


}
