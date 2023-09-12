    import React from 'react';
    import { useNavigate, useLocation } from 'react-router-dom';
    
    import Product from '../models/Product';
    import DVDProductForm from '../productForms/DVDProductForm';
    import BookProductForm from '../productForms/BookProductForm';
    import FurnitureProductForm from '../productForms/FurnitureProductForm';
    import '../styles/form.css';
    import { connect } from 'react-redux';
    import {Button} from 'react-bootstrap';
    import { addProduct, setFormField } from '../store/action'; // Import the relevant actions



    const AddProductForm = ({ formState, addProduct, setFormField }) => {
        
        const { name, price, SKU, type, attributes } = formState;

        
        const navigate = useNavigate();


        const handleFieldChange = (event) => {
            const { name, value } = event.target;
            setFormField(name, value);
        };
    
        const handleAttributeChange = (attributeName, attributeValue) => {
            const newAttributes = {
              ...attributes,
              [attributeName]: attributeValue,
            };
            setFormField('attributes', newAttributes); // This dispatches the action for the attributes object
          };
        const handleSubmit = async (event) => {
                event.preventDefault();
                const requiredFields = {
                    DVD: ['size'],
                    Book: ['weight'],
                    Furniture: ['height', 'width', 'length'],
                };
            
                const basicRequiredFields = ['name', 'price', 'SKU', 'type'];
                if (basicRequiredFields.some(field => !formState[field] || formState[field].trim() === '')) {
                    alert('Please fill in all required fields');
                    return;
                }
            
                const type = formState.type;
                if (requiredFields[type]) {
                    const missingFields = requiredFields[type].filter(field => !formState.attributes[field] || formState.attributes[field] <= 0);
                    if (missingFields.length > 0) {
                        const typeLabel = type === 'DVD' ? 'DVD' : (type === 'Book' ? 'Book' : 'Furniture');
                        alert(`Please fill in all required ${typeLabel} fields`);
                        return;
                    }
                }
            
                const product = new Product(name, price, attributes, SKU, type);
                try {
                    await addProduct(product);
                    // alert('Product added successfully!'); // this alreat is annoying
                    navigate('/');
                } catch (error) {
                    console.error('Error adding product:', error);

                    alert('Falied to add product. Please try again.');
                }
                
            
        };

        const typeSpecificFields = {
            DVD: <DVDProductForm attributes={attributes} handleAttributeChange={handleAttributeChange} />,
            Book: <BookProductForm attributes={attributes} handleAttributeChange={handleAttributeChange} />,
            Furniture: <FurnitureProductForm  attributes={attributes} handleAttributeChange={handleAttributeChange} />,
        };
        
        return (
            <div>
                <header className='form-header'>
                    <div>
                        <h2 id="product-header">Product Add</h2>
                    </div>
                    <Button onClick={handleSubmit} variant="success" >Save</Button>
                </header>
                <hr></hr>
                <form className="form-container">
                    
                    <label htmlFor="name" className="label-style">Name:</label>
                    <input className="input-style" type="text" id="name"  value={name} name="name" onChange={handleFieldChange}/>

                    <label htmlFor="price" className='label-style'>Price:</label>
                    <input className='input-style'type="number" id="price" name="price" value={price} onChange={handleFieldChange}/>

                    <label htmlFor="SKU" className='label-style'>SKU:</label>
                    <input className='input-style' type="text" id="SKU" value={SKU} name="SKU" onChange={handleFieldChange}/>

                    <label htmlFor="type" className='label-style'>Type:</label>
                    <select className="select-style" id="type" value={type} name='type' onChange={handleFieldChange}>
                        <option value="">Select a type</option>
                        <option value="DVD">DVD</option>
                        <option value="Book">Book</option>
                        <option value="Furniture">Furniture</option>
                    </select>
                    {typeSpecificFields[type]}

                    <button className='button-style' type="button" onClick={() => navigate('/')}>
                        Cancel
                    </button>    
                </form>
            </div>
        );
    };

const mapStateToProps = (state) => ({
    formState: state.addProductForm, // Use the correct reducer name
});
    
const mapDispatchToProps = {
    addProduct,
    setFormField,
};
      
export default connect(mapStateToProps, mapDispatchToProps)(AddProductForm);
