<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin as adminModel;

class Admin extends Controller
{
    public function adminList()
    {
        $adminModel = new adminModel();
        $result = $adminModel->adminList();
        $this->assign('count',count($result));
        $this->assign('info',$result);
        return view("admin-list");
    }

    public function adminAdd()
    {
        return view("admin-add");
    }

    public function adminEdit()
    {
        return view("admin-edit");
    }

    public function adminAddRole()
    {
        return view("admin-add-role");
    }

    public function adminRoleEdit()
    {
        return view("admin-role-edit");
    }

    public function adminRole()//角色管理
    {
        return view("admin-role");
    }


    public function changePwd()
    {
        return view("admin-change-pwd");
    }

}
