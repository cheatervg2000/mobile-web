<?php
include_once("connect.php");
$order_id = $_GET["order_id"];
$sql = "DELETE FROM orders WHERE order_id = $order_id";
mysqli_query($conn, $sql);
header("location:index.php?page_layout=order");
?>