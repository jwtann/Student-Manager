<?php
namespace app\admin\controller;
use core\Controller;

class Common extends Controller {
    public function __construct()
    {
        //判断如果session中的username不存在,代表用户没有登录,跳转去登录页面
        if (!isset($_SESSION['username'])){
            die($this->redirect('index.php?s=admin/login/enter')->message('请先登录再来操作!!!'));
        }
    }
}