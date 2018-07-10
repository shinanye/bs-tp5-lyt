<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Admin extends Model
{
    public function adminList()
    {
        $data = Db::table('lyt_admin')
                    ->alias('a')
                    ->join('lyt_role r','a.role_id=r.id')
                    ->field('a.id,a.admin_name,a.admin_sex,a.admin_tel,a.admin_email,a.admin_join_time,a.admin_status,r.actor')
                    ->select();
        return $data;
    }
}