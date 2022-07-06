<?php
if (!isset($_POST["account"])) {
  echo "沒有帶資料";
  exit;
}
require("../db-connect.php");

$name = $_POST["name"];
$account = $_POST["account"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$gender = $_POST["gender"];
$birthday = $_POST["birthday"];
$address = $_POST["address"];

//後端擋 -> 後端驗證(沒接觸資料庫)
if (empty($account)) {
  echo "沒有填account";
  exit;
}
if (empty($password)) {
  echo "沒有填password";
  exit;
}
if (empty($repassword)) {
  echo "沒有再輸入一次password";
  exit;
}
if ($password != $repassword) {
  echo "前後密碼不一致";
  exit;
}
//加密，現在也不用md5了，因為太好破解了，實務上不會使用
$password = md5($password);


//接觸資料庫
//檢查帳號是否存在
$sql = "SELECT account FROM users WHERE account='$account'";
$result = $conn->query($sql);
$userCount = $result->num_rows;

//確認帳號是否重複
if ($userCount > 0) {
  echo "該帳號已存在";
  exit;
}

//寫入資料庫
$now = date('Y-m-d H:i:s');
$sqlCreate = "INSERT INTO users (name, account, password, gender, birthday, phone, email, address, create_time, valid) VALUES ('$name', '$account', '$password', '$gender', '$birthday', '$phone', '$email', '$address', '$now',1)";

if ($conn->query($sqlCreate) === TRUE) {
  echo "新資料輸入成功";
} else {
  echo "Error: " . $sqlCreate . "<br>" . $conn->error;
}

$conn->close();

header("location: users.php");
