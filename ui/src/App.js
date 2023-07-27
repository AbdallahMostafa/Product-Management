import './App.css';
import ProductList from './components/ProductList';
import AddProductForm from './components/AddProductForm';

function App() {
  return (
    <div>
      <h1>Product App</h1>
      <ProductList />
      <AddProductForm />
    </div>
  );
}

export default App;
