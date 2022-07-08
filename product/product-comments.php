<?php
require("../db-connect.php");

//將users.id帶入product_comments.user_id 和products.id 帶入product_comments.product_id
//然後用users和products的id個別帶入他們的name
$sql="SELECT product_comments.* ,users.name AS users_name , products.name AS product_name FROM product_comments
JOIN users ON product_comments.user_id =users.id
JOIN products ON product_comments.product_id = products.id";

$result=$conn->query($sql);
$commentsCount=$result->num_rows;
$rows=$result->fetch_all(MYSQLI_ASSOC);

//待處理
//2.頁數
$page=isset($_GET["page"])? $_GET["page"] :1;
$perPage=5; //每頁有5項產品
$start=($page-1)*$perPage; //起始頁能顯示的產品數
//每頁產品
$sqlPage="SELECT product_comments.* ,users.name AS users_name , products.name AS product_name FROM product_comments
JOIN users ON product_comments.user_id =users.id
JOIN products ON product_comments.product_id = products.id   LIMIT $start, 5 ";
$resultPage=$conn->query($sqlPage);
$pageCommentCount=$resultPage->num_rows;

// //開始 
$startItem=($page-1)*$perPage+1;
// //結尾
$endItem=$page*$perPage;
// if($endItem>$userCount)$endItem=$userCount;
$totalPage=ceil($commentsCount/$perPage);//無條件進位

//變更評論/隱藏



?>
<!doctype html>
<html lang="en">

<head>
  <title>商品評論</title>
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
  <main class="main-content p-4">
    <div class="">
      <form action="product-comment-search.php" method="get">
        <div class="input-group">
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-info">搜尋</button>
        </div>
      </form>
      <?php switch($commentsCount){
            case 0:
                echo "";
                break;
            case 1:
                echo "第1筆 ,";
                break;
            case ($commentsCount < $endItem):
                echo "第$startItem ~ $commentsCount 筆 ,";
                break;
            case($commentsCount >= $endItem ):
                echo "第 $startItem ~ $endItem 筆 ,";
                break;
            default;
      }?>
       共 <?=$commentsCount?> 筆資料</div>
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item <?php if($page==1)echo "disabled";?>   ">
            <a class="page-link" href="
            <?php if(isset($_GET["category"])){
              echo "products-list.php?category=<?=$category?>&page=<?=$page?>";
            }else{
              $previousPage=$page-1;
              echo "products-list.php?page=$previousPage";
              }
              ?>
            "><</a>
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
              ?>"><?=$i?></a>
          </li>
          <?php endfor;?>
          <li class="page-item <?php if($page==$totalPage) echo "disabled";?> ">
            <a class="page-link" href="
            <?php if(isset($_GET["category"])){
              echo "products-list.php?&category=<?=$category?>&page=<?=$page?>";
            }else{
              $nextPage=$page+1;
              echo "products-list.php?page=$nextPage";
              }
              ?>">></a>
          </li>
        </ul>
      </nav>
    </div>

  <div class="container table-responsive">
        <table class="table table-bordered  table-hover mt-5">
          <thead>
            <tr>
              <th>評論編號</th>
              <th>使用者</th>
              <th>商品</th>
              <th>評論內容</th>
              <th>評論狀態</th>
              <th>隱藏</th>
            </tr>
          </thead>
          <tbody >
            <?php foreach($rows as $row):?>
            <tr>
              <td><?=$row["id"]?></td>
              <td><?=$row["users_name"]?></td>
              <td><?=$row["product_name"]?></td>
              <td><?=$row["comment"]?></td>
              <td><?php if($row["status"]==1){
                echo "顯示";
              }else{
                echo "隱藏";
              }
              ?>   
              </td>
              <td class="text-center"><a  class="btn btn-info my-2
              <?php
              if($row["status"]==1){
                echo "disabled";
              }
              ?>" href="comment-change.php?id=<?=$row["id"]?>&status=1">顯示</a>
              <a  class="btn btn-info my-2
              <?php
              if($row["status"]==0){
                echo "disabled";
              }
              ?>
              " href="comment-change.php?id=<?=$row["id"]?>&status=0">隱藏</a></td>
              
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>