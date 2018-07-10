<?php
namespace app\admin\controller;

use \app\admin\model\Member as memberModel;
use think\Controller;

class Member extends Controller
{
    public function memberBatch(){//批量删除用户  修改用户状态值status=0
        if($_POST){
            $memberModel = new memberModel();
            $arr = array();
            $list = $_POST['list'];
            $result = $memberModel->memberBatch($list);
            if($result>0){
                $arr = returnData(1,'批量删除用户成功!');
            }else{
                $arr = returnData(0,'批量删除用户失败');
            }
            return json_encode($arr);
        }
    }
    public function memberRecoverStatus(){//还原用户状态 修改状态值status=1
        $memberModel = new memberModel();
        $arr = array();
        if(isset($_POST['item'])){
            $uid = $_POST['item'];
            $result = $memberModel->recoverMemberDelStatus($uid);
            if($result>0){
                $arr = returnData(1,'已还原!');
            }else{
                $arr = returnData(0,'还原用户失败');
            }
            return json_encode($arr);
        }
    }
    public function memberDel()//删除用户 修改状态值status=0
    {
        $memberModel = new memberModel();
        $arr = array();
        if(empty($_POST)) {
            $result = $memberModel->memberDel();
            $this->assign('info', $result);
            $this->assign('count',count($result));
            return view("member-del");
        }else{
            $uid = $_POST['item'];
            $result = $memberModel->alterMemberDelStatus($uid);
            if($result>0){
                $arr = returnData(1,'已删除');
            }else{
                $arr = returnData(0,'删除失败');
            }
            return json_encode($arr);
        }
    }

    public function memberList()
    {
        if(empty(request()->param())){
            $memberModel = new memberModel();
            $result = $memberModel->memberList();
            $this->assign('info',$result);
            $this->assign('count',count($result));
            return view("member-list");
        }
    }

    public function memberShow(){

       if(!empty(request()->param())){

           $uid = request()->param('item');
           $memberModel = new memberModel();
           $result = $memberModel->queryUserInfo($uid);

           $this->assign('info',$result);
           return view("member-show");
       }
    }
    public function memberAdd()
    {
        if(empty($_POST)){
            return view("member-add");
        }else{
            $memberModel = new memberModel();
            $info = array();
            $arr = array();
            $lname = request()->param('username');
            $usex = request()->param('sex');
            $uEmail = request()->param('email');
            $utel = request()->param('mobile');
            $info['lname'] = $lname;
            $info['usex'] = $usex;
            $info['uEmail'] = $uEmail;
            $info['utel'] = $utel;
            $info['upwd'] = md5(sha1('123456'));

            $result = $memberModel->memberExistField('lyt_user','utel',$utel);
//            var_dump($result);
            if(empty($result)){
                $newInsertId = $memberModel->memberAdd($info);
                $rowsNum = $memberModel->rowsNum();//行数
                $userInfo['rowsNum'] = count($rowsNum);
                $userInfo['uid'] = $newInsertId;
                $userInfo['lname'] = $lname;
                $userInfo['usex'] = $usex;
                $userInfo['uEmail'] = $uEmail;
                $userInfo['utel'] = $utel;
                $userInfo['status'] = 1;

                $arr = returnData(1,"用户添加成功",json_encode($userInfo));
            }else{
                $arr = returnData(0,"该手机号已被注册");
            }

            return json_encode($arr);
        }
    }



    public function changePwd()
    {
        $memberModel = new memberModel();
        $arr = array();
        if(empty($_POST)){//无post请求时
            $uid = request()->param('item');
            $lname = request()->param('lname');
            $this->assign('lname',$lname);
            $this->assign('uid',$uid);
            return view("member-change-pwd");
        }else{
            $uid = $_POST['uid'];
            $pwd = md5(sha1($_POST['newpassword']));
            $result = $memberModel->alterMemberPwd($uid,$pwd);
            if($result>0){
                $arr = returnData(1,'密码修改成功');
            }else{
                $arr = returnData(0,'密码修改失败');
            }
            return json_encode($arr);
        }
    }

    public function memberEdit()
    {
        $memberModel = new memberModel();
        if(empty($_POST)){//无post请求时
            $uid = request()->param('item');
            $result = $memberModel->memberExistField('lyt_user','uid',$uid);
            $this->assign("info",$result);
            return view("member-edit");
        }else{//修改用户信息
            $info = array();
            $arr = array();
            $uid = $_POST['uid'];
            $info['lname'] = $_POST['lname'];
            $info['usex'] = $_POST['sex'];
            $info['utel'] = $_POST['mobile'];
            $info['uEmail'] = $_POST['email'];

            $result = $memberModel->alterMemberInfo($uid,$info);
            if($result>0){
                $arr = returnData(1,'修改成功');
            }else{
                $arr = returnData(0,'信息修改失败');
            }
            return json_encode($arr);
        }

    }
}
