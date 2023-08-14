import React from 'react';
import '../styles/furnitureForm.css';
import ProductFormWithTooltips from '../components/ProductFormWithTooltips';

const FurnitureProductForm = ({ attributes, handleAttributeChange }) => {
  return (
    <div>
      <div>
        <label htmlFor="weight">Weight:</label>
        <ProductFormWithTooltips title="Enter weight in KG">
          <input  className="input-style" type="number" id="weight" name="weight" onChange={(e) => handleAttributeChange('weight', e.target.value)} />
        </ProductFormWithTooltips>

      </div>
      <div>
        <label htmlFor="height">Height:</label>
        <ProductFormWithTooltips title="Enter height in cm" className="input-style" >
          <input className="input-style" type="number" id="height" name="height"  onChange={(e) => handleAttributeChange('height', e.target.value)} />
        </ProductFormWithTooltips>

      </div>
      <div>
        <label htmlFor="length">Length:</label>
        <ProductFormWithTooltips title="Enter length in cm">
          <input className="input-style" type="number" id="length" name="length"  onChange={(e) => handleAttributeChange('length', e.target.value)} />
        </ProductFormWithTooltips>

      </div>
    </div>
  );
};

export default FurnitureProductForm;
