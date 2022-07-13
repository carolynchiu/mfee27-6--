<?php
require("../db-connect.php");

$id=$_GET["id"];
if (!isset($_GET["id"])){
    echo "沒有參數";
}


//$sqlDelete="DELETE FROM products WHERE id = '$id' ";
$sqlRemove="UPDATE products SET status=2 WHERE id = '$id'";
if($conn->query($sqlRemove) === TRUE){
    echo "刪除成功";
}else{
    echo "刪除資料錯誤:". $conn->error;
}

header("location:products-list.php");



?>