<?php
include_once("connect.php");
$comm_id = $_GET["comm_id"];
$sql = "DELETE FROM comment
        WHERE comm_id = $comm_id
";
mysqli_query($conn, $sql);
header("location:index.php?page_layout=comment");
?>