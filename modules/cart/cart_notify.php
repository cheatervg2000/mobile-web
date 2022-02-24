<div id="cart" class="col-lg-3 col-md-3 col-sm-12">
    <a class="mt-4 mr-2" href="index.php?page_layout=cart">giỏ hàng</a>
    <span class="mt-3">
        <?php
        //Cập nhật lại số lượng toàn bộ sản phẩm
        if(isset($_POST["sbm"])){
            foreach($_POST["qtt"] as $prd_id=>$qtt){
                $_SESSION["cart"][$prd_id] = $qtt;
            }
        }

        // In ra số chủng loại sản phẩm
        // if(isset($_SESSION["cart"])){
        //     echo count($_SESSION["cart"]);
        // } else{
        //     echo 0;
        // }

        // In ra toàn bộ số lượng sản phẩm

        if(isset($_SESSION["cart"])){
            $total = 0;
            foreach($_SESSION["cart"] as $qtt){
                $total += $qtt;
            }
            echo $total;
        } else{
            echo 0;
        }
        ?>
    </span>
</div>