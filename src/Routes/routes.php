<?php
$container = require_once __DIR__ . '/../../config/container.php';
use Src\Controllers\ProductController;

$productController = $container->get(ProductController::class);
return [
    ['GET', '/api', [ProductController::class, 'index']],
    ['POST', '/api/products', [$productController, 'store']],
    // Additional routes...
];
