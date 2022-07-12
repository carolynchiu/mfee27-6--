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
        <title>Admins</title>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../style/common.css" />
    </head>

    <body>
        <?php require("../module/header.php"); ?>
        <?php require("../module/aside.php"); ?>
        <div class="main-content px-4">
            <div class="d-flex p-4">
                <button class="button-standard blue me-4" id="createBtn">新增</button>
            </div>
            <table class="table table-bordered border-dark" id="article-data">
                <thead>
                <tr class="table-info">
                    <th>文章編號</th>
                    <th>使用者</th>
                    <th>文章標題</th>
                    <th>發布時間</th>
                    <th>編輯</th>
                </tr>
                </thead>
                <tbody id="append-target"></tbody>
            </table>
            <div id="update-div"></div>
        </div>

        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>
       <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script>
          
            // 查詢現有資料
            $.ajax({
                url: "./api/research.php",
                type: "POST",
            }).then((res) => {

                // 1. 把res呈現在table裡面 (變成UI)
                let appendTarget = document.getElementById("append-target");
                    
                    // for 1. 宣告變數0 , 2.結束條件 , 3.每次回圈做完+1
                for (let i = 0; i < res.length; i++) {
                    let object = res[i];
                    console.log(object);
                    //#region 推UI

                    let tr = document.createElement("tr");
                    tr.classList.add('p-4');
                    tr.classList.add("data");
                    tr.innerHTML = `
                        <td class="border">${object.article_id}</td>
                        <td class="border">${object.user_name}</td>
                        <td class="border">${object.article_title}</td>    
                        <td class="border">${object.create_time}</td>
                        <td class="border">
                            <button class="button-standard blue" id="update-${object.article_id}">修改</button>
                            <button class="button-standard red" id="delete-${object.article_id}">刪除</button>
                        </td>
                    `;
                    appendTarget.append(tr);
                    //#endregion
                    //#region 刪除
                    // 刪除的按鈕ID
                    let deleteBtn = document.getElementById(
                        `delete-${object.article_id}`
                    );
                    // 刪除事件
                    deleteBtn.onclick = function () {
                        let isConfirm = confirm("確定刪除?");

                        if (isConfirm === true) {
                            $.ajax({
                                url: "./api/delete.php",
                                type: "post",
                                data: {
                                    id: object.article_id,
                                },
                            }).then(function (deleteRes) {
                                if (deleteRes === "刪除成功") {
                                    location.reload();
                                } else {
                                    alert("刪除失敗");
                                }
                            });
                        }
                    };
                    //#endregion
                    //#region 更新
                    let updateBtn = document.getElementById(
                        `update-${object.article_id}`
                    );

                    updateBtn.onclick = function () {
             
                        let formatted = JSON.stringify(object);
                        sessionStorage.setItem('article_ref',formatted);
                        window.location.href = "./edit.php";
                    };

                    
                    //#endregion
                }
                
                $("#article-data").DataTable();
            });
                    //新增按鈕跳轉
                    let createBtn =document.getElementById('createBtn');
                    createBtn.onclick = function(){
                    window.location.href ="./insert.php";
                    };

                
        </script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
