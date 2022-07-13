<?php
require("../db-connect.php");
$page=isset($_GET["page"])?$_GET["page"]:"" ;
$id=$_GET["id"];

// $sql="DELETE FROM users WHERE id='$id'";
// update to valid 0
$sql="UPDATE course SET valid=0 WHERE id='$id'";


// echo $sql;
if ($conn->query($sql) === TRUE) {
    $message = "課程刪除成功";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
header("location: course.php?page=$page&order=3");

?>