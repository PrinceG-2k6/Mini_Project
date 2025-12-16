import React from 'react'
import './App.css'
import AddtoCart from './AddtoCart'
import { Link } from 'react-router-dom'

const Header = () => {
  return (
    <div>
      <header>
    <div className="logo">
      <i className="fas fa-store"></i> MyShop
    </div>
    
    
    <nav>
      <ul>
        <li><Link to="/">Home</Link></li>
      </ul>
    </nav>
    
    <AddtoCart/>
    
  </header>
    </div>
  )
}

export default Header
