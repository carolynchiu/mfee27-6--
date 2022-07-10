<?php
session_start();
require("../db-connect.php");

if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}

$sqlAll = "SELECT * FROM users WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$userCount = $resultAll->num_rows; //所有的使用者

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
$sql = "SELECT * FROM users WHERE valid=1 ORDER BY $orderType LIMIT $start, $perPage";
$result = $conn->query($sql);
$pageUserCount = $result->num_rows; //每頁的使用者

//開始的筆數
$startItem = ($page - 1) * $perPage + 1;
$endItem = $page * $perPage;
if ($endItem > $userCount) $endItem = $userCount;

// $totalPage;
// $quotient = floor($userCount / $perPage);
// $remainder = $userCount % $perPage; //餘數
// if ($remainder === 0) {
//   $totalPage = $quotient;
// } else {
//   $totalPage = $quotient + 1;
// }

//無條件進位
$totalPage = ceil($userCount / $perPage);

?>
<!doctype html>
<html lang="en">

<head>
  <title>Users</title>
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
    <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
      <h1><i class="fa-solid fa-users me-3"></i>所有會員</h1>
    </div>
    <div class="container">
      <div class="row justify-content-between mb-3">
        <div class="col-md-3">
          <div class="py-2">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <i class="fa-solid fa-user-plus me-2"></i>新增使用者
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">新增使用者帳號</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="container">
                      <form action="doCreate.php" method="post">
                        <div class="mb-2">
                          <label for="">姓名</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-2">
                          <label for="">帳號</label>
                          <input type="text" class="form-control" name="account">
                        </div>
                        <div class="mb-2">
                          <label for="">密碼</label>
                          <input type="password" class="form-control" name="password">
                        </div>
                        <div class="mb-2">
                          <label for="">再輸入一次密碼</label>
                          <input type="password" class="form-control" name="repassword">
                        </div>
                        <div class="mb-2">
                          <label for="">電話</label>
                          <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="mb-2">
                          <label for="">Email</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-2">
                          <div>
                            <label class="me-2" for="">性別</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="0">
                            <label class="form-check-label" for="inlineRadio1">男</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="1">
                            <label class="form-check-label" for="inlineRadio2">女</label>
                          </div>
                        </div>
                        <div class="mb-2">
                          <label for="">生日</label>
                          <input type="date" class="form-control" name="birthday">
                        </div>
                        <div class="mb-2">
                          <label for="">地址</label>
                          <input type="text" class="form-control" name="address">
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
        <div class="col-md-8 d-flex">
          <div class="py-2 col-md-5">
            <form action="user-search.php" method="get">
              <div class="input-group">
                <button type="submit" class="btn btn-info"><i class="fa-solid fa-magnifying-glass me-2"></i>搜尋</button>
                <input type="text" name="search" class="form-control">
              </div>
            </form>
          </div>
          <div class="py-2 d-flex justify-content-end align-items-center col-md-6">
            <div class="me-2">排序</div>
            <div class="btn-group">
              <a href="users.php?page=<?= $page ?>&order=1" class="btn btn-info
        <?php if ($order == 1) echo "active"; ?>"><i class="fa-solid fa-arrow-down-short-wide me-2"></i>編號</a>
              <a href="users.php?page=<?= $page ?>&order=2" class="btn btn-info
        <?php if ($order == 2) echo "active"; ?>"><i class="fa-solid fa-arrow-down-wide-short me-2"></i>編號</a>
              <a href="users.php?page=<?= $page ?>&order=3" class="btn btn-info
        <?php if ($order == 3) echo "active"; ?>"><i class="fa-solid fa-arrow-down-short-wide me-2"></i>帳號</a>
              <a href="users.php?page=<?= $page ?>&order=4" class="btn btn-info
        <?php if ($order == 4) echo "active"; ?>"><i class="fa-solid fa-arrow-down-wide-short me-2"></i>帳號</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top">
        <div class="py-2 col-md-2">
          第<?= $startItem ?>-<?= $endItem ?> 筆，共<?= $userCount ?>筆資料
        </div>
      </div>
      <div class="py-1">
        <?php $pageInt = settype($page, "integer") ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item"><a class="page-link" href="users.php?page=<?php
                                                                            if ($page - 1 <= 0) {
                                                                              echo 1;
                                                                            } else {
                                                                              echo $page - 1;
                                                                            } ?>&order=<?= $order ?>"><i class="fa-solid fa-angle-left"></i></a></li>
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
              <li class="page-item
            <?php if ($page == $i) echo "active"; ?>
            "><a class="page-link" href="users.php?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="users.php?page=<?php
                                                                            if ($page + 1 > $totalPage) {
                                                                              echo $totalPage;
                                                                            } else {
                                                                              echo $page + 1;
                                                                            } ?>&order=<?= $order ?>"><i class="fa-solid fa-angle-right"></i></a></li>
          </ul>
        </nav>
      </div>
      <?php if ($pageUserCount > 0) : ?>
        <table class="table table-bordered border-dark">
          <thead>
            <tr class="table-info border-dark border-bottom border-3">
              <th>編號</th>
              <th>帳號</th>
              <th>姓名</th>
              <th>性別</th>
              <th>電話</th>
              <th>Email</th>
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
                <td><?php if ($row["gender"] == 0) {
                      echo "<i class='fa-solid fa-mars text-info'></i>";
                    } else {
                      echo "<i class='fa-solid fa-venus text-danger'></i>";
                    } ?></td>
                <td><?= $row["phone"] ?></td>
                <td><?= $row["email"] ?></td>
                <td class="text-center">
                  <a href="user.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-2"></i>詳細資料</a>
                  <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square me-2"></i>修改</a>
                  <a href="" class="btn btn-sm btn-danger"><i class="fa-solid fa-circle-minus me-2"></i>刪除</a>
                </td>
                <!-- 連結資料 -->
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else : ?>
        目前沒有資料
      <?php endif; ?>
      <div class="py-1">
        <?php $pageInt = settype($page, "integer") ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="users.php?page=<?php
                                                                            if ($page - 1 <= 0) {
                                                                              echo 1;
                                                                            } else {
                                                                              echo $page - 1;
                                                                            } ?>&order=<?= $order ?>"><i class="fa-solid fa-angle-left"></i></a></li>
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
              <li class="page-item
            <?php if ($page == $i) echo "active"; ?>
            "><a class="page-link" href="users.php?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="users.php?page=<?php
                                                                            if ($page + 1 > $totalPage) {
                                                                              echo $totalPage;
                                                                            } else {
                                                                              echo $page + 1;
                                                                            } ?>&order=<?= $order ?>"><i class="fa-solid fa-angle-right"></i></a></li>
          </ul>
        </nav>
      </div>
    </div> <!-- container-end -->
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>