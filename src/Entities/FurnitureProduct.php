<?php

namespace Src\Entities;
use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"furnitures")]
class FurnitureProduct extends Product implements ProductInterface {

    #[ORM\Column(type:"integer")]     
    private int $weight;

    #[ORM\Column(type:"integer")]

    private int $height;

    #[ORM\Column(type:"integer")]
    private int $length;
    // #[ORM\OneToOne(targetEntity:Product::class,  inversedBy:"furnitures", cascade:["persist"])]
    // #[ORM\JoinColumn(name:"product_id", referencedColumnName:"id")]
     
    // private $product;
    function fillProductData($request) {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setWeight($request['attributes']['weight']);
        $this->setHeight($request['attributes']['height']);
        $this->setLength($request['attributes']['length']);
        return $this;   
    }

    public function getWeight(): int {
        return $this->weight;
    }

    public function setWeight(int $weight): void {
        $this->weight = $weight;
    }

    public function getHeight(): int {
        return $this->height;
    }

    public function setHeight(int $height): void {
        $this->height = $height;
    }

    public function setLength(int $length)
    {
        $this->lenght = $length;
    }
    public function getLength()
    {
        return $this->length;
    }
    function getAttributes() {
        return [
            'weight' => $this->getWeight(),
            'height' => $this->getHeight(),
            'length' => $this->getLength()
        ];
    }
}
