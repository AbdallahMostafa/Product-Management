<?php

namespace Src\Interfaces;

/**
 * Interface ProductInterface
 *
 * This interface defines the contract for product classes that can fill product data
 * and provide attributes.
 */
interface ProductInterface
{

    /**
     * Fill the product data using the provided request.
     *
     * @param  mixed $request The request data for filling the product details.
     * @return $this The implementing instance for method chaining.
     */
    function fillProductData($requets);

    /**
     * Get the attributes of the product.
     *
     * @return array Associative array containing the product's attributes.
     */
    function getAttributes();
}
