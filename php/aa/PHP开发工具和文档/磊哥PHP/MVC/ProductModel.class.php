<?php

require './BaseModel.class.php';

class ProductModel extends BaseModel{
    function GetAllProduct(){
        //select product.*,product_type.protype_name from product inner join product_type on product.protype_id = product_type.protype_id;
        $sql = "select product.*,product_type.protype_name from product inner join product_type on product.protype_id = product_type.protype_id";
        return $this->db->getRows($sql);
    }
}