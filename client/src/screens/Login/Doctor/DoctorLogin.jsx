import { Button, FormControl, FormLabel, Heading, Input, Stack } from '@chakra-ui/react'
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { login } from '../../../config/auth';
import { ROLE_DOCTOR } from '../../../config/constants';

const DoctorLogin = () => {
    const navigate = useNavigate();

    const authenticated = sessionStorage.getItem('authenticated') ?? false;

    if (authenticated) {
        navigate('/');
    }

    const [email, setEmail] = useState();
    const [password, setPassword] = useState();

    const [successfulLogin, setSuccessfulLogin] = useState(false);
    const [loginError, setLoginError] = useState(false);

    const handleLogin = (event) => {
        event.preventDefault();
        const loginStatus = login(setLoginError, setSuccessfulLogin, email, password, '/api/login', 'Doctor-Token', ROLE_DOCTOR);

        if (loginStatus) {
            setTimeout(() => {
                navigate('/doctor/dashboard')
            }, 3000);
        }
    }

    return (
        <>
            <div className='flex justify-center mt-5'>
                <Stack spacing={4} w={'full'} maxW={'md'}>
                    <Heading fontSize={'2xl'} className='text-center'>Medicare bejelentkezés</Heading>
                    <FormControl id="email">
                        <FormLabel>Email</FormLabel>
                        <Input type="email" onChange={(e) => setEmail(e.target.value)}/>
                    </FormControl>
                    <FormControl id="password">
                        <FormLabel>Jelszó</FormLabel>
                        <Input type="password" onChange={(e) => setPassword(e.target.value)}/>
                    </FormControl>
                    <Stack spacing={6}>
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
            </div>
        </>
    );
};

export default DoctorLogin;
