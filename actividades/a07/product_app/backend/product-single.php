<?php
    use TECWEB\BACKEND\MYAPI\Products;
    require_once __DIR__.'/myapi/Products.php';

    $producto = new Products('marketzone');
    $producto->single($_POST['id']);
    echo $producto->getData();
?>
