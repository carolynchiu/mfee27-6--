<?php

require('../db-connect.php');
if(!isset($_POST["name"])){
    echo "沒有帶資料到本頁";
    exit;
}

$name=$_POST["name"];
$description=$_POST["description"];
$url=$_POST["url"];
// $create_time=date('Y-m-d H:i:s');
// echo $now;

// echo "$name,$email,$phone";
// exit;


//寫入資料庫
$now=date('Y-m-d H:i:s');
$sqlCreate= "INSERT INTO course (name,create_time,url) VALUES ('$name','$now','$url')";

if ($conn->query($sqlCreate) === TRUE) {
    $message = "新課程輸入成功1";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlCreate2= "INSERT INTO course_content (image,description) VALUES ('$image','$description')";

if ($conn->query($sqlCreate2) === TRUE) {
    $message = "新課程輸入成功2";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}






$conn->close();
?>


