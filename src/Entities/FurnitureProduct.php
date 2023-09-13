<?php

namespace Src\Entities;

use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"furnitures")]
class FurnitureProduct extends Product implements ProductInterface
{

    #[ORM\Column(type:"decimal", precision:10, scale:2)]
    private float $width;

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
        $this->setWidth($request['attributes']['width']);
        $this->setHeight($request['attributes']['height']);
        $this->setLength($request['attributes']['length']);
        return $this;
    }
    
    /**
     * Set the weight of the furniture product.
     *
     * @param  float $width The weight to set.
     * @return void
     */
    public function setWidth(float $width): void
    {
        $this->width = $width;
    }
    /**
     * Get the weight of the furniture product.
     *
     * @return float The weight.
     */
    public function getWidth(): float
    {
        return $this->width;
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
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'length' => $this->getLength()
        ];
    }
}
