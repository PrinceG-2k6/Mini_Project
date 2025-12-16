import React, { useState, useEffect } from 'react'
import ColorList from './ColorList';
import './App.css'

const AddColor = () => {
    let colors = JSON.parse(localStorage.getItem('color')) || { red: 0, green: 0, blue: 0 };

    const [red, setRed] = useState(colors.red);
    const [green, setGreen] = useState(colors.green);
    const [blue, setBlue] = useState(colors.blue);

    const [refresh, setRefresh] = useState(false);  // 🔹 extra state

    const url = "http://localhost:3000/colors";

    const createColor = async (e) => {
        localStorage.setItem('color', JSON.stringify({ red, green, blue }))
        let response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify({ red, green, blue })
        });
        response = await response.json();
        if (response) {
            alert("New color Added");
        }
    }

    const showcolor = (red, green, blue) => {
        const color = { red, green, blue };
        localStorage.setItem("color", JSON.stringify(color));
        setRefresh(prev => !prev);   // 🔹 toggle refresh state
    };

    useEffect(() => {
        const colors = JSON.parse(localStorage.getItem('color')) || { red: 0, green: 0, blue: 0 };
        setRed(colors.red);
        setGreen(colors.green);
        setBlue(colors.blue);
    }, [refresh]);  

    return (
        <div className='container'>
            <div className='colorMix'>
                <div style={{
                    backgroundColor: `rgb(${red},${green},${blue})`,
                    height: '350px',
                    width: '350px'
                }} className="container">
                </div>

                <form onSubmit={createColor}>
                    <table>
                        <tbody>
                            <tr>
                                <td><label htmlFor="red">Red : </label></td>
                                <td className='rangeInput'><input type="range" id='red' value={red} onChange={(e) => setRed(e.target.value)} min={0} max={255} /><p>{red}</p> </td>
                            </tr>
                            <tr>
                                <td><label htmlFor="green">Green : </label></td>
                                <td className='rangeInput'><input type="range" id='green' value={green} onChange={(e) => setGreen(e.target.value)} min={0} max={255} /><p>{green}</p></td>
                            </tr>
                            <tr>
                                <td><label htmlFor="blue">Blue : </label></td>
                                <td className='rangeInput'><input type="range" id='blue' value={blue} onChange={(e) => setBlue(e.target.value)} min={0} max={255} /><p>{blue}</p></td>
                            </tr>
                            <tr>
                                <td colSpan={2}>
                                    <button type="submit">Save Combination</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div className='colorList scrollable'>
                <ColorList showcolor={showcolor} />
            </div>
        </div>
    )
}

export default AddColor;
