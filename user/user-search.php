<?php
session_start();
require("../db-connect.php");

if (!isset($_GET["search"])) {
  $search = '';
  $userCount = 0;
} else {
  $search = $_GET["search"]; //抓網址的值

  //完全符合
  // $sql = "SELECT id, account, name, email, phone FROM users WHERE account='$search'";

  //模糊搜尋 -> LIKE
  $sql = "SELECT * FROM users  WHERE account LIKE '%$search%'";

  $result = $conn->query($sql);
  $userCount = $result->num_rows;
}


?>
<!doctype html>
<html lang="en">

<head>
  <title>User search</title>
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
    <div class="container">
      <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
        <h1><i class="fa-solid fa-magnifying-glass me-2"></i> "<span class="mx-2 text-primary"><?= $search ?></span>"的搜尋結果</h1>
      </div>
      <div class="py-2">
        <a href="users.php" class="btn btn-info"><i class="fa-solid fa-circle-arrow-left me-2"></i>回到所有使用者</a>
      </div>
      <div class="py-2">
        <form action="user-search.php" method="get">
          <div class="input-group">
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info"><i class="fa-solid fa-magnifying-glass me-2"></i>搜尋</button>
          </div>
        </form>
      </div>
      <div class="py-2">
        <div class="py-2">
          共<?= $userCount ?>筆資料
        </div>
      </div>
      <?php if ($userCount > 0) : ?>
        <table class="table table-bordered">
          <thead>
            <tr class="table-info border-dark border-bottom border-3">
              <th>會員編號</th>
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
                <td class="text-center"><?php if ($row["gender"] == 0) {
                                          echo "<i class='fa-solid fa-mars text-info'></i>";
                                        } else {
                                          echo "<i class='fa-solid fa-venus text-danger'></i>";
                                        } ?></td>
                <td><?= $row["phone"] ?></td>
                <td><?= $row["email"] ?></td>
                <td class="text-center"><a href="user.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-2"></i>詳細資料</a></td>
                <!-- 連結資料 -->
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else : ?>
        沒有符合的結果
      <?php endif; ?>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>