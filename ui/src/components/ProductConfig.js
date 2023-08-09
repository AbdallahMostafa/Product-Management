const productConfig = {
    DVD: {
      attributes: ['size'],
    },
    Book: {
      attributes: ['weight'],
    },
    Furniture : {
      attributes: ['length', 'weight', 'height'],
      renderAttributes: (attributes) =>
        `Dimensions: ${attributes.length} x ${attributes.weight} x ${attributes.height}`,
    },
  };
  
  export default productConfig;
  