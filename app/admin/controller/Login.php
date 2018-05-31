<?php
namespace app\admin\controller;
use core\Controller;
use core\view\View;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use system\model\User;

class Login extends Controller {

//    登录方法
    public function enter(){
        if ($_POST){
            if ($_POST['code'] != $_SESSION['code']){
                return $this->redirect()->message("验证码有误！");
            }

//            根据POST数据去数据库中查询、判断数据库中是否有当前填写的账号和密码的数据,如果有,代表登录是成功的,如果没有,代表登录失败
            $info = User::where('username = "' . $_POST['username'] . '" and password = "' . md5($_POST['password']) . '"')->get()->toarray();

            if (empty($info)){
                return $this->redirect()->message("用户名或密码不正确！");
            }

//            如果勾选了remember me，如果勾选了,就可以在cookie中存一个7天有效期的值
            if (isset($_POST['autoload'])){
                setcookie(session_name(),session_id(),time() + 7*24*3600,'/');
            }

//            往SESSION中存入用户名和数据库中的id
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['uid'] = $info[0]['id'];

            return $this->redirect('index.php?s=admin/entry/index')->message('登录成功!');
        }
        //加载后台登录模板
        return View::make();
    }

//    退出方法
    public function logout(){
//        清除SESSION
        session_unset();
        session_destroy();
        //提示退出成功并跳转去登录
        return $this->redirect("index.php")->message("退出成功！");
    }

//    验证码方法
    public function code(){
        $phraseBuilder = new PhraseBuilder(4, '0123456789');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build();
        header('Content-type: image/jpeg');
        $builder->output();
        $_SESSION['code'] = $builder->getPhrase();
    }
}