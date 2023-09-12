<?php
namespace Src\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"products")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type:"string")]
#[ORM\DiscriminatorMap(
    [
      "Book" => BookProduct::class,
      "DVD" => DVDProduct::class,
      "Furniture" => FurnitureProduct::class
    ]
)]
abstract class Product
{
    
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    protected string $SKU;
    #[ORM\Column(type: 'string')]
    protected string $name;
    #[ORM\Column(type:"decimal", precision:10, scale:2)]
    protected int $price;

     /**
      * Get the unique identifier of the product.
      *
      * @return int|null The product ID.
      */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Set the name of the product.
     *
     * @param  string $name The product name.
     * @return void
     */
    public function setName($name): void
    {
        $this->name =$name;
    }
     /**
      * Get the name of the product.
      *
      * @return string The product name.
      */
    public function getName(): string
    {
        return $this->name;
    }
   
    /**
     * Set the Stock Keeping Unit (SKU) of the product.
     *
     * @param  string $SKU The product SKU.
     * @return void
     */
    public function setSKU($SKU): void
    {
        $this->SKU = $SKU;
    }
     /**
      * Get the Stock Keeping Unit (SKU) of the product.
      *
      * @return string The product SKU.
      */
    public function getSKU(): string
    {
        return $this->SKU;
    }
    
    /**
     * Set the price of the product.
     *
     * @param  int $price The product price.
     * @return void
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }
    /**
     * Get the price of the product.
     *
     * @return int The product price.
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}
