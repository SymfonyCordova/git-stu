<?php
class BaseController{
    function __construct(){
        header("Content-type:text/html;charset=utf-8");
    }
    //显示一定的提示文字 然后文字跳转（可以设定停留的时间秒数）
    function GotoUrl($msg,$url,$time=3){
        echo "<font color=red>{$msg}</font>";
        echo "<br/><a href='$url'>返回</a>";
        echo "<br/>页面将在{$time}秒之后自动跳转";
        header("refresh:{$time};url={$url}");//自动定时调整功能
    }
}