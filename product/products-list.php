<?php
//待處理
//價錢篩選器
//時間篩選器
//3.排序
//要排序的項目:上下架



require("../db-connect.php");
//設定如果有抓到頁數 則$page=該頁數
//若無則假設$page為1
if(isset($_GET["page"])){
  $page=$_GET["page"];
}else{
  $page=1;
}

if (isset($_GET["category"])){
  $category = $_GET["category"];
  $sqlWhere="WHERE products.category_id=$category";
}else{
  $category="";
  $sqlWhere="";
}


//sql product所有的欄位和 product_category的名子並生出category_name
//使用join 將product.category_id和 category.id掛勾finished
$sqlAll="SELECT products.* , product_category.name AS category_name  FROM products JOIN product_category ON products.category_id = product_category.id $sqlWhere";
 //選取所有產品
$resultAll= $conn->query($sqlAll);
//產品的總數
$productsCount=$resultAll->num_rows;


$perPage=5; //每頁有5項產品
$start=($page-1)*$perPage; //起始頁能顯示的產品數
//每頁產品
$sqlPage="SELECT products.* , product_category.name AS category_name  FROM products JOIN product_category ON products.category_id = product_category.id $sqlWhere LIMIT $start, 5 ";
$resultPage=$conn->query($sqlPage);
$pageProductCount=$resultPage->num_rows;

// //開始 
$startItem=($page-1)*$perPage+1;
// //結尾
$endItem=$page*$perPage;
// if($endItem>$userCount)$endItem=$userCount;
$totalPage=ceil($productsCount/$perPage);//無條件進位

//給篩選器的finished
$sqlCategory="SELECT * FROM product_category";
$resultCategory=$conn->query($sqlCategory);
$rowsCategory=$resultCategory->fetch_all(MYSQLI_ASSOC);

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
  <?php //require("../module/header.php"); ?>
  <?php //require("../module/aside.php"); ?>
  <main class="main-content p-4">
  <div class="container table-responsive">
    <div>
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
      <form action="product-search.php" method="get">
        <div class="input-group">
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info">搜尋</button>
        </div>
      </form>
    </div>
      
      
    
    <div class="py-2 d-flex justify-content-between align-items-center ">
      <!-- 頁數切換 & 新增商品 -->
      <?php switch($productsCount){
            case 0:
                echo "";
                break;
            case 1:
                echo "第1筆 ,";
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
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item <?php if($page==1)echo "disabled";?>   ">
          <a class="page-link" href="products-list.php?category=<?=$category?>&page=<?=$page-1?>"><</a>
        </li>
        <?php for($i=1;$i<=$totalPage;$i++):?>
        <li class="page-item">
          <a class="page-link 
          <?php if($page==$i)echo "active"; ?>" href="
          <?php if(isset($_GET["category"])){
            echo "products-list.php?category=<?=$category?>&page=<?=$i?>";
          }else{
            echo "products-list.php?page=$i";
          }
          ?>
          ">
          <?=$i?></a>
        </li>
        <?php endfor;?>
        <li class="page-item <?php if($page==$totalPage) echo "disabled";?> ">
          <a class="page-link" href="products-list.php?category=<?=$category?>&page=<?=$page+1?>">></a>
        </li>
      </ul>
    </nav>
      <a class="btn btn-info " href="product-add.php">新增商品</a>
    </div>
    <?php if($pageProductCount>0): ?>
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
            <?php foreach($resultPage as $row):?>
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
          <?php else: ?>
            目前沒有資料
        <?php endif; ?>
        </table>
      </div>
  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>