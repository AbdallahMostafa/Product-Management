<?php
namespace Src\Entities;

use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity]
#[ORM\Table(name:"products")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type:"string")]
#[ORM\DiscriminatorMap([
      "Book" => BookProduct::class,
      "DVD" => DVDProduct::class,
      "Furniture" => FurnitureProduct::class
 ])]
abstract class Product {
    
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    protected string $SKU;
    #[ORM\Column(type: 'string')]
    protected string $name;
    #[ORM\Column(type: 'integer')]
    protected int $price;

    public function getId(): ?int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name =$name;
    }
    public function getSKU(): string {
        return $this->SKU;
    }
    public function setSKU($SKU): void {
        $this->SKU = $SKU;
    }
    public function getPrice(): int {
        return $this->price;
    }
    public function setPrice($price): void {
        $this->price = $price;
    }
}