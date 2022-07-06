<?php
require("../db-connect.php");
?>
<!doctype html>
<html lang="en">

<head>
  <title>新增商品</title>
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
        <form action="do-create.php" method="post">
            <div class="mb-2">
                <label for="">商品名稱</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-2">
                <label for="">商品簡介</label>
                <input type="text" class="form-control" name="description" required>
            </div>
            <div class="mb-2">
                <label for="inputState" class="form-label">商品類別</label>
                <select id="inputState" class="form-select" placeholder="option" name="category_id" required>
                    <option disabled selected ></option>
                    <!-- 用Foreach? -->
                    <option value="1">器材</option>
                    <option value="2">服飾</option>
                    <option value="3">食品</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">商品價格</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="mb-2">
                <label for="">商品庫存</label>
                <input type="number" class="form-control" name="stock_in_inventory" required>
            </div>
            <div class="mb-2">
                <label for="">商品圖片</label>
                <input type="text" class="form-control" name="image" required>
            </div>
            <div class="mb-2">
                <label for="">商品上下架時間</label>
                <input type="date" class="form-control" name="launch_time" required>
                ~
                <input type="date" class="form-control" name="discontinue_time" required>
            </div>
            <div class="mb-2">
                <label for="">商品上下架狀態</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="" value="1"
                        <?php  
                        
                        
                        ?>>
                        <label class="form-check-label" for="">上架</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="" value="0" 
                        <?php  
                        
                        
                        ?>>
                        <label class="form-check-label" for="">下架</label>
                    </div>
                    <!-- 用timestamp控制checked -->
                </div>
            </div>
            <button class="btn btn-info" type="submit">送出</button>
        </form>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>