<?php
namespace app\index\controller;

use think\Controller;

class Station extends Base
{
    public function station()//站点查询
    {
        if(!empty(request()->param())){
            $trainName = input("trainName");
            $key = "d2dbd9f8800ba9030431020358fffb56";
            $url = "http://apis.juhe.cn/train/station.list.php?dtype=&key=".$key;
            $result = _request($url,false);
            file_put_contents("trainPointer.txt",$result);
        }else{
            return view("station");
        }
    }

    public function trainList()
    {
        $trainInfo = array();
        $this->assign("current","station");
        $trainName = input("trainName");
        if(!is_file("trainPointer.txt")){
            $key = "d2dbd9f8800ba9030431020358fffb56";
            $url = "http://apis.juhe.cn/train/station.list.php?dtype=&key=".$key;
            $result = _request($url,false);
            file_put_contents("trainPointer.txt",$result);
        }

        $arrlist = file_get_contents("trainPointer.txt");
        $arrlist = json_decode($arrlist,true);
        foreach($arrlist["result"] as $items){
            $sta_name = $items["sta_name"];
            if(strpos($sta_name,$trainName)!==false){
                array_push($trainInfo,$items);
            }
        }

//        var_dump($trainInfo);
       $this->assign("trainInfo",$trainInfo);
        return view("train-list");



    }
}
