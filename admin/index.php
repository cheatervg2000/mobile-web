<script src="js/ckeditor/ckeditor.js"></script>
<?php
include_once("connect.php");
session_start();
define("TEMPLATE", true);
if(isset($_SESSION["users"]["mail"]) && isset($_SESSION["users"]["pass"])){
    include_once("admin.php");
} else{
    include_once("login.php");
}
?>