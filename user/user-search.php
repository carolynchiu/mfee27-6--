<?php
require("../db-connect.php");

if (!isset($_GET["search"])) {
  $search = '';
  $userCount = 0;
} else {
  $search = $_GET["search"]; //抓網址的值

  //完全符合
  // $sql = "SELECT id, account, name, email, phone FROM users WHERE account='$search'";

  //模糊搜尋 -> LIKE
  $sql = "SELECT id, account, name, email, phone FROM users WHERE account LIKE '%$search%'";

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
      <div class="py-2">
        <a href="users.php" class="btn btn-info">Users List</a>
      </div>
      <div class="py-2">
        <form action="user-search.php" method="get">
          <div class="input-group">
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info">搜尋</button>
          </div>
        </form>
      </div>
      <div class="py-2">
        <h2><?= $search ?>的搜尋結果</h2>
        <div class="py-2">
          共<?= $userCount ?>筆資料
        </div>
      </div>
      <?php if ($userCount > 0) : ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>id</th>
              <th>account</th>
              <th>name</th>
              <th>phone</th>
              <th>email</th>
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
                <td><?= $row["phone"] ?></td>
                <td><?= $row["email"] ?></td>
                <td><a href="user.php?id=<?= $row["id"] ?>" class="btn btn-info">Detail</a></td>
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