<?php
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Src\Controllers\ProductController;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Src\Factory\Product\ProductFactroy;

// Create the container builder
$containerBuilder = new ContainerBuilder();

// Configure the container
$containerBuilder->addDefinitions([
    // Define EntityManager as a service
    EntityManagerInterface::class => function () {
        // Create and return the EntityManager instance
        // Configure and initialize the EntityManager as per your specific setup
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__. "/../src/Entities"),
            isDevMode: true,
        );
        
        
        // configuring the database connection
        $connection = DriverManager::getConnection([
            'host'     => 'db',
            'driver'   => 'pdo_mysql',
            'user'     => 'user',
            'password' => 'password',
            'dbname'   => 'app',
        ], $config);
        
        // obtaining the entity manager
        $entityManager = new EntityManager($connection, $config);
       // Example configuration using Doctrine ORM

        return $entityManager;
    },
    // Define ProductFactory as a service
    ProductFactroy::class => function (EntityManagerInterface $entityManager) {
        // Create and return the ProductFactory instance
        // Perform any necessary configuration for the factory

        $productFactory = new ProductFactroy($entityManager);
        // Perform any additional configuration or initialization of the factory

        return $productFactory;
    },
    // Define ProductController as a service
    ProductController::class => function (EntityManagerInterface $entityManager, ProductFactroy $productFactory) {
        // Create and return the ProductController instance with dependencies injected

        return new ProductController($entityManager, $productFactory);
    },
]);

// Build the container
$container = $containerBuilder->build();

return $container;
