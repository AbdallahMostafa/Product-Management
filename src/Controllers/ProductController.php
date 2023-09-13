<?php

namespace Src\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Src\Factory\Product\ProductFactroy;
use Src\Entities\Product;
use Src\Controllers\Helpers\JSONResponse;
use Throwable;
use Src\Utilities\ProductValidator;

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
      * @param ProductFactroy         $factory       The product factory instance.
      */

    public function __construct(EntityManagerInterface $entityManager, ProductFactroy $factory, )
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    /**
     * Fetches and responds with a list of products.
     */
    public function index() : JSONResponse
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
        $response = new JSONResponse($productData, 200);
        return $response;
    }
    /**
     * Creates and stores a new product.
     *
     * @param array $request The product data from the request.
     */
    public function store($request) :JSONResponse
    {
        $validationErrors = ProductValidator::validateProductInput($request);
        
        if (!empty($validationErrors)) {
            $response = new JSONResponse(['errors' => $validationErrors], 400);
            return $response;
        }

        try {
            $product = $this->factory->createProduct($request['type'], $request);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (Throwable $exception) {
            $response = new JSONResponse(
                [ 'message' => $exception->getMessage()],
                $exception->getCode() ? $exception->getCode : 400
            );
         
            return $response;
        }
           
        $response = new JSONResponse(
            [
                'message' => 'Product created successfully',
                'request' => $product
            ], 
            201
        );
        return $response;
    }

    /**
     * Deletes selected products.
     *
     * @param array $request The request data containing product IDs.
     */
    public function delete($request) : JSONResponse
    {
        
        $requestData = $request;
        
        $productRepository = $this->entityManager->getRepository(Product::class);
        $productIds = $requestData['productIds'];

        $products = $productRepository->findBy(['id' => $productIds]);
        
        foreach ($products as $product) {
            $this->entityManager->remove($product);
        }
        
        // Flush the changes to the database
        $this->entityManager->flush();
        
        
        $response = new JSONResponse(
            [
            'message' => 'Products deleted successfully',
            'deletedProductCount' => count($products)], 
            202
        );
        return $response;
    }
}
