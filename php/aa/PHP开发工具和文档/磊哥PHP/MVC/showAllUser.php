<?php
header("Content-type:text/html;charset=utf-8");
require './UserModel.class.php';
require './ModelFactroy.class.php';
class UserController{
    function DetailAction(){
        //获取一个用户的信息
        $id=$_GET['id'];
        $obj = ModelFactory::M('UserModel');
        $data = $obj->GetUserById($id);
        //显示到一个用户的视图
        include './userInfo.html';
    }
    function AddUserAction(){
        //接受表单数据
         $username=$_POST['username'];
         $sex=$_POST['sex'];
         $xueli=$_POST['xueli'];
         $address=$_POST['address'];
         $obj = ModelFactory::M('UserModel');
         $result=$obj->HelpInsertUser($username,$sex,$xueli,$address);
        echo "<font color=red>添加用户成功！</font>";
        echo "<a href='?'>返回</a>";
    }
    function showFormAction(){
        //显示表单
         include './form_view.html';
     }
    function DelAction(){
        $id=$_GET['id'];
        $obj = ModelFactory::M('UserModel');
        $result=$obj->delUserById($id);
        echo "<font color=red>删除成功！</font>";
        echo "<a href='?'>返回</a>";
    }
    function IndexAction(){
    //载入视图文件，以显示该2份数据
    //$obj_user=new UserModel();//这一行使用下一行代替
        $obj_user = ModelFactory::M('UserModel');
        $data1=$obj_user->GetAllUser(); //是一个二维数组
        $data2=$obj_user->GetUserCount();//是一个一维数组
        include './showAllUser_view.html';
    }
    
    function EditAction(){
        $id=$_GET['id'];
        //从数据库中取出该用户的数据信息
        $obj_user = ModelFactory::M('UserModel');
        $user=$obj_user->GetUserById($id);
        include './user_form_view.html';
    }
    function UpdateUserAction(){
         //接受表单数据
         $id=$_POST['id'];
         $username=$_POST['username'];
         $sex=$_POST['sex'];
         $xueli=$_POST['xueli'];
         $address=$_POST['address'];
         $obj = ModelFactory::M('UserModel');
         $result=$obj->HelpUpdateUser($id,$username,$sex,$xueli,$address);
        echo "<font color=red>修改用户成功！</font>";
        echo "<a href='?'>返回</a>";
    }
}
$ctr=new UserController();
$act=!empty($_GET['act'])?$_GET['act']:"Index";
$action=$act."Action";
$ctr->$action();//可变函数-》变成方法
//以上3行代表了一下所有if判断逻辑。
/*
//实例化模型类，并从中实例化2份数据
if(!empty($_GET['act'])&&$_GET['act']=='detail'){
    DetailAction();
}
else if(!empty($_GET['act'])&&$_GET['act']=='AddUser'){
    AddUserAction();
}
else if(!empty($_GET['act'])&&$_GET['act']=='showForm'){
    showFormAction();
}
else if(!empty($_GET['act'])&&$_GET['act']=='del'){
    DelAction();
}
else{
/*
//一下几行，证明模型类的单列工厂
$obj_user2= ModelFactory::M('UserModel');
var_dump($obj_user);
echo "<br/>";
var_dump($obj_user2);

    IndexAction();
}
*/