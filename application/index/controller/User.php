<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\AlterInfo;

class User extends Base
{
    public function currentUser()
    {
        if(isset($_COOKIE["uppp"])){
            $uppp = $_COOKIE["uppp"];
            $infoModel = new AlterInfo();
            $result = $infoModel->getAllUserInfo($uppp);
            $this->assign("info",$result);
            return view("current-user");
        }else{
            $this->redirect('index/index/login');
        }
    }

    public function user()
    {
        if(!empty(request()->param())){
            setcookie("uppp", "", time()-3600,"/");
            $arr = returnData(1,"");
            return json_encode($arr);
        }else{
            return view("user");
        }
    }

    public function userInfo(){//用户个人信息
//        setcookie("uppp","5",time()+3600*24,"/");
        $arr = array();
        
        if(isset($_COOKIE["uppp"])){
            $uppp = $_COOKIE["uppp"];
            $infoModel = new AlterInfo();

            $info = $infoModel->getUserInfo($uppp);
            $info = $info[0];
            $this->assign("name",$info["lname"]);
            $this->assign("pwd",$info["upwd"]);
            $this->assign("tel",$info["utel"]);
            $this->assign("sex",$info["usex"]);

            if(!empty(request()->param())){
                $type = request()->param("cate");

                if($type=="user"){
                    $uname = request()->param("username");
                    $data = $infoModel->alterName($uppp,$uname);
                    if($data==0){
                        $arr = returnData(0,"用户名修改失败");
                    }else{
                        $arr = returnData(1,"用户名修改成功");
                    }
                }elseif($type=="pwd"){
                    $upwd = request()->param("pwd");
                    $data = $infoModel->alterPwd($uppp,$upwd);
                    if($data==0){
                        $arr = returnData(0,"密码修改失败");
                    }else{
                        $arr = returnData(1,"密码修改成功");
                    }

                }elseif($type=="sex"){
                    $usex = request()->param("select");
                    $data = $infoModel->alterSex($uppp,$usex);
                    if($data==0){
                        $arr = returnData(0,"性别修改失败");
                    }else{
                        $arr = returnData(1,"性别修改成功");
                    }
                }elseif($type=="tel"){
                    $utel = request()->param("tel");
                    $data = $infoModel->alterTel($uppp,$utel);
                    if($data==0){
                        $arr = returnData(0,"联系方式修改失败");
                    }else{
                        $arr = returnData(1,"联系方式修改成功");
                    }
                }
              return json_encode($arr);
            }else{
                return view("user-info");
            }
        }else{//用户没有登录
            $this->redirect("index/index/login");
        }
       
       
    }
}
