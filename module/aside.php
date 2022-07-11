
<aside class="dashboard-control position-fixed bg-light start-0 top-0 vh-100 border-end overflow-auto">
  <nav>
    <div class="py-4 px-3 text-primary">
      <?php if (isset($_SESSION["admin"])) : ?>
        Hi, <?= $_SESSION["admin"]["name"] ?>
      <?php endif; ?>
    </div>
    <ul class="list-unstyled side-menu">
      <li class="border-bottom">
        <a href="http://localhost/mfee27-group6/homepage.php"><i class="fa-solid fa-house fa-fw me-2"></i>首頁</a>
      </li>
      <li class="border-bottom">
        <a href="" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-screwdriver-wrench me-2"></i>管理員管理</a>
        <div class="collapse" id="collapseUsers">
          <ul class="list-unstyled">
            <li class="border-bottom ps-4">
              <a href="http://localhost/mfee27-group6/admin/admins.php">所有管理員</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="border-bottom">
        <a href="" data-bs-toggle="collapse" data-bs-target="#collapseUsers2" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-users fa-fw me-2"></i>會員管理</a>
        <div class="collapse" id="collapseUsers2">
          <ul class="list-unstyled">
            <li class="border-bottom ps-4">
              <a href="http://localhost/mfee27-group6/user/users.php">所有會員</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="border-bottom">
        <a href="" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-box-archive fa-fw me-2"></i>商品管理</a>
        <div class="collapse" id="collapseProducts">
          <ul class="list-unstyled">
            <li class="border-bottom ps-4">
              <a href="http://localhost/mfee27-group6/product/products-list.php
              ">所有商品</a>
            </li>
            <li class="border-bottom ps-4">
              <a href="http://localhost/mfee27-group6/product/product-comments.php">商品評論</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="border-bottom">
        <a href="" data-bs-toggle="collapse" data-bs-target="#collapseOrders" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-file-lines fa-fw me-2"></i>訂單管理</a>
        <div class="collapse" id="collapseOrders">
          <ul class="list-unstyled">
            <li class="border-bottom ps-4">
              <a href="http://localhost/mfee27-group6/order/order-list.php">所有訂單</a>
            </li>
            <li class="border-bottom ps-4">
              <a href="">優惠券管理</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="border-bottom">
        <a href="" data-bs-toggle="collapse" data-bs-target="#collapseHealth" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-heart-pulse fa-fw me-2"></i>健康專區管理</a>
        <div class="collapse" id="collapseHealth">
          <ul class="list-unstyled">
            <li class="border-bottom ps-4">
              <a href="">食譜管理</a>
            </li>
            <li class="border-bottom ps-4">
              <a href="http://localhost/mfee27-group6/course/course.php">課程管理</a>
            </li>
            <li class="border-bottom ps-4">
              <a href="">文章管理</a>
            </li>
          </ul>
        </div>
      </li>
      <!-- 
          <li class="border-bottom">
          <a href=""><i class="fa-solid fa-chart-line fa-fw me-2"></i>Dashboard</a>
          </li> 
      -->
    </ul>
  </nav>
</aside>