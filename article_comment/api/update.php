<?php
require("../../db-connect.php");


$id = $_POST['id'];
$comment = $_POST['comment'];

$sql= "UPDATE article_comment SET comment = ?  WHERE id = ?";

$stmt =$conn ->prepare($sql);

$stmt->bind_param('ss',$comment,$id);

$result=$stmt->execute();

if($result){
    echo '修改成功';
}else{
    echo '修改失敗';
}












?>