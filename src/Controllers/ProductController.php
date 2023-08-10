<?php

namespace Src\Controllers;

use Doctrine\ORM\EntityManagerInterface;
require_once __DIR__ .'/helpers/response.php';
use Src\Factory\Product\ProductFactroy;
use Src\Entities\Product;
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
        $productRepository = $this->entityManager->getRepository(Product::class);
        $products = $productRepository->findAll();

        // Convert products to an array of data
        $productData = [];
        
        foreach ($products as $product) {
            $discriminatorType = $this->entityManager->getClassMetadata(get_class($product))->discriminatorValue; // get the type
            
            $productData[] = [
                'id' => $product->getId(),
                'SKU' => $product->getSKU(),
                'type' => $discriminatorType,
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'attributes' => $product->getAttributes(),
            ];
        }

        // Respond with the fetched product data
        jsonResponse($productData, 200);
    }
    public function store($request)
    {   
        $product = $this->factory->createProduct($request['type'],$request);
        
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        jsonResponse([
            'message' => 'Product created successfully',
            'request' => $product], 201);   
    }
    public function delete($request) {
        
        $requestData = json_decode(file_get_contents('php://input'), true);

        $productRepository = $this->entityManager->getRepository(Product::class);
        $productIds = $requestData['productIds'];

        $products = $productRepository->findBy(['id' => $productIds]);

        foreach ($products as $product) {
            $this->entityManager->remove($product);
        }

        // Flush the changes to the database
        $this->entityManager->flush();
        jsonResponse([
            'deletedProductCount' => count($products),
        ]);
    }
}