<?php
require("../db-connect.php");
$id = $_GET["id"];

// delete
// $sql = "DELETE FROM users WHERE id='$id'";

//update to valid 0
// soft delete 軟刪除
$sql = "UPDATE admins SET valid=0 WHERE id='$id'";

// echo $sql;

if ($conn->query($sql) === TRUE) {
  echo "刪除成功";
} else {
  echo "刪除資料錯誤: " . $conn->error;
}

header("location: admins.php");
