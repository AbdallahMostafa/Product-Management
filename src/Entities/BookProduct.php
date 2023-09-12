<?php

namespace Src\Entities;

use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"books")]
class BookProduct extends Product implements ProductInterface
{
     
    
    #[ORM\Column(type:"decimal", precision:10, scale:2)]
    private float $weight;

    /**
     * Get the weight of the book product.
     *
     * @return float The weight.
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * Set the weight of the book product.
     *
     * @param  float $weight The weight to set.
     * @return void
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }
    /**
     * Fill the product data from a request.
     *
     * @param  array $request The request data.
     * @return BookProduct The updated BookProduct instance.
     */
    function fillProductData($request)
    {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setWeight($request['attributes']['weight']);
        return $this;
    }
    /**
     * Get the attributes of the book product.
     *
     * @return array The attributes.
     */
    function getAttributes()
    {
        return [
            'weight' => $this->getWeight(),
        ];
    }
}
