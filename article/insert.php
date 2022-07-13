<?php
session_start();
require("../db-connect.php");

if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}

// $sqlAll = "SELECT * FROM admins WHERE valid=1";
// $resultAll = $conn->query($sqlAll);
// // $adminCount = $resultAll->num_rows; //所有的使用者

// $page = 3;
// $perPage = 5;
// $start = ($page - 1) * $perPage;

// $order = $_GET["order"];
$order = isset($_GET["order"]) ? $_GET["order"] : 1; //給預設值

switch ($order) {
  case 1:
    $orderType = "id ASC";
    break;
  case 2:
    $orderType = "id DESC";
    break;
  case 3:
    $orderType = "account ASC";
    break;
  case 4:
    $orderType = "account DESC";
    break;
  default:
    $orderType = "ASC";
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>文章編輯</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.0-beta1 -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="../fontawesome-free-6.1.1-web/css/all.min.css"
        />
        <link rel="stylesheet" href="../style/common.css" />
    </head>

    <body>
        <?php require("../module/header.php"); ?>
        <?php require("../module/aside.php"); ?>
        <div class="main-content px-4">
            <div class="d-flex justify-content-end p-4">
                <button class="btn btn-primary" id="back">返回</button>
            </div>
            <h3 class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3" id="article_id">新增文章</h3>

            <div class="my-2">
                <label for="">標題</label>
                <input id="article_title" class="form-control" type="text">
            </div>

            <div class="my-2">
                <label for="">內文</label>
                <textarea id="article_text" class="form-control" type="text"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button id="submit" class="btn btn-primary mt-2">新增</button>
            </div>
            <div>
                <label id="create_time" for=""></label>
            </div>
            <div>
                <label id="user_name" for=""></label>
            </div>
        </div>

        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>

                        <script>

                            let user = JSON.parse(sessionStorage.getItem("admin"));
                            console.log(user);
                            let title = document.getElementById("article_title");
                            let content = document.getElementById("article_text");
                            // 跑送資料的方法
                            let submit = document.getElementById("submit");
                            submit.onclick= function(){
                                $.ajax({
                                url: "./api/create.php",
                                type: "post",
                                data: {
                                    user_id:"1",
                                    text: content.value,
                                    article_title: title.value
                                },

                            }).then((res)=>{console.log(res)})
                            ;
                            window.location.href="./"
                            };
                            //返回按鈕的事件
                            let backBtn =document.getElementById('back');
                            backBtn.onclick = function(){
                                window.location.href="./" 
                            }
                            
                        </script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
