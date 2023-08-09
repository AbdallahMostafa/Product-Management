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
                


                const product = new Product(name, price, attributes, SKU, type);
                
                console.log(product);
                try {
                    addProduct(product);
                    alert('Product added successfully!');
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
                        <h2>Product Add</h2>
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
