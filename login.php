<?php
session_start();
if (isset($_SESSION["admin"])) {
  header("location: homepage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>登入後台管理系統</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.0.2 -->
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <style>
    body {
      background: url("./images/login.jpg");
      background-size: cover;
    }

    .sign-up-panel {
      width: 280px;
    }

    .logo {
      height: 64px;
    }

    .input-top {
      border-radius: 0.375rem 0.375rem 0 0;
      border-bottom: 0;
    }

    .input-bt {
      border-radius: 0 0 0.375rem 0.375rem;
    }

    .form-floating>label {
      z-index: 2;
    }

    .form-control {
      position: relative;
    }

    .form-control:focus {
      z-index: 1;
    }
  </style>
</head>

<body>
  <div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="sign-up-panel">
      <?php if (isset($_SESSION["error"]) && $_SESSION["error"]["times"] > 5) : ?>
        <h2 class="text-danger">您已嘗試錯誤超過5次,請稍候再登入</h2>
      <?php else : ?>
        <form action="doLogin.php" method="post">
          <div class="text-center">
            <h1 class="mt-2">後台管理系統</h1>
          </div>
          <div class="form-floating mt-3">
            <input type="text" class="form-control input-top" id="floatingInput" placeholder="Your account" name="account" />
            <label for="floatingInput">帳號</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control input-bt" id="floatingPassword" placeholder="Password" name="password" />
            <label for="floatingPassword">密碼</label>
          </div>

          <div class="mt-3 mb-2 d-flex">
            <?php if (isset($_SESSION["error"])) : ?>
              <div class="text-danger"><?= $_SESSION["error"]["message"] ?></div>
            <?php endif; ?>
          </div>

          <div class="text-center">
            <button class="btn btn-warning" type="submit">登入</button>
            <a href="sign-up.php" class="btn btn-info">註冊</a>
          </div>
          <div class="pt-4 text-center text-muted">© 2020–2022</div>
        </form>
      <?php endif; ?>
    </div>
  </div>
  <!-- Bootstrap JavaScript Libraries -->
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>