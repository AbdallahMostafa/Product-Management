import React, {useState} from 'react';
import productService from '../services/productService';
import Product from '../models/Product';

const AddProductForm = () => {
    
    const [name, setName] = useState('');
    const [price, setPrice] = useState('');
    const [SKU, setSKU] = useState('');
    const [type, setType] = useState('');

    const [attributes, setAttributes] = useState([]);
    
    const attributeMap = {
        DVD: { size: 'size' },
        Book: { weight: 'weight' },
        Furniture: { weight: 'weight', length: 'length', height: 'height' },
    };

    const handleSKUChange =(event) => {
        setSKU(event.target.value);
    }

    const handleTypeChange =(event) => {
        setType(event.target.value);
    }
    const handleNameChange = (event) => {
        setName(event.target.value);
    };
    
    const handlePriceChange = (event) => {
        setPrice(event.target.value);
    };
    
    const handleAttributeChange = (event) => {
        const attributeName = event.target.name;
        const attributeValue = event.target.value;

        // Get the attribute name based on the selected type
        const attributeType = attributeMap[type];
        if (!attributeType) {
            console.error('Invalid product type:', type);
            return;
        }


        setAttributes({ ...attributes, [attributeType[attributeName]]: attributeValue });
    };

    const handleSubmit = async (event) => {
        
        event.preventDefault();

        const product = new Product(name, price, attributes, SKU, type);
        
        console.log(product);
        try {
            await productService.addProduct(product);
            setName('');
            setPrice('');
            setAttributes('');
            alert('Product added successfully!');
        } catch (error) {
            console.error('Error adding product:', error);
            alert('Falied to add product. Please try again.');
        }
    };

    const typeSpecificFields = {
        DVD: (
          <div>
            <label htmlFor="size">Size (MB):</label>
            <input type="number" id="size" name="size" onChange={handleAttributeChange}/>
          </div>
        ),
        Book: (
          <div>
            <label htmlFor="weight">Weight (Kg):</label>
            <input type="number" id="weight" name="weight" onChange={handleAttributeChange}/>
          </div>
        ),
        Furniture: (
          <div>
            <label htmlFor="dimensions">Dimensions (HxWxL):</label>
            <input type="text" id="dimensions" name="dimensions" onChange={handleAttributeChange} />
          </div>
        )
    };
    
    return (
        <form onSubmit={handleSubmit}>
            <label htmlFor="name">Name:</label>
            <input type="text" id="name" name="name" onChange={handleNameChange}/>

            <label htmlFor="price">Price:</label>
            <input type="number" id="price" name="price" onChange={handlePriceChange}/>

            <label htmlFor="SKU">SKU:</label>
            <input type="text" id="SKU" name="SKU" onChange={handleSKUChange}/>

            <label htmlFor="type">Type:</label>
            <select id="type" value={type} onChange={handleTypeChange}>
                <option value="">Select a type</option>
                <option value="DVD">DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
            </select>
            {typeSpecificFields[type]}

            <button type="submit">Add Product</button>
        </form>
    );
};

export default AddProductForm;