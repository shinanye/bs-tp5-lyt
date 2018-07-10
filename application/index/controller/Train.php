<?php
namespace app\index\controller;

use think\Controller;

class Train extends Base
{
    public function train()//车次
    {
        if(!empty(request()->param())){
            $time = input("time");
            $trainNum = input("trainNum");
            $key = "d2dbd9f8800ba9030431020358fffb56";
            $url = "http://apis.juhe.cn/train/s?name=".$trainNum."&dtype=json&key=".$key;
            $result = _request($url,false);

            file_put_contents("trainInfo.txt",$result);
            return file_get_contents("trainInfo.txt");
        }else{
            return view("train");
        }
    }

    public function trainList()
    {
        $this->assign("current","train");

        $trainNum = request()->param("trainNum");
        $this->assign("trainNum",$trainNum);
        $arrlist = file_get_contents("trainInfo.txt");
        $arrlist = json_decode($arrlist,true);

        $result = $arrlist["result"];
        $trainInfo = $result["train_info"];
        $stationList = $result["station_list"];

        $this->assign("train_info",$trainInfo);
        $this->assign("train_list",$stationList);

        return view("train-list");
    }
}
