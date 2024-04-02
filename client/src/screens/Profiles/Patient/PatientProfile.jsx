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
            console.log(response.data);
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
     * TODO: Felhasználói adatok megjelenítése egy táblázatban.
     * TODO: Hozzunk létre egy gombot Módosítás címmel.
     * TODO: FONTOS! NEM MINDEN ADAT MÓDOSÍTHATÓ!!!
     * TODO: Mit lehet módosítani?: email, city, street, house_number, zip, phone.
     * TODO: Ha a felhasználó rákattintott akkor a Táblázat cserélődjön le egy input mezőre minden elemnél, ahol a default value
     *      legyen a felhasználó adata. Ezen módosíthat.
     * TODO: Legyen egy Mentése, és egy Mégse gomb.
     */

    return (
        <div>
            Felhasználói profil
        </div>
    );
};

export default PatientProfile;