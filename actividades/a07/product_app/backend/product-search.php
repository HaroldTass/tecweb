<?php
    use TECWEB\BACKEND\MYAPI\Products;
    require_once __DIR__.'/myapi/Products.php';

    $producto = new Products('marketzone');
    $producto->search($_POST['search']);
    echo $producto->getData();
?>