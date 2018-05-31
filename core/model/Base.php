<?php
namespace core\model;
class Base{
    protected $pdo;
    //定义表名属性
    protected $table;
    //定义where条件属性
    protected static $where = '';

    public function __construct($config,$table)
    {
        //将$table表名变成一个属性,为了后面的其他方法使用
        $this->table = $table;
        $this->connect($config);
    }
//    连接数据库方法
    public function connect($config){
        $dsn = "mysql:host=".$config['host'].";dbname=".$config['dbname'];

        try {
            $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
            $this->pdo->query("set names utf8");
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

//    获取多条数据
    public function get(){
        //组合sql语句,获取多条数据,可能有where条件,如果没有where条件,就是获取所有数据,如果有,就是获取满足where条件的多条数据
        $sql = "select * from " .$this->table.self::$where;
        //通过pdo对象调用query方法获取多条数据
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        //将当前$data数据存入当前对象的一个临时属性中
        $this->data = $data;
        //返回当前对象
        return $this;
    }

//    获取单条数据
    public function find($pri){
        //获取调用表的主键名称
        $priKey = $this->getPri();
        $sql = "select * from " . $this->table . " where " . $priKey . " = " .$pri;
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        $this->data = $data;
        return $this;
    }

    public function add($post){
        //定义一个接收字段名的字符串
        $kstr = '';
        //定义一个接收字段值的字符串
        $vstr = '';
        //循环$data需要存入的数据
        foreach ($post as $k => $v){
            $kstr .= $k . ",";
            $vstr .= '"' . $v . '"' . ",";
        }
        //将最后的逗号去掉
        $kstr = rtrim($kstr,",");
        $vstr = rtrim($vstr,",");
//        组合sql语句，用pdo对象调用exec方法完成添加
        $sql = "insert into " . $this->table . " (" . $kstr . ")" . " values " . "(" . $vstr . ")";
        $result = $this->pdo->exec($sql);
//        返回执行结果
        return $result;
    }

//    数据编辑方法
    public function edit($post,$pri){
//        获得主键名称
        $priKey = $this->getPri();
        //定义一个空字符串
        $str = '';
        //循环$data,组合sql语句中需要的字符串
        foreach ($post as $k => $v){
            $str .= $k . ' = "' . $v . '",';
        }
        $str = rtrim($str,",");

        $sql = "update " . $this->table . " set " . $str . " where " . $priKey . " = " . $pri;
        $result = $this->pdo->exec($sql);
        return $result;
    }

//    删除数据方法
    public function del($pri){
        $priKey = $this->getPri();
        $sql = "delete from " . $this->table . " where " . $priKey . " = " . $pri;
        $result = $this->pdo->exec($sql);
        return $result;
    }

//    多表查询的方法
    public function query($sql){
        //直接使用pdo对象调用PDO的query方法获取关联表的数据
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        //将当前对象,将data数据存入当前对象的临时属性中
        $this->data = $data;
        return $this;
    }

//    获取主键名称方法
    protected function getPri(){
        //组合查看表结构的sql语句
        $sql = "desc ".$this->table;
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        //定义一个接收主键名称的变量
        $primary = '';
        //循环$result,判断,如果$v里面的Key不为空,就代表当前字段是主键
        foreach ($data as $v){
            if (!is_null($v['Key'])){
                $primary = $v['Field'];
                break;
            }
        }
        //将主键名称返回
        return $primary;
    }

//    组合where语句方法
    public function where($where){
        self::$where = " where " . $where;
        return $this;
    }

//    将对象数据转成数组
    public function toarray(){
        return $this->data;
    }

}