<!--	Latest Product	-->
<div class="products">
    <h3>Sản phẩm mới</h3>
    <?php
    $sql = "SELECT * FROM product
    ORDER BY prd_id DESC
    LIMIT 6
    ";
    $query = mysqli_query($conn, $sql);
    $i = 0;
    while($row = mysqli_fetch_array($query)){
        if($i == 0){
    ?>
    <div class="product-list card-deck">
    <?php
        }
    ?>
        <div class="product-item card text-center">
            <a href="index.php?page_layout=product&prd_id=<?php echo $row["prd_id"];?>"><img src="admin/img/products/<?php echo $row["prd_image"];?>"></a>
            <h4><a href="index.php?page_layout=product&prd_id=<?php echo $row["prd_id"];?>"><?php echo $row["prd_name"]; ?></a></h4>
            <p>Giá Bán: <span><?php echo formatPrice($row["prd_price"]); ?> VND</span></p>
        </div>
    <?php
    $i++;
    if($i == 3){
        $i = 0;
    ?>
    </div>
    <?php
        }
    }
    ?>
</div>
<!--	End Latest Product	-->