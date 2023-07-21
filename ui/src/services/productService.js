import axios from 'axios';

const BASE_URL = 'http://localhost:8000/api/products';

const productService = {
    getProducts: async () => {
      try {
        const response = await axios.get(BASE_URL);
        return response.data;
      } catch (error) {
        console.error('Error fetching products:', error);
        throw error;
      }
    },
  
    addProduct: async (product) => {
      try {
        const response = await axios.post(BASE_URL, product);
        return response.data;
      } catch (error) {
        console.error('Error adding product:', error);
        throw error;
      }
    },
  };

export default productService;