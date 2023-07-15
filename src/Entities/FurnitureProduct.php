<?php

namespace Src\Entities;
use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"furnitures")]
class FurnitureProduct extends Product implements ProductInterface {

    #[ORM\Column(type:"float")]     
    private float $weight;

    #[ORM\Column(type:"integer")]

    private int $height;
    // #[ORM\OneToOne(targetEntity:Product::class,  inversedBy:"furnitures", cascade:["persist"])]
    // #[ORM\JoinColumn(name:"product_id", referencedColumnName:"id")]
     
    // private $product;
    function fillProductData($request) {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setWeight($request['weight']);
        $this->setHeight($request['height']);
        return $this;   
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }

    public function getHeight(): int {
        return $this->height;
    }

    public function setHeight(int $height): void {
        $this->height = $height;
    }
}
