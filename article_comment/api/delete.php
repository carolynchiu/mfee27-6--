<?php
// 1. 與資料庫連線
require("../../db-connect.php");

// 建立接收前端資料的變數
$id = $_POST['id'];


// 2.決定這個api要做的事情(每個檔案的不同之處)
$sql= "UPDATE article_comment SET status = 0  WHERE id = ?";


// 3.建立資料庫請求
$stmt = $conn->prepare($sql);
//  有幾個參數就要寫幾個s
$stmt->bind_param('s',$id);
 
$result = $stmt->execute();

// true / false
if($result){
    echo '刪除成功';
}else{
    echo '刪除失敗';
}

?>