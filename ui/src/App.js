import './App.css';
import ProductList from './components/ProductList';
import AddProductForm from './components/AddProductForm';
import { ProductProvider } from './context/ProductContext';
import { BrowserRouter, Route, Routes  } from 'react-router-dom';

function App() {

  return (
    <div>      
      <ProductProvider>
      <BrowserRouter>
          <Routes>
            <Route exact path="/" element={<ProductList/>} />
            <Route exact path="/add-product" element={<AddProductForm  />} />
          </Routes>
        </BrowserRouter>
      </ProductProvider>

    </div>
  );
}

export default App;
