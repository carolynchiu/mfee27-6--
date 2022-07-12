<?php
session_start();
// if (!isset($_SESSION["user"])) {
//   header("location: login-2.php");
// }


if (!isset($_GET["recipe_id"])) {
  echo "沒有參數";
  exit;
}

$recipe_id = $_GET["recipe_id"];

require("../db-connect.php");


$sql = "SELECT recipe.*,users.name AS user_name FROM recipe 
JOIN users ON recipe.user_id=users.id 
WHERE recipe.id=$recipe_id";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>食譜明細</title>
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

    .object-cover {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <main class="main-content p-4">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
        <h1><i class="fa-solid fa-utensils me-3"></i></i>食譜明細-<?= $recipe_id ?></h1>
      </div>
      <?php foreach ($rows as $row) : ?>
        <div class="py-2 d-flex">
          <a class="btn btn-info me-3" href="recipe-all.php"><i class="fa-solid fa-circle-arrow-left me-2"></i>回到所有食譜</a>
          <a class="btn btn-info" href="recipe-edit.php?recipe_id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square me-2"></i>編輯食譜</a>
        </div>
        <div>
          <h2 class="display-3 text-center "><?= $row["title"] ?> </h2>
          <h5 class="text-center text-info mb-3">作者:<?= $row["user_name"] ?></h5>
          <div class="py-2 d-flex justify-content-center border-top">
            <figure class="mt-3">
              <img class="object-cover shadow rounded" style="width: 600px" src="../recipe/recipeimage/<?= $row["main_image"] ?>" alt="">
            </figure>
          </div>
          <div class="py-2 d-flex justify-content-center">
            <p class="w-50 text-center"> <?= $row["intro"] ?>
            </p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="py-2 d-flex justify-content-evenly bg-light w-50 shadow-sm">
              <div class="text-center text-secondary">
                <h4><i class="fa-solid fa-user me-2"></i>食譜份量</h4>
                <p><span class="text-primary"><?= $row["servings"] ?></span> 人份</p>
              </div>
              <div class="text-center text-secondary">
                <h4><i class="fa-solid fa-clock me-2"></i>烹飪時間</h4>
                <p> <span class="text-primary"><?= $row["cook_time"] ?></span> 分鐘</p>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center mt-5">
            <div class="py-2 d-flex justify-content-evenly bg-light w-50 shadow-sm">
              <div class="py-2 text-secondary">
                <h4 class="text-center"><i class="fa-solid fa-carrot me-2"></i>食材</h4>
                <p class="text-center"><?= $row["ingredient1"] ?></p>
                <p class="text-center"><?= $row["ingredient2"] ?></p>
                <p class="text-center"><?= $row["ingredient3"] ?></p>
                <p class="text-center"><?= $row["ingredient4"] ?></p>
                <p class="text-center"><?= $row["ingredient5"] ?></p>
              </div>
            </div>
          </div>


          <div class="d-flex justify-content-center mt-5">
            <div class="py-2  bg-light w-50 shadow-sm text-secondary">
              <h4 class="text-center py-2"><i class="fa-solid fa-shoe-prints me-2"></i>烹飪步驟</h4>
              <?php for ($i = 1; $i <= 5; $i++) : ?>
                <div class="py-2">
                  <?php if ($row["step_image$i"] !== "") : ?>
                    <div class="d-flex justify-content-center">
                      <figure class="mb-2 " style="width:400px">
                        <img class="object-cover shadow rounded" src="../recipe/recipeimage/<?= $row["step_image$i"] ?>" alt="">
                      </figure>
                    </div>
                  <?php endif; ?>
                  <div class="text-center py-3"><?= $row["step$i"] ?></div>
                </div>
              <?php endfor; ?>
            <?php endforeach; ?>
            </div>
          </div>


        </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>