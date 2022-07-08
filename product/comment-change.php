<?php
//可能用a連結到這 再修改表單內容
//確認有沒有抓到
if(isset($_GET["id"])&&isset($_GET["status"])){
    $status=$_GET["status"];
    $id =$_GET["id"];
    echo "yes"."<br>";
}else{
    echo "no";
}

//顯示
if($_GET["status"]==1){
    echo "status=1";
    $sqlReveal="UPDATE product_comments SET status =1 WHERE id=$_GET["id"]";
    $conn->query($sqlReveal);
    $conn->close();
}else{
    //header("location:product-comments.php");
}

//隱藏
if($_GET["status"]==0){
    echo "status=0";
    $sqlHide="UPDATE product_comments SET status =0 WHERE user_id=$id";
}else{
    //header("location:product-comments.php");
}





 
?>

