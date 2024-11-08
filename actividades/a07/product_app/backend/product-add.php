<?php
    use TECWEB\BACKEND\MYAPI\Products;
    require_once __DIR__.'/myapi/Products.php';

    $producto = new Products('marketzone');
    $producto->add(file_get_contents('php://input'));
    echo $producto->getData();
?>