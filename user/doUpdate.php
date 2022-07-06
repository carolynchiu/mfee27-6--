<?php
if (!isset($_POST["name"])) {
  echo "沒有帶資料";
  exit;
}
require("../db-connect.php");

$id = $_POST["id"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
// echo $name;

$sql = "UPDATE users SET name='$name', phone='$phone', email='$email' WHERE id=$id
";
// echo $sql;
if ($conn->query($sql) === TRUE) {
  echo "更新成功";
} else {
  echo "更新資料錯誤: " . $conn->error;
}

$conn->close();

//導回 user-edit.php
header("location:user.php?id=" . $id);
