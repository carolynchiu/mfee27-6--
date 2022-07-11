<?php
if (!isset($_POST["order_id"])) {
  echo "沒有帶資料";
  exit;
}
require("../db-connect.php");

$order_id = $_POST["order_id"];
$product_id = $_POST["product_id"];
$amount = $_POST["amount"];
$text = $_POST["text"];

//後端擋 -> 後端驗證(沒接觸資料庫)
if (empty($order_id)) {
  echo "沒有填order_id";
  exit;
}
if (empty($product_id)) {
  echo "沒有product_id";
  exit;
}
if (empty($amount)) {
  echo "沒有amount";
  exit;
}
if (empty($text)) {
  echo "沒有text";
  exit;
}

//寫入資料庫
$now = date('Y-m-d H:i:s');
$sqlCreate = "INSERT INTO order_product_detail (order_id, product_id, amount, text) VALUES ('$order_id','$product_id', '$amount','$text')";


if ($conn->query($sqlCreate) === TRUE) {
  echo "新資料輸入成功";
} else {
  echo "Error: " . $sqlCreate . "<br>" . $conn->error;
}

$conn->close();

header("location: order-detail.php?id=$order_id");
