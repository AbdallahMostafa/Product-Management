<?php
namespace Src\Factory\Product;

use Doctrine\ORM\EntityManagerInterface;
use Src\Entities\BookProduct;
use Src\Entities\DVDProduct;
use Src\Entities\FurnitureProduct;
use Src\Entities\Product;
use InvalidArgumentException;

/**
 * Factory class for creating various types of products.
 */
class ProductFactroy
{
     /**
      * @var EntityManagerInterface The entity manager instance.
      */
    private $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager The entity manager instance.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create a product based on the specified type and request data.
     *
     * @param  string $type    The type of the product (e.g., "Book", "DVD", "Furniture").
     * @param  mixed  $request The request data for filling the product details.
     * @return Product The created product instance.
     * @throws InvalidArgumentException If an invalid product type is provided.
     */
    public function createProduct(string $type, $request)
    {
        if ($type === 'Book') {
            $product = new BookProduct();
        } elseif ($type === 'DVD') {
            $product = new DVDProduct();
        } elseif ($type === 'Furniture') {
            $product = new FurnitureProduct();
        } else {
            throw new InvalidArgumentException("Invalid product type: $type", 400);
        }
        $product->fillProductData($request);
        return $product;
    }
}
