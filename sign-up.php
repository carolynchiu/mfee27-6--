<!doctype html>
<html lang="en">

<head>
  <title>註冊管理員帳號</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <style>
    .panel {
      width: 500px;
    }
  </style>
</head>

<body>
  <div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="panel">
      <h1 class="text-center">註冊</h1>
      <form action="doSignUp.php" method="post">
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
          <label for="">電話</label>
          <input type="tel" class="form-control" name="phone" required>
        </div>
        <div class="mb-2">
          <label for="">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-info">送出</button>
          <a href="login.php" class="btn btn-info">取消</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>