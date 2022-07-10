<?php
// 1. 與資料庫連線
require("../../db-connect.php");

// 建立接收前端資料的變數
$id = $_POST['user_id'];
$text = $_POST['text'];
$time=  $_POST['create_time'];

// 2.決定這個api要做的事情(每個檔案的不同之處)
$sql = "INSERT INTO article (user_id,text,create_time) values (?,?,?) ";


// 3.建立資料庫請求
$stmt = $conn->prepare($sql);
//  有幾個參數就要寫幾個s
$stmt->bind_param('sss',$id,$text,$time);
 
$result = $stmt->execute();

// true / false
if($result){
    echo '新增成功';
}else{
    echo '新增失敗';
}

?>