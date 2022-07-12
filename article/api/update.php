<?php
require("../../db-connect.php");


$id = $_POST['id'];
$text = $_POST['text'];

$sql= "UPDATE article SET text = ?  WHERE id = ?";

$stmt =$conn ->prepare($sql);

$stmt->bind_param('ss',$text,$id);

$result=$stmt->execute();

if($result){
    echo '修改成功';
}else{
    echo '修改失敗';
}












?>