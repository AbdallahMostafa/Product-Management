<?php


namespace CustomAutoloaderPackage;

/**
 * Class Autoloader
 *
 * A simple autoloader implementation to load classes based on namespaces.
 */
class Autoloader
{
    /**
     * Register the autoloader with the SPL autoloader stack.
     *
     * This method sets up the autoloader to load classes automatically based on their namespaces.
     * It uses a closure to include the corresponding class file if it exists.
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Convert the namespace to a file path

            $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
            // Check if the file exists and load it

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}
