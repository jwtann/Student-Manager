<?php
namespace core\model;
class Model{
    //定义连接数据库变量属性
    protected static $config;

    public function __call($name, $arguments)
    {
        return self::action($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::action($name, $arguments);
    }

    public static function action($name, $arguments){
//        通过get_called_class()得到调用方法的类名称
//        $info = get_called_class();
        $table = strtolower(explode("\\",get_called_class())[2]);
        //通过回调函数调用Base类里面的方法
        return call_user_func_array([new Base(self::$config,$table),$name],$arguments);
    }

//    接收连接数据库的配置项的方法
    public static function getConfig($config){
        //将配置项的值赋值给当前的config属性
        self::$config = $config;
    }
}