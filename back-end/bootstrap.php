<?php
// bootstrap.php
require_once __DIR__ . '/vendor/autoload.php';

use CustomAutoloaderPackage\Autoloader;
Autoloader::register();

// Create the container
$container = require_once __DIR__ . '/config/container.php';

// Store the container in a global context for easy access throughout the application
$GLOBALS['container'] = $container;

