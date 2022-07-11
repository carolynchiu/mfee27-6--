<?php
if (!isset($_POST["user_id"])) {
  echo "沒有帶資料";
  exit;
}
require("../db-connect.php");

$user_id = $_POST["user_id"];
$coupon_id = $_POST["coupon_id"];
$status_id = $_POST["status_id"];
$product_id = $_POST["product_id"];
$amount = $_POST["amount"];

//後端擋 -> 後端驗證(沒接觸資料庫)
if (empty($user_id)) {
  echo "沒有填user_id";
  exit;
}
if (empty($coupon_id)) {
  echo "沒有coupon_id";
  exit;
}
if (empty($status_id)) {
  echo "沒有status_id";
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

//寫入資料庫
$now = date('Y-m-d H:i:s');
$sqlCreate = "BEGIN;
INSERT INTO order_list (user_id, coupon_id, status_id, create_time, valid) VALUES ('$user_id', '$coupon_id', '$status_id', '$now',1);
INSERT INTO order_product_detail (order_id, product_id, amount, text) VALUES (LAST_INSERT_ID(), '$product_id', '$amount', 'xxx');
COMMIT;";
// $sqlCreate = "BEGIN;
// INSERT INTO order_list (user_id, coupon_id, status_id, create_time, valid) VALUES ('$user_id', '$coupon_id', '$status_id', '$now',1);
// INSERT INTO order_product_detail (order_id, product_id, amount, text) VALUES (LAST_INSERT_ID(), '$product_id', '$amount', 'xxx');
// COMMIT;";

if ($conn->multi_query($sqlCreate) === TRUE) {
  echo "新資料輸入成功";
} else {
  echo "Error: " . $sqlCreate . "<br>" . $conn->error;
}

$conn->close();

header("location: order-list.php");
