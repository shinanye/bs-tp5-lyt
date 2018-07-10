<?php
namespace app\admin\controller;

use think\Controller;

class Agents extends Controller
{
    public function agentsList()
    {
        var_dump(request()->param());
        return view("agents-list");
    }

    public function agentsAdd()
    {
        if(!empty(request()->param())){

        }else{
            return view("agents-add");
        }
    }

    public function agentsSearch()
    {
        return view("agents-search");
    }

    public function changePwd()
    {
        return view("change-pwd");
    }

    public function agentsEdit()
    {
        return view("agents-edit");
    }
}
