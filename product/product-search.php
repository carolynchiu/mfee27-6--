<?php
session_start();
require("../db-connect.php");


$searchCategory=isset($_GET["search-category"])?$_GET["search-category"]:"";
$category=isset($_GET["category"])?$_GET["category"]:"";
$min=isset($_GET["min"])?$_GET["min"]:"";
$max=isset($_GET["max"])?$_GET["max"]:"";
$status=isset($_GET["status"])?$_GET["status"]:"";
$search=isset($_GET["search"])?$_GET["search"]:"";
if(($search) == ""){
  $getSearch="";
}else{
  $getSearch="LIKE '%$search%'";
}


//每頁產品
// sql product所有的欄位和 product_category的名子並生出category_name
// 使用join 將product.category_id和 category.id掛勾finished
$query="SELECT products.* , product_category.name AS category_name  FROM products  JOIN product_category ON products.category_id = product_category.id";
$conditions=array();


if(!empty($searchCategory)){
  if($searchCategory == "id"){
    $conditions[]="products.id";
  }else{
    $conditions[]="products.name";
  }
}
if(!empty($category)){
  switch($category){
    case 1:
      $conditions[]="products.category_id=1";
      break;
    case 2:
      $conditions[]="products.category_id=2";
      break;
    case 3:
      $conditions[]="products.category_id=3";
      break;

  }
}
if($status==1 || $status==0){
  $conditions[]="products.status != 2";
}
if(!empty($max)){
  $conditions[]="products.price <= $max";
}
if(!empty($min)){
  $conditions[]="products.price >= $min";
}
$sql="$query";

//設定如果有抓到頁數 則$page=該頁數
//若無則假設$page為1
  $page=isset($_GET["page"])? $_GET["page"] :1;
  $perPage=5; //每頁有5項產品
  $start=($page-1)*$perPage; //起始頁能顯示的產品數

  $order= isset($_GET["order"])? $_GET["order"] : 1; 

 switch($order){
   case 1:
     $orderType="id ASC";
     break;
   case 2:
     $orderType="id DESC";
     break;
   case 3:
     $orderType="status DESC , id ASC";
     break;
   case 4:
     $orderType="status ASC , id ASC";
     break;
     default:
     $orderType="ASC";
 }


if(count($conditions)>0){
  $sql .= " WHERE ".implode(' AND ',$conditions)." $getSearch  ORDER BY $orderType LIMIT $start, 5";
}else{
  $sql .="  ORDER BY $orderType LIMIT $start, 5";
}
$resultPage=$conn->query($sql);
$pageProductCount=$resultPage->num_rows;



$sqlAll="SELECT products.* , product_category.name AS category_name  FROM products  JOIN product_category ON products.category_id = product_category.id";
if(count($conditions)>0){
  $order= isset($_GET["order"])? $_GET["order"] : 1; 

switch($order){
  case 1:
    $orderType="id ASC";
    break;
  case 2:
    $orderType="id DESC";
    break;
  case 3:
    $orderType="status DESC , id ASC";
    break;
  case 4:
    $orderType="status ASC , id ASC";
    break;
    default:
    $orderType="ASC";
}
  $sqlAll .= " WHERE ".implode(' AND ',$conditions)." $getSearch  ORDER BY $orderType ";
}else{
  $sql .=" $getSearch  ORDER BY $orderType";
}


//選取所有產品
$resultAll= $conn->query($sqlAll);
//產品的總數
$productsCount=$resultAll->num_rows;

// //開始 
$startItem=($page-1)*$perPage+1;
// //結尾
$endItem=$page*$perPage;
// if($endItem>$userCount)$endItem=$userCount;
$totalPage=ceil($productsCount/$perPage);//無條件進位

//給商品種類篩選器的 finished
$sqlCategory="SELECT * FROM product_category";
$resultCategory=$conn->query($sqlCategory);
$rowsCategory=$resultCategory->fetch_all(MYSQLI_ASSOC);

