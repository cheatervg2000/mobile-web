<?php
include_once("connect.php");
$order_id = $_GET["order_id"];
$sql = "UPDATE orders SET order_status = 2 WHERE order_id = $order_id";
mysqli_query($conn, $sql);
header("location:index.php?page_layout=order");
?>