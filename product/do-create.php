<?php
//完成
require("../db-connect.php");//串聯修改

$name=$_POST["name"];
$description=$_POST["description"];
$price=$_POST["price"];
$image=$_POST["image"];
$category_id=$_POST["category_id"];
$launch_time=$_POST["launch_time"];
$discontinue_time=$_POST["discontinue_time"];
$stock_in_inventory=$_POST["stock_in_inventory"];
$status=$_POST["status"];

$sql="INSERT INTO `products`( `name`, `description`, `price`, `image`, `category_id`, `launch_time`, `discontinue_time`, `stock_in_inventory`, `status`) VALUES ('$name','$description','$price','$image','$category_id','$launch_time','$discontinue_time','$stock_in_inventory','$status')";

if($conn->query($sql) === TRUE){
    echo "success!";
}else{
    echo "Error:".$sql."<br>".$conn->error;
}

$conn->close();

header("location:products-list.php");

?>