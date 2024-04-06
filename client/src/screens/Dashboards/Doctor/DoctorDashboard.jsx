import {useEffect, useState} from "react";
import axios from "../../../config/axios";
import {IconButton, Table, TableCaption, TableContainer, Tbody, Td, Th, Thead, Tr} from "@chakra-ui/react";
import {DeleteIcon, EditIcon, SearchIcon} from "@chakra-ui/icons";
import {Link} from "react-router-dom";

const DoctorDashboard = () => {
    const token = window.sessionStorage.getItem('token');

    const endpoint = '/api/appointments';
    const date = new Date();
    const today = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

    const [appointments, setAppointments] = useState([]);

    const fetchReceptionTimes = async () => {
        await axios.get(endpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setAppointments(response.data);
        }).catch(err => {
            console.log(err);
        });
    }

    const deleteReceptionTime = async (id) => {
        await axios.delete(endpoint + `/${id}`, {
            headers: {
                Authorization: token
            }
        });
        await fetchReceptionTimes();
    }

    useEffect(() => {
        fetchReceptionTimes();
    }, []);

    return (
        <>
            <h1 className='text-center font-bold my-2 text-2xl'>Időpontok áttekintése</h1>
            <TableContainer>
                <Table variant='simple'>
                    <TableCaption>Imperial to metric conversion factors</TableCaption>
                    <Thead>
                        <Tr>
                            <Th>Dátum</Th>
                            <Th>Kezdet</Th>
                            <Th>Vég</Th>
                            <Th>Státusz</Th>
                            <Th>Részletek</Th>
                            <Th>Módosítás</Th>
                            <Th>Törlés</Th>
                        </Tr>
                    </Thead>
                    <Tbody>
                        {
                            appointments.map((appointment) => {
                                return (
                                    <Tr key={appointment.id}>
                                        <Td>{appointment.date}</Td>
                                        <Td>{appointment.start_time}</Td>
                                        <Td>{appointment.end_time}</Td>
                                        <Td>{appointment.booked ? 'Foglalt' : 'Szabad'}</Td>
                                        <Td>
                                            { appointment.booked &&
                                                <Link to={`/appointment/detail/${appointment.id}`}>
                                                    <IconButton
                                                        colorScheme='teal'
                                                        aria-label='Időpont módosítás'
                                                        size='md'
                                                        icon={<SearchIcon/>}
                                                    />
                                                </Link>
                                            }
                                        </Td>
                                        <Td>
                                            { (!appointment.booked && appointment.date >= today) &&
                                                <Link to={`/appointment/${appointment.id}`}>
                                                    <IconButton
                                                        colorScheme='teal'
                                                        aria-label='Időpont módosítás'
                                                        size='md'
                                                        icon={<EditIcon/>}
                                                    />
                                                </Link>
                                            }
                                        </Td>
                                        <Td>
                                            { (!appointment.booked && appointment.date >= today) &&
                                                <IconButton
                                                    colorScheme='teal'
                                                    aria-label='Időpont törlése'
                                                    size='md'
                                                    icon={<DeleteIcon/>}
                                                    onClick={async () => {
                                                        await deleteReceptionTime(appointment.id);
                                                    }}
                                                />
                                            }
                                        </Td>
                                    </Tr>
                                );
                            })
                        }
                    </Tbody>
                </Table>
            </TableContainer>
        </>
    );
}

export default DoctorDashboard;
