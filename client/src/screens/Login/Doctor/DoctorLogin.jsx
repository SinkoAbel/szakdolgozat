import { Button, FormControl, FormLabel, Heading, Input, Stack } from '@chakra-ui/react'
import React, { useState } from 'react';

const DoctorLogin = () => {

    const [email, setEmail] = useState();
    const [password, setPassword] = useState();

    const [successfulLogin, setSuccessfulLogin] = useState();
    const [loginError, setLoginError] = useState();

    const handleLogin = () => {
        // TODO:
        console.log('doctor login');
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
