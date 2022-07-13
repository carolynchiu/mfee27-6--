<?php
session_start();
if (!isset($_GET["id"])) {
  echo "沒有參數";
  exit;
}
$id = $_GET["id"];

require("../db-connect.php");

//所有會員
$sqlAll = "SELECT * FROM users";
$resultAll = $conn->query($sqlAll);
$allCount = $resultAll->num_rows; //所有會員筆數

$sql = "SELECT * FROM users WHERE id=$id AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;

// $sqlOrder = "SELECT * FROM order_list WHERE user_id=$id ";
// $resultOrder = $conn->query($sqlOrder);
// $orderCount = $resultOrder->num_rows;

//使用者訂單記錄
$sqlOrder = "SELECT order_list.*, users.account AS user_account, order_status.name AS user_order_status FROM order_list 
JOIN users ON order_list.user_id = users.id 
JOIN order_status ON order_list.status_id =order_status.id
WHERE order_list.user_id=$id";
$resultOrder = $conn->query($sqlOrder);
$orderCount = $resultOrder->num_rows;

//產品收藏
$sqlProduct = "SELECT user_like_product.*, users.account AS user_account, products.name AS product_name, products.image AS product_image, products.price AS product_price FROM user_like_product 
JOIN users ON user_like_product.user_id = users.id 
JOIN products ON user_like_product.product_id =products.id
WHERE user_like_product.user_id=$id";
$resultProduct = $conn->query($sqlProduct);
$productCount = $resultProduct->num_rows;

//食譜收藏
$sqlRecipe = "SELECT user_like_recipe.*, users.account AS user_account, recipe.title AS recipe_name, recipe.main_image AS recipe_image, recipe.intro AS recipe_content FROM user_like_recipe 
JOIN users ON user_like_recipe.user_id = users.id 
JOIN recipe ON user_like_recipe.recipe_id =recipe.id
WHERE user_like_recipe.user_id=$id";
$resultRecipe = $conn->query($sqlRecipe);
$recipeCount = $resultRecipe->num_rows;

//課程收藏
$sqlCourse = "SELECT user_like_course.*, users.account AS user_account, course.name AS course_name, course_content.image AS course_image, course_content.description AS course_description FROM user_like_course
JOIN users ON user_like_course.user_id = users.id
JOIN course ON user_like_course.id = course.id
JOIN course_content ON user_like_course.id = course_content.id
WHERE user_like_course.user_id=$id
 ";
$resultCourse = $conn->query($sqlCourse);
$courseCount = $resultCourse->num_rows;

