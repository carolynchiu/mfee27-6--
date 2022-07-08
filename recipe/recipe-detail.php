<?php
// session_start();
// if (!isset($_SESSION["user"])) {
//   header("location: login-2.php");
// }


if(!isset($_GET["recipe_id"])){
    echo "沒有參數";
    exit;
}

$recipe_id=$_GET["recipe_id"];

require("../db-connect.php");


$sql ="SELECT recipe.*,users.name AS user_name FROM recipe 
JOIN users ON recipe.user_id=users.id 
WHERE recipe.id=$recipe_id";

$result=$conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);



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
    .object-cover{
            width: 100%;
            height: 100%;
            object-fit:cover;
        }
  </style>
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <main class="main-content p-4">
 
  <div class="container">
    <?php foreach($rows as $row):?>
      <div class="py-2 d-flex justify-content-between">
        <a class="btn btn-info" href="recipe-edit.php?recipe_id=<?=$row["id"]?>">修改資料</a>
        <a class="btn btn-info" href="recipe-all.php">回主頁面</a>
    </div>
          <h2><?=$row["title"]?></h2>
        <div class="py-2 justify-content-between">
            <h3><?=$row["user_name"]?></h3>
            <figure class="mb-2 ">
                <img class="object-cover" style="width: 600px" src="../recipe/recipeimage/<?=$row["main_image"]?>" alt="">
            </figure>
        </div>
        <div class="py-2 d-flex ">
            <div class="col-auto"><?=$row["servings"]?>人份</div>
            <div class="col-auto"><?=$row["cook_time"]?>分鐘</div>
        </div>
      

        <h3>食材</h3>
            <div class="py-2 ">
            <div class="col-auto"><?=$row["ingredient1"]?></div>
            <div class="col-auto"><?=$row["ingredient2"]?></div>
            <div class="col-auto"><?=$row["ingredient3"]?></div>
            <div class="col-auto"><?=$row["ingredient4"]?></div>
            <div class="col-auto"><?=$row["ingredient5"]?></div>
        </div>
        
        <?php for($i=1;$i<=5;$i++):?>
        <div class="py-2 d-flex">
            <?php if($row["step_image$i"]!==""):?>
            <div class="col-2">
              <figure class="mb-2 " style="width:200px">
                  <img class="object-cover" src="../recipe/recipeimage/<?=$row["step_image$i"]?>" alt="">
              </figure>
            </div>
            <?php endif;?>
            <div class="col-8"><?=$row["step$i"]?></div>
        </div>
        <?php  endfor; ?>
        <?php endforeach;?>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>