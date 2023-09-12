<?php

namespace Src\Utilities;

class ProductValidator
{
    function validateProductInput($request) {
        $errors = [];
    
        // Define validation rules for each product type
        $typeRules = [
            'DVD' => ['size'],
            'Book' => ['Weight'],
            'Furniture' => ['Weight', 'Width', 'Length'],
        ];
    
        if (!isset($request['Name']) || empty($request['Name'])) {
            $errors['Name'] = 'Name is required';
        }
        if (!isset($request['Price']) || !is_numeric($request['Price']) || $request['Price'] <= 0) {
            $errors['Price'] = 'Price must be a positive number';
        }
        if (!isset($request['SKU']) || empty($request['SKU'])) {
            $errors['SKU'] = 'SKU is required';
        }
        if (!isset($request['type']) || empty($request['type'])) {
            $errors['type'] = 'Product type is required';
        }
    
        // Validate type-specific attributes
        $productType = $request['type'];
        if (array_key_exists($productType, $typeRules)) {
            foreach ($typeRules[$productType] as $attribute) {
                if (!isset($request[$attribute]) || empty($request[$attribute])) {
                    $errors[$attribute] = ucfirst($attribute) . " is required for $productType";
                }
            }
        } else {
            $errors['type'] = 'Invalid product type';
        }
    
        return $errors;
    }
    
}