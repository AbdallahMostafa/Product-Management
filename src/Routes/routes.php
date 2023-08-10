<?php
$container = require_once __DIR__ . '/../../config/container.php';
use Src\Controllers\ProductController;

$productController = $container->get(ProductController::class);
return [
    ['GET', '/api/products', [$productController, 'index']],
    ['POST', '/api/products', [$productController, 'store']],
    ['DELETE', '/api/products', [$productController, 'delete']],
];
