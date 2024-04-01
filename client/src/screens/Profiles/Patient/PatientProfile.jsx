import React, {useEffect, useState} from 'react';
import axios from "../../../config/axios";

const PatientProfile = () => {
    const userID = window.sessionStorage.getItem('user_id');
    const token = window.sessionStorage.getItem('token');
    const endpoint = '/api/patients/' + userID;

    const [userData, setUserData] = useState([]);

    useEffect(() => {
        fetchUserData();
    }, []);

    const fetchUserData = async () => {
        await axios.get(endpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setUserData(response.data);
        }).catch(err => {
            console.log(err);
        });
    }

    const updateUserData = async () => {
        await axios.put(endpoint, {

        }, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            console.log(response.data);
        }).catch(err => {
            console.log(err);
        });
    }

    /**
     * TODO: felhasználói adatok megjelenítése, lehetőség a módosításra.
     */

    return (
        <div>
            Felhasználói profil
        </div>
    );
};

export default PatientProfile;