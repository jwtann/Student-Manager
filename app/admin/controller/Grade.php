<?php
namespace app\admin\controller;
use core\model\Model;
use core\view\View;

class Grade extends Common {
//    班级列表展示
    public function index(){
//        $data = \system\model\Grade::get()->toarray();
        $sql = "SELECT g.*,count(s.uid) AS stu_num FROM student AS s RIGHT JOIN grade AS g ON s.grade_id = g.id GROUP BY g.id";
        $grade = Model::query($sql)->toarray();
        //加载班级列表模板
        return View::make()->with("grade",$grade);
    }

//    班级添加模板
    public function create(){
        return View::make();
    }

//    添加班级方法
    public function add(){
        //获取post数据
        $post = $_POST;
        //添加之前应该判断是否有当前名称的班级数据,如果有,提示并返回
        $info = \system\model\Grade::where('gname = "' . $_POST['gname'] . '"')->get()->toArray();
        if ($info){
            return $this->redirect()->message('班级已存在!!');
        }
        //将post数据插入grade表中
        $result = \system\model\Grade::add($post);
        //判断返回结果是否为真,提示不同消息
        if ($result){
            return $this->redirect('index.php?s=admin/grade/index')->message('添加成功');
        }else{
            return $this->redirect()->message('添加失败');
        }
    }

//    班级编辑方法
    public function edit(){
//        获得GET参数传递过来的id
        $key = $_GET['id'];
        //找到对应$key的班级数据
        $data = \system\model\Grade::find($key)->toarray()[0];
        if ($_POST){
            //编辑之前应该判断是否有当前名称的班级数据,如果有,提示并返回
            $info = \system\model\Grade::where('gname = "' . $_POST['gname'] . '" and id != ' . $key)->get()->toArray();
            if ($info){
                return $this->redirect()->message('班级已存在!!');
            }

            //将班级数据调用框架提供的edit方法进行编辑
            $result = \system\model\Grade::edit($_POST,$key);
            if ($result !== false){
                return $this->redirect('index.php?s=admin/grade/index')->message('编辑成功');
            }else{
                return $this->redirect()->message('编辑失败');
            }
        }
        //加载编辑班级模板
        return View::make()->with("grade",$data);
    }

//    班级删除方法
    public function delete(){
        //获取需要删除班级的id
        $id = $_GET['id'];
        $result = \system\model\Grade::del($id);
        //判断返回结果是否为真,提示不同消息并跳转或返回
        if ($result){
            return $this->redirect('index.php?s=admin/grade/index')->message('班级数据删除成功');
        }else{
            return $this->redirect()->message('班级数据删除失败');
        }
    }
}