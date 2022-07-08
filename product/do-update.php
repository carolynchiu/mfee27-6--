<?php
if(!isset($_POST["name"])){
    echo "沒有帶資料";
    exit;
}
//複製product-add.php
require("../db-connect.php");//串聯修改

$id=$_POST["id"];
$name=$_POST["name"];
$description=$_POST["description"];
$price=$_POST["price"];
$image=$_POST["image"];
$category_id=$_POST["category_id"];
$launch_time=$_POST["launch_time"];
$discontinue_time=$_POST["discontinue_time"];
$stock_in_inventory=$_POST["stock_in_inventory"];
$status=$_POST["status"];

$sql="UPDATE products SET name='$name', description='$description', price='$price',image= '$image', category_id=$category_id,launch_time=$launch_time, discontinue_time=$discontinue_time,stock_in_inventory=$stock_in_inventory, status=$status WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "資料表 products 修改完成";
} else {
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();

header("location:products-list.php?id=".$id);
?>