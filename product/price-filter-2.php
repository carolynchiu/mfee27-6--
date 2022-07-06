<div class="py-2">
  <form action="product-price-2.php">
    <div class="row align-items-center">
      price
      <div class="col-auto">
        <input type="number" class="form-control" name="min" value="<?php $min = isset($_GET["min"]) ? $_GET["min"] : 0;
                                                                    echo $min; ?>">
      </div>
      <div class="col-auto">
        ~
      </div>
      <div class="col-auto">
        <input type="number" class="form-control" name="max" value="<?php $max = isset($_GET["max"]) ? $_GET["max"] : 99999;
                                                                    echo $max; ?>">
      </div>
      <div class=" col-auto">
        <button class="btn btn-info" type="submit">篩選</button>
      </div>
    </div>
  </form>
</div>