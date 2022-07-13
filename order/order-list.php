<?php
session_start();
require("../db-connect.php");

if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}

//所有訂單
$sqlAll = "SELECT * FROM order_list";
$resultAll = $conn->query($sqlAll);
$orderListCount = $resultAll->num_rows; //所有訂單


// 排序
$order = isset($_GET["order"]) ? $_GET["order"] : 1; //給預設值

switch ($order) {
  case 1:
    $orderType = "id ASC";
    break;
  case 2:
    $orderType = "id DESC";
    break;
  case 3:
    $orderType = "account ASC";
    break;
  case 4:
    $orderType = "account DESC";
    break;
  default:
    $orderType = "ASC";
}

//訂單狀態
$sqlStatus = "SELECT * FROM order_status";
$resultStatus = $conn->query($sqlStatus);
$rowsStatus = $resultStatus->fetch_all(MYSQLI_ASSOC);


// $page = 3;
$perPage = 10;
$start = ($page - 1) * $perPage;
$startItem = ($page - 1) * $perPage + 1; //開始的筆數
$endItem = $page * $perPage;


if (isset($_GET["status"])) {
  $status = $_GET["status"];
  $sqlWhere = "WHERE order_list.status_id=$status";
  $statusOrder = "&status=$status"; //某狀態的排序
  $sqlOrderStatus = "SELECT * FROM order_list WHERE status_id = $status";
  $resultOrderStatus = $conn->query($sqlOrderStatus);
  $orderStatusCount = $resultOrderStatus->num_rows; //某狀態的訂單數量
  if ($endItem > $orderStatusCount) $endItem = $orderStatusCount;
  $totalPage = ceil($orderStatusCount / $perPage);
} else {
  $status = "";
  $sqlWhere = "";
  $statusOrder = "";
  $orderStatusCount = $orderListCount;
  if ($endItem > $orderListCount) $endItem = $orderListCount;
  $totalPage = ceil($orderListCount / $perPage);
}
// 沒有加 order by就是自然排序,變更資料容易影響自然排序 (最好加)
$sql = "SELECT order_list.*, users.account AS user_account, coupon.name AS coupon_name, order_status.name AS order_status FROM order_list
JOIN users ON order_list.user_id = users.id 
JOIN coupon ON order_list.coupon_id = coupon.id
JOIN order_status ON order_list.status_id = order_status.id
$sqlWhere  
ORDER BY $orderType LIMIT $start, $perPage";
$result = $conn->query($sql);
$pageOrderCount = $result->num_rows; //每頁的使用者
?>
<!doctype html>
<html lang="en">

