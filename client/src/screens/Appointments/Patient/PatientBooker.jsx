import axios from "../../../config/axios";
import {useEffect, useState} from "react";
import {
    Select,
    Table,
    TableContainer,
    Tbody,
    Td,
    Th,
    Thead,
    Tr,
} from "@chakra-ui/react";
import BookingModal from "../../../components/Modal/BookingModal";

const PatientBooker = () => {
    const token = window.sessionStorage.getItem('token');
    const userID = window.sessionStorage.getItem('user_id');
    const doctorListEndpoint = '/api/doctors/list';

    const [doctorsList, setDoctorsList] = useState([]);
    const [appointmentsList, setAppointmentsList] = useState([]);
    const [selectedDoctorId, setSelectedDoctorId] = useState(null);
    const [appointmentsFetched, setAppointmentsFetched] = useState(false);


    useEffect(() => {
        fetchDoctors();
    }, []);

    const fetchDoctors = async () => {
        await axios.get(doctorListEndpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setDoctorsList(response.data);
        }).catch(err => {
            console.log(err);
        })
    }

    const fetchAppointments = async (doctorID) => {
        const appointmentEndpoint = `/api/doctors/appointments?filters[booked]=0&filters[doctor]=${doctorID}`;

        await axios.get(appointmentEndpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setAppointmentsList(response.data);
            setAppointmentsFetched(true);
        }).catch(err => {
            console.log(err);
        });
    }

    const handleDropdownSelection = async (event) => {
        setSelectedDoctorId(event.target.value);
        await fetchAppointments(event.target.value);
    }

    return (
        <>
            <div className="mx-5">
                <h1>Páciens időpontfoglaló felület.</h1>
                <form>
                    <Select className="my-3" onChange={(e) => handleDropdownSelection(e)}>
                        <option disabled selected>Válasszon kezelőorvost!</option>
                        {doctorsList.map(doctor => {
                            return (
                                <option key={doctor.id} value={doctor.id}>
                                    {doctor.last_name + ' ' + doctor.first_name}
                                </option>
                            );
                        })}
                    </Select>
                    { appointmentsFetched &&
                        <>
                            <p>Elérhető időpontok:</p>
                            <p>Amennyiben nem látna időpontot az azt jelenti, hogy jelenleg nincs elérhető
                                szakrendelés.</p>
                            <TableContainer>
                                <Table>
                                    <Thead>
                                        <Tr>
                                            <Th>Dátum</Th>
                                            <Th>Időpont kezdés</Th>
                                            <Th>Időpont vége</Th>
                                            <Th></Th>
                                        </Tr>
                                    </Thead>
                                    <Tbody>
                                        {appointmentsList.map((appointment) => {
                                            return (
                                                <Tr key={appointment.id}>
                                                    <Td>{appointment.date}</Td>
                                                    <Td>{appointment.start_time}</Td>
                                                    <Td>{appointment.end_time}</Td>
                                                    <Td>
                                                        <BookingModal
                                                            receptionTimeID={appointment.id}
                                                            userID={userID}
                                                            doctorID={selectedDoctorId}
                                                            fetchAppointments={fetchAppointments}
                                                        />
                                                    </Td>
                                                </Tr>
                                            );
                                        })}
                                    </Tbody>
                                </Table>
                            </TableContainer>
                        </>
                    }
                </form>
            </div>
        </>
    );
}

export default PatientBooker;
