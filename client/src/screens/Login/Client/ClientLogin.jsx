'use client'
import React, { useState } from 'react';
import { Button, Checkbox, Flex, Text, FormControl, FormLabel, Heading, Input, Stack, Image } from '@chakra-ui/react'
//import axios from 'axios';
import axios from '../../../config/axios';

const ClientLogin = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleLogin = async (event) => {
        event.preventDefault();
        
        try {
            await axios.post('/api/login', {
                email: email,
                password: password,
                token_type: 'Patient-Token'
            });
        } catch (err) {
            console.log(err);
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
                        </Stack>
                    </Stack>
                </Flex>
                <Flex flex={1}>
                    {/* TODO: replace picture with more medical alike */}
                    <Image
                        alt={'ClientLogin Image'}
                        objectFit={'cover'}
                        src={
                            'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80'
                        }
                    />
                </Flex>
            </Stack>
        </>
    );
};

export default ClientLogin;