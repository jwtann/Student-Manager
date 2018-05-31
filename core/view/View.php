<?php
namespace core\view;
class View{

    public function __call($name, $arguments)
    {
        return self::action($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::action($name, $arguments);
    }

    public static function action($name, $arguments){
        return call_user_func_array([new Base(),$name],$arguments);
    }
}