<div class="row gy-4">
  <?php foreach ($rows as $row) : ?>
    <div class="col-md-4">
      <div>
        <figure class="ratio ratio-4x3 mb-2">
          <img class="object-cover" src="../images/<?= $row["img"] ?>" alt="">
        </figure>
        <!-- 可以先把資料寫死再處理資料庫的資料 -->
        <div class="text-info"><?= $row["category_name"] ?></div>
        <h2 class="mb-2 h4"><?= $row["name"] ?></h2>
        <div class="text-end text-danger">$<?= $row["price"] ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>