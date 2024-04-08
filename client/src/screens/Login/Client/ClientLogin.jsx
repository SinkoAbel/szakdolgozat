'use client'
import React, { useState } from 'react';
import { Button, Checkbox, Flex, Text, FormControl, FormLabel, Heading, Input, Stack, Image } from '@chakra-ui/react'
import { useNavigate } from 'react-router-dom';
import { login } from '../../../config/auth';
import { ROLE_PATIENT } from '../../../config/constants';
import {setLoggedInTrue, setPatientRole, setToken, setUserId} from "../../../state/reducers/authenticationSlice";
import {useDispatch} from "react-redux";

const ClientLogin = () => {
    const navigate = useNavigate();
    const dispatch = useDispatch();

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const [successfulLogin, setSuccessfulLogin] = useState(false);
    const [loginError, setLoginError] = useState(false);

    const handleLogin = async (event) => {
        event.preventDefault();
        const success = await login(setLoginError, setSuccessfulLogin, email, password, '/api/patient/login', 'Patient-Token');

        if (!success) {
            return;
        }

        if (!loginError) {
            setTimeout(() => {
                dispatch(setToken(success.token));
                dispatch(setUserId(success.userID));
                dispatch(setLoggedInTrue());
                dispatch(setPatientRole());
                navigate('/patient/dashboard');
            }, 3000);   
        }
    }

    return (
        <>
            <Stack minH={'100vh'} direction={{ base: 'column', md: 'row' }}>
                <Flex p={8} flex={1} align={'center'} justify={'center'}>
                    <Stack spacing={4} w={'full'} maxW={'md'}>
                        <Heading fontSize={'2xl'}>Jelentkezzen be</Heading>
                        <FormControl id="email">
                            <FormLabel>Email</FormLabel>
                            <Input type="email" onChange={(e) => setEmail(e.target.value)}/>
                        </FormControl>
                        <FormControl id="password">
                            <FormLabel>Jelszó</FormLabel>
                            <Input type="password" onChange={(e) => setPassword(e.target.value)}/>
                        </FormControl>
                        <Stack spacing={6}>
                            <Stack
                                direction={{ base: 'column', sm: 'row' }}
                                align={'start'}
                                justify={'space-between'}>
                                <Checkbox>Jegyezze meg</Checkbox>
                                <Text color={'blue.500'}>Elfelejtett jelszó?</Text>
                            </Stack>
                            <Button colorScheme={'blue'} variant={'solid'} onClick={handleLogin}>
                                Bejelentkezés
                            </Button>
                            { successfulLogin &&
                                <div className='py-3 bg-green-200 rounded-xl'>
                                    <p className='font-bold text-center'>Sikeres bejelentkezés!</p>
                                </div>
                            }
                            { loginError &&
                                <div className='py-3 bg-red-200 rounded-xl'>
                                    <p className='text-center font-bold'>Hiba!</p>
                                    <p className='text-center font-bold'>Nem megfelelő email vagy jelszó!</p>
                                </div>
                            }                            
                        </Stack>
                    </Stack>
                </Flex>
                <Flex flex={1}>
                    <Image
                        alt={'ClientLogin Image'}
                        objectFit={'cover'}
                        src={
                            'https://carbona.hu/wp-content/uploads/2019/08/carbona-gyogyaszat-orvosi-vizsgalat-uj-960x640.jpg'
                        }
                    />
                </Flex>
            </Stack>
        </>
    );
};

export default ClientLogin;