<head>
  <title>order list</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css">
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
  <?php require("../module/header.php");
  ?>
  <?php require("../module/aside.php");
  ?>
  <main class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
      <h1><i class="fa-solid fa-file-lines me-3"></i>所有訂單</h1>
      <div class="div">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
          <i class="fa-solid fa-file-circle-plus me-2"></i>新增訂單
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">新增訂單</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form action="doCreate.php" method="post">
                    <div class="mb-2">
                      <label for="">會員編號</label>
                      <input type="number" class="form-control" name="user_id" required>
                    </div>
                    <div class="mb-2">
                      <label for="">優惠券</label>
                      <input type="number" class="form-control" name="coupon_id">
                    </div>
                    <div class="mb-2">
                      <label for="">訂單狀態</label>
                      <input type="number" class="form-control" name="status_id" required>
                    </div>
                    <div class="mb-2">
                      <label for="">商品編號</label>
                      <input type="number" class="form-control" name="product_id" required>
                    </div>
                    <div class="mb-2">
                      <label for="">商品數量</label>
                      <input type="number" class="form-control" name="amount" required>
                    </div>
                    <button type="submit" class="btn btn-info">送出</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-between align-items-center mb-3">
        <!-- 訂單狀態篩選按鈕 -->
        <div class="col-md-6">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="me-1 border border-info nav-link <?php if ($status == "") echo "active"; ?>" aria-current="page" href="order-list.php">All</a>
            </li>
            <?php foreach ($rowsStatus as $row) : ?>
              <li class="nav-item">
                <a class="me-1 border border-info nav-link <?php if ($status == $row["id"]) echo "active"; ?>" href="order-list.php?page=<?= $page ?>&status=<?= $row["id"] ?>"><?= $row["name"] ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="col-md-5">
          <div class="py-2 d-flex justify-content-end align-items-center">
            <div class="me-2">排序</div>
            <div class="btn-group">
              <a href="order-list.php?page=<?= $page ?>&order=1<?= $statusOrder ?>" class="btn btn-info
        <?php if ($order == 1) echo "active"; ?>"> <i class="fa-solid fa-arrow-down-short-wide me-2"></i>訂單編號</a>
              <a href="order-list.php?page=<?= $page ?>&order=2<?= $statusOrder ?>" class="btn btn-info
        <?php if ($order == 2) echo "active"; ?>"><i class="fa-solid fa-arrow-down-wide-short me-2"></i>訂單編號</a>
              <a href="order-list.php?page=<?= $page ?>&order=3<?= $statusOrder ?>" class="btn btn-info
        <?php if ($order == 3) echo "active"; ?>"><i class="fa-solid fa-arrow-down-short-wide me-2"></i>帳號</a>
              <a href="order-list.php?page=<?= $page ?>&order=4<?= $statusOrder ?>" class="btn btn-info
        <?php if ($order == 4) echo "active"; ?>"><i class="fa-solid fa-arrow-down-wide-short me-2"></i>帳號</a>
            </div>
          </div>
        </div>
      </div>

      <div class="py-2 border-top">
        第<?= $startItem ?>-<?= $endItem ?> 筆，共<?php echo $orderStatusCount; ?>筆資料
      </div>
      <div class="py-2">
        <nav aria-label="Page navigation example">
          <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item"><a class="page-link" href="order-list.php?page=<?php
                                                                                  if ($page - 1 <= 0) {
                                                                                    echo 1;
                                                                                  } else {
                                                                                    echo $page - 1;
                                                                                  } ?>&order=<?= $order ?><?= $statusOrder ?>"><i class="fa-solid fa-angle-left"></i></a></li>
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
              <li class="page-item
            <?php if ($page == $i) echo "active"; ?>
            "><a class="page-link" href="order-list.php?page=<?= $i ?>&order=<?= $order ?><?= $statusOrder ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="order-list.php?page=<?php
                                                                                  if ($page + 1 > $totalPage) {
                                                                                    echo $totalPage;
                                                                                  } else {
                                                                                    echo $page + 1;
                                                                                  } ?>&order=<?= $order ?><?= $statusOrder ?>"><i class="fa-solid fa-angle-right"></i></a></li>
          </ul>
        </nav>
      </div>
      <?php if ($pageOrderCount > 0) :
        $rows = $result->fetch_all(MYSQLI_ASSOC);
      ?>
        <table class="table table-bordered">
          <thead>
            <tr class="table-info border-dark border-bottom border-3">
              <th>訂單編號</th>
              <th>使用者帳號</th>
              <th>優惠券</th>
              <th>訂單建立時間</th>
              <th>訂單狀態</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row) : ?>
              <tr>
                <td><?= $row["id"] ?></td>
                <td><?= $row["user_account"] ?></td>
                <td><?= $row["coupon_name"] ?></td>
                <td><?= $row["create_time"] ?></td>
                <td class="<?php if ($row["order_status"] == "已取消") {
                              echo "text-danger";
                            } ?>"><?= $row["order_status"] ?></td>
                <td class="text-center">
                  <a href="order-detail.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-2"></i>詳細資料</a>
                  <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-circle-minus me-2"></i>取消</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else : ?>
        目前沒有資料
      <?php endif; ?>
      <div class="py-2">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="order-list.php?page=<?php
                                                                                  if ($page - 1 <= 0) {
                                                                                    echo 1;
                                                                                  } else {
                                                                                    echo $page - 1;
                                                                                  } ?>&order=<?= $order ?><?= $statusOrder ?>"><i class="fa-solid fa-angle-left"></i></a></li>
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
              <li class="page-item
            <?php if ($page == $i) echo "active"; ?>
            "><a class="page-link" href="order-list.php?page=<?= $i ?>&order=<?= $order ?><?= $statusOrder ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="order-list.php?page=<?php
                                                                                  if ($page + 1 > $totalPage) {
                                                                                    echo $totalPage;
                                                                                  } else {
                                                                                    echo $page + 1;
                                                                                  } ?>&order=<?= $order ?><?= $statusOrder ?>"><i class="fa-solid fa-angle-right"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>
    </div>
    <!-- container end -->

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>