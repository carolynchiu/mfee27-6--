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
<!doctype html>
<html lang="en">

<head>
  <title>Admins</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css">
  <link rel="stylesheet" href="../style/common.css">
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <div class="main-content px-4">
    <h3>新增文章</h3>
        <div class="d-flex">
        <input  class="form-control" id="create" type="text" />
        <button class="btn btn-primary" id="create-submit">送出</button>
        </div>
        <table class="table" id="article-data">
            <tr>
                <th>文章編號</th>
                <th>使用者</th>
                <th>文章標題</th>
                <th>內文</th>
                <th>發布時間</th>
                <th>編輯</th>
            </tr>
        </table>
        <div id="update-div"></div>
    </div>


        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>

        <script>
            // 查詢現有資料
            $.ajax({
                url: "./api/research.php",
                type: "POST",
            }).then((res) => {
                // 1. 把res呈現在table裡面 (變成UI)
                let appendTarget = document.getElementById("article-data");
                // for 1. 宣告變數0 , 2.結束條件 , 3.每次回圈做完+1
                for (let i = 0; i < res.length; i++) {
                    let object = res[i];
                    console.log(object);
                    //#region 推UI

                    let tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td>${object.article_id}</td>
                        <td>${object.user_name}</td>
                        <td>${object.article_title}</td>
                        <td>${object.article_text}</td>
                        <td>${object.create_time}</td>
                        <td>
                            <button class="button-standard blue" id="update-${object.id}">修改</button>
                            <button class="button-standard red" id="delete-${object.id}">刪除</button>
                        </td>
                    `;
                    appendTarget.append(tr);
                    //#endregion
                    //#region 刪除
                    // 刪除的按鈕ID
                    let deleteBtn = document.getElementById(
                        `delete-${object.id}`
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
                        `update-${object.id}`
                    );
                    updateBtn.onclick = function () {
                        // console.log(object);
                        function AppendNew() {
                            // 先得到自己命名的ID的標籤，再存到左邊的變數
                            let updateDiv =
                                document.getElementById("update-div");
                            // 再做出要推的標籤到變數裡
                            let text = document.createElement("textarea");

                            // updateSubmitBtn=變數                button=標籤
                            let updateSubmitBtn =
                                document.createElement("button");
                            // 方法：要推的目標.append(要推的東西)
                            // 概念：把要推的東西推到要推的目標內
                            text.value = object.text;
                            updateDiv.append(text);
                            updateSubmitBtn.innerText = "更改";

                            updateSubmitBtn.onclick = function () {
                                // 已經或得改的目標、改文字
                                let id = object.id;
                                let word = text.value;
                                console.log(id, word);
                                $.ajax({
                                    url: "./api/update.php",
                                    type: "post",
                                    data: {
                                        id: id,
                                        text: word,
                                    },
                                }).then(function (updateRes) {
                                    if (updateRes === "修改成功") {
                                        location.reload();
                                    } else {
                                        alert("修改失敗");
                                    }
                                });
                            };

                            updateDiv.append(updateSubmitBtn);
                        }

                        let target = document.getElementById("update-div");
                        target.innerHTML = "";
                        AppendNew();
                    };
                    //#endregion
                }
            });

            //#region 新增
            // 新增的方法
            let createInput = document.getElementById("create");
            let submitBtn = document.getElementById("create-submit");
            // 送出按鈕下去的時候
            submitBtn.onclick = function () {
                $.ajax("./api/create.php", {
                    method: "POST",
                    data: {
                        text: createInput.value,

                        // 後面要改的
                        user_id: 1,
                        // 後面要改的
                        // create_time: "2022-07-09 12:00:00",
                    },
                }).then((res) => {
                    console.log(res);
                    if (res === "新增成功") {
                        location.reload();
                    }
                });
            };
            //#endregion
        </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>