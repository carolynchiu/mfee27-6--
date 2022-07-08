<!doctype html>
<html lang="en">

<head>
  <title>Create-Admin</title>
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
      <h2>新增管理員帳號</h2>
      <form action="doCreate.php" method="post">
        <div class="mb-2">
          <label for="">姓名</label>
          <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-2">
          <label for="">帳號</label>
          <input type="text" class="form-control" name="account" required>
        </div>
        <div class="mb-2">
          <label for="">密碼</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <div class="mb-2">
          <label for="">再輸入一次密碼</label>
          <input type="password" class="form-control" name="repassword" required>
        </div>
        <div class="mb-2">
          <label for="">聯絡電話</label>
          <input type="tel" class="form-control" name="phone" required>
        </div>
        <div class="mb-2">
          <label for="">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" class="btn btn-info">送出</button>
      </form>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>