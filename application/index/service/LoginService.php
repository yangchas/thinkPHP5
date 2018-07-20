<?php
/**
 * Created by PhpStorm.
 * User: hiwin045
 * Date: 2018/7/13
 * Time: 14:18
 */

namespace app\index\service;

use app\index\model\User;
use think\Exception;
use think\Session;

class LoginService
{
    //检查
    public function check($data)
    {
        $name = $data['name'];
        $password = $data['password'];
//        $time = $data['time'];
        $timer = $data['timer'];
        $captcha = $data['captcha'];
//        $User =new User();
        //三次限制登录
        if (Session::get('info.login_time') > 4) {
            Session::set('info.code', 1);
            if (Session::get('info.start_time')) {
                if ($timer - Session::get('info.start_time') > 60) {
                    Session::set('info.start_time', $timer);
//                    Session::set('info.login_time',1);
                } else throw new Exception('登录次数过多,限制登录!');
            } else {
                Session::set('info.start_time', $timer);
//                Session::set('code',1);
//                Session::set('info.login_time',1);
//                throw new Exception('登录次数过多,限制登录!');
            }
        }

        if (!$name) {
            throw new Exception('用户名为空, 请重新输入!');
        }
        if (!$password) {
            throw new Exception('密码为空, 请重新输入!');
        }
        if (Session::has('info.code')) {
            if (!$captcha) throw new Exception('验证码为空, 请重新输入!');
            else if (!captcha_check($captcha))
                throw new Exception('验证码错误, 请重新输入!');
        }
        $user = User::get(['name' => $name]);
        if ($user) {
            $flag = $this->contrast($user->password, $password);
            if (!$flag) throw new Exception('密码错误, 请重新输入!');
            else {
                //登录成功
//                    Session::set('info.login_time',1);
                Session::delete('info');
                Session::set('user', 'user');

            }
        } else throw new Exception('无此用户, 请注册!');
    }

    //比对密码
    public function contrast($oldPwd, $newPwd)
    {
        $pwd = crypt($newPwd, substr(md5($newPwd), 1, 5));
        if ($pwd == $oldPwd)
            return true;
        else return false;
    }

    //注册
    public function register()
    {

    }

    //禁用
    public function disable()
    {

    }
}