<?php
require("../db-connect.php");

$sql="SELECT products.*  FROM products  ";
// 想辦法把product.category_id=category.name
$result=$conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);



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
  <div class="container table-responsive">
    <div class="py-2">
      <a class="btn btn-info" href="product-add.php">新增商品</a>
    </div>
        <table class="table table-bordered  table-hover mt-5">
          <thead>
            <tr>
              <th>商品編號</th>
              <th>商品名稱</th>
              <th>商品簡介</th>
              <th>商品類別</th>
              <th>商品價格</th>
              <th>商品庫存</th>
              <th>商品圖片</th>
              <th>商品上下架時間</th>
              <th>商品上下架狀態</th>
              <th>查看商品資訊</th>
            </tr>
          </thead>
          <tbody >
            <?php foreach($rows as $row):?>
            <tr>
              <td><?=$row["id"]?></td>
              <td><?=$row["name"]?></td>
              <td><?=$row["description"]?></td>
              <td><?=$row["category_id"]?></td>
              <td><?=$row["price"]?></td>
              <td><?=$row["stock_in_inventory"]?></td>
              <td><?=$row["image"]?></td>
              <td><?=$row["launch_time"]."<br>";?>~<?=$row["discontinue_time"]?></td>
              <td><?=$row["status"]?></td>
              <td class="text-center"><a class="btn btn-info " href="product.php?id=<?=$row["id"]?>">查看</a></td>
              
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>