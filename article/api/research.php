<?php
// 1. 與資料庫連線
require("../../db-connect.php");


// 2.決定這個api要做的事情(每個檔案的不同之處)
$sql = "SELECT * FROM article";

$result = mysqli_query($conn, $sql);   
while($row = mysqli_fetch_assoc($result))
$res[] = $row; 

header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);

?>