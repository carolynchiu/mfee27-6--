<?php
session_start();
// if (!isset($_SESSION["user"])) {
//   header("location: ../login.php");
// }

require("../db-connect.php");

// 分頁
if(isset($_GET["page"])){
  $page=$_GET["page"];
}else{
  $page=1;
}

$sqlAll="SELECT recipe.*, users.name AS user_name FROM recipe 
JOIN users ON recipe.user_id=users.id  WHERE recipe.valid=1";
// 撈出的資料會是物件，須把它存在result當中
$resultAll=$conn->query($sqlAll);
// numrows代表回傳的資料筆數
$recipe_count=$resultAll->num_rows;


$perPage=6;
$start=($page-1)*$perPage;




$sql ="SELECT recipe.*, users.name AS user_name FROM recipe 
    JOIN users ON recipe.user_id=users.id  WHERE recipe.valid=1 ORDER BY create_time DESC LIMIT $start, 6 ";

$result=$conn->query($sql);
$page_recipe_count=$result->num_rows;
$rows=$result->fetch_all(MYSQLI_ASSOC);


$startItem=($page-1)*$perPage+1;
$endItem=($page)*$perPage;
if($endItem>$recipe_count)$endItem=$recipe_count;

$totalpage=ceil($recipe_count/$perPage);



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>食譜列表</title>
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
  <div class="py-2">
      <a href="recipe-create.php"class="btn btn-info">新增食譜</a>
  </div>
  <div class="py-2">
        <form action="recipe-search.php" method="get">
          <div class="input-group">
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info">搜尋</button>
          </div>
          </form>
        </div>
  <div class="py-2">第 <?=$startItem?>-<?=$endItem?> 筆, 共 <?=$recipe_count?> 筆資料</div>
  <div class="row gy-4">
    <?php foreach($rows as $row):?>
        <div class="col-md-4">
            <figure class="ratio ratio-4x3 mb-2">
                <img class="object-cover" src="./recipeimage/<?=$row["main_image"]?>" alt="">
            </figure>
            <h2 class="mb-2"><?=$row["title"]?></h2>
            <div class="text-start"><?=$row["user_name"]?></div>
            <div class="py-2 d-grid">
                <a class="btn btn-info" href="recipe-detail.php?recipe_id=<?=$row["id"]?>">查看食譜</a>
            </div>
            <div class="py-2 d-grid">
                <a class="btn btn-danger" href="do-delete.php?recipe_id=<?=$row["id"]?>">刪除食譜</a>
            </div>
        </div>
    <?php endforeach;?>
</div>
      <div class="py-2">
        <ul class="pagination">
          <?php for($i=1; $i<=$totalpage; $i++): ?>
          <!-- 停留頁面的ui反白 -->
          <li class="page-item
          <?php 
          if($page==$i) echo"active";
          ?>
          
          "><a class="page-link" href="recipe-all.php?page=<?=$i?>"><?=$i?></a></li>
          <?php endfor; ?>
        </ul>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>