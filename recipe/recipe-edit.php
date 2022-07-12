<?php
// session_start();
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



// for($i=0;$i<count($rows);$i++){
//   $recipe=$rows[$i]["id"];
//   $sqlLikeCount="SELECT * FROM user_like_recipe WHERE id= $recipe_id";
//   $resultLike=$conn->query($sqlLikeCount);
//   $like_count=$resultLike->num_rows;
// echo $rows[$i]["id"].":". $like_count."<br>";
// $rows[$i]["liked-count"]=$like_count;
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>編輯食譜</title>
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
        <h1><i class="fa-solid fa-utensils me-3"></i></i>編輯食譜-<?= $recipe_id ?></h1>
      </div>
      <?php foreach ($rows as $row) : ?>
        <form action="do-edit.php" method="post">
          <input type="hidden" name="id" value="<?= $row["id"] ?>">
          <div>
            <label for="">食譜標題</label>
            <input type="text" class="form-control" name="title" value="<?= $row["title"] ?>">
          </div>
          <div class="py-2 justify-content-between">
            <h3><?= $row["user_name"] ?></h3>
            <figure class="mb-2 ">
              <img class="object-cover" style="width: 600px" src="../recipe/recipeimage/<?= $row["main_image"] ?>" alt="">
              <input class="form-control" type="file" id="formFile" name="main_image" value="<?= $row["main_image"] ?>">
              <input type="hidden" value="<?= $row["main_image"] ?>" name="main_image_original">
            </figure>
          </div>
          <div class="py-2">
            <textarea class="form-control" name="intro"><?= $row["intro"] ?></textarea>
          </div>
          <div class="py-2 d-flex ">
            <div class="col-auto"><input type="text" class="form-control" name="servings" value="<?= $row["servings"] ?>">人份</div>
            <div class="col-auto"><input type="text" class="form-control" name="cook_time" value="<?= $row["cook_time"] ?>">分鐘</div>
          </div>


          <h3>食材</h3>
          <div class="py-2 ">
            <div class="col-auto"><input type="text" class="form-control" name="ingredient1" value="<?= $row["ingredient1"] ?>"></div>
            <div class="col-auto"><input type="text" class="form-control" name="ingredient2" value="<?= $row["ingredient2"] ?>"></div>
            <div class="col-auto"><input type="text" class="form-control" name="ingredient3" value="<?= $row["ingredient3"] ?>"></div>
            <div class="col-auto"><input type="text" class="form-control" name="ingredient4" value="<?= $row["ingredient4"] ?>"></div>
            <div class="col-auto"><input type="text" class="form-control" name="ingredient5" value="<?= $row["ingredient5"] ?>"></div>
          </div>
          <div class="py-2 d-flex">
            <div class="col-2">
              <figure class="mb-2 " style="width:200px">
                <img class="object-cover" src="../recipe/recipeimage/<?= $row["step_image1"] ?>" alt="">
                <input class="form-control" type="file" id="formFile" name="step_image1">
                <input type="hidden" value="<?= $row["step_image1"] ?>" name="step_image1_original">
              </figure>
            </div>
            <div class="col-8"><textarea class="form-control" style="height:150px" name="step1"><?= $row["step1"] ?></textarea></div>
          </div>
          <div class="py-2 d-flex">
            <div class="col-2">
              <figure class="mb-2 " style="width:200px">
                <img class="object-cover" src="../recipe/recipeimage/<?= $row["step_image2"] ?>" alt="">
                <input class="form-control" type="file" id="formFile" name="step_image2">
                <input type="hidden" value="<?= $row["step_image2"] ?>" name="step_image2_original">
              </figure>
            </div>
            <div class="col-8"><textarea class="form-control" style="height:150px" name="step2"><?= $row["step2"] ?></textarea></div>
          </div>
          <div class="py-2 d-flex">
            <div class="col-2">
              <figure class="mb-2 " style="width:200px">
                <img class="object-cover" src="../recipe/recipeimage/<?= $row["step_image3"] ?>" alt="">
                <input class="form-control" type="file" id="formFile" name="step_image3">
                <input type="hidden" value="<?= $row["step_image3"] ?>" name="step_image3_original">
              </figure>
            </div>
            <div class="col-8"><textarea class="form-control" style="height:150px" name="step3"><?= $row["step3"] ?></textarea></div>
          </div>
          <div class="py-2 d-flex">
            <div class="col-2">
              <figure class="mb-2 " style="width:200px">
                <img class="object-cover" src="../recipe/recipeimage/<?= $row["step_image4"] ?>" alt="">
                <input class="form-control" type="file" id="formFile" name="step_image4">
                <input type="hidden" value="<?= $row["step_image4"] ?>" name="step_image4_original">
              </figure>
            </div>
            <div class="col-8"><textarea class="form-control" style="height:150px" name="step4"><?= $row["step4"] ?></textarea></div>
          </div>
          <div class="py-2 d-flex">
            <div class="col-2">
              <figure class="mb-2 " style="width:200px">
                <img class="object-cover" src="../recipe/recipeimage/<?= $row["step_image5"] ?>" alt="">
                <input class="form-control" type="file" id="formFile" name="step_image5">
                <input type="hidden" value="<?= $row["step_image5"] ?>" name="step_image5_original">
              </figure>
            </div>
            <div class="col-8"><textarea class="form-control" style="height:150px" name="step5"><?= $row["step5"] ?></textarea></div>
          </div>
          <button class="btn btn-info" type="submit">儲存</button>
          <a class="btn btn-info" href="recipe-detail.php?recipe_id=<?= $row["id"] ?>">取消</a>
        </form>
      <?php endforeach; ?>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>