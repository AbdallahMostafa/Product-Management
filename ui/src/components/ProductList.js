import React, {useEffect, useState} from 'react';
import productService from '../services/productService';

const ProductList = () => {
    const [products, setProduct] = useState([]);

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const productData = await productService.getProducts();
            console.log(productData);
            setProduct(productData);
        } catch(error) {
            console.error('Error fetching products:', error);
        }
    };
    return (
        <div>
            <h2>Product List</h2>
            <ul>
                {products.map((product) => (
                    <li key={product.id}>
                        {product.name} - {product.price}
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default ProductList;

