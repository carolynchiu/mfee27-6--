<?php
// session_start();
// if (!isset($_SESSION["user"])) {
//   header("location: login-2.php");
// }

require("../db-connect.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>dashboard</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.0.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
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
  <div class="container">
        <form action="do-create.php" method="post">
            <div class="mb-2">
                <label for="">食譜標題</label>
                <input class="form-control" type="text" name="title">
            </div>

            <input type="hidden" name="user_id" value="1">   
            
            <div class="mb-2">
              <label for="formFile" class="form-label">主要圖片</label>
              <input class="form-control" type="file" id="formFile" name="main_image">
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <div class="col-5">
                <label for="">份量</label>
                <input class="form-control" type="number" name="servings" spaceholder="人份">
                </div>
                <div class="col-5">
                <label for="">時間</label>
                <input class="form-control" type="text" name="cook_time" spaceholder="分鐘">
                </div>  
            </div>

            <div class="py-2">
            <label for="">食材</label></br>
            <input class="form-control" type="text" name="ingredient1">
            <input class="form-control" type="text" name="ingredient2">
            <input class="form-control" type="text" name="ingredient3">
            <input class="form-control" type="text" name="ingredient4">
            <input class="form-control" type="text" name="ingredient5">

            </div>

            <div class="py-2 ">
            <label for="">步驟與圖片</label>
              <div class="py-3 d-flex">
              <div class="col-3"><input class="form-control" type="file" id="formFile" name="step_image1"></div>
              <div class="col-9"><textarea class="form-control"name="step1" ></textarea></div>
              </div>
              <div class="py-3 d-flex">
              <div class="col-3"><input class="form-control" type="file" id="formFile" name="step_image2"></div>
              <div class="col-9"><textarea class="form-control" name="step2"></textarea></div>
              </div>
              <div class="py-3 d-flex">
              <div class="col-3"><input class="form-control" type="file" id="formFile" name="step_image3"></div>
              <div class="col-9"><textarea class="form-control" name="step3" ></textarea></div>
              </div>
              <div class="py-3 d-flex">
              <div class="col-3"><input class="form-control" type="file" id="formFile" name="step_image4"></div>
              <div class="col-9"><textarea class="form-control" name="step4"></textarea></div>
              </div>
              <div class="py-3 d-flex">
              <div class="col-3"><input class="form-control" type="file" id="formFile" name="step_image5"></div>
              <div class="col-9"><textarea class="form-control" name="step5" ></textarea></div>
              </div>
            </div>
            
                      
            
            <button class="btn btn-info" type="submit">送出</button>
        </form>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>