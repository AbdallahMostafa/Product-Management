<?php

namespace Src\Utilities;

class ProductValidator
{
    public static function validateProductInput($request) {
        $errors = [];
        
        // Define validation rules for each product type
        $typeRules = [
            'DVD' => ['size'],
            'Book' => ['weight'],
            'Furniture' => ['height', 'width', 'length'],
        ];
    
        if (!isset($request['name'])) {
            $errors['Name'] = 'Name is required';
        }
        if (!isset($request['price']) || !is_numeric($request['price']) || $request['price'] <= 0) {
            $errors['Price'] = 'Price must be a positive number';
        }
        if (!isset($request['SKU'])) {
            $errors['SKU'] = 'SKU is required';
        }
        if (!isset($request['type'])) {
            $errors['type'] = 'Product type is required';
        }
    
        // Validate type-specific attributes
        $productType = $request['type'];
        if (array_key_exists($productType, $typeRules)) {
            foreach ($typeRules[$productType] as $attribute) {
                if (!isset($request['attributes'][$attribute])) {
                    $errors[$attribute] = ucfirst($attribute) . " is required for $productType";
                }
            }
        } else {
            $errors['type'] = 'Invalid product type';
        }
    
        return $errors;
    }
    
}