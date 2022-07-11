<?php
if(!isset($_POST["title"])){
    echo "沒有帶資料";
    exit;
}
require("../db-connect.php");

$id=$_POST["id"];
$title=$_POST["title"];
if ($_POST["main_image"] !== ''){
    $main_image = $_POST["main_image"] ;
}else{
    $main_image = $_POST["main_image_original"] ;
};
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

if ($_POST["step_image1"] !== ''){
    $step_image1 = $_POST["step_image1"] ;
}else{
    $step_image1 = $_POST["step_image1_original"] ;
};

if ($_POST["step_image2"] !== ''){
    $step_image2 = $_POST["step_image2"] ;
}else{
    $step_image2 = $_POST["step_image2_original"] ;
};

if ($_POST["step_image3"] !== ''){
    $step_image3 = $_POST["step_image3"] ;
}else{
    $step_image3 = $_POST["step_image3_original"]; 
};

if ($_POST["step_image4"] !== ''){
    $step_image4 = $_POST["step_image4"]; 
}else{
    $step_image4 = $_POST["step_image4_original"] ;
};

if ($_POST["step_image5"] !== ''){
    $step_image5 = $_POST["step_image5"] ;
}else{
    $step_image5 = $_POST["step_image5_original"] ;
};

$sql="UPDATE recipe SET title='$title', main_image='$main_image',intro='$intro',servings='$servings',cook_time='$cook_time',
ingredient1='$ingredient1',ingredient2='$ingredient2',ingredient3='$ingredient3',ingredient4='$ingredient4',ingredient5='$ingredient5',
step1='$step1',step2='$step2',step3='$step3',step4='$step4',step5='$step5',
step_image1='$step_image1',step_image2='$step_image2',step_image3='$step_image3',step_image4='$step_image4',step_image5='$step_image5'
 WHERE id=$id";

// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    echo "資料表user修改完成";
    } else {
        echo "資料表user修改錯誤" . $conn->error;
    }
    

    $conn->close();

    header("location: recipe-detail.php?recipe_id=".$id)

?>