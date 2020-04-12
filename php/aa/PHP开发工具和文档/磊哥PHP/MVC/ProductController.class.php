<?php
//header("Content-type:text/html charset=utf-8");
require  './ProductModel.class.php';
require  './ModelFactroy.class.php';
require './BaseController.class.php';

class ProductController extends BaseController{
    function ShowAllProductAction(){
        //echo "aa";
        $obj = ModelFactory::M('ProductModel');
        $data=$obj->GetAllProduct(); //是一个二维数组
        include './Product_list.html';
    }
    function DetailAction(){
        //echo "bb";
    }
    function DelAction(){
        //echo "cc";
    }
}
$ctrl=new ProductController();
$act=!empty($_GET['a'])?$_GET['a']:"Index";
$action=$act."Action";
$ctrl->$action();
