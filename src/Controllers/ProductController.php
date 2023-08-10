<?php

namespace Src\Controllers;

use Doctrine\ORM\EntityManagerInterface;
require_once __DIR__ .'/helpers/response.php';
use Src\Factory\Product\ProductFactroy;
use Src\Entities\Product;

/**
 * ProductController handles product operations.
 */
class ProductController
{

    /**
     * @var EntityManagerInterface The entity manager instance.
     */
    private $entityManager;
    /**
     * @var ProductFactroy The product factory instance.
     */
    private $factory;

     /**
     * ProductController constructor.
     *
     * @param EntityManagerInterface $entityManager The entity manager instance.
     * @param ProductFactroy $factory The product factory instance.
     */
    public function __construct(EntityManagerInterface $entityManager, ProductFactroy $factory)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    /**
     * Fetches and responds with a list of products.
     */
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
    /**
     * Creates and stores a new product.
     *
     * @param array $request The product data from the request.
     */
    public function store($request)
    {
        $product = $this->factory->createProduct($request['type'], $request);
        
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        jsonResponse([
            'message' => 'Product created successfully',
            'request' => $product], 201);
    }

    /**
     * Deletes selected products.
     *
     * @param array $request The request data containing product IDs.
     */
    public function delete($request)
    {
        
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
