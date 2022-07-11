<?php
require("../db-connect.php");
$id = $_GET["id"];

// delete
// $sql = "DELETE FROM users WHERE id='$id'";

//update to valid 0
// soft delete 軟刪除
$sql = "UPDATE order_list SET status_id=4 WHERE id='$id'";
// $sql = "DELETE FROM order_product_detail WHERE order_id='$id'";

// echo $sql;

if ($conn->query($sql) === TRUE) {
  echo "刪除成功";
} else {
  echo "刪除資料錯誤: " . $conn->error;
}

header("location: order-list.php");
