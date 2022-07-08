<?php
//完成

require("../db-connect.php");
//可能用a連結到這 再修改表單內容
//確認有沒有抓到

if(isset($_GET["search"])){
    $search=$_GET["search"];
    echo "search catch"."<br>";
}else{
    echo "search loss"."<br>";
}

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
    $sqlReveal="UPDATE product_comments SET status =1 WHERE id=$id";
    if(isset($_GET["search"])){
        if($conn->query($sqlReveal)===TRUE){
            echo "change success";
        }else{
            echo "change fail";
        }
        header("location:product-comment-search.php?search=$search");
    }else{
        if($conn->query($sqlReveal)===TRUE){
            echo "change success";
        }else{
            echo "change fail";
        }
        header("location:product-comments.php");
    }
    
}

//隱藏
if($_GET["status"]==0){
    echo "status=0";
    $sqlHide="UPDATE product_comments SET status =0 WHERE id=$id";
    if(isset($_GET["search"])){
        if($conn->query($sqlHide)===TRUE){
            echo "change success";
        }else{
            echo "change fail";
        }
        header("location:product-comment-search.php?search=$search");
    }else{
        if($conn->query($sqlHide)===TRUE){
            echo "change success";
        }else{
            echo "change fail";
        }
        header("location:product-comments.php");
    }
}





 
?>

