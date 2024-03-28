import { Box, Button, Flex, FormControl, FormLabel, Heading, Input, Stack, useColorModeValue } from "@chakra-ui/react";
import { useState } from "react";
import axios from "../../../config/axios";

const DoctorAppointmentCreator = () => {

    const [date, setDate] = useState('');
    const [appointmentStart, setAppointmentStart] = useState('');
    const [appointmentEnd, setAppointmentEnd] = useState('');

    const [errorState, setErrorState] = useState(false);
    const [successState, setSuccssState] = useState(false);

    const [dateError, setDateError] = useState(false);
    const [appointmentStartError, setAppointmentStartError] = useState(false);
    const [appointmentEndError, setAppointmentEndError] = useState(false);

    const handleAppointmentCreation = async (event) => {
        event.preventDefault();
        setSuccssState(false);
        setErrorState(false);

        // TODO: Add validation!
        if (!date) {
            // TODO: add error fields, look up Chakra UI DOC!!!
        }

        const token = window.sessionStorage.getItem('token');
        const userID = window.sessionStorage.getItem('userID');

        await axios.post('/api/', {
            doctor_user_id: userID,
            date: date,
            start_time: appointmentStart,
            end_time: appointmentEnd,
        }, {
            headers: {
                Authorization: token
            }
        }).then((response) => {
            setSuccssState(true);
        }).catch((err) => {
            console.log(err);
            setErrorState(true)
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
                            </FormControl>
                            <FormControl isRequired>
                                <FormLabel>Rendelés kezdete</FormLabel>
                                <Input type="time" onChange={(e) => {
                                    setAppointmentStart(e.target.value);
                                }}/>
                            </FormControl>
                            <FormControl isRequired>
                                <FormLabel>Rendelés vége</FormLabel>
                                <Input type="time" onChange={(e) => {
                                    setAppointmentEnd(e.target.value);
                                }}/>
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
