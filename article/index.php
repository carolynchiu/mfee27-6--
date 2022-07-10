<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Article</title>
    </head>
    <body>
        <h3>新增文章</h3>
        <input id="create" type="text" />
        <button id="create-submit">送出</button>
        <table id="article-data">
            <tr>
                <th>文章編號</th>
                <th>帳號</th>
                <th>內文</th>
                <th>發布時間</th>
                <th>編輯</th>
            </tr>
        </table>
        <div id="update-div"></div>
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
                        <td>${object.id}</td>
                        <td>${object.user_id}</td>
                        <td>${object.text}</td>
                        <td>${object.create_time}</td>
                        <td>
                            <button id="update-${object.id}">修改</button>
                            <button id="delete-${object.id}">刪除</button>
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
                                    id: object.id,
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
    </body>
</html>
