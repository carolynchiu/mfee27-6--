<?php
require("../db-connect.php");

$sqlCategory = "SELECT * FROM category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);
/*
if (isset($_GET["category"])) {
  $category = $_GET["category"];
  // $sql = "SELECT * FROM product";
  // 把兩個資料表join
  $sql = "SELECT product.*, category.name AS category_name FROM product JOIN category ON product.category_id = category.id WHERE product.category_id=$category";
} else {
  $category = "";
  // $sql = "SELECT * FROM product";
  // 把兩個資料表join
  $sql = "SELECT product.*, category.name AS category_name FROM product JOIN category ON product.category_id = category.id";
}
*/

if (isset($_GET["category"])) {
  $category = $_GET["category"];
  $sqlWhere = "WHERE product.category_id=$category";
} else {
  $category = "";
  $sqlWhere = "";
}

$sql = "SELECT product.*, category.name AS category_name FROM product JOIN category ON product.category_id = category.id $sqlWhere";

$result = $conn->query($sql); //query，執行資料表的查詢，執行SQL指令
$product_count = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);
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
  </style>
</head>

<body>
  <?php require("./module/header.php"); ?>
  <?php require("./module/aside.php"); ?>
  <main class="main-content p-4">
    <div class="container">
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link <?php if ($category == "") echo "active"; ?>" aria-current="page" href="product-2.php">All</a>
        </li>
        <?php foreach ($rowsCategory as $row) : ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($category == $row["id"]) echo "active"; ?>" href="product-2.php?category=<?= $row["id"] ?>"><?= $row["name"] ?></a>
          </li>
        <?php endforeach; ?>
        <!-- <li class="nav-item">
          <a class="nav-link" href="product-2.php?category=2">Pokemon</a>
        </li> -->
      </ul>
      <?php require("./price-filter-2.php"); ?>
      <div class="py-2">
        共<?= $product_count ?> 筆資料
      </div>
      <?php require("./product-list-2.php"); ?>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>


</html>