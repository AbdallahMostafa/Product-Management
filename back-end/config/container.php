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
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__. "/../src/Entities"),
            isDevMode: true,
        );
        
        
        // configuring the database connection
        $connection = DriverManager::getConnection([
            'host' => 'ls-618a7bdbb6b848a5c511ac2862b5e2ee889af7ff.cskd1ux142rx.eu-west-3.rds.amazonaws.com',
            'driver'   => 'pdo_mysql',
            'user'     => 'admin',
            'password' => 'password',
            'dbname'   => 'dbapp',
            'port'     => 3306
        ], $config);
        
        // obtaining the entity manager
        $entityManager = new EntityManager($connection, $config);

        return $entityManager;
    },
    // Define ProductFactory as a service
    ProductFactroy::class => function (EntityManagerInterface $entityManager) {
        // Create and return the ProductFactory instance

        $productFactory = new ProductFactroy($entityManager);

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
