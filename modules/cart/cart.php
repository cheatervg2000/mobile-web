<?php
include "PHPMailer-master/src/PHPMailer.php";
include "PHPMailer-master/src/Exception.php";
include "PHPMailer-master/src/OAuth.php";
include "PHPMailer-master/src/POP3.php";
include "PHPMailer-master/src/SMTP.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>
<script>
    function buyNow(){
        document.getElementById("buy-now").submit();
    }
</script>
<!--	Cart	-->
<div id="my-cart">
    <?php
    // if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0){    //Đếm xem trong giỏ hàng còn sản phẩm không
    if(isset($_SESSION["cart"])){
        // if(isset($_POST["sbm"])){
        //     // print_r($_POST["qtt"]);
        //     foreach($_POST["qtt"] as $prd_id=>$qtt){
        //         $_SESSION["cart"][$prd_id] = $qtt;
        //     }
        // }

        $arr_id = array();
        foreach($_SESSION["cart"] as $prd_id=>$qtt){
            $arr_id[] = $prd_id;
        }
        $str_id = implode(',', $arr_id);
        $sql = "SELECT * FROM product
                WHERE prd_id IN ($str_id)";
        $query = mysqli_query($conn, $sql);
    ?>
    <div class="row">
        <div class="cart-nav-item col-lg-7 col-md-7 col-sm-12">Thông tin sản phẩm</div>
        <div class="cart-nav-item col-lg-2 col-md-2 col-sm-12">Tùy chọn</div>
        <div class="cart-nav-item col-lg-3 col-md-3 col-sm-12">Giá</div>
    </div>
    <form method="post">
        <?php
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $order_code = $yCode[intval(date('Y')) - 2022] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        $total_price_all = 0;
        while($row = mysqli_fetch_array($query)){
            $total_price = $_SESSION["cart"][$row["prd_id"]]*$row["prd_price"];
            $total_price_all += $total_price;
        ?>
        <div class="cart-item row">
            <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                <img src="admin/img/products/<?php echo $row["prd_image"]; ?>">
                <h4><?php echo $row["prd_name"]; ?></h4>
            </div>

            <div class="cart-quantity col-lg-2 col-md-2 col-sm-12">
                <input name="qtt[<?php echo $row["prd_id"]; ?>]" type="number" id="quantity" class="form-control form-blue quantity" 
                value=<?php echo $_SESSION["cart"][$row["prd_id"]]; ?> min="1" max="<?php echo $row["prd_quantity"]; ?>">
            </div>
            <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo formatPrice($total_price); ?></b><a href="modules/cart/cart_del.php?prd_id=<?php echo $row["prd_id"]; ?>">Xóa</a></div>
        </div>
        <?php
            }
        ?>
        <div class="row">
            <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                <button id="update-cart" class="btn btn-success" type="submit" name="sbm">Cập nhật giỏ hàng</button>
            </div>
            <div class="cart-total col-lg-2 col-md-2 col-sm-12"><b>Tổng cộng:</b></div>
            <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo formatPrice($total_price_all); ?></b></div>
        </div>
    </form>
    <?php
    } else{
    ?>
    <div class="alert alert-danger">Giỏ hàng của bạn hiện chưa có sản phẩm nào!</div>
    <?php
    }
    ?>