if(isset($_GET["search"])){
  $search=$_GET["search"];
}else{
  $search="";
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>商品-" <?=$search?> "搜尋的結果</title>
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

    /* product-module */
    .object-cover {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .table{
      table-layout:fixed;
    }
    table.table th,td {
            vertical-align: middle;
            text-align: center;
        }
  </style>
</head>

<body>
  <?php require("../module/header.php"); ?>
  <?php require("../module/aside.php"); ?>
  <main class="main-content p-4">
  <div class="d-flex justify-content-between align-items-center border-bottom border-dark border-5 pb-2 mb-3">
      <h1><i class="fa-solid fa-magnifying-glass me-3"></i>商品搜尋結果</h1>
      <div>
          <a class="btn btn-info my-2" href="products-list.php"><i class="fa-solid fa-arrow-rotate-left me-3"></i>回產品清單頁面</a>
        </div>
    </div>
  <div class="container table-responsive">
    <div>
        <form action="product-search.php" method="get">
          <div class="py-2 d-flex justify-content-between align-items-center ">
            <ul class="nav nav-pills my-2">
              <li class="nav-item">
                <a class="nav-link   <?php if($category=="") echo "active"?>"  aria-current="page" href="product-search.php?category=&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&order=<?=$order?>">全部</a>
              </li>
              <?php foreach ($rowsCategory as $row):?>
              <li>
                <a class="nav-link category  <?php if($category==$row["id"]) echo "active"?> " href="product-search.php?category=<?=$row["id"]?>&page=<?=$page?>&order=<?=$order?>&search=<?=$search?>&min=<?=$min?>&max=<?=$max?>" id="category" name="category"  >
                <?php switch($row["name"]){
            case($row["name"]="服飾"):
              echo "<i class='fa-solid fa-shirt'></i>";
              break;
            case($row["name"]="器材"):
              echo "<i class='fa-solid fa-kitchen-set'></i></i>";
              break;
            case($row["name"]="食品"):
              echo "<i class='fa-solid fa-carrot'></i>";
              break;
          }?><?=$row["name"]?></a>
              </li>
              <?php endforeach;?>
            </ul>
            <div class="btn-group">
              <a href="product-search.php?category=<?=$category?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&order=1" class="btn btn-info <?php if($order==1) echo "active" ?>" name="order">商品編號<i class="fa-solid fa-arrow-down-short-wide"></i></a>
              <a href="product-search.php?category=<?=$category?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&order=2" class="btn btn-info <?php if($order==2) echo "active" ?>" name="order">商品編號<i class="fa-solid fa-arrow-down-wide-short"></i></a>
              <a href="product-search.php?category=<?=$category?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&order=3" class="btn btn-info <?php if($order==3) echo "active" ?>" name="order">上架<i class="fa-solid fa-arrow-down-short-wide"></i></a>
              <a href="product-search.php?category=<?=$category?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&order=4" class="btn btn-info <?php if($order==4) echo "active" ?>">下架 <i class="fa-solid fa-arrow-down-wide-short"></i></a>
            </div>
          </div>
          <?php require("price-filter.php") ?>
            <!-- 搜尋 -->
        <div class="input-group d-block">
          <div class="input-group-text">
            <div class="d-flex align-items-center">
              <label class="form-check-label" for="">依商品編號</label>
              <input class="form-check-input my-0 mx-2" type="radio" name="search-category"  value="id" <?php 
              if($searchCategory == "id"){
                echo "checked";
              }
            ?>
            >
            </div>
            <div class="d-flex align-items-center">
              <label class="form-check-label" for="">依商品名稱</label>
              <input class="form-check-input my-0 mx-2" type="radio" name="search-category" id="" value="name" <?php 
              if($searchCategory  == "name"){
                echo "checked";
              }
            ?>>
            </div>
            
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info mx-2"><i class="fa-solid fa-magnifying-glass me-3"></i>搜尋</button>
        </div>
        
      </form>
      <!-- 要改的 -->
    </div>
    <div class="py-2  ">
      <!-- 頁數切換 & 新增商品 -->
      <div class="py-2">
      <h3> " <?=$search?> " 的搜尋結果 :</h3>
        <?php switch($productsCount){
            case 0:
                echo "";
                break;
            case($startItem == $productsCount):
                echo "第 $productsCount 筆 ," ;
                break;
            case ($productsCount < $endItem):
                echo "第$startItem ~ $productsCount 筆 ,";
                break;
            case($productsCount >= $endItem ):
                echo "第 $startItem ~ $endItem 筆 ,";
                break;
            default;
        }?>
       共 <?=$productsCount?> 筆資料</div>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center <?php if($productsCount==0) echo "d-none";?>">
        <li class="page-item <?php if($page==1)echo "disabled";?>   ">
          <a class="page-link" href="product-search.php?<?=$category."&"?>
          search=<?=$search?>&page=<?=$page-1?>&min=<?=$min?>&max=<?=$max?>"><</a>
        </li>
        <?php for($i=1;$i<=$totalPage;$i++):?>
        <li class="page-item">
          <a class="page-link 
          <?php if($page==$i)echo "active"; ?>" href="product-search.php?<?=$category."&"?>search=<?=$search?>&page=<?=$i?>&min=<?=$min?>&max=<?=$max?>"><?=$i?></a>
        </li>
        <?php endfor;?>
        <li class="page-item <?php if($page==$totalPage) echo "disabled";?> ">
          <a class="page-link" href="product-search.php?<?=$category."&"?>search=<?=$search?>&page=<?=$page+1?>&min=<?=$min?>&max=<?=$max?>">></a>
        </li>
      </ul>
    </nav>
    <?php if($pageProductCount>0): ?>
        <table class="table table-bordered  table-hover mt-5">
          <thead>
            <tr class="table-info border-dark border-bottom border-3">
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
            <?php foreach($resultPage as $row):?>
            <tr>
              <td><?=$row["id"]?></td>
              <td>
                <figure>
                  <img class="object-cover" src="../product_image/<?=$row["image"]?>" alt="">
                </figure>
              </td>
              <td><?=$row["name"]?></td>
              <td class="text-truncate"><?=$row["description"]?></td>
              <td><?=$row["category_name"]?></td>
              <td><?=$row["price"]?></td>
              <td><?=$row["stock_in_inventory"]?></td>
              <td><?=$row["launch_time"]."<br>";?>~<?=$row["discontinue_time"]?></td>
              <td><?php 
              if($row["status"]==1){
                echo "上架";
              }else{
                echo "下架";
              }
              ?></td>
              <td class="text-center"><a class="btn btn-info " href="product.php?id=<?=$row["id"]?>">查看</a></td>
            </tr>
            <?php endforeach;?>
          </tbody>
          <?php else: ?>
            目前沒有資料
        <?php endif; ?>
        </table>
        <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center <?php if($productsCount==0) echo "d-none";?>">
        <li class="page-item <?php if($page==1)echo "disabled";?>   ">
          <a class="page-link" href="product-search.php?<?=$category."&"?>
          search=<?=$search?>&page=<?=$page-1?>&min=<?=$min?>&max=<?=$max?>"><</a>
        </li>
        <?php for($i=1;$i<=$totalPage;$i++):?>
        <li class="page-item">
          <a class="page-link 
          <?php if($page==$i)echo "active"; ?>" href="product-search.php?<?=$category."&"?>search=<?=$search?>&page=<?=$i?>&min=<?=$min?>&max=<?=$max?>"><?=$i?></a>
        </li>
        <?php endfor;?>
        <li class="page-item <?php if($page==$totalPage) echo "disabled";?> ">
          <a class="page-link" href="product-search.php?<?=$category."&"?>search=<?=$search?>&page=<?=$page+1?>&min=<?=$min?>&max=<?=$max?>">></a>
        </li>
      </ul>
    </nav>
      </div>
  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>