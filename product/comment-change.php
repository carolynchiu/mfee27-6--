<?php
//完成?
//可以再做搜尋的篩選器
//ex. 以商品名or 使用者 or 評論內容

require("../db-connect.php");

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
    if($conn->query($sqlReveal)===TRUE){
        echo "change success";
    }else{
        echo "change fail";
    }
    if(isset($_GET["search"])){
        
        header("location:product-comment-search.php?search=$search");
    }else{
        header("location:product-comments.php");
    }
    
}

//隱藏
if($_GET["status"]==0){
    echo "status=0";
    $sqlHide="UPDATE product_comments SET status =0 WHERE id=$id";
    if($conn->query($sqlHide)===TRUE){
        echo "change success";
    }else{
        echo "change fail";
    }
    //根據有沒有抓到search來判斷 header去哪
    if(isset($_GET["search"])){
        header("location:product-comment-search.php?search=$search");
    }else{
        header("location:product-comments.php");
    }
}





 
?>

