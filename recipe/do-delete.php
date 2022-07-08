<?php
require("../db-connect.php");

$recipe_id=$_GET["recipe_id"];


// 軟刪除：valid改成0
$sql="UPDATE recipe SET valid=0 WHERE id='$recipe_id'";


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
    } else {
        echo "刪除資料錯誤" . $conn->error;
    }

    
    header("location: recipe-all.php")
?>