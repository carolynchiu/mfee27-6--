<?php
require("../db-connect.php");

if(!isset($_GET["search"])){
    $search="";
    $reicipe_count=0;
}else{
    

$search=$_GET["search"];

// 模糊比對：
$sql="SELECT * , users.name AS user_name  FROM recipe JOIN users ON recipe.user_id=users.id WHERE title LIKE'%$search%' AND recipe.valid=1";

$result=$conn->query($sql);
$recipe_Count=$result->num_rows;
$rows=$result->fetch_all(MYSQLI_ASSOC);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>搜尋食譜</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css" />

  </head>
  <body>
      <div class="container">
        <div class="py-2">
        <a class="btn btn-info" href="recipe-all.php"><i class="fa-solid fa-circle-arrow-left me-2"></i>回所有食譜</a>
        </div>

        <div class="py-2">
        <form action="recipe-search.php" method="get">
          <div class="input-group">
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info"><i class="fa-solid fa-magnifying-glass me-3"></i>搜尋</button>
          </div>
          </form>
        </div>

        <div class="py-2">
            <h2><?=$search?> 的搜尋結果</h2>
            <div class="py-2">共 <?=$recipe_Count?> 筆資料</div>
        </div>

        <?php if($recipe_Count>0):?>
            <div class="row gy-4">
                <?php foreach($rows as $row):?>
                    <div class="col-md-4">
                        <figure class="ratio ratio-4x3 mb-2">
                            <img class="object-cover" src="./recipeimage/<?=$row["main_image"]?>" alt="">
                        </figure>
                        <h2 class="mb-2"><?=$row["title"]?></h2>
                        <div class="text-start"><?=$row["user_name"]?></div>
                        <div class="py-2 d-grid">
                            <a class="btn btn-info" href="recipe-detail.php?recipe_id=<?=$row["id"]?>"><i class="fa-solid fa-carrot me-2"></i>查看食譜</a>
                        </div>
                        <div class="py-2 d-grid">
                            <a class="btn btn-danger" href="do-delete.php?recipe_id=<?=$row["id"]?>"><i class="fa-solid fa-xmark me-2"></i> 刪除食譜</a>
                        </div>

                    </div>
                <?php endforeach;?>
            </div>
        <?php else:?>
        沒有符合的結果
        <?php endif?>
  </body>
</html>