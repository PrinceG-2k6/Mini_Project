
import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import './App.css'

const EditColor = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const url = "http://localhost:3000/colors";

    const [red, setRed] = useState(0);
    const [green, setGreen] = useState(0);
    const [blue, setBlue] = useState(0);

    useEffect(() => {
        const getColorData = async () => {
            const res = await fetch(`${url}/${id}`);
            const data = await res.json();
            setRed(data.red);
            setGreen(data.green);
            setBlue(data.blue);
        };
        getColorData();
    }, [id]);

    const updateColor = async (e) => {
        e.preventDefault(); 
        await fetch(`${url}/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ red, green, blue })
        });
        alert("Color updated");
        localStorage.setItem('color',JSON.stringify({red,green,blue}));
        navigate("/");
    };


    return (
        <>
        
            <h1>Edit Color</h1>
        <div className='container'>
            <div className='colorMix'>
                <div style={{
                    backgroundColor: `rgb(${red},${green},${blue})`,
                    height: '100px',
                    width: '100px'
                }} className="container">
                </div>
                <form >
                    <table>
                        <tbody>
                            <tr>
                                <td><label htmlFor="red">Red : </label></td>
                                <td className='rangeInput'><input type="range" id='red' value={red} onChange={(e) => setRed(e.target.value)} min={0} max={255} /><p>{red}</p></td>
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
                                    <button onClick={(e)=>updateColor(e)}>Edit Combination</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        </>
    )
}

export default EditColor
