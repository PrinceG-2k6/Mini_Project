
import React, { useEffect, useState } from 'react'
import { useNavigate } from 'react-router-dom';
import './App.css'

const ColorList = ({showcolor}) => {


    const [colorData, setColorData] = useState([]);
    const [loading, setLoading] = useState(false);
    const url = "http://localhost:3000/colors";

    const navigate = useNavigate();

    useEffect(() => {
        setLoading(true);
        getColorData();
    }, []);

    const getColorData = async () => {
        let response = await fetch(url);
        response = await response.json();
        setColorData(response);
        setLoading(false);
    }


    const deletecolor = async (id) => {
        let response = await fetch(url + "/" + id, {
            method: "delete",

        });
        response = await response.json();
        if (response) {
            alert("Record Deleted");
            getColorData();
        }
    }

    const editcolor = (id) => {
        navigate("/edit/" + id);
    }
    
    return (
        <div style={{ textAlign: "center" }}>
            <ul className='color-list color-list-head'>
                <li>Color</li>
                <li>Red</li>
                <li>Green</li>
                <li>Blue</li>
                <li>RGB</li>
                <li>Action</li>
            </ul>
            {
                !loading ?
                    colorData.map((color) => (
                        <div key={color.id}>
                            <hr />
                            <ul key={color.id} className='color-list'>
                                <li><div className='colorMix'>
                                    <div style={{
                                        backgroundColor: 'rgb(' + color.red + ',' + color.green + ',' + color.blue + ')',
                                        height: '50px',
                                        width: '50px'
                                    }} className="container">

                                    </div></div></li>
                                <li>{color.red}</li>
                                <li>{color.green}</li>
                                <li>{color.blue}</li>
                                <li>rgb({color.red},{color.green},{color.blue})</li>
                                <li><button onClick={() => deletecolor(color.id)}>Delete</button>
                                    <button onClick={() => editcolor(color.id)}>Edit</button>
                                    <button onClick={() => showcolor(color.red, color.green, color.blue)}>Show</button>
                                </li>
                            </ul>
                        </div>
                    )) : "Data Loading"
            }
        </div>
    )
}

export default ColorList
