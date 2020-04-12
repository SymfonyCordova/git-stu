<?php
//单列工厂类
//通过这个工厂，可以传递过来一个模型的类名
//并返回给类的一个实例（对象），而且保证其为“单列的”
class ModelFactory{
    static $all_model=array();//用于存储各个模型类的唯一单列
    static function M($mode_name){//$mode_name是一个模型类的类名
        if(!isset(static::$all_model[$mode_name])//如果不存在
            ||
            !(static::$all_model[$mode_name] instanceof $mode_name)//或不是其实例
        )
        {
            static::$all_model[$mode_name]=new $mode_name();
        }
        return static::$all_model[$mode_name];
    }
}