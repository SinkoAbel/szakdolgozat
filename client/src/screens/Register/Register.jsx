'use client'
import React from 'react';
import { useState } from 'react';
import {Link, useNavigate} from 'react-router-dom';
import { Flex, Box, FormControl, FormLabel, Input, InputGroup, InputLeftAddon, HStack, InputRightElement, Stack, Button, Heading, Text,
        useColorModeValue } from '@chakra-ui/react';
import { ViewIcon, ViewOffIcon } from '@chakra-ui/icons';
import {useDispatch, useSelector} from "react-redux";
import {setBirthday, setBirthplace, setCity, setEmail, setFirstName, setHouseNumber, setInsuranceNumber, setLastName, setPassword, setPhone, setStreet, setZip} from "../../state/reducers/registerPatientSlice";
import { registerPatientEndpoint } from '../../config/endpoints';
import { ROLE_PATIENT } from '../../config/constants';
import reactAxios from '../../config/axios';

const Register = () => {

    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordAgain, setShowPasswordAgain] = useState(false);
    const [confirmPassword, setConfirmPassword] = useState('');

    const navigate = useNavigate();
    const dispatch = useDispatch();

    const {
        first_name,
        last_name,
        email,
        password,
        birthday,
        birthplace,
        city,
        zip,
        street,
        house_number,
        insurance_number,
        phone
    } = useSelector((state) => state.registerPatient);

    const isPasswordsMatching = confirmPassword === password;

    const handlePatientRegistration = async (event) => {
        event.preventDefault();
        console.log('register triggered');

        if (!isPasswordsMatching) return;
        // TODO: add validations for the remaining fields

        await reactAxios.post(registerPatientEndpoint, {
            first_name: first_name,
            last_name: last_name,
            email: email,
            birthday: birthday,
            birthplace: birthplace,
            city: city,
            zip: zip,
            street: street,
            house_number: house_number,
            insurance_number: insurance_number,
            phone: phone,
            password: password,
            role: ROLE_PATIENT
        }).then(res => {
            console.log(res.data);
            //sessionStorage.setItem('token', JSON.stringify({ token: res.data.token }));
        }).catch(err => {
            console.log(err);
        });
    }

    const handleLastNameChange = (event) => {
        dispatch(setLastName(event.target.value));
    }

    const handleFirstNameChange = (event) => {
        dispatch(setFirstName(event.target.value));
    }

    const handleEmailChange = (event) => {
        dispatch(setEmail(event.target.value));
    }

    const handleBirthdayChange = (event) => {
        console.log(event.target.value);
        dispatch(setBirthday(event.target.value));
    }

    const handleBirthplaceChange = (event) => {
        dispatch(setBirthplace(event.target.value));
    }

    const handleCityChange = (event) => {
        dispatch(setCity(event.target.value));
    }

    const handleZipChange = (event) => {
        dispatch(setZip(event.target.value));
    }

    const handleStreetChange = (event) => {
        dispatch(setStreet(event.target.value));
    }

    const handleHouseNumberChange = (event) => {
        dispatch(setHouseNumber(event.target.value));
    }

    const handleInsuranceNumberChange = (event) => {
        dispatch(setInsuranceNumber(event.target.value));
    }

    const handlePhoneChange = (event) => {
        dispatch(setPhone(event.target.value));
    }

    const handlePasswordChange = (event) => {
        dispatch(setPassword(event.target.value));
    }

    const handleConfirmPasswordChange = (event) => {
        setConfirmPassword(event.target.value);
    }


    return (
        <>
           <Flex
               minH={'100vh'}
               align={'center'}
               justify={'center'}
               bg={useColorModeValue('gray.50', 'gray.800')}>
               <Stack spacing={8} mx={'auto'} maxW={'lg'} py={12} px={6}>
                   <Stack align={'center'}>
                       <Heading fontSize={'4xl'} textAlign={'center'}>
                            Regisztráció
                       </Heading>
                   </Stack>
                   <Box
                       rounded={'lg'}
                       bg={useColorModeValue('white', 'gray.700')}
                       boxShadow={'lg'}
                       p={8}>
                       <Stack spacing={4}>
                           <HStack>
                               <Box>
                                   <FormControl id="last_name" isRequired>
                                       <FormLabel>Vezetéknév</FormLabel>
                                       <Input type="text" onChange={handleLastNameChange}/>
                                   </FormControl>
                               </Box>
                               <Box>
                                   <FormControl id="first_name" isRequired>
                                       <FormLabel>Keresztnév</FormLabel>
                                       <Input type="text" onChange={handleFirstNameChange}/>
                                   </FormControl>
                               </Box>
                           </HStack>
                           <FormControl id="email" isRequired>
                               <FormLabel>Email cím</FormLabel>
                               <Input type="email" onChange={handleEmailChange}/>
                           </FormControl>
                           <FormControl id="insurance_number" isRequired>
                               <FormLabel>Taj szám</FormLabel>
                               <Input type="text" onChange={handleInsuranceNumberChange}/>
                           </FormControl>
                           <FormControl id="password" isRequired>
                              <FormLabel>Jelszó</FormLabel>
                               <InputGroup>
                                   <Input type={showPassword ? 'text' : 'password'} onChange={handlePasswordChange}/>
                                   <InputRightElement h={'full'}>
                                       <Button
                                           variant={'ghost'}
                                           onClick={() => setShowPassword((showPassword) => !showPassword)}>
                                           {showPassword ? <ViewIcon /> : <ViewOffIcon />}
                                       </Button>
                                   </InputRightElement>
                               </InputGroup>
                           </FormControl>
                           <FormControl id="password_again" isRequired>
                               <FormLabel>Jelszó megint</FormLabel>
                               <InputGroup>
                                   <Input type={showPasswordAgain ? 'text' : 'password'} onChange={handleConfirmPasswordChange}/>
                                   <InputRightElement h={'full'}>
                                       <Button
                                           variant={'ghost'}
                                           onClick={() => setShowPasswordAgain((showPasswordAgain) => !showPasswordAgain)}>
                                           {showPasswordAgain ? <ViewIcon /> : <ViewOffIcon />}
                                       </Button>
                                   </InputRightElement>
                               </InputGroup>
                           </FormControl>
                           <FormControl id="birhday" isRequired>
                               <FormLabel>Születési dátum</FormLabel>
                               <Input type="date" onChange={handleBirthdayChange}/>
                           </FormControl>
                           <FormControl id="birthplace" isRequired>
                               <FormLabel>Születési hely</FormLabel>
                               <Input type="text" onChange={handleBirthplaceChange}/>
                           </FormControl>
                           <FormControl id="zip" isRequired>
                               <FormLabel>Irányítószám</FormLabel>
                               <Input type="number" mask="****" onChange={handleZipChange}/>
                           </FormControl>
                           <FormControl id="city" isRequired>
                               <FormLabel>Lakhely</FormLabel>
                               <Input type="text" onChange={handleCityChange}/>
                           </FormControl>
                           <FormControl id="street" isRequired>
                               <FormLabel>Utca név</FormLabel>
                               <Input type="text" onChange={handleStreetChange}/>
                           </FormControl>
                           <FormControl id="house_number" isRequired>
                               <FormLabel>Házszám</FormLabel>
                               <Input type="number" onChange={handleHouseNumberChange}/>
                           </FormControl>
                           <FormControl id="phone" isRequired>
                                <FormLabel>Telefonszám</FormLabel>
                                <Input type="tel" onChange={handlePhoneChange}/>
                           </FormControl>
                           <Stack spacing={10} pt={2}>
                               <Button
                                   onClick={handlePatientRegistration}
                                   loadingText="Submitting"
                                   size="lg"
                                   bg={'blue.400'}
                                   color={'white'}
                                   _hover={{
                                       bg: 'blue.500',
                                   }}>
                                   Regisztrálok
                               </Button>
                           </Stack>
                           <Stack pt={6}>
                               <Text align={'center'}>
                                   Már regisztrált ügyfelünk?
                               </Text>
                               <Link to="/login" className="underline text-green-600 text-center">
                                   Jelentkezzen be!
                               </Link>
                           </Stack>
                       </Stack>
                   </Box>
               </Stack>
           </Flex>
        </>
    );
};

export default Register;
