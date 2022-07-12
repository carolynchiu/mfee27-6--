<div class="py-2">
    <div class="row align-items-center">
        price 
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