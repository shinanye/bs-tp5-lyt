<?php
namespace app\admin\validate;
use think\Validate;

header("Content-type: text/html; charset=utf-8");
class User extends Validate{
    protected $rule = [
        'uname'=>'require|max:11|min:2|token',
        'pwd'  =>  'require|max:16|min:6',
        'repwd'  =>  'require|max:16|min:6',
    ];

    //错误提示
    protected $message  =   [
        'uname.require' => '账号必须填写',
        'uname.min'     =>'至少4位字符',
        'uname.max'     =>'最多11位字符',
        'pwd.require' => '密码必须填写',
        'pwd.min' => '密码最小为6位字符',
        'pwd.max' => '密码最长为16位字符',
        'repwd.require' => '密码必须填写',
        'repwd.min' => '密码最小为6位字符',
        'repwd.max' => '密码最长为16位字符',
    ];

    protected $scene  =   [
        'login' => ['uname','pwd'],//验证的场景 => 需要验证的字段
//        'forget' => ['tel','newpwd'],
    ];
}