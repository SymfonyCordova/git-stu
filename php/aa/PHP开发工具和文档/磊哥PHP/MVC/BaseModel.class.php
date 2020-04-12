<?php
require './MySQLDB.class.php';
class BaseModel{
    //这个，用于存储数据库工具类的实例（对象）
    protected $db=null;
    function __construct(){
            $config=array(
            'host'=>'localhost',
            'port'=>3306,
            'user'=>'root',
            'password'=>'123',
            'charset'=>'utf8',
            'dbname'=>'xianmu'
            );
        $this->db = MySQLDB::GetInstance($config);
    }

}