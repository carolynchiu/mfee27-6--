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
$sql = "SELECT user_order.*, product.name AS product_name, product.price, users.name AS user_name FROM user_order JOIN product ON user_order.product_id = product.id JOIN users ON user_order.user_id = users.id $sqlWhere ORDER BY user_order.order_date DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
  <title>Order List</title>
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
  </style>
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <main class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
      <h1>所有訂單</h1>
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-outline-primary">share</button>
        <button type="button" class="btn btn-outline-primary">export</button>
      </div>
    </div>
    <div class="container">
      <div class="py-2">
        <?php if (isset($_GET["product_id"]) || isset($_GET["user_id"]) || isset($_GET["start"])) : ?>
          <a href="order-list.php" class="btn btn-info">回所有訂單列表</a>
        <?php endif; ?>
      </div>
      <div class="py-2">
        <form action="">
          <div class="row align-items-center">
            <div class="col-auto">
              <input type="date" class="form-control" name="start" required value="<?php
                                                                                    if (isset($_GET["start"])) echo $_GET["start"];
                                                                                    ?>">
            </div>
            ~
            <div class="col-auto">
              <input type="date" class="form-control" name="end" required value="<?php
                                                                                  if (isset($_GET["end"])) echo $_GET["end"];
                                                                                  ?>">
            </div>
            <div class="col-auto">
              <button class="btn btn-info" type="submit">送出</button>
            </div>
          </div>
        </form>
      </div>

      <?php if (isset($_GET["product_id"])) : ?>
        <h1><?= $rowProduct["name"] ?>的訂購紀錄</h1>
      <?php endif; ?>
      <?php if (isset($_GET["user_id"])) : ?>
        <h1><?= $rowUser["name"] ?>的訂購紀錄</h1>
      <?php endif; ?>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th>品名</th>
            <th>單價</th>
            <th>數量</th>
            <th>總價</th>
            <th>使用者</th>
            <th>日期</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) : ?>
            <tr>
              <td class="text-end"><?= $row["id"] ?></td>
              <td>
                <a href="order-list.php?product_id=<?= $row["product_id"] ?>"><?= $row["product_name"] ?></a>
              </td>
              <td class="text-end"><?= $row["price"] ?></td>
              <td class="text-end"><?= $row["amount"] ?></td>
              <td class="text-end"><?= $row["price"] * $row["amount"] ?></td>
              <td>
                <a href="order-list.php?user_id=<?= $row["user_id"] ?>"><?= $row["user_name"] ?></a>
              </td>
              <td><?= $row["order_date"] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>