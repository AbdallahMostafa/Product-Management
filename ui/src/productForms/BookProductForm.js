import React from 'react';
import '../styles/header.css';
 
const BookProductForm = ({ attributes, handleAttributeChange }) => {
  return (
    <div>
      <label htmlFor="weight" className='lable-style'>Weight (Kg):</label>
      <input  className="input-style" type="number" name="weight"   onChange={(e) => handleAttributeChange('weight', e.target.value)} />
    </div>
  );
};

export default BookProductForm;