</div>
<!--	End Cart	-->
<?php
    if(isset($_SESSION["cart"]) && isset($_POST["name"]) && isset($_POST["mail"]) && isset($_POST["phone"]) && isset($_POST["add"])){
        $name = $_POST["name"];
        $email = $_POST["mail"];
        $phone = $_POST["phone"];
        $add = $_POST["add"];
        $str_body = '';
        $str_body .= '
        <p>
        <b>Khách hàng:</b>'.$name.' <br>
        <b>Điện thoại:</b>'.$phone.'<br>
        <b>Địa chỉ:</b>'.$add.'<br>
        </p>';
        $str_body .= '
        <table border="1" cellspacing="0" cellpadding="10" bordercolor="#305eb3" width="100%">
        <tr bgcolor="#305eb3">
            <td width="70%"><b><font color="#FFFFFF">Sản phẩm</font></b></td>
            <td width="10%"><b><font color="#FFFFFF">Số lượng</font></b></td>
            <td width="20%"><b><font color="#FFFFFF">Tổng tiền</font></b></td>
        </tr>';
        $query = mysqli_query($conn, $sql);
        $total_price_all = 0;
        while($row = mysqli_fetch_array($query)){
        $total_price = $_SESSION["cart"][$row["prd_id"]]*$row["prd_price"];
        $total_price_all += $total_price;
        $str_body .='
        <tr>
            <td width="70%">'.$row["prd_name"].'</td>
            <td width="10%">'.$_SESSION["cart"][$row["prd_id"]].'</td>
            <td width="20%">'.formatPrice($total_price).'VND</td>
        </tr>';
        $prd_quantity = $row["prd_quantity"] - $_SESSION["cart"][$row["prd_id"]];
        $sql = "UPDATE product
                SET prd_quantity = $prd_quantity
                WHERE prd_id = " . $row["prd_id"];
        mysqli_query($conn, $sql);
        if($prd_quantity == 0){
            $sql = "UPDATE product
                SET prd_status = 0
                WHERE prd_id = " . $row["prd_id"];
            mysqli_query($conn, $sql);
        }
        //Order update:
        $order_quantity = $_SESSION["cart"][$row["prd_id"]];
        $order_prd_id = $row["prd_id"];
        $sql = "INSERT INTO orders (order_code, prd_id, user_mail, order_quantity, order_status) 
        VALUES ('$order_code','$order_prd_id', '$email', '$order_quantity', '0')";
        mysqli_query($conn, $sql);
        }
        $str_body .='
        <tr>
            <td colspan="2" width="70%">Mã đơn hàng: '.$order_code.'</td>
            <td width="20%"><b><font color="#FF0000">'.formatPrice($total_price_all).'VND</font></b></td>
        </tr>
        </table>
        ';
        $str_body .= '
        <p>
	        Cám ơn quý khách đã mua hàng tại Shop của chúng tôi, bộ phận giao hàng sẽ liên hệ với quý khách để xác nhận sau 5 phút kể từ khi đặt hàng thành công và chuyển hàng đến quý khách chậm nhất sau 24 tiếng.
        </p>
        ';

        //echo $str_body;

        // Mail Config
        $mail = new PHPMailer(true);                              // Passing 'true' enables exceptions
        
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'dathunter100@gmail.com';                 // SMTP username
            $mail->Password = 'fvanpqgvbuhduamh';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
         
            //Recipients
            $mail->setFrom('dathunter100@gmail.com', 'VietPro Moblie Shop');

            $mail->addAddress($email, $name);     // Add a recipient
            
            // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
         
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
         
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Xac nhan don hang tu Vietpro Mobile Shop';
            $mail->Body    = $str_body;
            $mail->AltBody = 'Mô tả đơn hàng';
         
            $mail->send();
            unset($_SESSION["cart"]);
            header('location:index.php?page_layout=success');
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
?>
<!--	Customer Info	-->
<div id="customer">
    <form id="buy-now" method="post">
        <div class="row">

            <div id="customer-name" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Họ và tên (bắt buộc)" type="text" name="name" class="form-control" required>
            </div>
            <div id="customer-phone" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Số điện thoại (bắt buộc)" type="text" name="phone" class="form-control" required>
            </div>
            <div id="customer-mail" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Email (bắt buộc)" type="text" name="mail" class="form-control" required>
            </div>
            <div id="customer-add" class="col-lg-12 col-md-12 col-sm-12">
                <input placeholder="Địa chỉ nhà riêng hoặc cơ quan (bắt buộc)" type="text" name="add" class="form-control" required>
            </div>

        </div>
    </form>
    <div class="row">
        <div class="by-now col-lg-6 col-md-6 col-sm-12">
            <a onclick="buyNow()" href="#">
                <b>Mua ngay</b>
                <span>Giao hàng tận nơi siêu tốc</span>
            </a>
        </div>
        <div class="by-now col-lg-6 col-md-6 col-sm-12">
            <a href="#">
                <b>Trả góp Online</b>
                <span>Vui lòng call (+84) 0988 550 553</span>
            </a>
        </div>
    </div>
</div>
<!--	End Customer Info	-->