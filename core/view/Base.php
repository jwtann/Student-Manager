<?php
namespace core\view;
class Base{
    protected $file;
    protected $vars = [];

    public function make(){
        $this->file = "app/".MODEL."/view/".strtolower(CONTROLLER)."/".ACTION.".php";
        return $this;
    }

    public function with($name, $var){
        $this->vars[$name] = $var;
        return $this;
    }

    public function __toString()
    {
        extract($this->vars);
        require $this->file;
        return '';
    }
}