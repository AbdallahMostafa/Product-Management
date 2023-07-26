import React, {useState} from 'react';
import productService from '../services/productService';

const AddProductForm = () => {
    const typeSpecificFields = {
        DVD: (
          <div>
            <label htmlFor="size">Size (MB):</label>
            <input type="number" id="size" name="size" />
          </div>
        ),
        Book: (
          <div>
            <label htmlFor="weight">Weight (Kg):</label>
            <input type="number" id="weight" name="weight" />
          </div>
        ),
        Furniture: (
          <div>
            <label htmlFor="dimensions">Dimensions (HxWxL):</label>
            <input type="text" id="dimensions" name="dimensions" />
          </div>
        )
    };
    
    const [name, setName] = useState('');
    const [price, setPrice] = useState('');
    const [productType, setProductType] = useState('');
    const [SKU, setSKU] = useState('');
    const [type, setType] = useState('');

    const [attribute, setAttribute] = useState('');

    const handleNameChange = (event) => {
        setName(event.target.value);
    };
    
    const handlePriceChange = (event) => {
        setPrice(event.target.value);
    };
    
    const handleAttributeChange = (event) => {
        setAttribute(event.target.value);
    };

    const handleProductTypeChange = (e) => {
        setProductType(e.target.value);
      };

    const handleSubmit = async (event) => {
        
        event.preventDefault();

        const product = {
            SKU: SKU,
            name: name,
            price: price,
            attribute: attribute,
            type: type,
        };

        try {
            await productService.addProduct(product);
            setName('');
            setPrice('');
            setAttribute('');
            alert('Product added successfully!');
        } catch (error) {
            console.error('Error adding product:', error);
            alert('Falied to add product. Please try again.');
        }
    };
    return (
        <form onSubmit={handleSubmit}>
            <label htmlFor="name">Name:</label>
            <input type="text" id="name" name="name"/>

            <label htmlFor="price">Price:</label>
            <input type="number" id="price" name="price"/>

            <label htmlFor="SKU">SKU:</label>
            <input type="text" id="SKU" name="SKU"/>

            <label htmlFor="type">Type:</label>
            <select id="type" value={productType} onChange={handleProductTypeChange}>
                <option value="">Select a type</option>
                <option value="DVD">DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
            </select>
            {typeSpecificFields[productType]}

            <button type="submit">Add Product</button>
        </form>
    );
};

export default AddProductForm;