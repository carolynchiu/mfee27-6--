<?php
if (!isset($_GET["id"])) {
  echo "沒有參數";
  exit;
}
$id = $_GET["id"];

require("../db-connect.php");
$sql = "SELECT * FROM coupon WHERE id=$id AND valid=1";
$result = $conn->query($sql);
$couponCount = $result->num_rows;

?>
<!doctype html>
<html lang="en">

<head>
  <title>修改優惠券資料</title>
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
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <h1><i class="fa-solid fa-ticket me-3"></i></i>修改優惠券-<?= $row["id"]
                                                              ?></h1>

      </div>
      <div class="container">
        <div class="py-2">
          <a class="btn btn-info me-2" href="coupon-detail.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-circle-arrow-left me-2"></i>取消並返回</a>
        </div>
        <form action="doUpdate.php" method="post">
          <input type="hidden" name="id" value=" <?= $row["id"] ?>">
          <table class="table">
            <tr>
              <th>管理員編號</th>
              <td>
                <?= $row["id"] ?>
                <!-- <input class="form-control-plaintext" type="text" readonly value="" name="id"> -->
              </td>
              <!-- 不能讓使用者修改 -->
            </tr>
            <tr>
              <th>優惠券名稱</th>
              <td>
                <input type="text" class="form-control" value="<?= $row["name"] ?>" name="name">
              </td>
            </tr>
            <tr>
              <th>折扣金額</th>
              <td><input type="number" class="form-control" value="<?= $row["discount"] ?>" name="discount"></td>
            </tr>
            <tr>
              <th>起始時間</th>
              <td><input type="date" class="form-control" value="<?= $row["time_start"] ?>" name="time_start"></td>
            </tr>
            <tr>
              <th>結束時間</th>
              <td><input type="date" class="form-control" value="<?= $row["time_end"] ?>" name="time_end"></td>
            </tr>
          </table>
          <button class="btn btn-info" type="submit"><i class="fa-solid fa-circle-check me-2"></i>儲存</button>
        </form>
      <?php else : ?>
        沒有該使用者
      <?php endif; ?>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>


</html>