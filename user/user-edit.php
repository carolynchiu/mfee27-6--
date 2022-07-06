<?php
if (!isset($_GET["id"])) {
  echo "沒有參數";
  exit;
}
$id = $_GET["id"];

require("../db-connect.php");
$sql = "SELECT * FROM users WHERE id=$id AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;

?>
<!doctype html>
<html lang="en">

<head>
  <title>User</title>
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
    <?php if ($userCount > 0) :
      $row = $result->fetch_assoc(); ?>
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <h1>會員 <?= $row["name"]
                ?></h1>
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-outline-primary">share</button>
          <button type="button" class="btn btn-outline-primary">export</button>
        </div>
      </div>
      <div class="container">
        <div class="py-2">
          <a class="btn btn-info" href="user.php?id=<?= $row["id"] ?>">取消</a>
        </div>
        <form action="doUpdate.php" method="post">
          <input type="hidden" name="id" value=" <?= $row["id"] ?>">
          <table class="table">
            <tr>
              <th>id</th>
              <td>
                <?= $row["id"] ?>
                <!-- <input class="form-control-plaintext" type="text" readonly value="" name="id"> -->
              </td>
              <!-- 不能讓使用者修改 -->
            </tr>
            <tr>
              <th>Account</th>
              <td><?= $row["account"] ?></td>
            </tr>
            <tr>
              <th>Name</th>
              <td><input type="text" class="form-control" value="<?= $row["name"] ?>" name="name"></td>
            </tr>
            <tr>
              <th>Phone</th>
              <td><input type="tel" class="form-control" value="<?= $row["phone"] ?>" name="phone"></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><input type="email" class="form-control" value="<?= $row["email"] ?>" name="email"></td>
            </tr>
          </table>
          <div class="py-2">
            <button class="btn btn-info" type="submit">儲存</button>
          </div>
        </form>
      <?php else : ?>
        沒有該使用者
      <?php endif; ?>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>


</html>