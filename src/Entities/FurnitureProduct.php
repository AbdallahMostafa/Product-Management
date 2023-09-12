<?php

namespace Src\Entities;

use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"furnitures")]
class FurnitureProduct extends Product implements ProductInterface
{

    #[ORM\Column(type:"decimal", precision:10, scale:2)]
    private float $weight;

    #[ORM\Column(type:"decimal", precision:10, scale:2)]

    private float $height;

    #[ORM\Column(type:"decimal", precision:10, scale:2)]
    private float $length;
   
    /**
     * Fill the product data from a request.
     *
     * @param  array $request The request data.
     * @return FurnitureProduct The updated FurnitureProduct instance.
     */
    function fillProductData($request)
    {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setWeight($request['attributes']['weight']);
        $this->setHeight($request['attributes']['height']);
        $this->setLength($request['attributes']['length']);
        return $this;
    }
    
    /**
     * Set the weight of the furniture product.
     *
     * @param  float $weight The weight to set.
     * @return void
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }
    /**
     * Get the weight of the furniture product.
     *
     * @return float The weight.
     */
    public function getWeight(): float
    {
        return $this->weight;
    }


    /**
     * Set the height of the furniture product.
     *
     * @param  float $height The height to set.
     * @return void
     */
    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    /**
     * Get the height of the furniture product.
     *
     * @return float The height.
     */
    public function getHeight(): float
    {
        return $this->height;
    }
    /**
     * Set the length of the furniture product.
     *
     * @param  float $length The length to set.
     * @return void
     */

    public function setLength(float $length)
    {
        $this->length = $length;
    }
    /**
     * Get the length of the furniture product.
     *
     * @return float The length.
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Get the attributes of the furniture product.
     *
     * @return array The attributes.
     */
    function getAttributes()
    {
        return [
            'weight' => $this->getWeight(),
            'height' => $this->getHeight(),
            'length' => $this->getLength()
        ];
    }
}
