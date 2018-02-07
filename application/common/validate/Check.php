<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/7/26
 * Time: 14:31
 */
namespace app\common\validate;
use think\Validate;
class Check extends Validate{
    protected $rule = [
        'number' => 'require|length:5',
        'pwd' => 'alphaNum|min:7',
        'tel' => ['regex' => '/^1[3|4|5|7|8|9]\d{9}$/'],
    ];
    protected $message = [
        'number.require' => '用户名必须',
        'number.length'     => '用户名是五位数的员工编号',
        'pwd.alphaNum' =>  '密码不能包含特殊字符,由数字和字母组成',
        'pwd.min'     => '密码至少为7个字符',
        'tel'   => '手机号码格式不正确'
    ];
    protected $scene = [
        'login' => ['number','pwd'],
        'tel_check' => ['tel'],
        'reset_pwd' => ['pwd'],
    ];
}
