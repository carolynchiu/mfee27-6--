<?php
$id=$_POST["id"];
require("../db-connect.php");


$sql="SELECT * FROM products";
$result=$conn->query($sql);
$productCount=$result->num_rows;

$sqlHide="UPDATE products SET status =0 WHERE id='$id'";
$resultHide=$conn->query($sqlHide);
// $rowHide=$resultHide->fetch_assoc();

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
      <?php if($productCount>0):
                    $row=$result->fetch_assoc();?>
        <div class="py-2">
            <a class="btn btn-info" href="product.php?id=<?=$row["id"]?>">取消
            </a>
        </div>
        <div class="py-2">
        <form action="doUpdate.php">
            <table class="table">
                <tr>
                    <th>id</th>
                    <td><?=$row["id"]?></td>
                </tr>
                <tr>
                    <th>商品名稱</th>
                    <td><input type="text" value="<?=$row["name"]?>"></td>
                </tr>
                <tr>
                    <th>商品簡介</th>
                    <td><input type="text" value="<?=$row["description"]?>"></td>
                </tr>
                <tr>
                    <th>商品類別</th>
                    <!-- 待處理 -->
                    <td><select id="inputState" class="form-select" placeholder="option" name="category_id" value="<?=$row["category_id"]?>" required>
                    <option disabled selected ></option>
                    <!-- 用Foreach? -->
                    <option value="1">器材</option>
                    <option value="2">服飾</option>
                    <option value="3">食品</option>
                </select></td>
                </tr>
                <tr>
                    <th>商品價格</th>
                    <td><input type="text" value="<?=$row["price"]?>"></td>
                </tr>
                <tr>
                    <th>商品庫存</th>
                    <td><input type="text" value="<?=$row["stock_in_inventory"]?>"></td>
                </tr>
                <tr>
                    <th>商品圖片</th>
                    <td><input type="text" value="<?=$row["image"]?>"></td>
                </tr>
                <tr>
                    <th>商品上下架時間</th>
                    <td><input type="date" value="<?=$row["launch_time"]?>">~<input type="date" value="<?=$row["discontinue_time"]?>"></td>
                </tr>
                <tr>
                    <th>商品上下架狀態</th>
                    <!-- 待處理 -->
                    <td><div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="" value="1">
                        <label class="form-check-label" for="">上架</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="" value="2">
                        <label class="form-check-label" for="">下架</label>
                    </div></td>
                </tr>
            </table>
        </form>
            <div class="py-2">
                <a class="btn btn-info" href="">儲存</a>
            </div>
        <?php endif;?>
        </div>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>