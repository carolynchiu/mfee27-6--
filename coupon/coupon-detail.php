<?php
session_start();

if (!isset($_GET["id"])) {
  echo "沒有參數";
  exit;
}
$id = $_GET["id"];

require("../db-connect.php");

//所有管理員
$sqlAll = "SELECT * FROM coupon";
$resultAll = $conn->query($sqlAll);
$allCount = $resultAll->num_rows; //所有管理員筆數

$sql = "SELECT * FROM coupon WHERE id=$id AND valid=1";
$result = $conn->query($sql);
$couponCount = $result->num_rows;


?>
<!doctype html>
<html lang="en">

<head>
  <title>優惠券詳細資料</title>
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
    <?php if ($couponCount > 0) :
      $row = $result->fetch_assoc(); ?>
      <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
        <h1><i class="fa-solid fa-ticket me-3"></i></i>優惠券 <?= $row["id"]
                                                            ?></h1>
        <div class="btn-group" role="group" aria-label="Basic example">
          <a href="coupon_detail.php?id=<?php
                                        if ($id - 1 <= 0) {
                                          echo 1;
                                        } else {
                                          echo $id - 1;
                                        }
                                        ?>" type="button" class="btn btn-info btn-outline-dark"><i class="fa-solid fa-circle-chevron-left me-2"></i>上一筆</a>
          <a href="coupon_detail.php?id=<?php
                                        if ($id + 1 > $allCount) {
                                          echo $id;
                                        } else {
                                          echo $id + 1;
                                        }
                                        ?>" type="button" class="btn btn-info btn-outline-dark">下一筆<i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
        </div>
      </div>
      <div class="container">
        <!-- 回到使用者列表頁 -->
        <div class="py-2 d-flex justify-content-between">
          <div>
            <a href="coupon.php" class="btn btn-info me-2"><i class="fa-solid fa-circle-arrow-left me-2"></i>回到所有優惠券</a>
            <a href="coupon-edit.php?id=<?= $row["id"] ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square me-2"></i>修改</a>
          </div>
          <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-circle-minus me-2"></i>刪除</a>
        </div>
        <table class="table table-hover">
          <tr>
            <th>優惠券編號</th>
            <td><?= $row["id"]
                ?></td>
          </tr>
          <tr>
            <th>優惠券名稱</th>
            <td><?= $row["name"]
                ?></td>
          </tr>
          <tr>
            <th>折扣金額</th>
            <td class="text-danger">$<?= $row["discount"]
                                      ?></td>
          </tr>
          <tr>
            <th>起始時間</th>
            <td><?= $row["time_start"]
                ?></td>
          </tr>
          <tr>
            <th>結束時間</th>
            <td><?= $row["time_end"]
                ?></td>
          </tr>
          <tr>
            <th>優惠券建立時間</th>
            <td><?= $row["create_time"]
                ?></td>
          </tr>
        </table>
      <?php else : ?>
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
          <h1><i class="fa-solid fa-user me-3"></i>管理員 <?= $id ?></h1>
          <div class="btn-group" role="group" aria-label="Basic example">
            <a href="coupon_detail.php?id=<?php
                                          if ($id - 1 <= 0) {
                                            echo 1;
                                          } else {
                                            echo $id - 1;
                                          }
                                          ?>" type="button" class="btn btn-info btn-outline-dark"><i class="fa-solid fa-circle-chevron-left me-2"></i>上一筆</a>
            <a href="coupon_detail.php?id=<?php
                                          if ($id + 1 > $allCount) {
                                            echo $id;
                                          } else {
                                            echo $id + 1;
                                          }
                                          ?>" type="button" class="btn btn-info btn-outline-dark">下一筆<i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
          </div>
        </div>
        <h3 class="text-danger">管理員資料已刪除</h3>
      <?php endif; ?>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>