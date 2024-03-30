import { useEffect } from "react";
import axios from "../../../config/axios";
import { useState } from "react";

const DoctorDashboard = () => {
    const doctorID = window.sessionStorage.getItem('user_id');
    const token = window.sessionStorage.getItem('token');
    
    const [doctorDetails, setDoctorDetails] = useState([]);

    // TODO: Üdvözöljük, és mutassuk meg, hogy mikor van a legközelebbi időpont?
    const fetchDoctorDetail = async () => {
        await axios.get('/doctors/' + doctorID, {
            headers: {
                Authorization: token
            }
        }).then((response) => {
            setDoctorDetails(response.data);
            console.log(response.data);
        }).catch((err) => {
            console.log(err);
        });
    }

    useEffect(() => {
        //fetchDoctorDetail();
    }, []);

    return (
        <>
            <h1>Orvos panel</h1>
        </>
    );
}

export default DoctorDashboard;
