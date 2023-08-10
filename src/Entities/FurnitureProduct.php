<?php

namespace Src\Entities;

use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"furnitures")]
class FurnitureProduct extends Product implements ProductInterface
{

    #[ORM\Column(type:"integer")]
    private int $weight;

    #[ORM\Column(type:"integer")]

    private int $height;

    #[ORM\Column(type:"integer")]
    private int $length;
   
    /**
     * Fill the product data from a request.
     *
     * @param array $request The request data.
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
     * @param int $weight The weight to set.
     * @return void
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }
    /**
     * Get the weight of the furniture product.
     *
     * @return int The weight.
     */
    public function getWeight(): int
    {
        return $this->weight;
    }


    /**
     * Set the height of the furniture product.
     *
     * @param int $height The height to set.
     * @return void
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * Get the height of the furniture product.
     *
     * @return int The height.
     */
    public function getHeight(): int
    {
        return $this->height;
    }
    /**
     * Set the length of the furniture product.
     *
     * @param int $length The length to set.
     * @return void
     */

    public function setLength(int $length)
    {
        $this->length = $length;
    }
    /**
     * Get the length of the furniture product.
     *
     * @return int The length.
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
