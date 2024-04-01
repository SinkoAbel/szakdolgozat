import { Box, Button, Flex, FormControl, FormLabel, Heading, Input, Stack, useColorModeValue } from "@chakra-ui/react";
import { useState } from "react";
import axios from "../../../config/axios";
import {useNavigate} from "react-router-dom";

const DoctorAppointmentCreator = () => {
    const navigate = useNavigate();

    const [date, setDate] = useState(null);
    const [appointmentStart, setAppointmentStart] = useState(null);
    const [appointmentEnd, setAppointmentEnd] = useState(null);

    const [errorState, setErrorState] = useState(false);
    const [successState, setSuccssState] = useState(false);

    const [dateError, setDateError] = useState(false);
    const [appointmentStartError, setAppointmentStartError] = useState(false);
    const [appointmentEndError, setAppointmentEndError] = useState(false);
    const [timeError, setTimeError] = useState(false);
    const [intervalError, setIntervalError] = useState(false);

    const currentDate = new Date();
    const currentDateString = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')}`;
    const currentDatePlusThreeMonths = new Date(currentDate.setMonth(currentDate.getMonth() + 3));
    const YmdThreeMonths = `${currentDatePlusThreeMonths.getFullYear()}-${String(currentDatePlusThreeMonths.getMonth() + 1).padStart(2, '0')}-${String(currentDatePlusThreeMonths.getDate()).padStart(2, '0')}`;
    const dynamicTimeErrorText = `Csak ${currentDateString} közötti ${YmdThreeMonths} dátumot lehet megadni`;
    const clearInputs = () => {
        setDate(null);
        setAppointmentStart(null);
        setAppointmentEnd(null);
    }

    const defaultErrorFields = () => {
        setDateError(false);
        setAppointmentStartError(false);
        setAppointmentEndError(false);
        setTimeError(false);
        setIntervalError(false);
    }

    const defaultResponseStatuses = () => {
        setSuccssState(false);
        setErrorState(false);
    }

    const handleAppointmentCreation = async (event) => {
        event.preventDefault();
        defaultResponseStatuses();
        defaultErrorFields();

        if (!date) {
            setDateError(true);
            return;
        }

        if (!appointmentStart) {
            setAppointmentStartError(true);
            return;
        }

        if (!appointmentEnd) {
            setAppointmentEndError(true);
            return;
        }

        if (date < currentDateString || date > YmdThreeMonths) {
            setTimeError(true);
            return;
        }

        if (appointmentStart >= appointmentEnd ||
            appointmentStart < '07:00' ||
            appointmentStart > '19:30' ||
            appointmentEnd < '07:15' ||
            appointmentEnd > '20:00' ||
            (appointmentEnd - appointmentStart < '00:15')
        ) {
            setIntervalError(true);
            return;
        }

        const token = window.sessionStorage.getItem('token');
        const doctorID = window.sessionStorage.getItem('user_id');

        await axios.post('/api/appointments', {
            doctor_user_id: doctorID,
            date: date,
            start_time: appointmentStart,
            end_time: appointmentEnd,
        }, {
            headers: {
                Authorization: token
            }
        }).then((response) => {
            setSuccssState(true);
            clearInputs();

            setTimeout(() => {
                navigate('/doctor/dashboard');
            }, 3000);
        }).catch((err) => {
            console.log(err);
            setErrorState(true)
            clearInputs();
        });
    }

    return (
        <>
            <Flex
                minH={'100vh'}
                align={'center'}
                justify={'center'}
                bg={useColorModeValue('gray.50', 'gray.800')}>
                <Stack spacing={8} mx={'auto'} maxW={'lg'} py={12} px={6}>
                    { successState &&
                        <div className="bg-green-200 py-3 rounded-lg font-bold">
                            <p className="text-center">Sikeres időpont rögzítés!</p>
                        </div>
                    }
                    { errorState &&
                        <div className="bg-red-200 py-3 rounded-lg font-bold">
                            <p className="text-center">Időpont rögzítése sikertelen!</p>
                        </div>
                    }
                    { timeError &&
                        <div className="bg-red-200 py-3 px-3 rounded-lg font-bold">
                            <p className="text-center">Probléma a dátummal!</p>
                            <p className="text-center">
                                {dynamicTimeErrorText}
                            </p>
                        </div>
                    }
                    { intervalError &&
                        <div className="bg-red-200 py-3 px-3 rounded-lg font-bold">
                            <p className="text-center">Probléma a rendelés kezdeti vagy végponti idejével!</p>
                            <p className="text-center">
                                Csak 7:00 és 20:00 között lehet időpontot felvenni,<br/>
                                minimum 15 perces idő intervallumra.<br/>
                                Illetve a rendelés végének a dátuma nem lehet a rendelés kezdete előtt.
                            </p>
                        </div>
                    }
                    <Stack align={'center'}>
                        <Heading fontSize={'4xl'} textAlign={'center'}>
                            Időpont felvétele
                        </Heading>
                    </Stack>
                    <Box
                    rounded={'lg'}
                    bg={useColorModeValue('white', 'gray.700')}
                    boxShadow={'lg'}
                    p={8}>
                        <Stack spacing={4}>
                            <FormControl isRequired>
                                <FormLabel>Mely napra kíván időpontot felvenni?</FormLabel>
                                <Input type="date" onChange={(e) => {
                                    setDate(e.target.value);
                                }}/>
                                { dateError &&
                                    <p className="text-red-500 mt-1">A dátum kitöltése kötelező!</p>
                                }
                            </FormControl>
                            <FormControl isRequired>
                                <FormLabel>Rendelés kezdete</FormLabel>
                                <Input type="time" onChange={(e) => {
                                    setAppointmentStart(e.target.value);
                                }}/>
                                { appointmentStartError &&
                                    <p className="text-red-500 mt-1">A kezdő indőpont megadása kötelező!</p>
                                }
                            </FormControl>
                            <FormControl isRequired>
                                <FormLabel>Rendelés vége</FormLabel>
                                <Input type="time" onChange={(e) => {
                                    setAppointmentEnd(e.target.value);
                                }}/>
                                { appointmentEndError &&
                                    <p className="text-red-500 mt-1">Az időpont végének megadása kötelező!</p>
                                }
                            </FormControl>
                        </Stack>
                    </Box>
                    <Stack spacing={10} pt={2}>
                        <Button
                            onClick={(e) => handleAppointmentCreation(e)}
                            loadingText="Submitting"
                            size="lg"
                            bg={'blue.400'}
                            color={'white'}
                            _hover={{
                                bg: 'blue.500',
                            }}>
                            Időpont felvétele
                        </Button>
                    </Stack>
                </Stack>
            </Flex>
        </>
    );
}

export default DoctorAppointmentCreator;
