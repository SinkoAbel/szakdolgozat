import {useEffect, useState} from "react";
import axios from "../../../config/axios";
import {Table, TableContainer, Tbody, Td, Th, Thead, Tr} from "@chakra-ui/react";
import { useSelector } from "react-redux";

const PatientDashboard = () => {
    const {
        userId,
        token
    } = useSelector((state) => state.authentication);
    const endpoint = '/api/patients/' + userId;

    const [userData, setUserData] = useState([]);
    const [forthcomingAppointments, setForthcomingAppointments] = useState([]);
    const [loading, setLoading] = useState(true);
    
    useEffect(() => {
        fetchUserData();
        fetchForthComingAppointments();
    }, []);

    const fetchUserData = async () => {
        await axios.get(endpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setUserData(response.data);
            setLoading(false);
        }).catch(err => {
            console.log(err);
            setLoading(false);
        });
    }

    const fetchForthComingAppointments = async () => {
        await axios.get('/api/bookings?filters[from_today]=1', {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setForthcomingAppointments(response.data);
        }).catch(err => {
            console.log(err);
        });
    }

    if (loading) {
        return (
            <div className="text-center">
                <p>Adatok betöltése folyamatban...</p>
            </div>
        )
    }

    return (
        <>
            <div className="my-4">
                <h2>{'Üdvözöljük ' + userData.last_name + ' ' + userData.first_name + ' a Medicare időpontfoglaló rendszerében!'}</h2>
            </div>
            <div>
                <p>Közelgő időpontok:</p>
                <TableContainer>
                    <Table>
                        <Thead>
                            <Th>Dátum</Th>
                            <Th>Időpont kezdete</Th>
                            <Th>Időpont vége</Th>
                            <Th>Orvos</Th>
                        </Thead>
                        <Tbody>
                            {
                                forthcomingAppointments.map((appointment) => {
                                    return (
                                        <Tr>
                                            <Td>{appointment.bookable_reception_times.date}</Td>
                                            <Td>{appointment.bookable_reception_times.start_time}</Td>
                                            <Td>{appointment.bookable_reception_times.end_time}</Td>
                                            <Td>{appointment.bookable_reception_times.doctor_users.last_name + ' ' + appointment.bookable_reception_times.doctor_users.first_name}</Td>
                                        </Tr>
                                    );
                                })
                            }
                        </Tbody>
                    </Table>
                </TableContainer>
            </div>
        </>
    );
};

export default PatientDashboard;
