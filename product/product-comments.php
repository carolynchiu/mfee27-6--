<?php
require("../db-connect.php");

//待處理
//1.
//將users.id帶入product_comments.user_id 和products.id 帶入product_comments.product_id
//然後用users和products的id個別帶入他們的name
// $sql="SELECT product_comments.* ,users.name AS users_name, products.name AS products_name  FROM product_comments JOIN users ,products ON product_comments.user_id= users.id,product_comments.product_id=products.id";

//2.頁數
//3.搜尋

$sql="SELECT * FROM product_comments";
$result=$conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);



?>
<!doctype html>
<html lang="en">

<head>
  <title>商品評論</title>
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
        <table class="table table-bordered  table-hover mt-5">
          <thead>
            <tr>
              <th>評論編號</th>
              <th>使用者</th>
              <th>商品</th>
              <th>評論內容</th>
              <th>評論狀態</th>
              <th>隱藏</th>
            </tr>
          </thead>
          <tbody >
            <?php foreach($rows as $row):?>
            <tr>
              <td><?=$row["id"]?></td>
              <td><?=$row["user_id"]?></td>
              <td><?=$row["product_id"]?></td>
              <td><?=$row["comment"]?></td>
              <td><?php if($row["status"]==1){
                echo "顯示";
              }else{
                echo "隱藏";
              }
              ?>   
              </td>
              <td class="text-center"><a class="btn btn-info my-2" href="product.php?id=<?=$row["id"]?>">顯示</a>
              <a class="btn btn-info my-2 " href="product.php?id=<?=$row["id"]?>">隱藏</a></td>
              
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>