<?php

namespace Src\Entities;
use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name:"dvds")]
class DVDProduct extends Product implements ProductInterface {

    #[ORM\Column(type: 'float')]
    protected int $size;
    
    // #[ORM\OneToOne(targetEntity:Product::class,  inversedBy:"dvds", cascade:["persist"])]
    // #[ORM\JoinColumn(name:"product_id", referencedColumnName:"id")] 
    // private $product;
    function fillProductData ($request) {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setSize($request['size']);
        return $this;   
    }
    public function getSize(): float {
        return $this->size;
    }

    public function setSize(float $size): void {
        $this->size = $size;
    }
}