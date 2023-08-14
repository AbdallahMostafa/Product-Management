import React from 'react';

const DVDProductForm = ({ attributes, handleAttributeChange }) => {
  return (
    <div>
      <label htmlFor="size" className='lable-style'>Size (MB):</label>
      <input className="input-style" type="number" id="size" name="size" onChange={(e) => handleAttributeChange('size', e.target.value)} />
    </div>
  );
};

export default DVDProductForm;
