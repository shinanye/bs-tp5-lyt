<?php
namespace app\index\validate;
use think\Validate;

header("Content-type: text/html; charset=utf-8");
class User extends Validate{
    protected $rule = [
        'username'=>'require|max:11|min:4|token',
        'password'  =>  'require|max:11|min:6',
        'repassword'=>'equalTo:#password',
        'tel'  =>  'require',
    ];

    //错误提示
    protected $message  =   [
        'username.require' => '用户名必须填写',
        'username.min'     =>'至少4位字符',
        'username.max'     =>'最多11位字符',
        'password.require' => '密码必须填写',
        'password.min' => '密码最小为6位字符',
        'password.max' => '密码最长为11位字符',
        'repassword.equalTo'=>'确认密码与密码不相符',
        'tel.require' => '必须填写联系方式',
    ];

    protected $scene  =   [
        'register' => ['username','password','repassword','tel'],//验证的场景 => 需要验证的字段
//        'forget' => ['tel','newpwd'],
    ];
}