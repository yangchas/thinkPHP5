<?php

namespace app\index\controller;
use think\Controller;


class IndexController extends CommonController
{
    public function index()
    {
        $htmls=$this->fetch();
        return $htmls;
//        echo 'sdfff';
    }
    public function captcha()
    {

    }

    public function upload()
    {
//        echo 'fsdddddd';
//        $file=$_FILES['image'];
//        echo var_dump($file);
//        if ($file["error"] > 0)
//        {
//            echo "错误：" . $file["error"] . "<br>";
//        }
//        else
//        {
//            echo "上传文件名: " . $file["name"] . "<br>";
//            echo "文件类型: " . $file["type"] . "<br>";
//            echo "文件大小: " . ($file["size"] / 1024) . " kB<br>";
//            echo "文件临时存储的位置: " . $file["tmp_name"];
//        }
//        $files=request()->file('image');
//        foreach ($files as $file){
//            $info=$file->move(ROOT_PATH.'public'.DS.'uploads');
//            if ($info){
//                echo $info->getExtension();
//                echo $info->getFilename();
//            }else echo $file-getError();
//        }
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        echo var_dump($file);
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            echo '进入上传...<br>';
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo var_dump($info);
                echo '上传成功';
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
                echo '上传失败';
            }
        }else echo '没进入上传';
    }
}
