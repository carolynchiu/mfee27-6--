<?php
require("../db-connect.php");
//設定如果有抓到頁數 則$page=該頁數
//若無則假設$page為第1頁
// if(isset($_GET["page"])){
//   $page=$_GET["page"];
//   echo "yes";
// }else{
//   echo "no";
//   $page=1;
// }

if (isset($_GET["category"])){
  $category = $_GET["category"];
  $sqlWhere="WHERE product.category_id=$category";
}else{
  $category="";
  $sqlWhere="";
}

$sql="SELECT products.* , product_category.name AS category_name  FROM products JOIN product_category ON products.category_id = product_category.id ";
// 想辦法把product.category_id=category.name
$result=$conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);

$sqlCategory="SELECT * FROM product_category";
$resultCategory=$conn->query($sqlCategory);
$rowsCategory=$resultCategory->fetch_all(MYSQLI_ASSOC);

 
$perPage=4; //每頁有4項產品
$start=($page-1)*$perPage;
$sqlPage="SELECT * FROM products  
LIMIT $start, 4";

$resultPage= $conn->query($sqlPage);
$pageUserCount=$resultPage->num_rows;

//開始 
$startItem=($page-1)*$perPage+1;
//結尾
$endItem=$page*$perPage;
if($endItem>$userCount)$endItem=$userCount;
$totalPage=ceil($userCount/$perPage);//無條件進位

?>
<!doctype html>
<html lang="en">

<head>
  <title>所有商品</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css" />
  <style>
    *{
      border:1px solid red;
    }
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

    /* product-module */
    .object-cover {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .table{
      table-layout:fixed;
    }
  </style>
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>

 <? if(isset($_GET["page"])){
  $page=$_GET["page"];
  echo "yes";
}else{
  echo "no";
  $page=1;
}
?>
  <main class="main-content p-4">
  <div class="container table-responsive">
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link  <?php if($category=="") echo "active"?>" aria-current="page" href="products-list.php">全部</a>
      </li>
      <?php foreach ($rowsCategory as $row):?>
      <li>
        <a class="nav-link <?php if($category==$row["id"]) echo "active"?> "  href="products-list.php?category=<?=$row["id"]?>"><?=$row["name"]?></a>
      </li>
      <?php endforeach;?>
    </ul>
    <div class="py-2 text-end">
      <a class="btn btn-info" href="product-add.php">新增商品</a>
    </div>
        <table class="table table-bordered  table-hover mt-5">
          <thead>
            <tr>
              <th>商品編號</th>
              <th>商品圖片</th>
              <th>商品名稱</th>
              <th>商品簡介</th>
              <th>商品類別</th>
              <th>商品價格</th>
              <th>商品庫存</th>
              <th>商品上下架時間</th>
              <th>商品上下架狀態</th>
              <th>查看商品資訊</th>
            </tr>
          </thead>
          <tbody >
            <?php foreach($rows as $row):?>
            <tr>
              <td><?=$row["id"]?></td>
              <td>
                <figure>
                  <img class="object-cover" src="../product_image/<?=$row["image"]?>" alt="">
                </figure>
              </td>
              <td><?=$row["name"]?></td>
              <td><?=$row["description"]?></td>
              <td><?=$row["category_name"]?></td>
              <td><?=$row["price"]?></td>
              <td><?=$row["stock_in_inventory"]?></td>
              <td><?=$row["launch_time"]."<br>";?>~<?=$row["discontinue_time"]?></td>
              <td><?php if($row["status"]==1){
                echo "上架";
              }else{
                echo "下架";
              }
              ?></td>
              <td class="text-center"><a class="btn btn-info " href="product.php?id=<?=$row["id"]?>">查看</a></td>
              
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <div class="py-2">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->
            <?php for($i=1;$i<=$totalPage;$i++): ?>
              <li class="page-item
              <?php
              if($page==$i)echo "active";
              ?>
              "><a class="page-link" href="users.php?page=<?=$i?>&order=<?=$order?>"><?=$i?></a></li>
            <?php endfor;?>
            <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
          </ul>
        </nav>
        </div>
      </div>
  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>