// 文章收藏
$sqlArticle = "SELECT user_like_article.*, users.account AS user_account, article.article_title AS article_title, article.text AS article_text  FROM user_like_article 
JOIN users ON user_like_article.user_id = users.id 
JOIN article ON user_like_article.article_id =article.id
WHERE user_like_article.user_id=$id";
$resultArticle = $conn->query($sqlArticle);
$articleCount = $resultArticle->num_rows;

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
      <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
        <h1><i class="fa-solid fa-user me-3"></i>會員 <?= $id ?></h1>
        <div class="btn-group" role="group" aria-label="Basic example">
          <a href="user.php?id=<?php
                                if ($id - 1 <= 0) {
                                  echo 1;
                                } else {
                                  echo $id - 1;
                                }
                                ?>" type="button" class="btn btn-info btn-outline-dark"><i class="fa-solid fa-circle-chevron-left me-2"></i>上一筆</a>
          <a href="user.php?id=<?php
                                if ($id + 1 > $allCount) {
                                  echo $id;
                                } else {
                                  echo $id + 1;
                                }
                                ?>" type="button" class="btn btn-info btn-outline-dark">下一筆<i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
        </div>
      </div>
      <div class="container">
        <!-- 回到使用者列表頁 -->
        <div class="py-2 d-flex justify-content-between mb-3">
          <div>
            <a href="users.php" class="btn btn-info me-2"><i class="fa-solid fa-circle-arrow-left me-2"></i>回到所有使用者</a>
            <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-info"><i class="fa-solid fa-user-pen me-2"></i>修改</a>
          </div>
          <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-circle-minus me-2"></i>刪除</a>
        </div>
        <table class="table table-hover">
          <tr>
            <th>會員編號</th>
            <td><?= $row["id"]
                ?></td>
          </tr>
          <tr>
            <th>帳號</th>
            <td><?= $row["account"]
                ?></td>
          </tr>
          <tr>
            <th>姓名</th>
            <td><?= $row["name"]
                ?></td>
          </tr>
          <tr>
            <th>生日</th>
            <td><?= $row["birthday"]
                ?></td>
          </tr>
          <tr>
            <th>性別</th>
            <td><?php if ($row["gender"] == 0) {
                  echo "<i class='fa-solid fa-mars text-info'></i>";
                } else {
                  echo "<i class='fa-solid fa-venus text-danger'></i>";
                } ?></td>
          </tr>
          <tr>
            <th>電話</th>
            <td><?= $row["phone"]
                ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?= $row["email"]
                ?></td>
          </tr>
          <tr>
            <th>住址</th>
            <td><?= $row["address"]
                ?></td>
          </tr>
          <tr>
            <th>Create Time</th>
            <td><?= $row["create_time"]
                ?></td>
          </tr>
        </table>
      <?php else : ?>
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
          <h1><i class="fa-solid fa-user me-3"></i>會員 <?= $id ?></h1>
          <div class="btn-group" role="group" aria-label="Basic example">
            <a href="user.php?id=<?php
                                  if ($id - 1 <= 0) {
                                    echo 1;
                                  } else {
                                    echo $id - 1;
                                  }
                                  ?>" type="button" class="btn btn-info btn-outline-dark"><i class="fa-solid fa-circle-chevron-left me-2"></i>上一筆</a>
            <a href="user.php?id=<?php
                                  if ($id + 1 > $allCount) {
                                    echo $id;
                                  } else {
                                    echo $id + 1;
                                  }
                                  ?>" type="button" class="btn btn-info btn-outline-dark">下一筆<i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
          </div>
        </div>
        <h3 class="text-danger">會員資料已刪除</h3>
      <?php endif; ?>
      <div class="mt-5">
        <nav>
          <div class="nav nav-tabs justify-content-center border-dark h5" id="nav-tab" role="tablist">
            <button class="nav-link active border-dark border-bottom-0 border border-2" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-order" type="button" role="tab" aria-controls="nav-order" aria-selected="true"><i class="fa-solid fa-file-lines me-2"></i>訂單紀錄</button>
            <button class="nav-link border-dark border-bottom-0 border border-2" id="nav-product-tab" data-bs-toggle="tab" data-bs-target="#nav-product" type="button" role="tab" aria-controls="nav-product" aria-selected="false"><i class="fa-solid fa-box-archive me-2"></i>商品收藏</button>
            <button class="nav-link border-dark border-bottom-0 border border-2" id="nav-recipe-tab" data-bs-toggle="tab" data-bs-target="#nav-recipe" type="button" role="tab" aria-controls="nav-recipe" aria-selected="false"><i class="fa-solid fa-utensils me-2"></i>食譜收藏</button>
            <button class="nav-link border-dark border-bottom-0 border border-2" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="false"><i class="fa-solid fa-dumbbell me-2"></i>課程收藏</button>
            <button class="nav-link border-dark border-bottom-0 border border-2" id="nav-article-tab" data-bs-toggle="tab" data-bs-target="#nav-article" type="button" role="tab" aria-controls="nav-article" aria-selected="false"><i class="fa-solid fa-newspaper me-2"></i>文章收藏</button>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <!-- 訂單記錄 -->
          <div class="tab-pane fade show active" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
            <?php if ($orderCount > 0) :
              $rowsOrder = $resultOrder->fetch_all(MYSQLI_ASSOC);
            ?>
              <table class="table table-bordered border-dark mt-3">
                <thead>
                  <tr class="table-info border-dark">
                    <th>訂單編號</th>
                    <th>會員編號</th>
                    <th>使用者帳號</th>
                    <th>訂購日期</th>
                    <th>訂單狀態</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rowsOrder as $row) : ?>
                    <tr>
                      <td><?= $row["id"] ?></td>
                      <td><?= $row["user_id"] ?></td>
                      <td><?= $row["user_account"] ?></td>
                      <td><?= $row["create_time"] ?></td>
                      <td><?= $row["user_order_status"] ?></td>
                      <td class="text-center">
                        <a href="http://localhost/mfee27-group6/order/order-detail.php?id=<?= $row['id'] ?>" class="btn btn-outline-info">訂單明細</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else : ?>
              沒有訂單記錄
            <?php endif; ?>
          </div>
          <!-- 食譜收藏 -->
          <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
            <?php if ($productCount > 0) :
              $rowsProduct = $resultProduct->fetch_all(MYSQLI_ASSOC);
            ?>
              <div class="row gy-4 mt-3">
                <?php foreach ($rowsProduct as $row) : ?>
                  <div class="col-md-3 me-3 border border-dark">
                    <div>
                      <figure class="ratio ratio-4x3 my-2 border border-secondary shadow-sm">
                        <img class="object-cover" src="../product_image/<?= $row["product_image"] ?>" alt="">
                      </figure>
                      <!-- 可以先把資料寫死再處理資料庫的資料 -->
                      <h1><?= $row["product_id"] ?></h1>
                      <h2 class="mb-2 h4"><?= $row["product_name"] ?></h2>
                      <div class="text-end text-danger">$<?= $row["product_price"] ?></div>
                      <div class="text-center"><a href="http://localhost/mfee27-group6/product/product.php?id=<?= $row['id'] ?>" class="btn btn-outline-info">查看商品</a></div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              沒有收藏商品
            <?php endif; ?>
          </div>
          <div class="tab-pane fade" id="nav-recipe" role="tabpanel" aria-labelledby="nav-recipe-tab">
            <?php if ($recipeCount > 0) :
              $rowsRecipe = $resultRecipe->fetch_all(MYSQLI_ASSOC);
            ?>
              <div class="row gy-4 mt-3">
                <?php foreach ($rowsRecipe as $row) : ?>
                  <div class="col-md-3">
                    <div class="card border border-dark" style="width: 18rem;">
                      <figure class="ratio ratio-4x3 mb-2">
                        <img src="../recipe/recipeimage/<?= $row["recipe_image"] ?>" class="card-img-top" alt="...">
                      </figure>
                      <div class="card-body">
                        <h5 class="card-title"><?= $row["recipe_name"] ?></h5>
                        <p class="card-text"><?= $row["recipe_content"] ?></p>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              沒有食譜收藏
            <?php endif; ?>
          </div>
          <!-- 課程收藏 -->
          <div class="tab-pane fade" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab">
            <?php if ($courseCount > 0) :
              $rowsCourse = $resultCourse->fetch_all(MYSQLI_ASSOC);
            ?>
              <div class="row gy-4 mt-3">
                <?php foreach ($rowsCourse as $row) : ?>
                  <div class="col-md-3">
                    <div class="card" style="width: 18rem;">
                      <img src="../course/upload/<?= $row["course_image"] ?>" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title"><?= $row["course_name"] ?></h5>
                        <p class="card-text"><?= $row["course_description"] ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              沒有課程收藏
            <?php endif; ?>
          </div>
          <div class="tab-pane fade" id="nav-article" role="tabpanel" aria-labelledby="nav-article-tab">
            <?php if ($articleCount > 0) :
              $rowsArticle = $resultArticle->fetch_all(MYSQLI_ASSOC);
            ?>
              <div class="row gy-4 mt-3">
                <?php foreach ($rowsArticle as $row) : ?>
                  <div class="col-md-3">
                    <div class="card">
                      <h5 class="card-header">文章-<?= $row["article_id"] ?></h5>
                      <div class="card-body">
                        <h5 class="card-title"><?= $row["article_title"] ?></h5>
                        <p class="card-text"><?= $row["article_text"] ?></p>
                        <a href="#" class="btn btn-primary">查看文章</a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              沒有課程收藏
            <?php endif; ?>
          </div>
        </div>
      </div>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>