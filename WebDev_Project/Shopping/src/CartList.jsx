import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux';
import { clearAllItem, removeItem, updateQuantity } from './redux/slice';
import './App.css'
import { useNavigate } from 'react-router-dom';

const CartList = () => {
    const navigate = useNavigate();

  const dispatch = useDispatch();
  const cartSelector = useSelector((state) => state.cart.items);

  const manageQuantity = (id, q) => {
    let quantity = parseInt(q) > 1 ? parseInt(q) : 1;
    dispatch(updateQuantity({ id, quantity }));
  };

  const handlePlaceOrder =()=>{
    localStorage.clear();
    dispatch(clearAllItem())
    alert("Your Order Placed\nThanks\nShop Again")
    navigate("/");
  }

  return (
    <div className='cart-container'>
      <div className="card-Header">
        <h2>Your Cart Item</h2>
        <span>{cartSelector.length} Items</span>
      </div>

      {cartSelector.length > 0 ? (
        cartSelector.map((item) => (
          <div className="cart-item" key={item.id}>
            <div className="item-info">
              <img src={item.thumbnail} alt={item.title} />
              <div className="item-details">
                <h4>{item.title}</h4>
                <p>{item.brand}</p>
              </div>
            </div>
            <div className="item-actions">
              <div style={{ display: 'flex' }}>
                <input
                  onChange={(e) => manageQuantity(item.id, e.target.value)}
                  type="number"
                  value={item.quantity ? item.quantity : 1}
                  style={{ margin: '15px' }}
                  placeholder='Enter Quantity'
                  min={1}
                />
                <div>
                  <span className='item-price'>
                    $ {(item.quantity ? item.quantity * item.price : item.price).toFixed(2)}
                  </span>
                  <button
                    onClick={() => dispatch(removeItem(item))}
                    className='btn remove'
                  >
                    Remove From Cart
                  </button>
                </div>
              </div>
            </div>
          </div>
        ))
      ) : (
        "No Item Added To Cart"
      )}

      <div className='cart-footer'>
        Total : $ {(
          cartSelector.reduce(
            (sum, item) =>
              item.quantity ? sum + item.price * item.quantity : sum + item.price,
            0
          )
        ).toFixed(2)}
      </div>
      <button className='btn' onClick={handlePlaceOrder}>Place Order</button>
    </div>
  );
};

export default CartList;
