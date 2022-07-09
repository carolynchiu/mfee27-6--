<?php
require("../db-connect.php");

//要先給一個值，這樣沒有 $_GET["product_id"] 或是 $_GET["user_id"] 才不會報錯
$sqlWhere = "";

if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $sqlWhere = "WHERE user_order.product_id = $product_id";

    //產品名稱 XXX的訂購紀錄 (UI顯示)
    $sqlProduct = "SELECT name FROM product WHERE id=$product_id";
    $resultProduct = $conn->query($sqlProduct);
    $rowProduct = $resultProduct->fetch_assoc();
}

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
    $sqlWhere = "WHERE user_order.user_id = $user_id";

    //使用者名稱 XXX的訂購紀錄 (UI顯示)
    $sqlUser = "SELECT name FROM users WHERE id=$user_id";
    $resultUser = $conn->query($sqlUser);
    $rowUser = $resultUser->fetch_assoc();
}

if (isset($_GET["start"])) {
    $start = $_GET["start"];
    $end = $_GET["end"];
    $sqlWhere = "WHERE order_date BETWEEN '$start' AND '$end'";
}

//ORDER BY 日期排序 降冪 新的日期在前面比較好
// $sql = "SELECT user_order.*, product.name AS product_name, product.price, users.name AS user_name FROM user_order JOIN product ON user_order.product_id = product.id JOIN users ON user_order.user_id = users.id $sqlWhere ORDER BY user_order.order_date DESC";
$sql = "SELECT * FROM course JOIN course_content ON course.id=course_content.id WHERE course.valid=0 || course.valid=1 ORDER BY course.create_time DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);



?>
<!doctype html>
<html lang="en">

<head>
    <title>所有課程</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css" />
    <style>
        :root {
            --aside-width: 200px;
        }

        a,
        a:link {
            text-decoration: none;
        }

        .site-name {
            width: var(--aside-width);
        }

        .dashboard-control {
            width: var(--aside-width);
        }

        .dashboard-control nav {
            margin-top: 40px;
        }

        .side-menu a {
            display: block;
            color: #333;
            padding: 10px;
        }

        .side-menu a:hover {
            background: #fff;
        }

        .second-title {
            padding: 10px;
        }

        .second-title a {
            color: #333;
        }

        .main-content {
            margin-left: var(--aside-width);
            margin-top: 40px;
        }
        table.table th,td{
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php require("../module/header.php"); ?>
    <?php require("../module/aside.php"); ?>
    <main class="main-content p-4">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <h1>所有課程</h1>
            <div class="btn-group" role="group" aria-label="Basic example">
                
                <a href="create_course.php" type="get" class="btn btn-outline-primary">+新增課程</a>
            </div>
        </div>
        <div class="container">
            <div class="py-2">
                <?php if (isset($_GET["product_id"]) || isset($_GET["user_id"]) || isset($_GET["start"])) : ?>
                    <a href="order-list.php" class="btn btn-info">回所有訂單列表</a>
                <?php endif; ?>
            </div>



            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>課程編號</th>
                        <th>課程名稱</th>
                        <th>課程圖片</th>
                        <th>建立日期</th>
                        <th>操作</th>
                        <th>狀態</th>
                        <!-- <th>上/下架</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td><?= $row["name"] ?></td>
                            <td><img src="<?= $row["image"] ?>" class="w-25" alt=""></td>                            
                            <td><?= $row["create_time"] ?></td>
                            <td>
                            <a class="btn btn-info" href="edit-course.php?id=<?= $row["id"] ?>">詳細內容</a>
                            
                            
                            <a class="btn btn-success 
                            <?php if($row["valid"]==0){
                                echo "d-inline";
                            }else echo "d-none"  ?> 
                            " href="doOn.php?id=<?= $row["id"] ?>">上架</a>


                            <a class="btn 
                            <?php if($row["valid"]==1){
                                echo "d-inline";
                            }else echo "d-none"  ?> 
                            btn-secondary" href="doOff.php?id=<?= $row["id"] ?>">下架</a>

                            <a id="check-del" class="btn btn-danger" href="doDelete.php?id=<?= $row["id"] ?>">刪除</a>
                            </td>
                            <td>
                                <?php if($row["valid"]==1){
                                    echo "<span class=\"text-success fw-bold\">上架</span>";
                                }else echo "<span class=\"text-secondary fw-bold\">下架</span>"; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                                
            
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>