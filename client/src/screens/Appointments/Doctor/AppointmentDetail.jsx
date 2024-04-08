import React, {useEffect, useState} from 'react';
import {useNavigate, useParams} from "react-router-dom";
import axios from "../../../config/axios";
import {IconButton, Table, TableContainer, Tbody, Td, Tr} from "@chakra-ui/react";
import {ArrowBackIcon} from "@chakra-ui/icons";
import { useSelector } from 'react-redux';

const AppointmentDetail = () => {
    const navigate = useNavigate();

    const [loading, setLoading] = useState(true);
    const [details, setDetails] = useState([]);

    const appointment = useParams();
    const appointmentID = appointment.appointmentId;
    const {
        token
    } = useSelector((state) => state.authentication);

    const endpoint = `/api/appointments/${appointmentID}`;

    useEffect(() => {
        const fetchAPI = async () => {
            await axios.get(endpoint, {
                headers: {
                    Authorization: token
                }
            }).then(response => {
                console.log(response.data);
                setDetails(response.data);
                setLoading(false);
            }).catch(err => {
                console.log(err);
                setLoading(false);
            });
        }

        fetchAPI();
    }, []);

    if (loading) {
        return <div className="text-center">
                    <p>Betöltés...</p>
                </div>
    }

    return (
        <>
            { details &&
                <div>
                    <div className="my-2 mx-6">
                        <IconButton aria-label='Vissza a főoldalra.' colorScheme={'teal'} icon={<ArrowBackIcon/>}
                                    onClick={() => navigate('/doctor/dashboard')}
                        />
                    </div>
                    <TableContainer>
                        <Table>
                            <Tbody>
                                <Tr>
                                    <Td>Foglalás dátuma: {details.date}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Időpont kezdete: {details.start_time}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Időpont vége: {details.end_time}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Páciens
                                        neve: {details.booking_detail.patient.last_name + ' ' + details.booking_detail.patient.first_name}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Páciens email címe: {details.booking_detail.patient.email}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Telefonszáma: {details.booking_detail.patient.patient_details.phone}</Td>
                                </Tr>
                                <Tr>
                                    <Td>Születési dátuma: {details.booking_detail.patient.patient_details.birthday}</Td>
                                </Tr>
                                <Tr>
                                    <Td>TAJ
                                        száma: {details.booking_detail.patient.patient_details.insurance_number}</Td>
                                </Tr>
                            </Tbody>
                        </Table>
                    </TableContainer>
                </div>
            }
        </>
    );
};

export default AppointmentDetail;