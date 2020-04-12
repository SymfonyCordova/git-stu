<?php 
require './BaseModel.class.php';

class UserModel extends BaseModel{
    function GetAllUser(){
        $sql="select * from user";
        $data=$this->db->GetRows($sql);
        return $data;
    }
    function GetUserCount(){
        $sql="select count(*) as c from user";
        //$db = MySQLDB::GetInstance($config);
        $data=$this->db->getOneData($sql);
        return $data;
    }
    function delUserById($id){
        $sql="delete from user where id=$id";
        $data=$this->db->exec($sql);
        return $data;
    }
    function GetUserById($id){
        $sql="select * from user  where id=$id";
        $data=$this->db->GetOneRow($sql);
        return $data;
    }
    function HelpInsertUser($username,$sex,$xueli,$address){
        $sql="insert into user values(null,'{$username}','{$sex}','{$xueli}','{$address}')";
        $result=$this->db->exec($sql);
        return $result;
    }
    function HelpUpdateUser($id,$username,$sex,$xueli,$address){
        $sql="update user set name='{$username}',sex='{$sex}' ,xueli='{$xueli}' ,address='{$address}'  where id={$id}";
        $result=$this->db->exec($sql);
        return $result;
    }
}