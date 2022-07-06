<?php
if(!isset($_GET["id"])){
  echo "沒有參數";
  exit;
}
$id=$_GET["id"];
require("../db-connect.php");


$sql="SELECT * FROM products WHERE id=$id";
$result=$conn->query($sql);
$productCount=$result->num_rows;



?>
<!doctype html>
<html lang="en">

<head>
  <title>Product</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css" />
  <style>
    *{
      border:1px solid red;
    }
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

    /* product-module */
    .object-cover {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .table{
      table-layout:fixed;
    }
  </style>
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <main class="main-content p-4">
  <div class="container">
        <div class="py-2">
            <a class="btn btn-info" href="products-list.php">回到商品頁面</a>
        </div>
        <div class="py-2">
        <?php if($productCount>0):
                    $row=$result->fetch_assoc();?>
            <table class="table">
                <tr>
                    <th>id</th>
                    <td><?=$row["id"]?></td>
                </tr>
                <tr>
                    <th>商品名稱</th>
                    <td><?=$row["name"]?></td>
                </tr>
                <tr>
                    <th>商品簡介</th>
                    <td><?=$row["description"]?></td>
                </tr>
                <tr>
                    <th>商品類別</th>
                    <td><?=$row["category_id"]?></td>
                </tr>
                <tr>
                    <th>商品價格</th>
                    <td><?=$row["price"]?></td>
                </tr>
                <tr>
                    <th>商品庫存</th>
                    <td><?=$row["stock_in_inventory"]?></td>
                </tr>
                <tr>
                    <th>商品圖片</th>
                    <td><?=$row["image"]?></td>
                </tr>
                <tr>
                    <th>商品上下架時間</th>
                    <td><?=$row["launch_time"]?>~<?=$row["discontinue_time"]?></td>
                </tr>
                <tr>
                    <th>商品上下架狀態</th>
                    <td><?=$row["status"]?></td>
                </tr>
            </table>
            <div class="py-2">
                <a class="btn btn-warning" href="product-edit.php?id=<?=$row["id"]?>">修改商品內容</a>
                <a class="btn btn-danger" href="">刪除商品</a>
            </div>
        <?php endif;?>
        </div>
      </div>
        
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>