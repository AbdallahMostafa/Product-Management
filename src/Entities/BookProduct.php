<?php

namespace Src\Entities;
use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name:"books")]
class BookProduct extends Product implements ProductInterface {
     
    #[ORM\Column(type:"decimal", precision:10, scale:2)]    
    private float $weight;

    
    // #[ORM\OneToOne(targetEntity:Product::class,  inversedBy:"books", cascade:["persist"])]
    // #[ORM\JoinColumn(name:"product_id", referencedColumnName:"id")]
     
    // private $product;
    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }
    function fillProductData($request) {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setWeight($request['weight']);
        return $this;
    }
}