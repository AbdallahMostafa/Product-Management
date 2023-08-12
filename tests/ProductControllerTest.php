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
        $furniture->setWeight(10);
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
                   'weight' => 10,
                   'height' => 10,
                   'length' => 10
               ]
           ]
        ];

        $expectedOutputJson = json_encode($expectedOutput);
        ob_start();
        $controller->index();
        $actualOutput = ob_get_clean();

        $this->assertEquals($expectedOutputJson, $actualOutput);
    }
}
