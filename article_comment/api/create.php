<?php
// 1. 與資料庫連線
require("../../db-connect.php");
date_default_timezone_set("Asia/Taipei");


// 建立接收前端資料的變數
$id = $_POST['user_id'];
$comment = $_POST['comment'];


// 2.決定這個api要做的事情(每個檔案的不同之處)
$sql = "INSERT INTO article_comment (user_id,comment,status,article_id) values (?,?,1,1) ";


// 3.建立資料庫請求
$stmt = $conn->prepare($sql);
//  有幾個參數就要寫幾個s
$stmt->bind_param('ss',$id,$comment);
 
$result = $stmt->execute();

// true / false
if($result){
    echo '新增成功';
}else{
    echo '新增失敗';
}

?>