<?php
if(!isset($_POST["name"])){
    echo "沒有帶資料";
    exit;
}

require("../db-connect.php");

$id=$_POST["id"];
$name=$_POST["name"];
$url=$_POST["url"];
// echo $name;
$sql="UPDATE course SET name='$name', url='$url' WHERE id=$id";
// echo $sql;
if ($conn->query($sql) === TRUE) {
    $message = "課程 course 修改完成";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
    
    // header("Location:course.php");
} else {
    echo "修改資料表錯誤: " . $conn->error;
}


$conn->close();

?>