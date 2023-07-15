<?php
namespace Src\Factory\Product;
use Doctrine\ORM\EntityManagerInterface;
use Src\Entities\BookProduct;
use Src\Entities\DVDProduct;
use Src\Entities\FurnitureProduct;
use Src\Entities\Product;

class ProductFactroy {
    protected $product;
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function createProduct(string $type, $request) {
        if ($type === 'Book') {
            $product = new BookProduct();
        } elseif ($type === 'DVD') {
            $product = new DVDProduct();
        } elseif ($type === 'Furniture') {
            $product = new FurnitureProduct();
        } else {
            throw new InvalidArgumentException("Invalid product type: $type");
        }
        
        $product->fillProductData($request);
        return $product;
    }
}