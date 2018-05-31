<?php
namespace app\admin\controller;
use core\view\View;

class User extends Common {

//    用户更改密码方法
    public function changepwd(){

        if ($_POST){
//            用当前登录账号对应的数据库中的id去数据库中查找
            $info = \system\model\User::find($_SESSION['uid'])->toarray();

//            原密码如果匹配不上
            if ($info[0]['password'] != md5($_POST['oldPassword'])){
                return $this->redirect()->message('原密码输入错误!');
            }

//            两次密码输入不一致
            if ($_POST['password'] != $_POST['password2']){
                return $this->redirect()->message('两次密码输入不一致!');
            }

//            密码长度限制
            if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 6){
                return $this->redirect()->message('密码长度6-20位!');
            }

//            定义数据，修改当前用户的密码,并退出登录
            $data = [
                'password' => md5($_POST['password']),
            ];

//            去数据库中更新对应数据
            $result = \system\model\User::edit($data,$info[0]['id']);

//            根据更新结果提示相应信息
            if ($result){
                return $this->redirect('index.php?s=admin/login/logout')->message('密码修改成功!');
            }else{
                return $this->redirect()->message('密码修改失败!');
            }

        }
//        加载修改密码模板
        return View::make();
    }
}