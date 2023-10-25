<?php

use PHPUnit\Framework\TestCase;
use Src\Controllers\ProductController;
use Src\Factory\Product\ProductFactroy;
use Src\Entities\Product;
use Src\Entities\DVDProduct;
use Src\Entities\FurnitureProduct;
use Src\Entities\BookProduct;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class ProductControllerTest extends TestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a simple in-memory SQLite database configuration
        $config = Setup::createAttributeMetadataConfiguration([__DIR__ . "../src/Entities"], true);
        $conn = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        // Create the EntityManager
        $this->entityManager = EntityManager::create($conn, $config);

         // Create the database schema
         $schemaTool = new SchemaTool($this->entityManager);
         $classes = [
             $this->entityManager->getClassMetadata(Product::class),
             $this->entityManager->getClassMetadata(BookProduct::class),
             $this->entityManager->getClassMetadata(DVDProduct::class),
             $this->entityManager->getClassMetadata(FurnitureProduct::class)
            ]; // Add other entity classes here
         $schemaTool->createSchema($classes);
    }


    public function testIndex()
    {

        $Book = new BookProduct();
        $Book->setSKU('ABC123');
        $Book->setName('Book');
        $Book->setPrice(10);
        $Book->setWeight(10);

        $DVD = new DVDProduct();
        $DVD->setSKU('XYZ123');
        $DVD->setName('DVD');
        $DVD->setPrice(10);
        $DVD->setSize(10);

        $furniture = new FurnitureProduct();
        $furniture->setSKU('DDFFGG');
        $furniture->setName('Furniture');
        $furniture->setPrice(10);
        $furniture->setWidth(10);
        $furniture->setHeight(10);
        $furniture->setLength(10);

        $this->entityManager->persist($Book);
        $this->entityManager->persist($DVD);
        $this->entityManager->persist($furniture);
        $this->entityManager->flush();
        $factory = $this->createMock(ProductFactroy::class);
        $controller = new ProductController($this->entityManager, $factory);

        $expectedOutput = [
           [
               'id' => 1,
               'SKU' => 'ABC123',
               'type' => 'Book',
               'name' => 'Book',
               'price' => 10,
               'attributes' => [
                   'weight' => 10
               ]
           ],
           [
               'id' => 2,
               'SKU' => 'XYZ123',
               'type' => 'DVD',
               'name' => 'DVD',
               'price' => 10,
               'attributes' => [
                   'size' => 10
               ]
           ],
           [
               'id' => 3,
               'SKU' => 'DDFFGG',
               'type' => 'Furniture',
               'name' => 'Furniture',
               'price' => 10,
               'attributes' => [
                   'width' => 10,
                   'height' => 10,
                   'length' => 10
               ]
           ]
        ];

        $expectedOutputJson = json_encode($expectedOutput);
        $actualOutput = $controller->index();        
        $this->assertEquals($expectedOutputJson, $actualOutput->getBody());
    }
    public function testFillProductData()
    {

        // Create a request array for a BookProduct
        $request = [
        'type' => 'Book',
        'SKU' => 'BBB123',
        'name' => 'New Book',
        'price' => 20,
        'attributes' => [
            'weight' => 5
        ]
        ];

        // Create an instance of BookProduct
        $bookProduct = new BookProduct();

        // Call fillProductData on the BookProduct instance
        $bookProduct->fillProductData($request);

        $this->assertEquals('BBB123', $bookProduct->getSKU());
        $this->assertEquals('New Book', $bookProduct->getName());
        $this->assertEquals(20, $bookProduct->getPrice());
        $this->assertEquals(5, $bookProduct->getWeight());

    }


    public function testDeleteProduct()
    {
        $Book = new BookProduct();
        $Book->setSKU('ABC123');
        $Book->setName('Book');
        $Book->setPrice(20);
        $Book->setWeight(10);
        $this->entityManager->persist($Book);

        $DVD = new DVDProduct();
        $DVD->setSKU('XYZ123');
        $DVD->setName('DVD');
        $DVD->setPrice(10);
        $DVD->setSize(10);
        $this->entityManager->persist($DVD);

        $this->entityManager->flush();

        $factory = $this->createMock(ProductFactroy::class);

        $controller = new ProductController($this->entityManager, $factory);

        // Define the request data for deletion
        $request = [
        'productIds' => [$Book->getId(), $DVD->getId()],
        ];
        // Simulate the delete request
        $output = $controller->delete($request);
        $responseData = $output->getBody();
        $responseData = json_decode($responseData, true);
        
        $this->assertArrayHasKey('deletedProductCount', $responseData);
        $this->assertEquals(2, json_encode($responseData['deletedProductCount']));
    }

}
