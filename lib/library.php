<?php
    function formatPrice($price){
        $price = number_format($price, 0, ",", ".");
        return $price;
    }
?>