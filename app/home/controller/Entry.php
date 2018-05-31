<?php
namespace app\home\controller;
use core\view\View;
use system\model\Name;
use system\model\Student;

class Entry{

    public function index(){
//        获取学生表与班级表关联之后，学生的信息、班级名称，用于前台显示
        $sql = "SELECT s.*, g.gname FROM student AS s LEFT JOIN grade AS g ON s.grade_id = g.id";
        $data = Student::query($sql)->toarray();
//        加载模板，分配数据
        return View::make()->with("data",$data);
    }

//    学生信息查看方法
    public function show(){
        //获取需要查看的学生id
        $key = $_GET['id'];
//        组合sql语句，根据前台模板上面需要显示的信息，通过表关联获得相应数据
        $sql = "SELECT s.*, g.gname FROM student AS s LEFT JOIN grade AS g ON s.grade_id = g.id WHERE uid = ".$key;
//        执行框架中的查询方法获得数据
        $data = Student::query($sql)->toarray()[0];
//        加载模板，分配数据
        return View::make()->with("data",$data);
    }
}