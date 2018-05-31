<?php
namespace core;
class Boot{

    public function command(){
        //开启session
        session_start();
        //分析get参数,如果有get参数中的s,就分析s参数得到模块,控制器,方法,如果没有s参数,就取默认的模块,控制器,方法
        if (isset($_GET['s'])){
            //将s参数切割成数组,分别获取模块,控制器,方法
            $info = explode("/",$_GET['s']);
            //定义模块名称变量
            $m = $info[0];
            //定义控制器名称变量
            $c = ucfirst($info[1]);
            //定义方法名称变量
            $a = $info[2];
        } else{
            $m = "home";
            $c = "Entry";
            $a = "index";
//            $m = "admin";
//            $c = "Login";
//            $a = "enter";
        }

        //定义模块常量
        define("MODEL",$m);
        //定义控制器常量
        define("CONTROLLER",$c);
        //定义方法常量
        define("ACTION",$a);

        //组合需要调用的类名称
        $class = "app\\$m\controller\\$c";
        //使用回调函数调用对应类中的方法
        echo call_user_func_array([new $class,$a],[]);
    }
}