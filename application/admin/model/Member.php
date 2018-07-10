<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Member extends Model
{
    public function memberBatch($list){//批量删除用户  修改用户状态值status=0
        Db::startTrans();
        try{
            foreach($list as $item){
                Db::table('lyt_user')
                    ->where('uid',$item)
                    ->update(['status'=>0]);
            }
            // 提交事务
            Db::commit();
            return 1;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }

    }
    public function recoverMemberDelStatus($uid)//删除用户 修改状态值status=1
    {
        $data = Db::table('lyt_user')
            ->where('uid',$uid)
            ->update(['status'=>1]);
        return $data;
    }

    public function alterMemberDelStatus($uid)//删除用户 修改状态值status=0
    {
        $data = Db::table('lyt_user')
                ->where('uid',$uid)
                ->update(['status'=>0]);
        return $data;
    }
    public function alterMemberPwd($uid,$pwd)//修改用户数据信息
    {
        $data = Db::table('lyt_user')
            ->where('uid',$uid)
            ->update(['upwd'=>$pwd]);
        return $data;
    }

    public function alterMemberInfo($uid,$info)//修改用户数据信息
    {
        $data = Db::table('lyt_user')
                ->where('uid',$uid)
                ->update($info);
        return $data;
    }
    public function memberList()
    {
        $data = Db::table('lyt_user')
                    ->select();
        return $data;
    }


    public function queryUserInfo($uid)
    {
        $data = Db::table('lyt_user')
            ->where('uid',$uid)
            ->select();
        return $data;
    }

    public function memberDel(){
        $data = Db::table('lyt_user')
            ->where('status',0)
            ->select();
        return $data;
    }

    public function memberExistField($tableName,$field,$tel){//查询字段是否存在 存在返回数组
        $data = Db::table($tableName)
            ->where($field,$tel)
            ->select();
        return $data;
    }

    public function memberAdd($arr){
        Db::table('lyt_user')
                ->insert($arr);
        $addId = Db::name('user')->getLastInsID();
        return $addId;
    }

    public function rowsNum(){
        $data = Db::table('lyt_user')
            ->field('uid')
            ->select();
        return $data;
    }
}