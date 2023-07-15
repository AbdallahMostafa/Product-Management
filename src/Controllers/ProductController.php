<?php

namespace Src\Controllers;

use Doctrine\ORM\EntityManagerInterface;
require_once __DIR__ .'/helpers/response.php';
use Src\Factory\Product\ProductFactroy;
class ProductController {

    private $entityManager;
    private $factory;
    public function __construct(EntityManagerInterface $entityManager, ProductFactroy $factory)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }
    public function index()
    {

        jsonResponse(['message' => 'HI'], 200);   
    }
    public function store($request)
    {
        
        $product = $this->factory->createProduct($request['type']);
        $data = $product->fillProductData($product, $request);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        jsonResponse([
            'message' => 'Product created successfully',
            'request' => $data], 201);   
    }
}