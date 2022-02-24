<?php
$keyword = $_POST["keyword"];
$arr_keyword = explode(" ", $keyword);
$new_keyword = "%".implode("%", $arr_keyword)."%";
$sql = "SELECT * FROM product
        WHERE prd_name LIKE '$new_keyword'
    ";
$query = mysqli_query($conn, $sql);
?>
<!--	List Product	-->
<div class="products">
    <div id="search-result">Kết quả tìm kiếm với sản phẩm <span><?php echo $keyword; ?></span></div>
    <?php
    $i = 0;
    $rows = mysqli_num_rows($query);
    while($row = mysqli_fetch_array($query)){
        if($i == 0){
    ?>
    <div class="product-list card-deck">
    <?php
        }
    ?>
        <div class="product-item card text-center">
            <a href="index.php?page_layout=product&prd_id=<?php echo $row["prd_id"];?>"><img src="admin/img/products/<?php echo $row["prd_image"] ?>"></a>
            <h4><a href="index.php?page_layout=product&prd_id=<?php echo $row["prd_id"];?>"><?php echo $row["prd_name"]; ?></a></h4>
            <p>Giá Bán: <span><?php echo formatPrice($row["prd_price"]); ?> VND</span></p>
        </div>
    <?php
        $i++;
        if($i%3 == 0){
            $i = 0;
    ?>   
    </div>
    <?php
        }
    }
    if($rows%3 != 0){
    ?>
    </div>
    <?php
    }
    ?>
</div>
<!--	End List Product	-->

<div id="pagination">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Trang trước</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Trang sau</a></li>
    </ul>
</div>