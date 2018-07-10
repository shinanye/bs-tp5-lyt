<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件

function randStr($num){//随机数的个数
    $randStr = str_shuffle('1234567890');//产生6位随机验证码数字
    $rand = substr($randStr,0,$num);
    return $rand;
}

function getParam($p){
    $param = request()->param($p);
    return $param;
}


function returnData($code,$msg,$info=""){
    $arr = array("status"=>$code,"txt"=>$msg,"info"=>$info);
    return $arr;
}

function checkMatch($param1,$param2){
    if($param1==$param2){
        return true;
    }
    return false;
}

function _request($curl,$https=true,$method='GET',$data=null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl);
    curl_setopt($ch, CURLOPT_HEADER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if($https){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  //验证主机
    }
    if($method == 'POST'){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //3.抓取URL并把它传递给浏览器
    $content = curl_exec($ch);
    if ($content  === false) {
        return "网络请求出错: " . curl_error($ch);
        exit();
    }
    curl_close($ch);
    return $content;
}

