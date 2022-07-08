<?php
require("../db-connect.php");

$id=$_GET["id"];
if (!isset($_GET["id"])){
    echo "沒有參數";
}

$sql="DELETE FROM products WHERE id = '$id' ";
if($conn->query($sql) === TRUE){
    echo "刪除成功";
}else{
    echo "刪除資料錯誤:". $conn->error;
}

header("location:product-list.php");



?>