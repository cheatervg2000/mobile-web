<?php
$conn = mysqli_connect(
    "localhost",
    "root",      //""username"
    "",          //"password"
    "vietpro_mobile_shop"    //"database name"
);
mysqli_query($conn, "SET NAMES 'utf8'");
?>