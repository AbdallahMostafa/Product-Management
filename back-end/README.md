# Product Management Back-End

Welcome to the back-end of our Product Management application! This README provides an overview of the back-end structure, setup instructions, and usage guidelines.

## Table of Contents

1. [Project Overview](#project-overview)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
3. [Development](#development)
    - [Project Structure](#project-structure)
    - [Running the Development Server](#running-the-development-server)
4. [Project Components](#project-components)
4. [Testing](#testing)
    - [Unit Tests](#unit-tests)

## 1. Project Overview

This the back-end part of our Product Management application. It provides a the back-end for adding, updating, and deleting products.
## 3. Development

### Project Structure

The project structure is organized as follows:

- `src/`: Contains the source code for the back-end application.
- `src/Controllers/`: Houses various PHP Controllers, andd Helpers including `ProductController`, and `JSONResponse`.
- `src/Entites`: Houses various PHP Entites including `Product`, `DVDProduct`, `FurnitureProduct`, and `BookProduct`
- `src/Factory/`: Contains the Factory that is responsible for creating the product based on the type of the product.
- `src/Interfaces/`: Houses the Interfaces that is gonna be implemented by the back-end compoonents.
- `src/Routes`: Houses the different Routes for the bacl-end including `GET`, `POST`, `DELETE`/ 
- `src/Utilities`: Houses the different Utility class that will be used across the back-end application including `CorsUtility`,`ProductValidator`,`ResponseHandler`
- `bin/doctrine`: Houses the doctrine file to be able to use the doctrine package
- `config`: Houses the Dependency Injection container. 
- `test`: Houese the test cases for the product controller using PHPUnit.
- `Autoloader`: Houese a custom package to load classes based on namespaces.
- `index.php`:  The entry point for the application
- `bootstrap.php`: includes the Composer-generated autoload file, which sets up autoloading for the project, registering the custom     
    autoloader, created dependency injection container in the global context, and creating a dependency injection container.
- Other project files: Such as `composer.json`, `composer-lock.json`, `README.md`, `Dockerfile`, `fly.toml`.

## 4. Project Components

### Product Controller - `ProductController`

The `ProductController` is a fundamental component in our backend, responsible for handling product-related operations, including retrieving, creating, and deleting products.

### Purpose

The primary responsibilities of the `ProductController` include:

1. **Fetching Products**: The `index` method retrieves a list of products from the database and responds with product data in JSON format. It converts product entities into an array of data suitable for a response.

2. **Creating Products**: The `store` method creates and stores a new product based on the provided request data. It performs input validation, checks for duplicate SKUs, and handles any exceptions that may occur during the creation process.

3. **Deleting Products**: The `delete` method deletes selected products based on the provided request data containing product IDs. It removes the specified products from the database.

### Usage

To use the `ProductController`, follow these steps:

1. **Initialization**:

   Initialize the controller by injecting the `EntityManagerInterface` and `ProductFactroy` instances.

   ```php
   use Doctrine\ORM\EntityManagerInterface;
   use Src\Factory\Product\ProductFactroy;
   
   public function __construct(EntityManagerInterface $entityManager, ProductFactroy $factory)
   {
       $this->factory = $factory;
       $this->entityManager = $entityManager;
   }
    ```

#### Product Classes

This README provides documentation for the `FurnitureProduct`, `DVDProduct`, and `BookProduct` classes used in your project.

##### FurnitureProduct Class

The `FurnitureProduct` class represents a product of the "Furniture" type in your application. This class extends the `Product` base class and implements the `ProductInterface`.

### Attributes

- `width` (float): The width of the furniture.
- `height` (float): The height of the furniture.
- `length` (float): The length of the furniture.

### Methods

- `getWidth(): float`: Get the width of the furniture.
- `getHeight(): float`: Get the height of the furniture.
- `getLength(): float`: Get the length of the furniture.
- `getAttributes(): array`: Get the attributes of the furniture product.
- `fillProductData(array $request): FurnitureProduct`: Fill the product data from a request.

##### DVDProduct Class

The `DVDProduct` class represents a product of the "DVD" type in your application. This class extends the `Product` base class and implements the `ProductInterface`.

### Attributes

- `size` (float): The size of the DVD.

### Methods

- `getSize(): float`: Get the size of the DVD.
- `setSize(float $size): void`: Set the size of the DVD.
- `getAttributes(): array`: Get the attributes of the DVD product.
- `fillProductData(array $request): DVDProduct`: Fill the product data from a request.

##### BookProduct Class

The `BookProduct` class represents a product of the "Book" type in your application. This class extends the `Product` base class and implements the `ProductInterface`.

### Attributes

- `weight` (float): The weight of the book.

### Methods

- `getWeight(): float`: Get the weight of the book.
- `setWeight(float $weight): void`: Set the weight of the book.
- `getAttributes(): array`: Get the attributes of the book product.
- `fillProductData(array $request): BookProduct`: Fill the product data from a request.


### Product Factory

The `ProductFactory` is responsible for creating various types of products. It provides a convenient way to create instances of different product types based on the specified type and request data.

### Constructor

- `__construct(EntityManagerInterface $entityManager)`: Create an instance of the `ProductFactory` with an entity manager instance.

### Methods

- `createProduct(string $type, $request): Product`: Create a product based on the specified type and request data.
  - Parameters:
    - `$type` (string): The type of the product (e.g., "Book," "DVD," "Furniture").
    - `$request` (mixed): The request data for filling the product details.
  - Returns: A product instance of the specified type.

### Usage

Here's an example of how to use the `ProductFactory` to create product instances:

```php
// Create a ProductFactory instance with an entity manager
$productFactory = new ProductFactory($entityManager);

// Create a DVD product
$dvdProduct = $productFactory->createProduct("DVD", $dvdRequestData);

// Create a Book product
$bookProduct = $productFactory->createProduct("Book", $bookRequestData);

// Create a Furniture product
$furnitureProduct = $productFactory->createProduct("Furniture", $furnitureRequestData);
```

### Dependency Injection Container Configuration

The provided code configures a dependency injection container using PHP-DI to manage dependencies in your application. This container handles the instantiation and injection of various services, including the `EntityManager`, `ProductFactory`, and `ProductController`.

#### Configuration

The container is configured with the following services:

##### `EntityManager`

- Description: The `EntityManager` is responsible for database interaction and managing entities.
- Configuration:
  - It is created with specific database connection settings, including the host, user, password, and database name.

##### `ProductFactory`

- Description: The `ProductFactory` is responsible for creating various types of products.
- Dependencies:
  - It depends on the `EntityManager` for data persistence.
  
##### `ProductController`

- Description: The `ProductController` handles requests related to products and utilizes the `ProductFactory`.
- Dependencies:
  - It depends on the `EntityManager` for data persistence.
  - It depends on the `ProductFactory` to create product instances.

### Usage

You can use the configured container to access these services and their dependencies throughout your application. Here's an example of how to access the `ProductController`:

```php
// Import the container configuration file
$container = require 'path/to/container.php';

// Retrieve the ProductController instance from the container
$productController = $container->get(ProductController::class);

// You can now use $productController to handle product-related requests.
```

### JSON Response Handler - `JSONResponse`

The `JSONResponse` class is a utility that provides a structured way to handle and send JSON responses in your backend application. It implements the `JSONResponseInterface` to ensure a consistent format for responses.

#### Purpose

The primary purpose of the `JSONResponse` class is to:

- Format and encode data as JSON: It takes data as input and ensures it can be properly encoded as JSON.

- Set HTTP status codes: You can specify the HTTP status code for the response, which is useful for indicating the success or failure of a request.

- Add custom headers: The class allows you to add custom HTTP headers to the response, providing flexibility in response handling.

### Usage

To use the `JSONResponse` class, follow these steps:

1. **Initialization**:

   Create an instance of the `JSONResponse` class by providing the response data, HTTP status code (default is 200 for success), and any additional custom headers if needed.

   ```php
   $data = ['message' => 'Success'];
   $statusCode = 200; // HTTP status code
   $customHeaders = ['Custom-Header' => 'Value'];
   $jsonResponse = new JSONResponse($data, $statusCode, $customHeaders);
    ```

### CorsUtility Class

The `CorsUtility` class is responsible for managing Cross-Origin Resource Sharing (CORS) headers in your application. It provides methods to set appropriate headers for allowing cross-origin requests and handling preflight requests.

## Methods

### `setCorsHeaders()`

- Description: Set CORS headers to allow cross-origin requests.
- Headers Set:
  - `Access-Control-Allow-Origin: {your_url}`
  - `Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS`
  - `Access-Control-Allow-Headers: Content-Type, Authorization`
- HTTP Response Code: 204 (No Content)

### `handlePreflightRequest()`

- Description: Check if the request is a preflight request (OPTIONS) and handle it.
- Functionality:
  - Calls `setCorsHeaders()` to allow the preflight request.
  - Exits to respond to the preflight request and stop further execution.

## Usage

You can use the `CorsUtility` class to manage CORS headers in your application, allowing or restricting cross-origin requests. Here's an example of how to use it in the context of a web service:

```php
// Import the CorsUtility class
use Src\Utilities\CorsUtility;

// Check if the request is a preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    CorsUtility::handlePreflightRequest();
}

// Set CORS headers for other requests
CorsUtility::setCorsHeaders();
```

### ResponseHandler Class

The `ResponseHandler` class provides a utility for sending HTTP responses in your application. It includes functionality to set the HTTP status code, CORS headers, response headers, and the response body.

## Methods

#### `sendResponse($response)`

- Description: Send an HTTP response.
- Parameters:
  - `$response`: An instance of the response object containing the following properties:
    - `getCode()`: Get the HTTP status code.
    - `getHeaders()`: Get the response headers as an associative array.
    - `getBody()`: Get the response body as a string.
- Functionality:
  - Sets CORS headers using the `CorsUtility` class.
  - Sets the HTTP status code based on the provided response.
  - Sets response headers based on the provided response.
  - Outputs the response body.

## Usage

You can use the `ResponseHandler` class to send HTTP responses in your application. Here's an example of how to use it to send a response:

```php
// Import the ResponseHandler class
use Src\Utilities\ResponseHandler;

// Create an instance of the response object (pseudo-code)
$response = new Response();
$response->setCode(200);
$response->addHeader('Content-Type', 'application/json');
$response->setBody('{"message": "Success"}');

// Send the response
ResponseHandler::sendResponse($response);
```
## 5. Testing 

### Unit Tests

Unit tests are essential for ensuring that individual components and functions within your PHP application work as expected. We use PHPUnit, a popular testing framework for PHP, to write and execute unit tests.

#### Running Unit Tests

To run unit tests, make sure you have PHPUnit installed and then navigate to the root directory of your project in your terminal:

```bash
docker exec php ./vendor/bin/phpunit tests/ProductControllerTest.php
```    
