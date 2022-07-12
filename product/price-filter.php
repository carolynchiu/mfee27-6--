<div class="py-2">
    <div class= "ms-2 my-2 row align-items-center">
        商品價格 
        <div class="col-auto">
                <input type="number" class="form-control" name="min" value="<?php
                $min=isset($_GET["min"])?$_GET["min"]:"";
                echo $min;
                ?>">
        </div>
                ~
        <div class="col-auto">
                <input type="number" class="form-control" name="max" value="<?php
                $max=isset($_GET["max"])?
                $_GET["max"]:"";
                echo $max;
                ?>">
        </div>
    </div>
</div>