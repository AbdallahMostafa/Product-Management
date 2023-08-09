import productService from '../services/productService';

// Action to set products
export const setProducts = (products) => ({
  type: 'SET_PRODUCTS',
  payload: products,
});
// Action to toogle product selection
export const toggleProductSelection = (productId) => ({
  type: 'TOGGLE_PRODUCT_SELECTION',
  payload: productId,
});

// Action to set a form field
export const setFormField = (fieldName, fieldValue) => {
  return {
    type: 'SET_FORM_FIELD',
    payload: { fieldName, fieldValue },
  };
};

// Action to reset the form
export const resetForm = () => {
  return {
    type: 'RESET_FORM',
  };
};


// Action to add a product
export const addProduct = (product) => {
  return async (dispatch) => {
    try {
      // Make the API call to add the product to the backend
      await productService.addProduct(product);

      // If the API call is successful, dispatch the SET_PRODUCTS action
      // to update the product list in the Redux store.
      const updatedProductList = await productService.getProducts();
      dispatch({ type: 'SET_PRODUCTS', payload: updatedProductList });

      // Reset the form after successfully adding the product
      dispatch({ type: 'RESET_FORM' });
    } catch (error) {
      // Handle any errors that occur during the API call
      console.error('Error adding product:', error);
      // dispatch an error action or show an error message to the user here.
    }
  };
};


