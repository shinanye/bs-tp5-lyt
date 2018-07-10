<?php
namespace app\admin\controller;

use think\Controller;
use \app\admin\model\Index as indexModel;

class Index extends Controller
{
    public function register()
    {
        $arr= array();
        $info = array();
        $indexModel = new indexModel();
        if(!empty(request()->param())) {//注册界面有参数的情况
            $req = request();
            $admin_name = $req->param("uname");
            $admin_pwd = $req->param("pwd");
            $admin_tel = $req->param("utel");
            $admin_email = $req->param("uEmail");
            $info["admin_name"] = $admin_name;
            $info["admin_pwd"] = md5(sha1($admin_pwd));
            $info["admin_tel"] = $admin_tel;
            $info['admin_join_time'] = date('Y-m-d H:i:s',time());
            $info["admin_email"] = $admin_email;

            $code = $req->param("code");
            if($_COOKIE["code"]===$code){
                $data = $indexModel->registerNameQuery($admin_name);
                if(empty($data)){
                    $data = $indexModel->registerPwdQuery($info["admin_pwd"]);
                    if(empty($data)){
                        $data = $indexModel->registerTelQuery($admin_tel);
                        if(empty($data)){
                            $data = $indexModel->registerEmailQuery($admin_email);
                            if(empty($data)){
                                $addAdminId = $indexModel->getRegisterId($info);
                                setcookie("jackId",$addAdminId,time()+3600*24,"/");
                                $arr = retuanData(1,"注册成功");
                            }else{
                                $arr = retuanData(0,"该邮箱已被注册");
                            }//email
                        }else{
                            $arr = retuanData(0,"该手机号已被使用");
                        }//tel
                    }else{
                        $arr = retuanData(0,"该密码已被使用");
                    }//pwd
                }else{
                    $arr = retuanData(0,"用户名已被注册");
                }//uname
            }else{
                $arr = retuanData(0,"验证码不正确，请重新获取");
            }//code
            return json_encode($arr);
        }
        else{
            return view("register");
        }
    }

    public function login()
    {
        $arr= array();
       if(!empty(request()->param())){//登录界面有参数的情况
           $code = request()->param("code");
           if (captcha_check($code)){
               $validate = $this->validate($_POST,'User.login');
               if(true ===$validate){
                    $indexModel = new indexModel();
                   $uname = request()->param("uname");
                   $data = $indexModel->login($uname);
                    if(!empty($data)){//查无此人
                        $redata = $data[0]["admin_pwd"];
                        $pwd = request()->param("pwd");
                        $pwd = md5(sha1($pwd));
                        $status = checkMatch($redata,$pwd);
                        if($status){
                            if((request()->param("online"))=="online"){
                                setcookie("astime",time(),time()+3600*24,"/");
                                setcookie("jackId",$data[0]["Id"],time()+3600*24,"/");
                            }
                            $arr = retuanData(1,"登陆成功");
                        }else{
                            $arr = retuanData(0,"登录密码不正确");
                        }
                    }else{
                        $arr = retuanData(0,"该用户名不存在，请联系管理员");
                    }
               }else{
                   if($validate=="令牌数据无效"){
                       $arr = retuanData(0,"请刷新页面");
                   }else{
                       $arr = retuanData(0,$validate);
                   }
               }
           }else{
               $arr = retuanData(0,"验证码错误，请先获取验证码");
           }
           return json_encode($arr);
       }
       else{//登录界面无参  显示登录界面
           return view("login");
       }
    }

    public function index()
    {
       return view("index");
    }

    public function trains()
    {
//        var_dump(request()->param());
        if(!empty(request()->param())){
            $start = request()->param("start");
            $end = request()->param("end");
            $time = request()->param("time");
            $trainNum = request()->param("trainNum");
            $key = "d2dbd9f8800ba9030431020358fffb56";
            $url = "http://apis.juhe.cn/train/s2swithprice?start=".$start."&end=".$end."&traintype=&key=".$key;
           $data =  _request($url,false);
            $data = json_decode($data,true);
//            foreach($data["result"]["list"])
//           var_dump($data["result"]["list"]);
            foreach($data["result"]["list"] as $item){
                var_dump( $item["price_list"]);
            }
//            var_dump($data["result"]["list"][])
        }
        else{
            return view("trains");
        }
    }

    public function welcome(){
        $now = date('Y-m-d H:i:m',time());
        $this->assign('now',$now);
        return $this->fetch("welcome");
    }

    public function sendSMS(){
        $tel = request()->param("utel");
        return json_encode(sendSMS($tel),true);
    }
}
