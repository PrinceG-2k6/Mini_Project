import { useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'
import AddColor from './AddColor'
import { NavLink, Route, Routes } from 'react-router-dom'
import EditColor from './EditColor'

function App() {

  
  return (
    <>
      <ul className='NavList'>
          <li><NavLink to="/" style={{textDecoration:"none"}}>HOME</NavLink></li>
        </ul>

        <Routes>
          <Route path='/' element={<AddColor/>}></Route>
          <Route path='/edit/:id?' element={<EditColor/>}></Route>
        </Routes>
    </>
  )
}

export default App
