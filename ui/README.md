# Product Management Front-End

Welcome to the front-end of our Product Management application! This README provides an overview of the front-end structure, setup instructions, and usage guidelines.

## Table of Contents

1. [Project Overview](#project-overview)
2. [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
3. [Development](#development)
    - [Project Structure](#project-structure)
    - [Running the Development Server](#running-the-development-server)
4. [Project Component](#project-components)
5. [Testing](#testing)
    - [Unit Tests](#unit-tests)

## 1. Project Overview

This front-end repository is a part of our Product Management application. It provides a user interface for adding and managing products, including DVD, Book, and Furniture items. The application relies on React, Redux, and React Router for state management and navigation.

## 2. Getting Started

### Prerequisites

Before you can work on the front-end of this project, ensure that you have the following software installed if you don't have docker installed:

- [Node.js](https://nodejs.org/): JavaScript runtime for running the development server.
- [npm](https://www.npmjs.com/) or [Yarn](https://yarnpkg.com/): Package managers for installing project dependencies.

If you have docker installed the start script in the root directory will handle the installation of the node module.

### Installation

1. Install project dependencies:

    ```bash
    npm install
    # or
    yarn install
    ```

## 3. Development

### Project Structure

The project structure is organized as follows:

- `src/`: Contains the source code for the front-end application.
- `src/components/`: Houses various React components, including `AddProductForm`, `ProductConfig`, `ProductFormWithTooltips`, and `ProductList`.
- `src/productForms`: Houses various React form components, including `BookProductForm`, `DVDProductForm`, and `FurnitureProductForm`
- `src/store/`: Contains Redux actions, reducers, and the store configuration.
- `src/styles/`: Stores CSS styles for the application.
- `src/models`: Stores the Modles for the application
- `src/services`: Stores the API URL and back-end calls
- `src/tests`: Houses the test cases for the React components using `Jest`

- Other project files: Such as `package.json`, `package-lock.json`, `.gitignore`, and `README.md`.

### Running the Development Server

To start the development server and work on the front-end, use the following command:

```bash
npm start
# or
yarn start
```
## 4. Project Components

### Product List Component - `ProductList`

The `ProductList` component is a crucial part of our project, responsible for displaying a list of products and providing options for managing them.

### Usage

To use this component, include it in your project and connect it to your Redux store. It takes several props and includes functionalities for fetching and displaying product data, toggling product selection, and performing mass deletions.

Here's an overview of the key functionalities of the `ProductList` component:

- **Fetching Product Data**: It uses the `useEffect` hook to fetch product data from the backend using the `productService`. The `setProducts` action is dispatched to update the product data in the Redux store.

- **Mass Deletion**: Users can select multiple products using checkboxes and then click the "MASS DELETE" button to delete the selected products. This action dispatches the `deleteSelectedProducts` action.

- **Displaying Product Information**: It displays product information, including SKU, name, price, and product-specific attributes. The attributes are dynamically rendered based on the product type using the `productConfig` configuration.

- **Interactive Features**: Users can interact with each product by selecting it via checkboxes and clicking on the product to view more details or perform actions.

Here's an example of how to use the `ProductList` component in your project:

```jsx
import React from 'react';
import ProductList from './ProductList';

const MyProductPage = () => {
  return (
    <div>
      <h1>Product Management</h1>
      <ProductList />
    </div>
  );
};

export default MyProductPage;
```

### Product Configuration with `productConfig`

Our project uses the `productConfig` object to define and manage attributes for different product types. This configuration is essential for creating and rendering product forms and information accurately.

Here's a breakdown of the `productConfig` object:

- **DVD**: For DVD products, it specifies the `size` attribute.

- **Book**: For book products, it specifies the `weight` attribute.

- **Furniture**: For furniture products, it specifies `length`, `width`, and `height` attributes. Additionally, there is a `renderAttributes` function defined for furniture products. This function formats the attributes as "Dimensions: length x width x height."

This configuration allows us to dynamically create forms and display product attributes based on the product type.

For example, when rendering a furniture product's attributes, we use the `renderAttributes` function as follows:

```javascript
const furnitureAttributes = {
  length: 60,
  width: 40,
  height: 80,
};

const formattedAttributes = productConfig.Furniture.renderAttributes(furnitureAttributes);
```
### Product Form Component with Tooltips - `ProductFormWithTooltips`

The `ProductFormWithTooltips` component is a reusable component in our project that enhances user experience by providing helpful tooltips for various input fields. It simplifies the inclusion of tooltips in our forms.

### Usage

To use this component, simply include it within your form structure. It takes two props:

- `title`: The title or description of the tooltip.
- `children`: The content or input field for which you want to display a tooltip.

Here's an example of how to use `ProductFormWithTooltips` in your form:

```jsx
import React from 'react';
import ProductFormWithTooltips from './ProductFormWithTooltips';

const MyForm = () => {
  return (
    <form>
      <ProductFormWithTooltips title="Enter the product name">
        <input type="text" placeholder="Product Name" />
      </ProductFormWithTooltips>
    </form>
  );
};

export default MyForm;
```
### Product Class

The `Product` class is a core component of our project, responsible for representing individual products. It has the following properties:

- `name`: Represents the name of the product.
- `price`: Represents the price of the product.
- `attributes`: Represents the attributes of the product, which can include specific properties depending on the product type.
- `SKU`: Represents the Stock Keeping Unit, a unique identifier for the product.
- `type`: Represents the type of the product (e.g., 'DVD', 'Book', 'Furniture').

This class allows us to create instances of products with the specified characteristics, making it a crucial element in our application\'s data management.

```javascript
class Product {
    constructor(name, price, attributes, SKU, type) {
        this.name = name;
        this.price = price;
        this.attributes = attributes;
        this.SKU = SKU;
        this.type = type;
    }
}

export default Product;
```

### State Management with Redux

In our project, we use Redux for state management to handle product data, form fields, and selected products.

### Redux Actions

#### `setProducts(products)`

This action is used to set the list of products in the Redux store.

#### `toggleProductSelection(productId)`

This action is responsible for toggling the selection of a product by its ID.

#### `setFormField(fieldName, fieldValue)`

This action updates the value of a form field based on the field name and value.

#### `resetForm()`

This action resets the form to its initial state.

#### `addProduct(product)`

This asynchronous action adds a product to the backend using an API call. If successful, it dispatches the `SET_PRODUCTS` action to update the product list in the Redux store and resets the form.

#### `deleteSelectedProducts(selectedProductIds)`

This asynchronous action deletes selected products from the backend using an API call. If successful, it updates the Redux store with the remaining products and clears the selectedProducts array.

### Redux Store Configuration

We configure the Redux store using the following setup:

```javascript
import { createStore, applyMiddleware } from 'redux';
import rootReducer from './reducers';
import thunk from 'redux-thunk';

const store = createStore(rootReducer, applyMiddleware(thunk));

export default store;
```

### API Calls with `productService`

In our project, we use the `productService` module to handle API calls for products. This module interacts with the backend to retrieve, add, and delete product data.

#### Retrieving Products

To retrieve products from the backend, we use the `getProducts` function. It makes a GET request to the API endpoint and returns the product data.

```javascript
const products = await productService.getProducts();
```

#### Adding a Product
To add a new product to the backend, we use the addProduct function. It sends a POST request to the API with the product data and returns the response.

```javascript
const newProduct = {
  name: 'Product Name',
  price: 29.99,
  attributes: { size: '10' },
  SKU: 'ABC123',
  type: 'DVD',
};

const addedProduct = await productService.addProduct(newProduct);
```

#### Deleting Selected Products

For deleting selected products, we use the deleteProducts function. It sends a DELETE request to the API with an array of product IDs to be deleted.

```javascript
const selectedProductIds = [1, 2, 3];
const deletedProducts = await productService.deleteProducts(selectedProductIds);
```
## 5. Testing

### React Component Testing

Testing your React components is crucial to ensure that they function as intended and maintain expected behavior as your application evolves. In your project, we use [Jest](https://jestjs.io/) and [React Testing Library](https://testing-library.com/docs/react-testing-library/intro) to write and run tests for your React components.

#### Running Tests

To run the React component tests, follow these steps:

1. Make sure you are in the root directory of your React project in your terminal:

   ```bash
        docker exec react npm test 
    ```
