<?php
if (!isset($_POST["name"])) {
  echo "沒有帶資料";
  exit;
}
require("../db-connect.php");

$id = $_POST["id"];
$name = $_POST["name"];
$discount = $_POST["discount"];
$time_start = $_POST["time_start"];
$time_end = $_POST["time_end"];
// echo $name;

$sql = "UPDATE coupon SET name='$name', discount='$discount', time_start='$time_start', time_end='$time_end' WHERE id=$id";
// echo $sql;
if ($conn->query($sql) === TRUE) {
  echo "更新成功";
} else {
  echo "更新資料錯誤: " . $conn->error;
}

$conn->close();

//導回 user-edit.php
header("location: coupon-detail.php?id=" . $id);
