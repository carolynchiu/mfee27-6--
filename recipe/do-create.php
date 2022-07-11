<?php

require("../db-connect.php");

// 如果沒有資料帶到此頁時顯示訊息
// 直接點開此頁時不會有錯誤碼
if(!isset($_POST["title"])){
    echo"沒有帶資料到本頁";
    exit;
}

$title=$_POST["title"];
$user_id=$_POST["user_id"];
$main_image=$_POST["main_image"];
$intro=$_POST["intro"];
$servings=$_POST["servings"];
$cook_time=$_POST["cook_time"];
$ingredient1=$_POST["ingredient1"];
$ingredient2=$_POST["ingredient2"];
$ingredient3=$_POST["ingredient3"];
$ingredient4=$_POST["ingredient4"];
$ingredient5=$_POST["ingredient5"];
$step1=$_POST["step1"];
$step2=$_POST["step2"];
$step3=$_POST["step3"];
$step4=$_POST["step4"];
$step5=$_POST["step5"];
$step_image1=$_POST["step_image1"];
$step_image2=$_POST["step_image2"];
$step_image3=$_POST["step_image3"];
$step_image4=$_POST["step_image4"];
$step_image5=$_POST["step_image5"];

// date是取得當下時間的函式
// 到XAMPP的config中ph.ini找timezone改成asia taipei
$now=date('Y-m-d H:i:s');


$sql="INSERT INTO recipe (title, user_id, main_image,intro, servings,cook_time,ingredient1,ingredient2,ingredient3,ingredient4,ingredient5,step1,step2,step3,step4,step5,step_image1,step_image2,step_image3,step_image4,step_image5,create_time, valid) VALUES ('$title', '$user_id', '$main_image','$intro','$servings','$cook_time','$ingredient1','$ingredient2','$ingredient3','$ingredient4','$ingredient5','$step1','$step2','$step3','$step4','$step5','$step_image1','$step_image2','$step_image3','$step_image4','$step_image5','$now',1)";

if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("location: recipe-all.php");
?>