<?php
// 应用目录
use think\Config;
use think\Db;
use think\Request;
header("Content-Type:text/html;charset=utf-8");

define('APP_PATH', __DIR__.'/application/');
// 加载框架引导文件
require './thinkphp/start.php';

echo(Config::get("database.hostname"));
echo config('database.hostname');
$request = Request::instance();
echo "当前模块名称是" . $request->module();
echo "当前控制器名称是" . $request->controller();
echo "当前操作名称是" . $request->action();
dump(Db::table('student')->where('id',1)->find());
