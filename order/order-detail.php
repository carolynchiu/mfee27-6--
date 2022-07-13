<?php
session_start();

if (!isset($_GET["id"])) {
  echo "沒有參數";
  exit;
}
$id = $_GET["id"];

require("../db-connect.php");

//所有訂單
$sqlAll = "SELECT * FROM order_list";
$resultAll = $conn->query($sqlAll);
$allCount = $resultAll->num_rows; //所有訂單筆數

$sqlOrder = "SELECT order_list.*, users.account AS user_account, users.name AS user_name,coupon.name AS coupon_name,coupon.discount AS coupon_discount, order_status.id AS status_id, order_status.name AS order_status FROM order_list
JOIN users ON order_list.user_id = users.id 
JOIN coupon ON order_list.coupon_id = coupon.id
JOIN order_status ON order_list.status_id = order_status.id  
WHERE order_list.id=$id";
$resultOrder = $conn->query($sqlOrder);
$orderCount = $resultOrder->num_rows;

//訂單商品名細
$sqlDetail = "SELECT order_product_detail.*, products.name AS product_name, products.price AS product_price FROM order_product_detail 
JOIN products ON order_product_detail.product_id = products.id
WHERE order_id=$id";
$resultDetail = $conn->query($sqlDetail);
$detailCount = $resultDetail->num_rows;
?>
<!doctype html>
<html lang="en">

<head>
  <title>訂單商品詳細內容</title>
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
    <?php if ($detailCount > 0) :
      $rowsDetail = $resultDetail->fetch_all(MYSQLI_ASSOC);
      $rowsOrder = $resultOrder->fetch_assoc();
    ?>
      <div class="d-flex justify-content-between align-items-center border-bottom border-dark pb-2 mb-3">
        <h1><i class="fa-solid fa-file-lines me-3"></i>訂單編號-<?= $id ?> </h1>
        <div class="btn-group" role="group" aria-label="Basic example">
          <a type="button" href="order-detail.php?id=<?php
                                                      if ($id - 1 <= 0) {
                                                        echo 1;
                                                      } else {
                                                        echo $id - 1;
                                                      }
                                                      ?>" class="btn btn-info btn-outline-dark"><i class="fa-solid fa-circle-chevron-left me-2"></i>上一筆</a>
          <a type="button" href="order-detail.php?id=<?php
                                                      if ($id + 1 > $allCount) {
                                                        echo $id;
                                                      } else {
                                                        echo $id + 1;
                                                      }
                                                      ?>" class="btn btn-info btn-outline-dark">下一筆<i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
        </div>
      </div>
      <div class="container">
        <!-- 回到使用者列表頁 -->
        <div class="py-2">
          <div class="d-flex justify-content-between align-items-center">
            <a href="order-list.php" class="btn btn-info"><i class="fa-solid fa-circle-arrow-left me-2"></i>回到所有訂單</a>

            <!-- CRUD => delete -->
            <a href="doDelete.php?id=<?= $id ?>" class="btn btn-danger"><i class="fa-solid fa-circle-minus me-2"></i>取消訂單</a>
          </div>
        </div>
        <table class="table table-md table-hover">
          <tr>
            <th>訂單編號</th>
            <td><?= $id ?></td>
          </tr>
          <tr>
            <th>使用者帳號</th>
            <td><?= $rowsOrder["user_account"] ?></td>
          </tr>
          <tr>
            <th>使用者姓名</th>
            <td><?= $rowsOrder["user_name"] ?></td>
          </tr>
          <tr>
            <th>優惠券</th>
            <td><?= $rowsOrder["coupon_name"] ?><span class="ms-2">($<?= $rowsOrder["coupon_discount"] ?>)</span></td>
          </tr>
          <tr>
            <th>訂單狀態</th>
            <td class="<?php if ($rowsOrder["order_status"] == "已取消") {
                          echo "text-danger";
                        } ?>"><?= $rowsOrder["order_status"] ?></td>
          </tr>
          <tr>
            <th>訂單建立時間</th>
            <td><?= $rowsOrder["create_time"] ?></td>
          </tr>
        </table>
        <div class="mt-5">
          <h3 class="mb-2">商品明細</h3>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fa-solid fa-circle-plus"></i>
          </button>

          <!-- Modal -->
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">新增商品至訂單</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <?php if ($rowsOrder["status_id"] == 1) : ?>
                      <form action="doCreateProduct.php" method="post">
                        <div class="mb-2">
                          <label for="">訂單編號</label>
                          <input type="number" class="form-control" name="order_id" placeholder="<?= $id ?>" required>
                        </div>
                        <div class="mb-2">
                          <label for="">商品編號</label>
                          <input type="number" class="form-control" name="product_id" required>
                        </div>
                        <div class="mb-2">
                          <label for="">商品數量</label>
                          <input type="number" class="form-control" name="amount" required>
                        </div>
                        <div class="mb-2">
                          <label for="">商品備註</label>
                          <input type="text" class="form-control" name="text" required>
                        </div>
                        <button type="submit" class="btn btn-info">送出</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                      </form>
                    <?php else : ?>
                      <h3>訂單已出貨無法新增商品</h3>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-md table-bordered border-dark">
          <thead>
            <tr class="table-info border-dark">
              <th>編號</th>
              <th>商品名稱</th>
              <th>商品價格</th>
              <th>數量</th>
              <th>小計</th>
              <th>備註</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $number = 1;
            $total = 0;
            foreach ($rowsDetail as $row) :
              $subTotal = $row["product_price"] * $row["amount"];
              $total += $subTotal; ?>
              <tr>
                <td><?= $number++ ?></td>
                <td><?= $row["product_name"] ?></td>
                <td class="text-end">$<?= $row["product_price"] ?></td>
                <td class="text-end"><?= $row["amount"] ?></td>
                <td class="text-end">$<?= $subTotal ?></td>
                <td><?= $row["text"] ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="6" class="text-end">
                <div class="text-secondary h5">總計:<span class="ms-3">$<?= $total ?></span></div>
                <div class="text-danger"><span class=" me-2">-</span> 優惠券：<span class="ms-3">$<?= $rowsOrder["coupon_discount"] ?></span></div>
                <div class="h3">總金額:<span class="ms-3">$<?= $total - $rowsOrder["coupon_discount"] ?></span></div>

              </td>
            </tr>
          </tbody>
        </table>
      <?php else : ?>
        沒有訂單詳細資料
      <?php endif; ?>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>