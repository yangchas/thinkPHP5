<?php
/**
 * Created by PhpStorm.
 * User: hiwin045
 * Date: 2018/6/22
 * Time: 17:06
 */

namespace app\index\controller;


use app\index\model\Student;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Session;

class StudentController extends CommonController
{


    /**
     * 列表页
     * @param int $page_size
     * @param int $page
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($page_size=5, $page=1)
    {
//        $users = Db::name('student')->select();
//        $msgs=Request::param('data');
        $data1 = Session::get('data');
        $msgs = $data1;
        $Student = new Student();
//        $students = $Student->select();
        //listRows: 每页数量  page: 当前页
        $students=$Student->paginate($page_size,false,['page'=>$page]);
//        $students=$Student::all([1,2,3]);
//        $students=$Student::get(2);
        $this->assign('msg', $msgs);
        $this->assign('students', $students);
        $htmls = $this->fetch();
        return $htmls;
    }


    /**
     *保存数据
     */
    public function save()
    {
        var_dump($_POST);//不安全,不过滤
        $postData = Request::instance()->post();//可以过滤
//        $postData=$this->$this->request->post();
        $Student = new Student();
        try {
            $Student->name = $postData['name'];
            $Student->age = $postData['age'];
            $Student->sex = $postData['sex'];
            $nowtime = date('Y-m-d H:i:s', $postData['createTime']);
            $Student->create_time = $nowtime;
            $code=$Student->save();
            if (!$code) throw new Exception();
        }catch (Exception $e)
        {
            $this->redirect('./student', [], 302, ['data' => '新增失败!']);
        }
        $this->redirect('./student', [], 302, ['data' => '新增成功!']);
    }


    /**
     * 修改(更新)数据
     * @throws \think\exception\DbException
     */
    public function update()
    {
        $postData = Request::instance()->post();//可以过滤
        $Student = new Student();
        $student = $Student::get($postData['id']);
        try {
            if(!$student) throw new Exception('该数据不存在');
            $student->id = $postData['id'];
            $student->name = $postData['name'];
            $student->age = $postData['age'];
            $student->sex = $postData['sex'];
            $nowtime = date('Y-m-d H:i:s', $postData['createTime']);
            $student->create_time = $nowtime;
            $code = $student->save();
            if (!$code) throw new Exception();
        } catch (Exception $e) {
            $this->redirect('./student', [], 302, ['data' => '修改失败!' . $e->getMessage()]);
        }
        $this->redirect('./student', [], 302, ['data' => '修改成功!']);
    }


    /**
     * 跳转新增页面
     * @return mixed
     */
    public function add()
    {
        $this->assign('type', 'save');
        $this->assign('sexs', array('1' => '男', '0' => '女'));
        $htmls = $this->fetch();
        return $htmls;
    }


    /**
     * 跳转编辑页面
     * @param null $id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function edit($id = null)
    {
//        $param=Request::instance()->param('id');
        $Student = new Student();
        $student = $Student::get($id);
        $this->assign('sexs', array('1' => '男', '0' => '女'));
        $this->assign('student', $student);
        $this->assign('type', 'update');
        $html = $this->fetch('Student/add');
        return $html;
    }


    /**
     * 删除数据----单条
     * @param null $deleteId
     */
    public function delete($deleteId = null)
    {
        if ($deleteId) {
            $Student = new Student();
            try {
                $student = $Student->get($deleteId);
                if (!$student) throw new Exception('没有此条数据');
                $code = $student->delete();
//                $code=$Student->destroy($deleteId);
                if (!$code) throw new Exception('未知的错误');
            } catch (\Exception $e) {
                $this->redirect('./student', [], 302, ['data' => '删除失败!' . $e->getMessage()]);
            }
            $this->redirect('./student', [], 302, ['data' => '删除成功!']);
        }
        $this->redirect('./student', [], 302, ['data' => '删除失败!' . '请指定具体的数据']);
    }

}
