<?php
require("../../db-connect.php");


$id = $_POST['id'];
$text = $_POST['text'];
$article_title = $_POST['article_title'];

$sql= "UPDATE article SET text = ?, article_title = ?  WHERE id = ?";

$stmt =$conn ->prepare($sql);

$stmt->bind_param('sss',$text, $article_title, $id);

$result=$stmt->execute();

if($result){
    echo '修改成功';
}else{
    echo '修改失敗';
}












?>