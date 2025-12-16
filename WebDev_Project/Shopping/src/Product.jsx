import './App.css'
import React, { useEffect } from 'react'
import { useDispatch, useSelector } from "react-redux"
import AddtoCart from './AddtoCart';
import { addItem, removeItem } from './redux/slice';
import {fetchProducts} from './redux/productSlice'

const Product = () => {

    const dispatch = useDispatch();
    useEffect(()=>{
      dispatch(fetchProducts());
    },[])

    const productSelector =  useSelector((state)=>state.products.items)
    console.log(productSelector)

    const cartSelector = useSelector((state)=>state.cart.items);

  return (
    <div className='grid'>
      {
        productSelector.length? productSelector.map((item,index)=>(
          <div className="card" key={index}>
            <img src={item.thumbnail} />
            <div className="content">
              <div className="title">{item.title}</div>
              <div className="brand">{item.brand}</div>
              <div className="price">Price: $ {item.price}</div>
              <div className="rating">Rating: {item.rating}</div>
              {
                cartSelector.find(cartItem=>cartItem.id==item.id)?
                <button onClick={()=>dispatch(removeItem(item))} className='btn remove'>Remove From Cart</button>:
                <button onClick={()=>dispatch(addItem(item))} className='btn'>Add To Cart</button>

              }
              
            </div>
          </div>
        )):null
      }
    </div>
  )
}

export default Product
