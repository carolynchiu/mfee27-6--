<?php

require('../db-connect.php');
if(!isset($_POST["name"])){
    echo "沒有帶資料到本頁";
    exit;
}

$name=$_POST["name"];
// $description=$_POST["description"];
$url=$_POST["url"];
$create_time=date('Y-m-d H:i:s');
// echo $now;

// echo "$name,$email,$phone";
// exit;


//寫入資料庫
$now=date('Y-m-d H:i:s');
$sqlCreate= "INSERT INTO course (name,create_time) VALUES ('$name','$create_time')";

if ($conn->query($sqlCreate) === TRUE) {
    $message = "新課程輸入成功";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();




?>