<?php

namespace Src\Entities;

use Src\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:"dvds")]
class DVDProduct extends Product implements ProductInterface
{

    #[ORM\Column(type: 'integer')]
    protected int $size;
    

    /**
     * Fill the product data from a request.
     *
     * @param array $request The request data.
     * @return DVDProduct The updated DVDProduct instance.
     */
    function fillProductData($request)
    {
        $this->setName($request['name']);
        $this->setPrice($request['price']);
        $this->setSKU($request['SKU']);
        $this->setSize($request['attributes']['size']);
        return $this;
    }
     /**
     * Get the size of the DVD product.
     *
     * @return int The size.
     */
    public function getSize(): int
    {
        return $this->size;
    }
     /**
     * Set the size of the DVD product.
     *
     * @param int $size The size to set.
     * @return void
     */

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Get the attributes of the DVD product.
     *
     * @return array The attributes.
     */
    function getAttributes()
    {
        return [
            'size' => $this->getSize(),
        ];
    }
}
