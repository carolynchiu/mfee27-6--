<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("location: login.php");
}

require("./db-connect.php");
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
  <link rel="stylesheet" href="./fontawesome-free-6.1.1-web/css/all.min.css" />

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
  <?php require("./module/header.php"); ?>
  <?php require("./module/aside.php"); ?>
  <main class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
      <h1>Dashboard</h1>
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-outline-primary">share</button>
        <button type="button" class="btn btn-outline-primary">export</button>
      </div>
    </div>
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-body bg-primary text-white">
            <div class="row d-flex justify-content-between align-items-center px-5 py-3">
              <div class="col-auto">
                <!-- <i class="fa fa-file-text fa-5x"></i> -->
                <i class="fa-solid fa-users fa-4x"></i>
              </div>
              <div class="col-auto">
                <?php
                $sqlUsers = "SELECT * FROM users WHERE valid=1";
                $resultUsers = $conn->query($sqlUsers);
                $usersCount = $resultUsers->num_rows; //所有的使用者
                ?>
                <div class="h2"><?= $usersCount ?></div>
                <div>使用者</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="card-footer text-primary py-3">
              <a href="http://localhost/mfee27-group6/user/users.php">
                <span class="pull-left ">查看詳情</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              </a>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-body bg-success text-white">
            <div class="row d-flex justify-content-between align-items-center px-5 py-3">
              <div class="col-auto">
                <!-- <i class="fa fa-comments fa-4x"></i> -->
                <i class="fa-solid fa-box-archive fa-4x"></i>
              </div>
              <div class="col-auto ">
                <div class="h2">0</div>
                <div>商品</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="card-footer text-success py-3">
              <span class="pull-left">查看詳情</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card ">
          <div class="card-body bg-warning text-white">
            <div class="row d-flex justify-content-between align-items-center px-5 py-3">
              <div class="col-auto">
                <!-- <i class="fa fa-user fa-5x"></i> -->
                <i class="fa-solid fa-file-lines fa-4x"></i>
              </div>
              <div class="col-auto ">
                <div class="h2">0</div>
                <div>訂單</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="card-footer text-warning py-3">
              <span class="pull-left">查看詳情</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-body bg-danger text-white">
            <div class="row d-flex justify-content-between align-items-center px-5 py-3">
              <div class="col-auto">
                <i class="fa-solid fa-utensils fa-4x"></i>
              </div>
              <div class="col-auto ">
                <div class="h2">0</div>
                <div>食譜</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="card-footer text-danger py-3">
              <span class="pull-left">查看詳情</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-body bg-info text-white">
            <div class="row d-flex justify-content-between align-items-center px-5 py-3">
              <div class="col-auto">
                <!-- <i class="fa fa-list fa-5x"></i> -->
                <i class="fa-solid fa-dumbbell fa-4x"></i>
              </div>
              <div class="col-auto ">
                <div class="h2">0</div>
                <div>課程</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="card-footer text-info py-3">
              <span class="pull-left">查看詳情</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-body bg-dark text-white">
            <div class="row d-flex justify-content-between align-items-center px-5 py-3">
              <div class="col-auto">
                <!-- <i class="fa fa-list fa-5x"></i> -->
                <i class="fa-solid fa-pen-to-square fa-4x"></i>
              </div>
              <div class="col-auto ">
                <div class="h2">0</div>
                <div>文章</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="card-footer text-dark py-3">
              <span class="pull-left">查看詳情</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>