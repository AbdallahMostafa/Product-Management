<?php
$container = include_once __DIR__ . '/../../config/container.php';
use Src\Controllers\ProductController;

/**
 * @var ProductController $productController 
*/
$productController = $container->get(ProductController::class);


/**
 * API routes configuration for products.
 *
 * Each route is defined as an array with the HTTP method, URL path, and controller action.
 *
 * @return array The array of route definitions.
 */
return [
    ['GET', '/api/products', [$productController, 'index']],
    ['POST', '/api/products', [$productController, 'store']],
    ["DELETE", '/api/products', [$productController, 'delete']],
];
