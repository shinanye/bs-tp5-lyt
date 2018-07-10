<?php
namespace app\index\controller;

use app\index\model\Login;
use app\index\model\Register;
use think\Controller;
header("Content-Type:application/json; charset=utf8");

class Index extends Base
{
    public function index()
    {

//        if(!empty(request()->param())){
//
//            setcookie("sstime",input("time"),null,"/");//时间戳
//            return json_encode(returnData(1,"暂不获取"));
//        }else{
//            return view("index");
//        }

       if(!empty(request()->param())){
           $start = input("start");
           $end = input("end");
           $time = date("Y/m/d",input("time"));
           $traintype = input("traintype");
           $key = "d2dbd9f8800ba9030431020358fffb56";
           $url = "http://apis.juhe.cn/train/s2swithprice?start=".$start."&end=".$end."&date=".$time."&traintype".$traintype."=&key=".$key;
           $data = _request($url,false);
//           var_dump( date("Y/m/d",input("time")));
//           exit;
           setcookie("sstime",input("time"),null,"/");
            file_put_contents("trainInfo.txt",$data);
//           return $data;
           return file_get_contents("trainInfo.txt");
       }else{
           return view("index");
       }
    }

    public function trainList()
    {
        $this->assign("current","index");
        $time = cookie("sstime");
//        var_dump(date("Y-m-d",$time));
        $this->assign("time",date("Y-m-d",$time));
        $arrlist = file_get_contents("trainInfo.txt");
        $arrlist = json_decode($arrlist,true);
        $result = $arrlist["result"];
        $list = $result["list"];

        $this->assign("trainList",$list);
        return view("train-list");
    }

    public function login()
    {
        $loginModel = new Login();
        $arr = array();
        if(!empty(request()->param())){

            $pamars = request();
            $info = array();
            $uname = $pamars->param("username");
            $upwd = $pamars->param("pwd");
            $info["lname"]=$uname;//用户登录名
            $info["upwd"]=md5(sha1($upwd));
            $data = $loginModel->searchUname($uname);
            if(!empty($data)){
                $data = $loginModel->searchPWD($info["upwd"]);
                if(!empty($data)){
                    $uid = $loginModel->getUserId($info);
                    $uid = $uid[0]["uid"];
                    setcookie("uppp",$uid,time()+24*3600,"/");
                    $arr = returnData(1,"登陆成功");
                }else{
                    $arr = returnData(0,"密码不正确");
                }//密码
            }
            else{
                $arr = returnData(0,"用户名不正确");
            }//用户名
            return json_encode($arr);
        }
        else{
            return view("login");
        }
    }

    public function register()
    {
        $arr = array();
        $info = array();
        if(!empty(request()->param())){
            $req = request();
//            var_dump(captcha_check($req->param("code")));
            if (captcha_check($req->param("code"))){
                $uname = $req->param("username");
                $upwd = $req->param("password");
                $utel = $req->param("tel");
                $info["lname"] = $uname;
                $info["upwd"] = md5(sha1($upwd));
                $info["utel"] = $utel;
                $registerModel = new Register();
                $data = $registerModel->searchUname($uname);
                if(empty($data)){
                    $data = $registerModel->searchPWD($info["upwd"]);
                    if(empty($data)){
                        $data = $registerModel->searchTel($utel);
                        if(empty($data)){
                            $addUserId = $registerModel->addUser($info);
                            setcookie("uppp",$addUserId,time()+24*3600,"/");
                            exit;
                            $arr = returnData(1,"注册成功");
                        }else{
                            $arr = returnData(0,"该手机号已被注册");
                        }//tel
                    }else{
                        $arr = returnData(0,"该密码已被使用");
                    }//pwd
                }else{
                    $arr = returnData(0,"该用户名已被注册");
                }//username

            }else{
                $arr = returnData(0,"验证码不正确，请重新填写");
            }//code
            return json_encode($arr);
        }
        else{
            return view("register");
        }
    }

    public function logout()//退出显示登录页面或者首页
    {
        return view("login");
    }
}
