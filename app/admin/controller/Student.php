<?php
namespace app\admin\controller;

use core\view\View;

class Student extends Common {

//    学生列表展示方法
    public function index(){
        //因为需要展示班级名称,所以单独取学生数据不够,这个时候需要自己写sql语句,调用框架提供的query方法来执行自己的sql语句
        $sql = "select student.*,grade.gname from student join grade on student.grade_id = grade.id";
        $student = \system\model\Student::query($sql)->toarray();
        //加载学生列表模板
        return View::make()->with("student",$student);
    }

//    学生添加方法
    public function create(){
        if ($_POST){
            //将post数据交给框架的add方法,添加到student表中
            $result = \system\model\Student::add($_POST);
            //判断$result是否为真,如果为真,代表添加成功,如果为假,代表添加失败
            if ($result){
                return $this->redirect('index.php?s=admin/student/index')->message('添加成功!');
            }else{
                return $this->redirect()->message('添加失败!');
            }
        }
        //获取所有班级数据
        $grade = \system\model\Grade::get()->toarray();
        //加载添加学生模板
        return View::make()->with("grade",$grade);
    }

//    学生信息编辑方法
    public function edit(){
        //获取需要修改的学生id
        $key = $_GET['id'];
        //获取所有班级数据并分配
        $grade = \system\model\Grade::get()->toarray();
        //通过$key找到对应学生的数据
        $student = \system\model\Student::find($key)->toarray();

        if ($_POST){
            //调用框架提供的edit方法来修改学生数据
            $result = \system\model\Student::edit($_POST,$key);
            if ($result){
                return $this->redirect('index.php?s=admin/student/index')->message('修改成功');
            }else{
                return $this->redirect()->message('修改失败');
            }
        }
        //加载编辑学生模板,分配需要修改的学生数据
        return View::make()->with("student",$student)->with("grade",$grade);
    }

//    学生信息删除方法
    public function del(){
        //获取get参数中的需要删除的学生id
        $key = $_GET['id'];
        $result = \system\model\Student::del($key);
        //判断$result是否为真,如果为真,代表删除成功,如果为假,代表删除失败
        if ($result){
            return $this->redirect('index.php?s=admin/student/index')->message('删除成功');
        }else{
            return $this->redirect()->message('删除失败');
        }
    }

//    ajax删除方法
    public function ajaxDel(){
        $key = $_GET['id'];
        $result = \system\model\Student::del($key);
        if ($result){
            //1代表删除成功
            return json_encode(['valid' => 1,'message' => '删除成功!']);
        }else{
            //0代表删除失败
            return json_encode(['valid' => 0,'message' => '删除失败!']);
        }
    }
}