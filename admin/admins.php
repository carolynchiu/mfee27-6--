<?php
require("../db-connect.php");

if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}

$sqlAll = "SELECT * FROM admins WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$adminCount = $resultAll->num_rows; //所有的使用者

// $page = 3;
$perPage = 10;
$start = ($page - 1) * $perPage;

// $order = $_GET["order"];
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


// 沒有加 order by就是自然排序,變更資料容易影響自然排序 (最好加)
$sql = "SELECT * FROM admins WHERE valid=1 ORDER BY $orderType LIMIT $start, $perPage";
$result = $conn->query($sql);
$pageAdminCount = $result->num_rows; //每頁的使用者

//開始的筆數
$startItem = ($page - 1) * $perPage + 1;
$endItem = $page * $perPage;
if ($endItem > $adminCount) $endItem = $adminCount;

// $totalPage;
// $quotient = floor($adminCount / $perPage);
// $remainder = $adminCount % $perPage; //餘數
// if ($remainder === 0) {
//   $totalPage = $quotient;
// } else {
//   $totalPage = $quotient + 1;
// }

//無條件進位
$totalPage = ceil($adminCount / $perPage);

?>
<!doctype html>
<html lang="en">

<head>
  <title>Admins</title>
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
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <main class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
      <h1>所有管理員</h1>
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-outline-primary">share</button>
        <button type="button" class="btn btn-outline-primary">export</button>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-auto">
          <div class="py-2">
            <a href="create-admin.php" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i>新增管理員</a>
          </div>
        </div>
        <div class="col-auto">
          <div class="py-2 d-flex justify-content-end align-items-center">
            <div class="me-2">排序</div>
            <div class="btn-group">
              <a href="admins.php?page=<?= $page ?>&order=1" class="btn btn-primary
        <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
              <a href="admins.php?page=<?= $page ?>&order=2" class="btn btn-primary
        <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
              <a href="admins.php?page=<?= $page ?>&order=3" class="btn btn-primary
        <?php if ($order == 3) echo "active"; ?>">account <i class="fa-solid fa-arrow-down-short-wide"></i></a>
              <a href="admins.php?page=<?= $page ?>&order=4" class="btn btn-primary
        <?php if ($order == 4) echo "active"; ?>">account <i class="fa-solid fa-arrow-down-wide-short"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="py-2">
      第<?= $startItem ?>-<?= $endItem ?> 筆，共<?= $adminCount ?>筆資料
    </div>
    <?php if ($pageAdminCount > 0) : ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>編號</th>
            <th>帳號</th>
            <th>姓名</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          //把資料轉換成關聯式陣列 
          while ($row = $result->fetch_assoc()) : ?>
            <tr>
              <td><?= $row["id"] ?></td>
              <td><?= $row["account"] ?></td>
              <td><?= $row["name"] ?></td>
              <td class="text-center">
                <a href="" class="btn btn-warning">修改</a>
                <a href="" class="btn btn-danger">刪除</a>
              </td>
              <!-- 連結資料 -->
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else : ?>
      目前沒有資料
    <?php endif; ?>
    <div class="py-2">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->
          <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
            <li class="page-item
            <?php if ($page == $i) echo "active"; ?>
            "><a class="page-link" href="admins.php?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
          <?php endfor; ?>
          <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
        </ul>
      </nav>
    </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>