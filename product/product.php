<?php
session_start();
if(!isset($_GET["id"])){
  echo "沒有參數";
  exit;
}
$id=$_GET["id"];
require("../db-connect.php");


$sql="SELECT * FROM products WHERE id=$id ";
$result=$conn->query($sql);
$productCount=$result->num_rows;


?>
<!doctype html>
<html lang="en">

<head>
<?php if($productCount>0):
$row=$result->fetch_assoc();?>
  <title>商品: <?=$row["name"]?></title>
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
  <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
      <h1><i class="fa-solid fa-box-archive me-3"></i>商品<?=$row["id"]?>:<?=$row["name"]?></h1>
    </div>
  <div class="container">
        <div class="py-2">
            <a class="btn btn-info" href="products-list.php"><i class="fa-solid fa-arrow-rotate-left me-3"></i>回到商品頁面</a>
        </div>
        <div class="py-2">
          <div class="row  justify-content-between py-2">
            <div class="d-flex col-8 justify-content-center">
            <table class="table table-hover  ps-5 ">
                <tr>
                    <th>商品編號</th>
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
                    <td><?php 
                    switch($row["category_id"]):
                      case 1:
                        echo "器材";
                        break;
                      case 2:
                        echo "服飾";
                        break;
                      case 3:
                        echo "食品";
                        break;
                      default:
                        echo "";
                    ?>
                    // <?php endswitch;?></td>
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
                    <th>商品上下架時間</th>
                    <td><?=$row["launch_time"]?>~<?=$row["discontinue_time"]?></td>
                </tr>
                <tr>
                    <th>商品上下架狀態</th>
                    <td><?php if($row["status"]==1){
                      echo "上架";
                    }else{
                      echo "下架";
                    }
                    ?></td>
                </tr>
            </table>
                  </div>
            <figure class="col-4">
              <img class="object-cover shadow" src="../product_image/<?=$row["image"]?>" alt="">
            </figure>
            </div>
            <div class="py-2 d-flex justify-content-between">
                <a class="btn btn-warning" href="product-edit.php?id=<?=$row["id"]?>"><i class="fa-solid fa-pen me-2"></i>修改商品內容</a>
                <a class="btn btn-danger" href="do-delete.php?id=<?=$row["id"]?>"><i class="fa-solid fa-trash-can me-2"></i>刪除商品</a>
            </div>
        <?php endif;?>
        </div>
      </div>
        
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>