<?php
/**
 * Created by PhpStorm.
 * User: hiwin045
 * Date: 2018/7/13
 * Time: 10:26
 */

namespace app\index\controller;

use app\index\service\LoginService;
use think\Controller;
use think\Exception;
use think\Request;
use think\Session;

class LoginController extends Controller
{
    public $loginService;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->loginService=new LoginService();
    }

    public function index()
    {
//        Session::delete('user');
        //获取登录次数
        $login_time=Session::get('info.login_time');
        if (!$login_time) Session::set('info.login_time',1);
        $msgs=Session::get('data');
        $code=Session::get('info.code');
        $this->assign('msg', $msgs);
        $this->assign('login_time', $login_time);
        $this->assign('code', $code);
        $htmls = $this->fetch();
        return $htmls;
    }

    //登录
    public function loginIn()
    {
        $postData = Request::instance()->post();//可以过滤
        try{
            $this->loginService->check($postData);
        }catch (Exception $e){
            Session::set('info.login_time',Session::get('info.login_time')+1);
            $this->redirect('./login', [], 302, ['data' => '登录失败!'. $e->getMessage()]);
        }
        //跳回后台首页
        return redirect('./index',[],302,['data' => '登录成功!'])->restore();
    }

    //注册
    public function register()
    {

    }

    //注销--退出登录
    public function loginOut()
    {
        Session::delete('user');
        $this->redirect('./login');
    }
}
