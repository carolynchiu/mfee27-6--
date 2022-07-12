<?php
if (!isset($_POST["name"])) {
  echo "沒有帶資料";
  exit;
}
require("../db-connect.php");

$name = $_POST["name"];
$discount = $_POST["discount"];
$time_start = $_POST["time_start"];
$time_end = $_POST["time_end"];

//後端擋 -> 後端驗證(沒接觸資料庫)
if (empty($name)) {
  echo "沒有填優惠券名稱";
  exit;
}
if (empty($discount)) {
  echo "沒有填折扣金額";
  exit;
}
if (empty($time_start)) {
  echo "沒有再輸入起迄時間";
  exit;
}
if (empty($time_end)) {
  echo "沒有再輸入起迄時間";
  exit;
}


//接觸資料庫
//檢查帳號是否存在
$sql = "SELECT name FROM coupon WHERE name='$name'";
$result = $conn->query($sql);
$couponCount = $result->num_rows;

//確認帳號是否重複
if ($couponCount > 0) {
  echo "該優惠券已存在";
  exit;
}

//寫入資料庫
$now = date('Y-m-d H:i:s');
$sqlCreate = "INSERT INTO coupon (name, discount, time_start, time_end, create_time, valid) VALUES ('$name', '$discount', '$time_start', '$time_end', '$now',1)";

if ($conn->query($sqlCreate) === TRUE) {
  echo "新資料輸入成功";
} else {
  echo "Error: " . $sqlCreate . "<br>" . $conn->error;
}

$conn->close();

header("location: coupon.php");
