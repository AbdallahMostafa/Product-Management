const intialState = {
    products: [],
    loading: true,
    selectedProducts: []
}

const productReducer = (state = intialState
    , action) => {
        switch (action.type) {
            case 'SET_PRODUCTS':
                return {
                    ...state,
                    products: action.payload,
                    loading:false,
                };
                case 'TOGGLE_PRODUCT_SELECTION':
                    const productId = action.payload;
                    const isSelected = state.selectedProducts.includes(productId);
              
                    // Add or remove the product ID from selectedProducts based on its current state
                    return {
                      ...state,
                      selectedProducts: isSelected
                        ? state.selectedProducts.filter((id) => id !== productId)
                        : [...state.selectedProducts, productId],
                    };
            default: 
                return state;
        };
}

export default productReducer;
