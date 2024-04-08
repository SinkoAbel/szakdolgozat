import React, {useEffect, useState} from 'react';
import axios from "../../config/axios";
import {useNavigate, useParams} from "react-router-dom";
import {
    Box,
    Button,
    Flex,
    FormControl,
    FormLabel,
    Heading,
    Input,
    Stack,
    useColorModeValue
} from "@chakra-ui/react";
import { useSelector } from 'react-redux';
const Appointment = () => {
    const navigate = useNavigate();
    const {
        token
    } = useSelector((state) => state.authentication);

    const [details, setDetails] = useState([]);

    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);

    const [date, setDate] = useState(null);
    const [startTime, setStartTime] = useState(null);
    const [endTime, setEndTime] = useState(null);

    const appointmentObject = useParams();
    const appointmentID = appointmentObject.appointmentId;
    

    const endpoint = `/api/appointments/${appointmentID}`;

    const fetchAppointment = async () => {
        await axios.get(endpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setDetails(response.data);
        }).catch(err => {
            console.log(err);
        });
    }

    const updateData = async () => {
        await axios.put(endpoint, {
            date: date,
            start_time: startTime,
            end_time: endTime,
        }, {
            headers: {
                Authorization: token
            }
        }).then((response) => {
            setSuccess(true);

            setTimeout(() => {
                navigate('/doctor/dashboard');
            }, 2000);
        }).catch(err => {
            console.log(err);
            setError(true);
        });
    }

    useEffect(() => {
        fetchAppointment();
    }, []);

    return (
        <div className="bg-gray-50">
            <Flex
                minH={'100vh'}
                align={'center'}
                justify={'center'}
                bg={useColorModeValue('gray.50', 'gray.800')}>
                <Stack spacing={8} mx={'auto'} maxW={'lg'} py={12} px={6}>
                    <Stack align={'center'}>
                        <Heading fontSize={'4xl'} textAlign={'center'}>
                            Időpont módosítás
                        </Heading>
                    </Stack>
                    { success &&
                        <div className='text-center py-2 bg-green-200 rounded-lg'>
                            <p className='font-bold'>
                                Sikeres módosítás
                            </p>
                        </div>
                    }
                    { error &&
                        <div className='text-center py-2 bg-red-200 rounded-lg'>
                            <p className='font-bold'>
                                Sikertelen módosítás
                            </p>
                        </div>
                    }
                    <Box
                        rounded={'lg'}
                        bg={useColorModeValue('white', 'gray.700')}
                        boxShadow={'lg'}
                        p={8}>
                        <Stack spacing={4}>
                            <FormControl isRequired>
                                <FormLabel>Dátum?</FormLabel>
                                <Input type="date" onChange={(e) => {
                                    setDate(e.target.value);
                                }} defaultValue={details.date}/>
                            </FormControl>
                            <FormControl isRequired>
                                <FormLabel>Rendelés kezdete</FormLabel>
                                <Input type="time" onChange={(e) => {
                                    setStartTime(e.target.value);
                                }} defaultValue={details.start_time}/>
                            </FormControl>
                            <FormControl isRequired>
                                <FormLabel>Rendelés vége</FormLabel>
                                <Input type="time" onChange={(e) => {
                                    setEndTime(e.target.value);
                                }} defaultValue={details.end_time}/>
                            </FormControl>
                        </Stack>
                    </Box>
                    <Stack spacing={10} pt={2}>
                        <Button
                            onClick={async () => updateData()}
                            loadingText="Submitting"
                            size="lg"
                            bg={'blue.400'}
                            color={'white'}
                            _hover={{
                                bg: 'blue.500',
                            }}>
                            Időpont módosítása
                        </Button>
                        <Button
                            size="lg"
                            colorScheme={'teal'}
                            onClick={() => navigate('/doctor/dashboard')}
                        >
                            Vissza
                        </Button>
                    </Stack>
                </Stack>
            </Flex>
        </div>
    );
};

export default Appointment;